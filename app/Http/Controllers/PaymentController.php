<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Postulant;
use App\Models\VirtualAccount;
use App\Models\Deposit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function postulantIndex(Request $request)
    {
        $user = Auth::user();
        $postulantId = $user->postulant_id;

        $payments = Payment::with('demande.type_vol', 'demande.type_demande')
            ->where('postulant_id', $postulantId)
            ->orderByDesc('created_at')
            ->get();

        $unpaid = Demande::where('user_id', $user->id)
            ->where('statut_id', 4)
            ->whereNull('payer')
            ->with('type_demande', 'type_vol', 'orders', 'routes.num_autorisations')
            ->orderByDesc('date_autorisation')
            ->get();

        $virtualAccount = VirtualAccount::where('user_id', $user->id)->first();
        $deposits = $virtualAccount
            ? Deposit::where('virtual_account_id', $virtualAccount->id)->orderByDesc('created_at')->get()
            : collect();

        $unpaidAmount = $unpaid->reduce(function ($carry, $d) {
            $order = $d->orders->where('status', 0)->sortByDesc('id')->first() ?? $d->orders->sortByDesc('id')->first();
            return $carry + (float) ($order->prix_total ?? 0);
        }, 0);

        $paymentsAmount = $payments->sum('amount');
        $depositsAmount = $deposits->sum('amount');

        return Inertia::render('Postulant/paiements', [
            'payments' => $payments,
            'unpaid' => $unpaid,
            'deposits' => $deposits,
            'stats' => [
                'payments_count' => $payments->count(),
                'payments_amount' => $paymentsAmount,
                'unpaid_count' => $unpaid->count(),
                'unpaid_amount' => $unpaidAmount,
                'deposits_count' => $deposits->count(),
                'deposits_amount' => $depositsAmount,
            ],
        ]);
    }

    public function comptableIndex(Request $request)
    {
        $tab = $request->get('tab', 'paid');
        $mode = $request->mode;
        $demandeId = $request->demande_id;
        $autorisation = $request->autorisation;
        $postulant = $request->postulant;
        $search = $request->search;

        $paymentsQuery = Payment::with(
            'demande.user.postulant',
            'demande.type_vol',
            'demande.type_demande',
            'demande.routes.num_autorisations'
        )
            ->when($mode, fn ($q) => $q->where('mode', $mode))
            ->when($demandeId, fn ($q) => $q->where('demande_id', 'LIKE', "%{$demandeId}%"))
            ->when($postulant, function ($q) use ($postulant) {
                $q->whereHas('demande.user.postulant', fn ($qq) => $qq->where('id', $postulant));
            })
            ->when($autorisation, function ($q) use ($autorisation) {
                $q->whereHas('demande.routes.num_autorisations', fn ($qq) => $qq->where('numero', 'LIKE', "%{$autorisation}%"));
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('receipt_no', 'LIKE', "%{$search}%")
                        ->orWhere('receipt_no_format', 'LIKE', "%{$search}%")
                        ->orWhere('demande_id', 'LIKE', "%{$search}%")
                        ->orWhereHas('demande.user.postulant', function ($qq) use ($search) {
                            $qq->where('nom_raison_sociale', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('demande.routes.num_autorisations', function ($qq) use ($search) {
                            $qq->where('numero', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('created_at');

        $unpaidQuery = Demande::where('statut_id', 4)
            ->whereNull('payer')
            ->with('user.postulant', 'type_demande', 'type_vol', 'orders', 'routes.num_autorisations')
            ->when($demandeId, fn ($q) => $q->where('id', 'LIKE', "%{$demandeId}%"))
            ->when($postulant, function ($q) use ($postulant) {
                $q->whereHas('user.postulant', fn ($qq) => $qq->where('id', $postulant));
            })
            ->when($autorisation, function ($q) use ($autorisation) {
                $q->whereHas('routes.num_autorisations', fn ($qq) => $qq->where('numero', 'LIKE', "%{$autorisation}%"));
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('id', 'LIKE', "%{$search}%")
                        ->orWhereHas('user.postulant', function ($qq) use ($search) {
                            $qq->where('nom_raison_sociale', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('routes.num_autorisations', function ($qq) use ($search) {
                            $qq->where('numero', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('date_autorisation');

        $payments = $paymentsQuery->paginate($request->page_size ?? 10)->withQueryString();
        $unpaid = $unpaidQuery->paginate($request->page_size ?? 10)->withQueryString();

        $paymentsCount = (clone $paymentsQuery)->count();
        $paymentsAmount = (clone $paymentsQuery)->sum('amount');
        $unpaidCount = (clone $unpaidQuery)->count();
        $unpaidAmount = (clone $unpaidQuery)->get()->reduce(function ($carry, $d) {
            $order = $d->orders->where('status', 0)->sortByDesc('id')->first() ?? $d->orders->sortByDesc('id')->first();
            return $carry + (float) ($order->prix_total ?? 0);
        }, 0);

        return Inertia::render('comptable/paiements', [
            'payments' => $payments,
            'unpaid' => $unpaid,
            'mode' => $mode,
            'tab' => $tab,
            'postulants' => Postulant::select('id','nom_raison_sociale')
                ->orderBy('nom_raison_sociale')
                ->get(),
            'filters' => [
                'demande_id' => $demandeId,
                'autorisation' => $autorisation,
                'postulant' => $postulant,
                'search' => $search,
            ],
            'stats' => [
                'payments_count' => $paymentsCount,
                'payments_amount' => $paymentsAmount,
                'unpaid_count' => $unpaidCount,
                'unpaid_amount' => $unpaidAmount,
            ],
        ]);
    }

    public function caisseIndex(Request $request)
    {
        $immat = $request->immatriculation;
        $callSign = $request->call_sign;
        $search = $request->search;

        $unpaid = Demande::where('statut_id', 4)
            ->whereNull('payer')
            ->with('user.postulant', 'type_demande', 'type_vol', 'orders', 'aeronefs', 'routes.num_autorisations')
            ->when($request->filled('search'), function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('id', 'LIKE', "%{$search}%")
                        ->orWhereHas('user.postulant', function ($qq) use ($search) {
                            $qq->where('nom_raison_sociale', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('aeronefs', function ($qq) use ($search) {
                            $qq->where('imatriculation', 'LIKE', "%{$search}%")
                                ->orWhere('indicatif_appel', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->when($immat, function ($q) use ($immat) {
                $q->whereHas('aeronefs', function ($qq) use ($immat) {
                    $qq->where('imatriculation', 'LIKE', "%{$immat}%");
                });
            })
            ->when($callSign, function ($q) use ($callSign) {
                $q->whereHas('aeronefs', function ($qq) use ($callSign) {
                    $qq->where('indicatif_appel', 'LIKE', "%{$callSign}%");
                });
            })
            ->orderByDesc('date_autorisation')
            ->paginate($request->page_size ?? 10)
            ->withQueryString();

        return Inertia::render('caisse/index', [
            'unpaid' => $unpaid,
            'filters' => [
                'immatriculation' => $immat,
                'call_sign' => $callSign,
                'search' => $search,
            ],
        ]);
    }

    public function payAtCaisse(Request $request)
    {
        $request->validate([
            'demande_id' => ['required', 'exists:demandes,id'],
            'motif' => ['required', 'string', 'max:255'],
        ]);

        $demande = Demande::with('orders', 'user')->findOrFail($request->demande_id);
        $order = $demande->orders()->where('status', 0)->latest()->first();
        if (!$order) {
            return redirect()->back()->with('error', 'Aucune facture en attente pour cette autorisation.');
        }

        $payment = Payment::create([
            'demande_id' => $demande->id,
            'order_id' => $order->id,
            'postulant_id' => $demande->user->postulant_id,
            'user_id' => Auth::id(),
            'mode' => 'caisse',
            'amount' => $order->prix_total,
            'motif' => $request->motif,
        ]);

        $order->status = 1;
        $order->save();

        if ($demande->payer == null && $demande->payer_revise == 1 && $demande->statut_id == 4) {
            $demande->payer_revise = 0;
            $demande->payer = 1;
        } else {
            $demande->payer = 1;
        }
        $demande->save();

        return redirect()->back()->with('success', 'Paiement enregistré en caisse.');
    }

    public function receipt($id)
    {
        $payment = Payment::with('demande.user.postulant', 'demande.type_demande', 'demande.type_vol')->findOrFail($id);

        $pdf = Pdf::loadView('payment_receipt', [
            'payment' => $payment,
        ]);

        return $pdf->stream('recu_paiement_' . $payment->receipt_no . '.pdf');
    }
}
