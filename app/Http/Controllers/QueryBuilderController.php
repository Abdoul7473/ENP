<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Route;
use App\Models\Demande;
use App\Models\TypeVol;
use App\Models\Postulant;
use App\Models\TypeDemande;
use App\Models\Autorisation;
use Illuminate\Http\Request;
use App\Models\NumAutorisation;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TypeAutorisation;
use Illuminate\Support\Facades\DB;
use App\Exports\AutorisationExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DemandeRepoortExport;
use Carbon\Carbon;

class QueryBuilderController extends Controller
{
    public function index(){
        $excludedTables = ['personal_access_tokens', 'role_has_permissions', 'model_has_roles', 'model_has_permissions', 'migrations'];
        $tables = [];

        // Récupération des noms de toutes les tables
        $tablesInfo = DB::select('SHOW TABLES');

        foreach ($tablesInfo as $tableInfo) {
            foreach ($tableInfo as $tableName) {
                if (!in_array($tableName, $excludedTables)) {
                    // Récupération des attributs de la table
                    $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
                    
                    // Ajouter le nom de la table, un ID et les attributs
                    $tables[] = [
                        'name' => $tableName,
                        'id' => uniqid(),
                        'columns' => $columns
                    ];
                }
            }
        }
        return Inertia::render('QueryBuilder/index', ['tables' => $tables]); 
    }
    public function create(){
        $type_demandes = TypeDemande::all();
        $users = DB::select(" SELECT *
        FROM users  WHERE type_user_id <> 4");
        $type_vols = TypeVol::all();
        $type_autoridstions = TypeAutorisation::all();
        $postulants = Postulant::all();
        return Inertia::render('Rapport/index', ['type_demandes' => $type_demandes, 'users' => $users, 'type_vols' => $type_vols, 'type_autoridstions' => $type_autoridstions, 'postulants' => $postulants]); 
    }
    public function store(Request $request){
        // dd($request->all());
        if (isset($request->data['date']) && !empty($request->data['date'])) {
            $dates = $request->data['date'];
        
            // If only one date is provided, duplicate it to create a date range
            if (count($dates) === 1) {
                $dates[] = $dates[0];
            }
        
            sort($dates);
        }

        if($request->type_rapport == 'Demande'){

            $query = $this->buildQueryDemande($request, $dates);

            $demandes['resultat'] = $query->get();
            // dd($demandes);
            $demandes['item'] = $request->all();
            
            return $demandes;
        }elseif($request->type_rapport == 'Autorisations'){
            $query = $this->buildQueryAutorisations($request, $dates);
            $autorisation['resultat'] = $query->get();
            $autorisations['resultat'] = $autorisation['resultat']->map(function ($value) {
                // dd($value->num_autorisations[0]->route->demande->type_vol_id,$value->num_autorisations[0]->route->demande->preciser);
                if (!empty($value->num_autorisations[0])) 
                {
                    if($value->num_autorisations[0]->route->demande->type_vol_id == 4){
                        $type_auto = TypeAutorisation::find(4);
                        
                    }elseif($value->num_autorisations[0]->route->demande->type_demande_id == 1){
                        $type_auto = TypeAutorisation::find(2);
                        // dd('2');
                    }else{
                        $type_auto = TypeAutorisation::find(1);
                        
                    }

                    $numerosString = '';
                    
                    // dd('avant return');
                    return [
                        "id" => $value->id,
                        "date_autorisation" => $value->date_autorisation,
                        "montant_total" => $value->montant_total,
                        "nombre_route" => $value->nombre_route,
                        "qr_code" => $value->qr_code,
                        "num_autorisations" => $value->num_autorisations,
                        "reference" => $value->reference,
                        "type_autorisation" =>$value->type_autorisation,
                        "type_autorisation_id" =>$value->type_autorisation_id,
                        "nums" => $value->num_autorisations->map(function ($query, $index) use ($value,$type_auto,$numerosString){
                            $numerosString = '';
                            if($value->num_autorisations[0]->route->demande->permanant == 1){
                                // dd('permanent');
                                $date = new DateTime($value->num_autorisations[0]->route->demande->date_autorisation);
                                $type_auto = TypeAutorisation::find(3);
                                $caracteres = moisVersCaracteres($value->num_autorisations[0]->route->demande->nbre_mois);
                                // foreach ($numeros as $index => $numero) {
                                $caractere = $caracteres[$index % count($caracteres)];
                                $type = checkTypeAuto($query->route->ville_arrive,$query->route->ville_depart);
                                
                                $numerosString .= "\n NE-".$type.date('y').$query->numero. $caractere."\n";
                            //    dd($numerosString);
                                // $numerosString .= "\n - N° DG/ANAC/".$type_auto->code.'/'.date('Y').'-'.$date->format('dm').$query->numero.'/'. $caractere."\n";
                                // $code = "N° DG/ANAC/".$type_auto->code.'/'.date('Y').'-'.$date->format('dm').$query->numero.'/'. $caractere."";
                                // }
                            }else{
                                $date = new DateTime($value->num_autorisations[0]->route->demande->date_autorisation);
                                // $type_auto = TypeAutorisation::find(3);
                                if($value->num_autorisations[0]->route->demande->type_vol_id == 4 ){
                                    $type_auto = TypeAutorisation::find(4);
                                }elseif($value->num_autorisations[0]->route->demande->type_demande_id == 1){
                                    $type_auto = TypeAutorisation::find(2);
                                }else{
                                    $type_auto = TypeAutorisation::find(1);
                                }
                                
                                if( Carbon::parse($value->num_autorisations[0]->route->demande->date_demande)->diffInDays($query->route->date_route) > 4){
                                    $urgence = 'N';
                                }else{
                                    $urgence = 'U';
                                }
                                // dd($urgence);
                                $date = new DateTime($query->route->demande->date_autorisation);
                                if($type_auto->id == 4){
                                        
                                    $numerosString .= "\n NE-".date('y').$query->numero;

                                }else{
                                    $type = checkTypeAuto($query->route->ville_arrive,$query->route->ville_depart);
                            
                                    $numerosString .= "\n NE-".$type.date('y').$query->numero;
                                }
                                 // Si le statut est égal à 1, on n'ajoute pas la variable urgence
                                if ($query->statut == 1) {
                                    $numerosString .= "R"."\n"; // Ajouter '/R' si le statut est égal à 1
                                } else {
                                    // Ajouter la variable urgence si le statut n'est pas égal à 1
                                    $numerosString .= '' . $urgence ."\n";
                                }
                                
                            }
                            return [
                                "num" => $numerosString
                            ];
                        }),
                    ];
                }
            });
            $autorisations['item'] = $request->all();
            // dd($autorisation);
            return $autorisations;
        }

    }

    public function export_rapport(Request $request){
        // dd($request);
        if ($request->tab == "autorisation"){
            // dd($request);
            $date = date('d-m-y h:i:s');
            if($request->type == 'print'){
                $pdf = Pdf::loadView('rapport/autorisation',[
                    'data' => json_decode($request->data_from),
                ]);
                return $pdf->stream();
            }
            return Excel::download(new DemandeRepoortExport(json_decode($request->data_from)), "rapport_autorisation_{$date}.xlsx");
        }else if ($request->tab == "demande") {
            $date = date('d-m-y h:i:s');
            if($request->type == 'print'){
                $pdf = Pdf::loadView('rapport/demande',[
                    'data' => json_decode($request->data_from),
                ]);
                return $pdf->stream();
            }
            return Excel::download(new DemandeRepoortExport(json_decode($request->data_from)), "rapport_demande_{$date}.xlsx");
        }
       
    }

    protected function buildQueryDemande(Request $request, $dates){
        $query = Demande::with('type_vol', 'type_demande', 'aeronefs','user.postulant', 'statut','routes','routes.ville_arrive','routes.ville_depar','routes.num_autorisations')->whereHas('user', function ($query) {
            $query->where('postulant_id', '<>', NULL);
        });

        switch ($request->data['requestSelected']) {
            case 1:
                if (empty($request->data['date'])) {
                    return "Veuillez renseigner la date de demande";
                }else{
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 2:
                if (empty($request->data['date'])) {
                    return "Veuillez renseigner la date prévue de vol";
                } else {
                    $query->whereBetween('date_prevu_vol', [$dates[0], $dates[1]]);
                }
                break;
            case 3:
                if (empty($request->data['date'])) {
                    return "Veuillez renseigner la date d'approbation";
                } else {
                    $query->whereBetween('date_approbation', [$dates[0], $dates[1]]);
                }
                break;
            case 4:
                if (empty($request->data['date'])) {
                    return "Veuillez renseigner la date d'autorisation";
                } else {
                    $query->whereBetween('date_autorisation', [$dates[0], $dates[1]]);
                }
                break;
            case 5:
                $query->where('type_demande_id', $request->data['type_demande']);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 6:
                $query->where('statut_id', 1);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 7:
                $query->where('statut_id', 2);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 8:
                $query->where('statut_id', 3);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 9: 
                $query->where('statut_id', 4);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 10:
                $query->where('statut_id', 5);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 11:
                $query->where('statut_id', 6);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 12:
                $query->where('statut_id', 7);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 13:
                $query->where('statut_id', 8);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 14:
                $query->where('statut_id', 2);
                $query->where('user_verif', $request->data['user']);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 15:
                $query->where('statut_id', 3);
                $query->where('user_appro', $request->data['user']);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 16:
                $query->where('statut_id', 4);
                $query->where('user_autoriser', $request->data['user']);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 17:
                $query->where('statut_id', 5);
                $query->where('user_rejet', $request->data['user']);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 18:
                $query->where('urgence', '<=', 4);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 19:
                $query->where('ville_fait', 'like', '%' . $request->data['ville'] . '%');
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 20:
                $query->where('type_vol_id', $request->data['type_vol']);
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 21:
                $query->whereNull('statut_id');
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            case 22:
                $query->whereHas('user', function($query) use ($request){
                    $query->where('postulant_id', $request->data['postulant']);
                });
                if (!empty($request->data['date'])) {
                    $query->whereBetween('date_demande', [$dates[0], $dates[1]]);
                }
                break;
            default:
                return "La variable n'est ni A, ni B, ni C";
        }
        return $query;
    }

    protected function buildQueryAutorisations(Request $request, $dates){
        $query = Autorisation::with('type_autorisation', 'num_autorisations.route.demande.user.postulant',
        'num_autorisations.route.demande.aeronefs','num_autorisations.route.demande.orders',
        'num_autorisations.route.ville_depar','num_autorisations.route.ville_arive')->whereHas('num_autorisations.route.demande.user', function ($query) {
            $query->where('postulant_id', '<>', NULL);
        });
        // dd($query->get());
        switch ($request->data['requestSelected']){
            case 1:
                if (empty($request->data['date'])) {
                    return "Veuillez renseigner la date d'autorisation";
                }else{
                    $query->whereBetween('date_autorisation', [$dates[0], $dates[1]]);
                }
                break;
            case 2:
                if (empty($request->data['date'])) {
                    return "Veuillez renseigner la date d'autorisation";
                }else{
                    $query->where('type_autorisation_id', $request->data['type_autoridstion']);
                    $query->whereBetween('date_autorisation', [$dates[0], $dates[1]]);
                }
                break;
            case 3:
                if (empty($request->data['date'])) {
                    return "Veuillez renseigner la date d'autorisation";
                }else{
                    $query->where('nombre_route', $request->data['operateurSelected'], $request->data['nombre']);
                    $query->whereBetween('date_autorisation', [$dates[0], $dates[1]]);
                }
                break;
            case 4:
                if (empty($request->data['date'])) {
                    return "Veuillez renseigner la date d'autorisation";
                }else{
                    $query->where('montant_total', $request->data['operateurSelected'], $request->data['nombre']);
                    $query->whereBetween('date_autorisation', [$dates[0], $dates[1]]);
                }
                break;
            case 5:
                if (empty($request->data['date'])) {
                    return "Veuillez renseigner la date d'autorisation";
                }else{
                    $query->whereHas('num_autorisations.route.demande.user', function ($query) use ($request) {
                        $query->where('postulant_id', $request->data['postulant']);
                    });
                    $query->whereBetween('date_autorisation', [$dates[0], $dates[1]]);
                }
                break;
            default:
                return "Sélectionnez une requête ";
        }
        // dd($query->get());
        return $query;
    }
}
