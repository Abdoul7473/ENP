<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\Compagnie;
use App\Models\Situation;
use App\Models\Absent;
use App\Models\Malade;
use App\Models\Permissionnaire;
use Inertia\Inertia;

class SituationController extends Controller
{
    public function create(Request $request,$id){
        $compagnie = Compagnie::where('id',$id)->get()[0];
        $eleves = Eleve::where('compagnie_id',$id)->get();
        return Inertia::render('Situations/create',[
            'eleves' => $eleves,
            'compagnie' => $compagnie
        ]);
    }
    public function store(Request $request){
        $situation = Situation::create([
            'nombre_present' => $request->nombre_present,
            'nombre_absent' => $request->nombre_absent,
            'nombre_malade' => $request->nombre_malade,
            'nombre_permissionnaire' => $request->permissionnaire,
            'compagnie_id' => $request->compagnie_id,
            'statut' => 0
        ]);
        if ($request->eleve_absents != []){
            foreach ($request->eleve_absents as $key => $eleve_absent) {
                Absent::create([
                    'eleve_id' => $eleve_absent,
                    'situation_id' => $situation->id
                ]);
            }
        }
        if ($request->eleve_permissionnaires != []){
            foreach ($request->eleve_permissionnaires as $key => $eleve_permissionnaire) {
                Permissionnaire::create([
                    'eleve_id' => $eleve_permissionnaire,
                    'situation_id' => $situation->id
                ]);
            }
        }
        if ($request->eleve_malades != []){
            foreach ($request->eleve_malades as $key => $eleve_malade) {
                Malade::create([
                    'eleve_id' => $eleve_malade,
                    'situation_id' => $situation->id
                ]);
            }
        }
        
        return redirect()->route('situation.index',$request->compagnie_id)->with( 'success',  'Situation créée avec succès' );
    }
    public function index(Request $request,$id){
        $situations = Situation::where('compagnie_id',$id)->with('compagnie','absents.eleve','malades.eleve','permissionnaires.eleve')->when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->paginate($request->page_size ?? 10);

        return Inertia::render('Situations/index',[
            'situations' => $situations,
            'id' => $id
        ]);
    }
}
