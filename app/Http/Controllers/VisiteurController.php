<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Visiteur;
use Illuminate\Http\Request;

class VisiteurController extends Controller
{
    public function index(Request $request)
    {
        $visiteurs = Visiteur::when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->paginate($request->page_size ?? 10);
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
        $visiteur = Visiteur::create( [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'date_naiss' => $request->date_naiss,
            'email' => $request->email,
            'sexe' => $request->sexe,
            'tel' => $request->tel,
            'heure_arrive' => $request->heure_arrive,
            'heure_depart' => $request->heure_depart,
            'motif' => $request->motif,
            'localite' => $request->localite,
            ] );
        return redirect()->route('visiteurs.index')->with('success', 'visiteur crée avec succès');
    }
}
