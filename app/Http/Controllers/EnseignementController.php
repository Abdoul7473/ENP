<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Avancement;
use App\Models\Compagnie;
use App\Models\Corp;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\EnseignantGroupeModulo;
use App\Models\Evaluation;
use App\Models\Groupe;
use App\Models\Ligne;
use App\Models\Modulo;
use App\Models\Note;
use App\Models\Releve;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Ramsey\Uuid\Type\Integer;
use Barryvdh\DomPDF\Facade\Pdf;


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
    public function releve_index(Request $request){
        // dd($request);
        $releves = $request->groupe_id ? Releve::with('eleve')->whereHas('eleve',function ($query) use ($request){
            $query->where('groupe_id',$request->groupe_id);
        })->get() : [];
        // dd($releves);
        $groupes = $request->corp_id ? Groupe::where('corp_id',$request->corp_id)->get() : [];
        $corps = Corp::all();
        return Inertia::render('Releve/index',[
            'corps' => $corps,
            'groupes' => $groupes,
            'releves' => $releves
        ]);
    }
    public function releve_generate(Request $request){
        $eleves = Eleve::where('groupe_id',$request->groupe_id)->get();
        foreach ($eleves as $key => $eleve) {
            $total_coefficient_classe = 0;
            $total_note_classe = 0;
            $total_note_coefficiente_classe = 0;
            $total_coefficient_examen = 0;
            $total_note_examen = 0;
            $total_note_coefficiente_examen = 0;
            $releve = Releve::create([
                'eleve_id' => $eleve->id
            ]);
            $note_exames = Note::where('eleve_id',$eleve->id)->with('evaluation.enseignant_groupe_modulo.modulo.matiere')->whereHas('evaluation',function ($query) use ($request){
                $query->where('type_evaluation','Examen');
            })->get();
            
            $note_devoirs = Note::where('eleve_id',$eleve->id)->with('evaluation.enseignant_groupe_modulo.modulo.matiere')->whereHas('evaluation',function ($query) use ($request){
                $query->where('type_evaluation','Dévoir');
            })->get();
            // dd($note_devoirs);
            foreach ($note_devoirs as $key => $note) {
                $note_coefficient_devoir = $note->note*$note->evaluation->enseignant_groupe_modulo->modulo->coefficient;
                // dump($note_coefficient);
                $total_coefficient_classe = $note->evaluation->enseignant_groupe_modulo->modulo->coefficient + $total_coefficient_classe;
                $total_note_classe = $note->note + $total_note_classe;
                $total_note_coefficiente_classe = $note_coefficient_devoir + $total_note_coefficiente_classe;
                Ligne::create([
                    'matiere' => $note->evaluation->enseignant_groupe_modulo->modulo->matiere->libelle,
                    'coefficient' => $note->evaluation->enseignant_groupe_modulo->modulo->coefficient,
                    'note' => $note->note,
                    'note_coefficiente' => $note->evaluation->enseignant_groupe_modulo->modulo->coefficient * $note->note,
                    'type' => 'Dévoir',
                    'releve_id' => $releve->id
                ]);
                // $moyenne_classe = 
            }
            foreach ($note_exames as $key => $note) {
                $note_coefficient_examen = $note->note*$note->evaluation->enseignant_groupe_modulo->modulo->coefficient;
                $total_coefficient_examen = $note->evaluation->enseignant_groupe_modulo->modulo->coefficient + $total_coefficient_examen;
                $total_note_examen = $note->note + $total_note_examen;
                $total_note_coefficiente_examen = $note_coefficient_examen + $total_note_coefficiente_examen;
                Ligne::create([
                    'matiere' => $note->evaluation->enseignant_groupe_modulo->modulo->matiere->libelle,
                    'coefficient' => $note->evaluation->enseignant_groupe_modulo->modulo->coefficient,
                    'note' => $note->note,
                    'note_coefficiente' => $note->evaluation->enseignant_groupe_modulo->modulo->coefficient * $note->note,
                    'type' => 'Examen',
                    'releve_id' => $releve->id
                ]);
            } 
            $moyenne_classe = $total_note_coefficiente_classe / $total_coefficient_classe;
            $moyenne_examen = $total_note_coefficiente_examen / $total_coefficient_examen;
            $releve->total_coefficient_classe = $total_coefficient_classe;
            $releve->total_note_classe = $total_note_classe;
            $releve->total_note_coefficiente_classe = $total_note_coefficiente_classe;
            $releve->moyenne_classe = $moyenne_classe;
            $releve->moyenne_classe = $moyenne_classe;

            $releve->total_coefficient_examen = $total_coefficient_examen;
            $releve->total_note_examen = $total_note_examen;
            $releve->total_note_coefficiente_examen = $total_note_coefficiente_examen;
            $releve->moyenne_examen = $moyenne_examen;
            $releve->moyenne_examen = $moyenne_examen;
            $releve->update();

        }
       
        return response()->json([
        ]);
    }
    public function ReleveGenerate(Request $request,$id){
        $releve_devoir = Ligne::where('releve_id',$id)->where('type','Dévoir')->with('releve.eleve')->get();
        // dd($releve_devoir);
        $releve_examen = Ligne::where('releve_id',$id)->where('type','Examen')->with('releve.eleve')->get();
        $data = [
            'annee' => Annee::where('statut',1)->get()[0],
            'releve_devoir' => $releve_devoir,
            'releve_examen' => $releve_examen,
        ];
        // dd($cartes);
        $pdf = Pdf::loadView('releve', $data);
        return $pdf->stream();
    }
}
