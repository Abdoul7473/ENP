<?php

namespace App\Http\Controllers;

use App\Exports\RapportExport;
use App\Models\Absent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Annee;
use App\Models\Encadreur;
use App\Models\Malade;
use App\Models\Permissionnaire;
use App\Models\Rapport;
use App\Models\Situation;
use App\Models\Visiteur;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        $annee = Annee::where('statut', 1)->first();
        $officiers = Encadreur::where('is_commandant', 1)->get();
        $rapports = Rapport::with('encadreur', 'situations.compagnie',)->when($request->sort_by, function ($query, $value) {
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
    public function GeneratePDF(Request $request)
    {
        $rapport = Rapport::with('situations.compagnie', 'encadreur.grade')->find($request->id);
        $situations = Situation::where('rapport_id', $request->id)->with('absents', 'malades', 'permissionnaires')->get();
        $malades = Malade::with('situation.compagnie')->whereHas('situation', function ($query) use ($request) {
            $query->where('rapport_id', $request->id);
        })->get();
        $absents = Absent::with('situation.compagnie')->whereHas('situation', function ($query) use ($request) {
            $query->where('rapport_id', $request->id);
        })->get();
        $permissionnaires = Permissionnaire::with('situation.compagnie')->whereHas('situation', function ($query) use ($request) {
            $query->where('rapport_id', $request->id);
        })->get();

        $data = [
            'rapport' => $rapport,
            'total_effectif' => $rapport->situations->sum('compagnie.effectif'),
            'total_present' => $rapport->situations->sum('nombre_present'),
            'total_malade' => $rapport->situations->sum('nombre_malade'),
            'total_permissionnaire' => $rapport->situations->sum('nombre_permissionnaire'),
            'total_absent' => $rapport->situations->sum('nombre_absent'),
            'situations' => $situations,
            'malades' => $malades,
            'absents' => $absents,
            'permissionnaires' => $permissionnaires,
        ];
        // dd($cartes);
        $pdf = Pdf::loadView('rapport', $data);
        return $pdf->stream();
    }
    public function Query(Request $request)
    {
        $visiteurs = Visiteur::all();
        $results = $visiteurs->whereBetween('date', [$request['data']['date_interval'][0], $request['data']['date_interval'][1]]);
        return $results;
    }
    public function ExportExcel(Request $request)
    {
        if ($request->tab == 1) {
            return Excel::download(new RapportExport(json_decode($request->resultat)), "Visiteurs.xlsx");
        } else {
            $pdf = Pdf::loadView('/rapport/visiteur', [
                'datas' => json_decode($request->resultat),
                'type' => 2
            ]);
            return $pdf->stream();
        }
    }
}
