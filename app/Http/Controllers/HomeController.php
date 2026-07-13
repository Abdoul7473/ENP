<?php

namespace App\Http\Controllers;

use App\Models\Pay;
use App\Models\Ville;
use App\Models\TermsDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {
    public function __construct() {
        $this->middleware('auth')->only('index');
    }

    public function index() {
        $dateDebut = now()->startOfMonth();
        $dateFin = now()->endOfMonth();

        $demandesParJour = DB::table('demandes')
            ->select(
                DB::raw('DATE(date_demande) as date_demande'),
                DB::raw('COUNT(*) as nombre_demandes_par_jour')
            )
            ->whereBetween('date_demande', [$dateDebut, $dateFin])
            ->groupBy(DB::raw('DATE(date_demande)'))
            ->orderBy(DB::raw('DATE(date_demande)'))
            ->get();
            //dd($demandesParJour);
        $demandesParMoisAnneeEnCours = DB::table('demandes')
        ->select(
            DB::raw('YEAR(date_demande) as annee'),
            DB::raw('MONTHNAME(date_demande) as mois'),
            DB::raw('MONTH(date_demande) as mois_numero'),
            DB::raw('COUNT(*) as nombre_demandes')
        )
        ->whereYear('date_demande', '=', date('Y'))
        ->groupBy('annee', 'mois', 'mois_numero')
        ->orderBy('annee')
        ->orderBy('mois_numero')
        ->get();
        $demandesParPostulant = DB::table('demandes')
        ->select(
            'postulants.nom_raison_sociale',
            'users.id as id_postulant',
            DB::raw('count(*) as nombre_demandes'),
            DB::raw('SUM(IF(demandes.statut_id = 4, 1, 0)) as nombre_demandes_autorisees'),
            DB::raw('SUM(IF(demandes.statut_id = 5, 1, 0)) as nombre_demandes_rejetees'),
            DB::raw('SUM(IF(demandes.statut_id != 0, 1, 0)) as nombre_demandes_soumises')
        )
            ->join('users', 'demandes.user_id', '=', 'users.id')
            ->join('postulants', 'users.postulant_id', '=', 'postulants.id')
            ->groupBy('users.id', 'postulants.nom_raison_sociale')
            ->get();
        $totalDemandesSoumises = $demandesParPostulant->sum('nombre_demandes_soumises');
        $totalDemandesAutorisees = $demandesParPostulant->sum('nombre_demandes_autorisees');
        $totalDemandesRejetees = $demandesParPostulant->sum('nombre_demandes_rejetees');
        //dd($demandesParMoisAnneeEnCours);
        return Inertia::render( 'home', [
            'items' => $demandesParPostulant,
            'totalDemandesSoumises' => $totalDemandesSoumises,
            'totalDemandesAutorisees' => $totalDemandesAutorisees,
            'totalDemandesRejetees' => $totalDemandesRejetees,
            'demandesParMois' => $demandesParMoisAnneeEnCours
        ] );
    }

    public function demandesParJour($mois) {
        $data = DB::table('demandes')
            ->selectRaw('DAY(date_demande) as jour, COUNT(*) as nombre_demandes')
            ->whereMonth('date_demande', 2)
            ->whereYear('date_demande', date('Y'))
            ->groupBy('jour')
            ->orderBy('jour')
            ->get();
        //dd($data, $mois);
        return $data; 
    }

    public function connexionpage( Request $request ) {
        if(Auth::check()){
            if (Auth::user()->postulant_id != null) {
                return redirect()->intended(RouteServiceProvider::POSTULANT);
            } else {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }else{
            $pays = Pay::all();
            // return $request->pay_id;
            if ( $request->pay_id ) {
                $villes = Ville::where( 'pay_id', $request->pay_id )->get();
                return $villes;
            }
            $docs = TermsDocument::all()->keyBy('type');
            $terms = [
                'cgu' => $docs->get('cgu') ? [
                    'url' => '/documents/terms/' . $docs->get('cgu')->filename,
                    'name' => $docs->get('cgu')->original_name,
                    'mime' => $docs->get('cgu')->mime_type,
                ] : null,
                'deposit' => $docs->get('deposit') ? [
                    'url' => '/documents/terms/' . $docs->get('deposit')->filename,
                    'name' => $docs->get('deposit')->original_name,
                    'mime' => $docs->get('deposit')->mime_type,
                ] : null,
            ];
            return Inertia::render( 'ConnexionPage', [
                'pays' => $pays,
                'terms' => $terms,
            ] );
        }
    }
}
