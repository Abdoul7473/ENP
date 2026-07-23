<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Annee;
use App\Models\Encadreur;
use App\Models\Rapport;
use App\Models\Situation;
use Barryvdh\DomPDF\Facade\Pdf;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        $annee = Annee::where('statut', 1)->first();
        $officiers = Encadreur::where('is_commandant', 1)->get();
        $rapports = Rapport::with('encadreur','situations.compagnie',)->when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->paginate($request->page_size ?? 10);
        return Inertia::render('Rapport/index', [
            'rapports' => $rapports,
            "officiers" => $officiers
        ]);
    }
    public function store(Request $request)
    {
        $situations = Situation::where('statut', 0)->get();
        $rapport = Rapport::create([
            'description' => $request->description,
            'encadreur_id' => $request->officier
        ]);
        foreach ($situations as $key => $situation) {
            $situation->rapport_id = $rapport->id;
            $situation->statut = 1;
            $situation->update();
         }
        return redirect()->route('rapport.index')->with('success', 'Rapport généré');
    }
    public function GeneratePDF(Request $request){
        $rapport = Rapport::where('id',$request->id)->with('situations.compagnie','encadreur')->get()[0];
        $data = [
            'rapport' => $rapport
        ];
        // dd($cartes);
        $pdf = Pdf::loadView('rapport', $data);
        return $pdf->stream();
    }
}
