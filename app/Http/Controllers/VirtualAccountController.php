<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\VirtualAccount;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Demande;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\DepositsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class VirtualAccountController extends Controller
{
    //
    public function getBalance(Request $request) {
        // dd($request->user);
        $user = Auth::user();
        // dd($user->id);
        $balance = 0.0;
        $virtualAccount = VirtualAccount::where('user_id',$user->id)->first();
        if($virtualAccount)
        $balance = $virtualAccount->balance;
        
        return response()->json(['balance' => $balance]);
    }

    public function index(Request $request)
    {
        // dd($request->user());
        $users = User::where('statut',1)->get();
       
        $usersWithAccounts = DB::table('users')
        ->join('virtual_accounts', 'users.id', '=', 'virtual_accounts.user_id')
        ->select('users.*')
        ->distinct()  // S'assurer que chaque utilisateur n'est récupéré qu'une seule fois
        ->get();

        // dd($usersWithAccounts);
        
        return Inertia::render("deposit/index",[
            "users" => $users,
            "usersWithAccounts" => $usersWithAccounts
        ]);
    }

    public function postulantBalances(Request $request)
    {
        $balances = User::query()
            ->whereNotNull('postulant_id')
            ->with(['postulant:id,nom_raison_sociale,tel,code', 'virtualAccount:id,user_id,balance'])
            ->when($request->search, function ($query, $value) {
                $query->where(function ($inner) use ($value) {
                    $inner->where('email', 'LIKE', '%' . $value . '%')
                        ->orWhereHas('postulant', function ($sub) use ($value) {
                            $sub->where('nom_raison_sociale', 'LIKE', '%' . $value . '%')
                                ->orWhere('tel', 'LIKE', '%' . $value . '%')
                                ->orWhere('code', 'LIKE', '%' . $value . '%');
                        });
                });
            })
            ->orderByDesc('id')
            ->paginate($request->page_size ?? 10)
            ->through(function ($user) {
                return [
                    'id' => $user->id,
                    'code' => optional($user->postulant)->code,
                    'postulant' => optional($user->postulant)->nom_raison_sociale,
                    'email' => $user->email,
                    'telephone' => optional($user->postulant)->tel,
                    'balance' => (float) optional($user->virtualAccount)->balance,
                ];
            });

        return Inertia::render('deposit/postulant_balance', [
            'balances' => $balances,
        ]);
    }

   public function getDeposits(Request $request) {
    $q = $this->buildDepositsQuery($request);

        // 🔹 Récupérer les 30 dernières lignes par défaut
        $deposits = $q->take(30)->get();
    
        return response()->json($deposits);
    }


    public function active(Request $request) {
        // dd($request->all());
        $deposit = Deposit::where('id',$request->id)->with('virtualAccount')->first();
        // dd('depot',$deposit);
        $deposit->update(['status'=>'actif']);
        // $montant = floatval($request->montant);
        $montant = (float) str_replace([' ', ','], '', (string) $request->montant);
        // dd($montant);
        // dd($deposit,$deposit->virtualAccount);
        // $virtualAccount = VirtualAccount::where('user_id',$deposit->user->id)->first();
        $deposit->virtualAccount->increment('balance', $montant);
        // dd('ok');
        // dd($query->get());
    
        return redirect()->route('deposit.index')->with('success', 'Confirmation du depot effectué avec succès');
    }

    public function store(Request $request)
    {
        if ($request->has('montant')) {
            $request->merge([
                'montant' => str_replace([' ', ','], '', (string) $request->montant),
            ]);
        }
        // Validation des données
        $request->validate([
            'montant' => 'required|numeric|min:1000', // Exemple : minimum 1000 Fcfa
            'id' => 'nullable|exists:users,id',
        ]);

        $virtualAccount = VirtualAccount::where('user_id',$request->id)->first();

        if(!$virtualAccount){
            $virtualAccount = VirtualAccount::create(['user_id' => $request->id]);
        }
        // Création du dépôt
        $depot = Deposit::create([
            'amount' => $request->montant,
            'code' => 'RRRRE',
            'virtual_account_id' => $virtualAccount->id,
        ]);

        return redirect()->route('deposit.index')->with('success', 'Dépot effectué avec succès');

    }

    // public function paiement(Request $request) {
    //     // dd($request->all(),Auth::user()->id);
    //     $virtualAccount = VirtualAccount::where('user_id',Auth::user()->id)->first();
    //     // dd($virtualAccount);
    //     $nombre_sans_separateurs = str_replace(' ', '', $request->frais);
    //     $montant = floatval($nombre_sans_separateurs);
    //     $montant_account = (float) $virtualAccount->balance;
    //     if($virtualAccount){
    //         if($montant > $montant_account){
    //             return redirect()->route('homepostulant')->with('error', 'Votre solde est insuffisant pour effectuer ce paiement');
    //         }
    //     }else{
    //         return redirect()->route('homepostulant')->with('error', 'Vous n\'avez pas de compte');
    //     }
        
    //     $mails = [];
    //     $order = Order::where('demande_id',$request->id)->where('status',0)->first();
    //     // dd($order);
    //     $order->status = 1;
    //     // $order->session_id = $request->session()->get('access_token');
    //     $order->save();

    //     $demande = Demande::find($request->id);
    //     if ($demande->payer == null &&  $demande->payer_revise == 1 &&  $demande->statut_id == 4) {
    //         $demande->payer_revise = 0;
    //         $demande->payer = 1 ;
    //     }else {
    //         $demande->payer = 1 ;
    //     }

    //     $demande->save();
    //     $virtualAccount->decrement('balance', $montant);

    //     return redirect()->route('homepostulant')->with('success', 'Votre payement à été effectué avec succès');
    // }

    public function paiement(Request $request)
    {
        $virtualAccount = VirtualAccount::where('user_id', Auth::id())->first();

        if (!$virtualAccount) {
            return redirect()->route('homepostulant')->with('error', 'Vous n\'avez pas de compte');
        }

        $order = Order::where('demande_id', $request->id)
            ->where('status', 0)
            ->first();

        if (!$order) {
            return redirect()->route('homepostulant')
                ->with('error', 'Aucune facture en attente pour cette demande.');
        }

        $montant = (float) str_replace(' ', '', (string) $order->prix_total);

        if ($montant > (float) $virtualAccount->balance) {
            return redirect()->route('homepostulant')->with('error', 'Votre solde est insuffisant pour effectuer ce paiement');
        }

        DB::transaction(function () use ($request, $montant, $virtualAccount) {
            $order = Order::where('demande_id', $request->id)
                ->where('status', 0)
                ->firstOrFail();

            $order->status = 1;
            $order->save();

            $demande = Demande::findOrFail($request->id);

            if ($demande->payer == null && $demande->payer_revise == 1 && $demande->statut_id == 4) {
                $demande->payer_revise = 0;
                $demande->payer = 1;
            } else {
                $demande->payer = 1;
            }

            $demande->save();

            $virtualAccount->decrement('balance', $montant);

            Payment::create([
                'demande_id' => $demande->id,
                'order_id' => $order->id,
                'postulant_id' => $demande->user->postulant_id,
                'mode' => 'compte',
                'amount' => $montant,
            ]);
        });

        return redirect()->route('homepostulant')->with('success', 'Votre paiement a été effectué avec succès');
    }

    public function exportDepositsPdf(Request $request)
    {
        $deposits = $this->buildDepositsQuery($request)->get();
        $total = $deposits->sum('amount');

        $pdf = Pdf::loadView('rapport/deposits', [
            'deposits' => $deposits,
            'total' => $total,
            'filters' => $this->extractDepositFilters($request),
        ]);

        return $pdf->stream('deposits.pdf');
    }

    public function exportDepositsExcel(Request $request)
    {
        $deposits = $this->buildDepositsQuery($request)->get();
        $total = $deposits->sum('amount');

        return Excel::download(
            new DepositsExport($deposits, $total, $this->extractDepositFilters($request)),
            'deposits.xlsx'
        );
    }

    private function buildDepositsQuery(Request $request)
    {
        return Deposit::orderByDesc('created_at')
            ->with('virtualAccount.user')
            ->when($request->filled('user'), function ($query) use ($request) {
                $query->whereHas('virtualAccount', function ($q) use ($request) {
                    $q->where('user_id', $request->user);
                });
            })
            ->when($request->filled('startDate') && $request->filled('endDate'), function ($query) use ($request) {
                $start = Carbon::parse($request->startDate)->startOfDay();
                $end = Carbon::parse($request->endDate)->endOfDay();
                $query->whereBetween('created_at', [$start, $end]);
            });
    }

    private function extractDepositFilters(Request $request)
    {
        return [
            'user' => $request->user,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ];
    }
}
