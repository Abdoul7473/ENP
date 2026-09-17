<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\EnseignantGroupeModulo;
use App\Models\Groupe;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EnseignementController extends Controller
{
    public function enseignement_index(Request $request,$id){
        $enseignants = Enseignant::all();
        $groupe = Groupe::where('id',$id)->with('corp')->get()[0];
        $modules = Modulo::with('matiere')->where('corp_id',$groupe->corp_id)->get();
        $enseignements = EnseignantGroupeModulo::with('enseignant','modulo.matiere','modulo.avancements')->where('groupe_id',$id)->get();
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
}
