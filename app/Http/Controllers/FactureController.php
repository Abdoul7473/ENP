<?php

namespace App\Http\Controllers;

use App\Models\Aeronef;
use App\Models\Facture;
use App\Models\FactureOrder;
use App\Models\FactureRedevance;
use App\Models\Order;
use App\Models\Redevance;
use App\Models\NumAutorisation;
use App\Models\TypeAutorisation;
use App\Models\RFacture;
use App\Models\Signature;
use App\Models\Route;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FactureController extends Controller
{
    //
    public function index(Request $request)
    {
        // dd($request->all());

        $facture=Facture::when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })
        ->when(!isset($request->sort_by), function ($query) {
            $query->latest();
        })
        ->when($request->search, function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('nom', 'LIKE', '%'.$value.'%');
                        // ->orWhere('code_icao', 'LIKE', '%'.$value.'%')
                        // ->orWhere('region', 'LIKE', '%'.$value.'%')
                        // ->orWhere('nom', 'LIKE', '%'.$value.'%')
                        // ->orWhere('pays', 'LIKE', '%'.$value.'%')
                        // ->orWhere('libelle', 'LIKE', '%'.$value.'%');
            });
        })->with('facture_orders.order',)
        ->paginate($request->page_size ?? 10);

        $redevences=RFacture::when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })
        ->when(!isset($request->sort_by), function ($query) {
            $query->latest();
        })
        ->when($request->search, function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('nom', 'LIKE', '%'.$value.'%');
                        // ->orWhere('code_icao', 'LIKE', '%'.$value.'%')
                        // ->orWhere('region', 'LIKE', '%'.$value.'%')
                        // ->orWhere('nom', 'LIKE', '%'.$value.'%')
                        // ->orWhere('pays', 'LIKE', '%'.$value.'%')
                        // ->orWhere('libelle', 'LIKE', '%'.$value.'%');
            });
        })->with('facture_redevances.redevance.demande.aeronefs',)
        ->paginate($request->page_size ?? 10);


        // dd($facture);

        return Inertia::render('factures/index', [
            'factures'=>$facture,
            'redevences'=>$redevences,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->tab_num=='tab-1') {
            # code...
            $fact= Facture::find($request->id);
            $autos=FactureOrder::where('facture_id',$request->id)->get();
            foreach ($autos as $key => $auto) {
                # code...
                $orde=Order::find($auto->order_id);
                $orde->update( ['status'=>1,]);
            }
            $fact->update( ['rib'=>$request->ref_cheque,'mode_payement'=>$request->mode_payement,'payer'=>1,]);
            return redirect()->back()->with('success','Payement a été effectué avec succès');
        } else {
                $fact= RFacture::find($request->id);
                $reds=FactureRedevance::where('r_facture_id',$request->id)->get();
                foreach ($reds as $key => $red) {
                    # code...
                    $redev=Redevance::find($red->redevance_id);
                    $redev->update( ['status'=>1,]);
                }
                // dd($fact);
                $fact->update( ['rib'=>$request->ref_cheque,'mode_payement'=>$request->mode_payement,'payer'=>1,]);
                return redirect()->back()->with('success','Payement a été effectué avec succès');
        }



    }

    public function facture(Request $request)
    {
        // dd($request->rapport['postulant']);
        if ($request->rapport['postulant']!='') {
            # code...
            $fact=Facture::find($request->rapport['id']);
            $montant=$fact->montant;
            $orderid = FactureOrder::where('facture_id', $fact->id)->pluck('order_id');
            $autorisations=Order::whereIn('id', $orderid)->with('demande','demande.type_demande','demande.aeronefs', 'postulant','demande.user')->get();
            $number = str_pad( $request->rapport['id'], 7, '0', STR_PAD_LEFT);
            if ($request->rapport['type_facture']=='Payées') {
                # code...
                $autorisations_payees=$autorisations;
                $autorisations_impayees=[];
                $montant_impaye=0;
                $montant_paye=$montant;
            }else{
                $autorisations_payees=[];
                $autorisations_impayees=$autorisations;
                $montant_impaye=$montant;
                $montant_paye=0;
            }
            $postulant=$request->rapport['postulant'];
            // dd($autorisations);
            $signature=Signature::where('user_id',Auth::user()->id)->first();

            $auto_payees = collect();
            $auto_impayees = collect();
            $u = "";

            foreach ($autorisations_impayees as $item_impaye) {
                $tab = collect();
           
                $routes = Route::where('demande_id',$item_impaye->demande_id)->with('ville_depart','ville_arrive','demande.user.postulant.type_postulant')->get();
                // $routesN = Route::where('demande_id',$item_paye->demande_id)->whereNotNull('num_autorisation')->with('autorisation.type_autorisation','ville_depart','ville_arrive','demande.user.postulant.type_postulant')->get();
                $route_ids = Route::where('demande_id',$item_impaye->demande_id)->pluck('id')->toArray();
                if($u != $item_impaye->demande_id){
                    $liste = NumAutorisation::whereIn('route_id',$route_ids)->where('statut',null)->with('autorisation.type_autorisation','route.ville_depart','route.ville_arrive')->get();

                }else{
                    $liste = NumAutorisation::whereIn('route_id',$route_ids)->with('autorisation.type_autorisation','route.ville_depart','route.ville_arrive')->get();

                }
                $groupRoutes = $routes->groupBy('date_route');
                // dd($liste,$groupRoutes);
                $numerosString = "";

                // Parcourir chaque numéro et ajouter à la chaîne
                if($routes[0]->demande->permanant == 1){
                    $caracteres = moisVersCaracteres($routes[0]->demande->nbre_mois);
                    $type_auto = TypeAutorisation::find(3);
                    // Vérification de la taille des deux tableaux pour éviter tout dépassement
                    foreach ($liste as $index => $numero) {
                        // $date = new DateTime($numero->route->date_route);
                        $date = new DateTime($routes[0]->demande->date_autorisation);
                        // Récupération du caractère correspondant à l'index actuel
                        $caractere = $caracteres[$index % count($caracteres)];
                        $type = checkTypeAuto($numero->route->ville_arrive,$numero->route->ville_depart);
                        // $type = checkTypeAuto($numero->route->ville_arrive);
                        // Ajout du numéro avec le caractère correspondant à la fin de la chaîne
                        $numerosString = "\n NE-".$type.date('y').$numero->numero.'/'. $caractere;
                        if ($numero->statut == 1) {
                            $numerosString = "\n NE-".$type.date('y').$numero->numero.'R';
                            // $numerosString .= '/R'; // Ajouter '/R' si statut est égal à 1
                        }
                        $tab->push($numerosString);
                        $numerosString = "";
                    }
                    $auto_impayees->push([ $item_impaye, 'numero' => $tab]);

                }else{
                   
                    if($routes[0]->demande->type_vol_id == 4 ){
                        $type_auto = TypeAutorisation::find(4);
                    }elseif($routes[0]->demande->type_demande_id == 1){
                        $type_auto = TypeAutorisation::find(2);
                    }else{
                        $type_auto = TypeAutorisation::find(1);
                    }
                    foreach ($liste as $key => $numero) {
                       
                        if( Carbon::parse($routes[0]->demande->date_demande)->diffInDays($numero->route->date_route) > 4){
                            $urgence = 'N';
                        }else{
                            $urgence = 'U';
                        }
                        $date = new DateTime($routes[0]->demande->date_autorisation);
                        if($type_auto->id == 4){
                                
                            $numerosString .= "\n NE-".date('y').$numero->numero;

                        }else{
                            $type = checkTypeAuto($numero->route->ville_arrive,$numero->route->ville_depart);
                    
                            $numerosString .= "\n NE-".$type.date('y').$numero->numero;
                        }
                        
                        // Si le statut est égal à 1, on n'ajoute pas la variable urgence
                        if ($numero->statut == 1) {
                            $numerosString .= "R"."\n"; // Ajouter '/R' si le statut est égal à 1
                        } else {
                            // Ajouter la variable urgence si le statut n'est pas égal à 1
                            $numerosString .= '' . $urgence ."\n";
                        }
                        // $tab[$key] = $numerosString;
                        $tab->push($numerosString);
                        $numerosString = "";
                           
                    }
                    $auto_impayees->push([ $item_impaye, 'numero' => $tab]);
                    
                    // dd('tab',$tab);
                }
                $u = $item_impaye->demande_id;
            }

            $i = "";
            foreach ($autorisations_payees as $item_paye) {
                $tab1 = collect();
                $routes = Route::where('demande_id',$item_paye->demande_id)->with('ville_depart','ville_arrive','demande.user.postulant.type_postulant')->get();
                // $routesN = Route::where('demande_id',$item_paye->demande_id)->whereNotNull('num_autorisation')->with('autorisation.type_autorisation','ville_depart','ville_arrive','demande.user.postulant.type_postulant')->get();
                $route_ids = Route::where('demande_id',$item_paye->demande_id)->pluck('id')->toArray();
                if($i != $item_paye->demande_id){
                    $liste = NumAutorisation::whereIn('route_id',$route_ids)->with('autorisation.type_autorisation','route.ville_depart','route.ville_arrive')->get();
                }else{
                    $liste = NumAutorisation::whereIn('route_id',$route_ids)->with('autorisation.type_autorisation','route.ville_depart','route.ville_arrive')->get();
                }
                // $numeros = $routesN->groupBy('num_autorisation');
                // $numeros = $liste->groupBy('numero');
                $groupRoutes = $routes->groupBy('date_route');
                // dd($liste,$groupRoutes);
                $numerosString = "";

                // Parcourir chaque numéro et ajouter à la chaîne
                if($routes[0]->demande->permanant == 1){
                    $caracteres = moisVersCaracteres($routes[0]->demande->nbre_mois);
                    $type_auto = TypeAutorisation::find(3);
                    // Vérification de la taille des deux tableaux pour éviter tout dépassement
                    foreach ($liste as $index => $numero) {
                        // $date = new DateTime($numero->route->date_route);
                        $date = new DateTime($routes[0]->demande->date_autorisation);
                        // Récupération du caractère correspondant à l'index actuel
                        $caractere = $caracteres[$index % count($caracteres)];
                        $type = checkTypeAuto($numero->route->ville_arrive,$numero->route->ville_depart);
                        // $type = checkTypeAuto($numero->route->ville_arrive);
                        // Ajout du numéro avec le caractère correspondant à la fin de la chaîne
                        $numerosString = "\n NE-".$type.date('y').$numero->numero. $caractere;
                        if ($numero->statut == 1) {
                            $numerosString = "\n NE-".$type.date('y').$numero->numero.'R';
                            // $numerosString .= '/R'; // Ajouter '/R' si statut est égal à 1
                        }
                        $tab1->push($numerosString);
                        $numerosString = "";
                           
                    }
                    $auto_payees->push([ $item_paye, 'numero' => $tab1]);

                }else{
                   
                    if($routes[0]->demande->type_vol_id == 4 ){
                        $type_auto = TypeAutorisation::find(4);
                    }elseif($routes[0]->demande->type_demande_id == 1){
                        $type_auto = TypeAutorisation::find(2);
                    }else{
                        $type_auto = TypeAutorisation::find(1);
                    }
                    foreach ($liste as $key => $numero) {
                        // $date = new DateTime($numero->route->date_route);
                        if( Carbon::parse($routes[0]->demande->date_demande)->diffInDays($numero->route->date_route) > 4){
                            $urgence = 'N';
                        }else{
                            $urgence = 'U';
                        }
                        $date = new DateTime($routes[0]->demande->date_autorisation);
                        if($type_auto->id == 4){
                                
                            $numerosString .= "\n NE-".date('y').$numero->numero;

                        }else{
                            $type = checkTypeAuto($numero->route->ville_arrive,$numero->route->ville_depart);
                       
                            $numerosString .= "\n NE-".$type.date('y').$numero->numero;
                        }
                           
                         // Si le statut est égal à 1, on n'ajoute pas la variable urgence
                        if ($numero->statut == 1) {
                            $numerosString .= "R"."\n"; // Ajouter '/R' si le statut est égal à 1
                        } else {
                            // Ajouter la variable urgence si le statut n'est pas égal à 1
                            $numerosString .= '' . $urgence ."\n";
                        }
                        $tab1->push($numerosString);
                        $numerosString = "";
                           
                    }
                    $auto_payees->push([ $item_paye, 'numero' => $tab1]);
                    // dd('tab',$tab);
                }
                $i = $item_paye->demande_id;
            }
            // dd($auto_impayees[0]['id']);
            $data = [
                "autorisations_payees" => $autorisations_payees,
                "autorisations_impayees" => $autorisations_impayees,
                "montant_paye"=>$montant_paye,
                "montant_impaye"=>$montant_impaye,
                "postulant"=>$postulant,
                'signature' => $signature,
                'number' => $number,
                'auto_impayees' => $auto_impayees,
                'auto_payees' => $auto_payees,
            ];
            $pdf = Pdf::loadView('rapportComptable', $data);
            return $pdf->stream();
        } else {
            # code...
            // dd($request->all());
            $montant_impaye=0;
            $aeronefs=Aeronef::find($request->rapport['exploitant']);
            $number = str_pad( $request->rapport['id'], 7, '0', STR_PAD_LEFT);
            $redevanceid = FactureRedevance::where('r_facture_id', $request->rapport['id'])->pluck('redevance_id');
            $redevences_impayees=Redevance::whereIn('id', $redevanceid)->with('demande','demande.aeronefs')->get();
            foreach ($redevences_impayees as $key => $redevences_impaye) {
                # code...
                $montant_impaye=$montant_impaye+$redevences_impaye->montant;
            }
            $signature=Signature::where('user_id',Auth::user()->id)->first();
            $data = [
                // 'autorisation' => $auto,
                'signature' => $signature,
                'number' => $number,
                'redevences_impayees' => $redevences_impayees,
                'montant_impaye' => $montant_impaye,
                'aeronefs' => $aeronefs,
                'redevance_id' =>''
            ];
            // dd($frais[7]);
        //  dd($data);
            $pdf = Pdf::loadView('redevanceFacture', $data);
            return $pdf->stream();
        }

    }
}
