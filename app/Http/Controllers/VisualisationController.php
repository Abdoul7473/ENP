<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VisualisationController extends Controller
{
    //
    public function index(Request $request)
    {
        $demandes_autorisees = Demande::where('statut_id', 4)
            ->when($request->search, function ($query, $value) {
                $query->whereHas('aeronefs', function ($subQuery) use ($value) {
                    $subQuery->where('type', 'LIKE', '%' . $value . '%')
                    ->orWhere('imatriculation', 'LIKE', '%' . $value . '%')
                    ->orWhere('commandant_bord', 'LIKE', '%' . $value . '%')
                    ->orWhere('indicatif_appel', 'LIKE', '%' . $value . '%')
                    ->orWhere('email_exploitant', 'LIKE', '%' . $value . '%')
                    ->orWhere('nom_exploitant', 'LIKE', '%' . $value . '%');
                });
            })
            ->with('aeronefs', 'type_demande', 'type_vol', 'statut', 'user.postulant')
            ->orderBy('date_prevu_vol', 'asc')
            ->paginate($request->page_size ?? 10);
            // $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4)->when($request->search, function ($query, $value) {
            //     $query->where('', 'LIKE', '%' . $value . '%');
            // })->with('aeronefs','type_demande','type_vol','statut','user.postulant')->orderBy('date_prevu_vol','asc')
            // ->paginate($request->page_size ?? 10);
            //  dd($demandes_autorisees);
        return Inertia::render('Demandes/visualiser', [
            'demandes_autorisees' => $demandes_autorisees,
        ]);
    }
}
