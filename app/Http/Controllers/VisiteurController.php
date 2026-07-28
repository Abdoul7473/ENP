<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Visiteur;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisiteurController extends Controller
{
    public function index(Request $request)
    {
        $visiteurs = Visiteur::all();
        return Inertia::render('visiteurs/index', [
            'visiteurs' => $visiteurs
        ]);
    }
    public function create(Request $request) {
        return Inertia::render('visiteurs/create',[

        ]);
    }
    public function store(Request $request){
        // dd($request);
        $gmtDate = Carbon::now( 'GMT' );
        $date = $gmtDate->format('Y-m-d');
        Visiteur::create( [
            'nom' => $request->nom,
            'statut' => 0,
            'date' => $date,
            'prenom' => $request->prenom,
            'mat_vehicule' => $request->mat_vehicule,
            'num_carte' => $request->num_carte,
            'date_naiss' => $request->date_naiss,
            'email' => $request->email,
            'sexe' => $request->sexe,
            'tel' => $request->tel,
            'heure_arrive' => $request->heure_arrive,
            'motif' => $request->motif,
            'localite' => $request->localite,
        ] );
        return redirect()->route('visiteurs.index')->with('success', 'visiteur crée avec succès');
    }
     public function notifier(Request $request){
        $visiteur = Visiteur::find($request->id);
        $visiteur->statut = 1;
        $gmtheure = Carbon::now( 'GMT' );
        $heure = $gmtheure->format( 'H:i' );
        $visiteur->heure_depart = $heure;
        
        $visiteur->update();
        return redirect()->route('visiteurs.index')->with('success', 'le depart de visiteur a été notifié avec succès');
    }
}
