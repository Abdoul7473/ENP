<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Perm;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function index(Request $request){
        $annee_actif = Annee::where('statut',1)->first();
        // dd($annee_actif);
        $eleves = Eleve::whereHas('compagnie',function ($query) use($annee_actif){
            $query->where('annee_id',$annee_actif->id);
        } )->get();
        $permissionnaires = Perm::with('eleve')->get();
        return Inertia::render('permissionnaires/index',[
            'eleves' => $eleves,
            'permissionnaires' => $permissionnaires
        ]);
    }
    public function store(Request $request){
        $perm = Perm::create([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'nombre_jour' => $request->nombre_jour,
            'heure_arrive' => $request->heure_arrive,
            'lieu' => $request->lieu,
            'motif' => $request->motif,
            'eleve_id' => $request->eleve,
        ]);
        if (strlen($perm->id)== 1) {
            $num = '000' . $perm->id;
        }elseif(strlen($perm->id)== 2){
            $num = '00' . $perm->id;
        }elseif(strlen($perm->id)==3){
            $num = '0'.$perm->id;
        }else{
            $num = $perm->id;
        }
        $perm->numero = $num . "/ENP/SG";
        $perm->update();
        return redirect()->back()->with('success','Permission crée avec succès');
    }
    public function PermissionPdf($id){
        $gmtDate = Carbon::now( 'GMT' );
        $date = $gmtDate->format( 'd/m/Y' );
        $perm = Perm::where('id',$id)->with('eleve.compagnie.corp')->get()[0];
        $data = [
            'permission' => $perm,
            'date' => $date
        ];
        $pdf = Pdf::loadView('permission', $data);
        return $pdf->stream();
    }
}
