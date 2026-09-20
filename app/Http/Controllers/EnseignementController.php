<?php

namespace App\Http\Controllers;

use App\Models\Avancement;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\EnseignantGroupeModulo;
use App\Models\Evaluation;
use App\Models\Groupe;
use App\Models\Modulo;
use App\Models\Note;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnseignementController extends Controller
{
    public function enseignement_index(Request $request,$id){
        $enseignants = Enseignant::all();
        $groupe = Groupe::where('id',$id)->with('corp')->get()[0];
        $modules = Modulo::with('matiere')->where('corp_id',$groupe->corp_id)->get();
        $enseignements = EnseignantGroupeModulo::with('enseignant','modulo.matiere','avancements')->where('groupe_id',$id)->get();
        return Inertia::render('Enseignement/index',[
            'enseignements' => $enseignements,
            'groupe' => $groupe,
            'modules' => $modules,
            'enseignants' => $enseignants,
            'id' => $id
        ]);
    }
    public function enseignement_store(Request $request){
        EnseignantGroupeModulo::create([
            'groupe_id' => $request->groupe_id,
            'modulo_id' => $request->module_id,
            'enseignant_id' => $request->enseignant_id
        ]);
        return redirect()->route('enseignement.index',$request->groupe_id)->with('success','Enregistrement effectué');
    }
    public function avancement_index(Request $request,$id){
        $avancements = Avancement::where('enseignant_groupe_modulo_id',$id)->get();
        $enseignement = EnseignantGroupeModulo::with('modulo.matiere')->where('id',$id)->get()[0];
        return Inertia::render('Avancement/index',[
            'avancements' => $avancements,
            'enseignement' => $enseignement,
            'id' => $id
        ]);
    }
    public function avancement_create(Request $request,$id){
        return Inertia::render('Avancement/create',[
                'id' => $id
        ]);
    }
    public function avancement_store(Request $request){
        Avancement::create([
             'date' => $request->date,
            'heure_depart' => $request->heure_depart,
            'heure_arrive' => $request->heure_arrive,
            'objectif_general' => $request->objectif_general,
            'objectif_specific' => $request->objectif_specific,
            'enseignant_groupe_modulo_id' => $request->id,
            'progression'=> $request->progression,
            'nombre_heure' => $request->nombre_heure
        ]);
        return redirect()->route('avancement.index',$request->id)->with('success','Avancement crée');
    }
    public function evaluation_index(Request $request,$id){
        $evaluations = Evaluation::with('enseignant_groupe_modulo.modulo.matiere')->whereHas('enseignant_groupe_modulo',function ($query) use($id){
            $query->where('groupe_id',$id);
        })->get();
        $enseignements =  EnseignantGroupeModulo::with('modulo.matiere','groupe')->where('groupe_id',$id)->get();
        $groupe = Groupe::find($id);
        return Inertia::render('Evaluation/index',[
            'evaluations' => $evaluations,
            'groupe' => $groupe,
            'enseignements' => $enseignements,
            'id' => $id
        ]);
    }
    public function note_index(Request $request,$id){
        $notes = Note::with('eleve')->where('evaluation_id',$id)->get();
        $evaluation = Evaluation::find($id);
        $enseignement =  EnseignantGroupeModulo::with('modulo.matiere','groupe')->find($evaluation->enseignant_groupe_modulo_id);
        // $groupe = Groupe::where('')
        $eleves = Eleve::where('groupe_id',$enseignement->groupe_id)->get();
        return Inertia::render('Note/index',[
            'notes' => $notes,
            'eleves' => $eleves,
            'enseignement' => $enseignement,
            'id' => $id
        ]);
    }
    public function note_store(Request $request){
        // dd($request);
        foreach ($request->notes as $key => $note) {
            if ($note !== null){
                Note::create([
                    'evaluation_id' => $request->id,
                    'note' => $note,
                    'eleve_id' => $key
                ]);
            }
        }
        return redirect()->route('note.index',$request->id)->with('success','Avancement crée');
    }
    public function evaluation_store (Request $request){
        // dd($request);
        Evaluation::create([
            'enseignant_groupe_modulo_id' => $request->enseignement_id,
            'date_evaluation' => $request->date_evaluation,
            'assistant1' =>$request->assistant1,
            'assistant2' =>$request->assistant2,
            'type_evaluation' => $request->type
        ]);
        return redirect()->route('evaluation.index',$request->id)->with('success','évaluation créée');
    }
}
