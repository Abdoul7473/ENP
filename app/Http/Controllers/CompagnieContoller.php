<?php

namespace App\Http\Controllers;

use App\Models\Compagnie;
use App\Models\Encadreur;
use App\Models\Grade;
use App\Models\Corp;
use App\Models\Affectation;
use App\Models\Annee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class CompagnieContoller extends Controller
{
     public function index(Request $request)
    {
        $annee = Annee::where('statut',1)->first();
        $compagnies = Compagnie::where('annee_id',$annee->id)->with('corp')->when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->paginate($request->page_size ?? 10);
        $corps = Corp::all();
        return Inertia::render('Compagnies/index', [
            'compagnies' => $compagnies,
            'corps' => $corps
        ]);
    }
     public function store(Request $request){
        $annee = Annee::where('statut',1)->first();
        $compagnie = Compagnie::create( [
            'nom' => $request->nom,
            'sigle' => $request->sigle,
            'passant' => $request->passant,
            'effectif' => $request->effectif,
            'corp_id' => $request->corp_id,
            'annee_id' => $annee->id
            ] );
        return redirect()->route('compagnie.index')->with('success', 'Compagnie créee avec succès');
    }
    public function encadreur_index(Request $request){
        $encadreurs = Encadreur::with('grade','affectations.compagnie')->when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->paginate($request->page_size ?? 10);
        return Inertia::render('Encadreurs/index',[
            'encadreurs' => $encadreurs
        ]);
    }
    public function encadreur_create(Request $request){
        $grades = Grade::all();
        $compagnies = Compagnie::all();
        return Inertia::render('Encadreurs/creation',[
            'grades' => $grades,
            'compagnies' => $compagnies
        ]);
    }

    public function encadreur_store(Request $request){
        $gmtDate = Carbon::now( 'GMT' );
        $date = $gmtDate->format( 'Y-m-d' );
        $encadreur = Encadreur::create( [
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'matricule' => $request->matricule,
            'sexe' => $request->sexe,
            'tel' => $request->tel,
            'date_naiss' => $request->date_naiss,
            'is_commandant' => $request->is_commandant,
            'lieu_naiss' => $request->lieu_naiss,
            'grade_id' => $request->grade,
            'groupe_sanguin' => $request->groupe_sanguin,
            ] );
        $affectation = Affectation::create([
            'date' => $date,
            'statut' => true,
            'encadreur_id' => $encadreur->id,
            'compagnie_id' =>$request->compagnie
        ]);
        return redirect()->route('encadreur.index')->with('success', 'Encadreur crée avec succès');
    }
    public function index_annee(Request $request){
        $annees = Annee::when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
            })->paginate($request->page_size ?? 10);
        return Inertia::render('Annees/index',[
            "annees" => $annees
        ]);
    }
     public function store_annee(Request $request){
        $gmtDate = Carbon::parse($request->date_debut);
        $date = $gmtDate->format('y');
        $annee = Annee::create( [
            'libelle' => '0'. $date,
            'code' => $date,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'statut' => 0
            ] );
       return redirect()->route('annee.index')->with('success', 'Année créée avec succès');
    }
}
