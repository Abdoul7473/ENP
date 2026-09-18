<?php

namespace App\Http\Controllers;

use App\Models\Corp;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Groupe;
use App\Models\Matiere;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModuleController extends Controller
{
    public function index(Request $request){
        $matieres = Matiere::all();
        return Inertia::render('Matieres/index',[
            'matieres' => $matieres
        ]);
    }
    public function store(Request $request){
        foreach ($request->donnees as $key => $value) {
                Matiere::updateOrInsert([
                    'libelle' => $value['libelle'],
                ]);
            }
        return redirect()->route('matiere.index')->with( 'success',  'Matières enregistrées avec succès' );
    }
    public function corp_index(Request $request){
        $corps = Corp::all();
        return Inertia::render('Corps/index',[
            'corps' => $corps
        ]);
    }
    public function groupe_index(Request $request, $id){
        $groupes = Groupe::with('eleves')->where('corp_id',$id)->get();
        $corp = Corp::find($id);
        $eleves = Eleve::whereHas('compagnie',function($query) use ($id){
            $query->where('corp_id',$id);
        })->get();
        // dd($eleves);
        
        return Inertia::render('Groupes/index',[
            'corp' => $corp,
            'groupes' => $groupes,
            'eleves' => $eleves,
            'id' => $id
        ]);
    }
    public function groupe_store(Request $request){
        // dd($request);
        $groupe = Groupe::create([
            'libelle' => $request->libelle,
            'effectif' => $request->effectif,
            'corp_id' => $request->corp_id
        ]);
        foreach ($request->eleves as $key => $value) {
            $eleve = Eleve::find($value);
            $eleve->groupe_id = $groupe->id;
            $eleve->update();
        }
        return redirect()->back()->with('success','Groupe crée avec success');
    }
    public function module_index(Request $request,$id){
        $corp = Corp::find($id);
        $matieres = Matiere::all();
        $modules = Modulo::with('matiere')->where('corp_id',$id)->get();
        return Inertia::render('Module/index',[
            'modules' => $modules,
            'corp' => $corp,
            'matieres' => $matieres,
            'id' => $id
        ]);
    }
    public function module_store(Request $request){
        $module = Modulo::create([
                'matiere_id' => $request->matiere_id,
                'corp_id' => $request->corp_id,
                'horaire' => $request->horaire,
                'coefficient' => $request->coefficient
        ]);
        return redirect()->back()->with('success','Affectation éffectué');
    }
    public function enseignant_index(Request $request){
        $ensengnant = Enseignant::all();
        return Inertia::render('Enseignant/index',[
            'enseignants' => $ensengnant
        ]);
    }
    public function enseignant_store(Request $request){
         Enseignant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'date_naiss' => $request->date_naiss,
            'lieu_naiss' => $request->lieu_naiss,
            'sexe' => $request->sexe,
            'telephone' => $request->telephone
        ]);
        return redirect()->back()->with('success','Enseignant enregistré ');
    }
}
