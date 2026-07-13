<?php

namespace App\Http\Controllers;

use App\Exports\AutorisationExport;
use App\Exports\AutorisationExportSage;
use App\Models\Demande;
use App\Models\Frai;
use App\Models\Facture;
use App\Models\FactureOrder;
use App\Models\NumAutorisation;
use App\Models\Autorisation;
use App\Models\TypeAutorisation;
use App\Models\Order;
use App\Models\Postulant;
use App\Models\Signature;
use App\Models\Route;
use Carbon\Carbon;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Service\Climate\OrderService;
use Illuminate\Http\JsonResponse;
class ComtapleController extends Controller
{
    //
    public function index(Request $request)
    {
        // dd($request->all());
        $postulant=Postulant::all();
        $autorisations_payes=Order::where('status', '1')->with('demande','demande.type_demande', 'demande.aeronefs','postulant')->get();
        $autorisations_impayes=Order::where('status','0')->with('demande','demande.type_demande', 'demande.aeronefs', 'postulant')->get();
        $autorisations_payees=Order::where('status', '1')->with('demande','demande.type_demande', 'demande.aeronefs','postulant')->orderBy('id', 'asc')
        ->paginate($request->page_size ?? 10);
        $autorisations_impayees=Order::where('status','0')->with('demande','demande.type_demande', 'demande.aeronefs', 'postulant')->orderBy('id', 'asc')
        ->paginate($request->page_size ?? 10);
        // dd($autorisations_impayees);
        $montant_paye=0;
        $montant_impaye=0;
        foreach ($autorisations_payes as $key => $value) {
            # code...
            $montant_paye += (float) $value->prix_total;
        }
        foreach ( $autorisations_impayes as $key => $value) {
            # code...
            $montant_impaye += (float) $value->prix_total;

        }
        // dd($autorisations_impayees);
        return Inertia::render('comptable/index', [
            'postulant'=>$postulant,
            'autorisations_payees' =>$autorisations_payees,
            'autorisations_impayees' =>$autorisations_impayees,
            'montant_paye' =>number_format($montant_paye, 0, '', ' '),
            'montant_impaye' =>number_format($montant_impaye, 0, '', ' '),
        ]);
    }

    public function axiosfacture(Request $request)
    {
        // dd($request->all());

        $montant_paye=0;
        $montant_impaye=0;
        $date_debut=$request->date_debut;
        $date_fin=$request->date_fin;
        $postulant=$request->postulant;
        if($date_debut!=null && $date_fin!=null){
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }else{
                $autorisations_payees=Order::where('status', '1')->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }elseif($date_debut!=null && $date_fin==null){
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }else{
                $autorisations_payees=Order::where('status', '1')->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }elseif($date_debut==null && $date_fin!=null){
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }else{
                $autorisations_payees=Order::where('status', '1')->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }else {
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->latest()->take(200)->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->latest()->take(200)->get();
            }else{
                $autorisations_payees=Order::where('status', '1')->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->latest()->take(200)->get();
                $autorisations_impayees=Order::where('status', '0')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->latest()->take(200)->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }
        
        // $data = collect([
        //     'data' => $autorisations_payees,
        // ]);
        // $data1 = collect([
        //     'data' => $autorisations_impayees,
        // ]);


        return ["autorisations_payees" => $autorisations_payees,"autorisations_impayees" => $autorisations_impayees,"montant_paye"=>$montant_paye,"montant_impaye"=>$montant_impaye];
    }

    public function generateRapportComptaPdf(Request $request)
    {
        // dd($request->rapport);
        $date_debut=$request->rapport['date_debut'];
        $date_fin=$request->rapport['date_fin'];
        $postulant=$request->rapport['postulant'];
        $montant_paye=0;
        $montant_impaye=0;
        $number='';
        if($date_debut!=null && $date_fin!=null){
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();

            }else{
                $autorisations_payees=Order::where('status', '1')->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }elseif($date_debut!=null && $date_fin==null){
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }else{
                $autorisations_payees=Order::where('status', '1')->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }elseif($date_debut==null && $date_fin!=null){
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
               }else{
                $autorisations_payees=Order::where('status', '1')->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }else {
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->latest()->take(200)->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->latest()->take(200)->get();
            }else{
                $autorisations_payees=Order::where('status', '1')->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->latest()->take(200)->get();
                $autorisations_impayees=Order::where('status', '0')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->latest()->take(200)->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }

        if ($request->rapport['type_facture']=='Impayées') {
            # code...
            $montant_paye=0;
            if($postulant!=null){
                $postu=Postulant::find($postulant);
                $nom='facture de '.$postu->nom_raison_sociale.' du '.date('d-m-Y');
                if (!$autorisations_impayees->isEmpty()) {
                    $facture=Facture::create(['nom' => $nom,'montant' => $montant_impaye]);
                    foreach ($autorisations_impayees as $key => $value) {
                        FactureOrder::create(['facture_id' => $facture->id,'order_id' => $value->id]);
                    }
                    $number = str_pad( $facture->id, 7, '0', STR_PAD_LEFT);
                }
            }
        }
        if ($request->rapport['type_facture']=='Payées') {
            # code...
            $montant_impaye=0;
        }
        $signature=Signature::where('user_id',Auth::user()->id)->first();

        $auto_payees = collect();
        $auto_impayees = collect(); 
        // dd($autorisations_impayees);
        $u = "";
        foreach ($autorisations_impayees as $item_impaye) {
            // dump($item_impaye->demande_id);
            // $routes=Route::where('demande_id',$item_impaye->demande_id)->whereHas('num_autorisations')->with('num_autorisations')->get();
            // foreach ( $routes as $item) {
            //     $numerosString = '';
            //     // dd($item->date_route);
            //     $date = new DateTime($item->date_route);
            //     $type_auto = checkTypeAuto($item->ville_arrive,$item->ville_depart);
            //     $numerosString .= "NE-".$type_auto.'/'.date('Y').'-'.$date->format('dm').$item->num_autorisations[0]->numero;
            //     if(Carbon::parse($item->demande->date_demande)->diffInDays($item->date_route) > 4){
            //         $numerosString .= '/N';
            //     }else{
            //         $numerosString .= '/U';
            //     }
            //     if ($item->statut == 1) {
            //         $numerosString .= '/R';
            //     }
            //     $auto_impayees->push(['id' => $item_impaye->demande_id, 'numero' => $numerosString]);
            // }
            $tab = collect();
           
                $routes = Route::where('demande_id',$item_impaye->demande_id)->with('ville_depart','ville_arrive','demande.user.postulant.type_postulant')->get();
                // $routesN = Route::where('demande_id',$item_paye->demande_id)->whereNotNull('num_autorisation')->with('autorisation.type_autorisation','ville_depart','ville_arrive','demande.user.postulant.type_postulant')->get();
                $route_ids = Route::where('demande_id',$item_impaye->demande_id)->pluck('id')->toArray();
                if($u != $item_impaye->demande_id){
                    $liste = NumAutorisation::whereIn('route_id',$route_ids)->where('statut',null)->with('autorisation.type_autorisation','route.ville_depart','route.ville_arrive')->get();

                }else{
                    $liste = NumAutorisation::whereIn('route_id',$route_ids)->with('autorisation.type_autorisation','route.ville_depart','route.ville_arrive')->get();

                }
                // $liste = NumAutorisation::whereIn('route_id',$route_ids)->with('autorisation.type_autorisation','route.ville_depart','route.ville_arrive')->get();
                // dump($liste);
                
                
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
        // die();
        // dd($auto_impayees);
        $i = "";
        foreach ($autorisations_payees as $item_paye) {
            // $routes=Route::where('demande_id',$item_paye->demande_id)->whereHas('num_autorisations')->with('num_autorisations')->get();
            // foreach ( $routes as $item) {
            //     $numerosString = '';
            //     // dd($item->date_route);
            //     $date = new DateTime($item->date_route);
            //     $type_auto = checkTypeAuto($item->ville_arrive,$item->ville_depart);
            //     $numerosString .= "NE-".$type_auto.'/'.date('Y').'-'.$date->format('dm').$item->num_autorisations[0]->numero;
            //     if(Carbon::parse($item->demande->date_demande)->diffInDays($item->date_route) > 4){
            //         $numerosString .= '/N';
            //     }else{
            //         $numerosString .= '/U';
            //     }
            //     if ($item->statut == 1) {
            //         $numerosString .= '/R';
            //     }
            //     $auto_payees->push(['id' => $item_paye->demande_id, 'numero' => $numerosString]);
            // }
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
        // dd($auto_payees,$auto_impayees);
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
        // dd($data);
        if ($montant_paye !=0 || $montant_impaye!=0) {
            # code...
            if ($request->rapport['type_export']=='PDF') {
                # code...

                $pdf = Pdf::loadView('rapportComptable', $data);
                return $pdf->stream();
            }elseif ($request->rapport['type_export']=='XLSX') {
                // dd($montant_paye,$montant_impaye);
                $donnees=new AutorisationExport($data);
                // return ($donnees)->download('data.xlsx');
                return Excel::download($donnees, 'facture.xlsx');
            }
        }else{
            // $script = "<script>window.close();</script>";
            // return response($script);
            // return redirect()->back($script)->with('error','Aucun données se trouve');

        }


    }

    public function generateRapportComptaExcelSage(Request $request)
    {
        // dd($request->rapport);
        $date_debut=$request->rapport['date_debut'];
        $date_fin=$request->rapport['date_fin'];
        $postulant=$request->rapport['postulant'];
        $montant_paye=0;
        $montant_impaye=0;
        $number='';
        if($date_debut!=null && $date_fin!=null){
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();

            }else{
                $autorisations_payees=Order::where('status', '1')->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->whereHas('demande',function ($query) use ($date_debut,$date_fin){$query->whereBetween('date_autorisation',[$date_debut, $date_fin]);})->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }elseif($date_debut!=null && $date_fin==null){
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }else{
                $autorisations_payees=Order::where('status', '1')->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->whereHas('demande',function ($query) use ($date_debut){$query->where('date_autorisation','>=', $date_debut);})->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }elseif($date_debut==null && $date_fin!=null){
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
               }else{
                $autorisations_payees=Order::where('status', '1')->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->get();
                $autorisations_impayees=Order::where('status', '0')->whereHas('demande',function ($query) use ($date_fin){$query->where('date_autorisation','<=', $date_fin);})->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }else {
            if($postulant!=null){
                $autorisations_payees=Order::where('status', '1')->where('postulant_id', $postulant)->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->latest()->take(200)->get();
                $autorisations_impayees=Order::where('status', '0')->where('postulant_id', $postulant)->doesntHave('facture_orders')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->latest()->take(200)->get();
            }else{
                $autorisations_payees=Order::where('status', '1')->with('demande','demande.type_demande','demande.aeronefs', 'postulant')->latest()->take(200)->get();
                $autorisations_impayees=Order::where('status', '0')->with('demande','demande.type_demande','demande.aeronefs',  'postulant')->latest()->take(200)->get();
            }
            foreach ($autorisations_payees as $key => $value) {
                # code...
                $montant_paye += (float) $value->prix_total;
            }
            foreach ( $autorisations_impayees as $key => $value) {
                # code...
                $montant_impaye += (float) $value->prix_total;

            }
        }

        if ($request->rapport['type_facture']=='Impayées') {
            # code...
            $montant_paye=0;
            if($postulant!=null){
                $postu=Postulant::find($postulant);
                $nom='facture de '.$postu->nom_raison_sociale.' du '.date('d-m-Y');
                if (!$autorisations_impayees->isEmpty()) {
                    $facture=Facture::create(['nom' => $nom,'montant' => $montant_impaye]);
                    foreach ($autorisations_impayees as $key => $value) {
                        FactureOrder::create(['facture_id' => $facture->id,'order_id' => $value->id]);
                    }
                    $number = str_pad( $facture->id, 7, '0', STR_PAD_LEFT);
                }
            }
        }
        if ($request->rapport['type_facture']=='Payées') {
            # code...
            $montant_impaye=0;
        }
        $signature=Signature::where('user_id',Auth::user()->id)->first();

        $auto_payees = collect();
        $auto_impayees = collect(); 
        // dd($autorisations_impayees);
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
                        $numerosString = "\n NE-".$type.date('y').$numero->numero. $caractere;
                        if ($numero->statut == 1) {
                            $numerosString = "\n NE-V".date('y').$numero->numero.'R';
                            $mont = Frai::where('type', 'R')->get()[0]->montant;
                            // $numerosString .= '/R'; // Ajouter '/R' si statut est égal à 1
                        }else{
                            $mont = Frai::where('type_autorisation_id', $type_auto->id)->where('type', $caracteres)->get()[0]->montant;
                        }
                        
                        // $mont = Frai::where('type_autorisation_id', $type_auto->id)->where('type', $caracteres)->get()[0]->montant;
                        $tab->push($numerosString);
                        $auto_impayees->push([ $item_impaye, 'numero' => $numerosString, 'montant' => $mont, 'num_facture' => $item_impaye->num_facture, 'num_facture_format' => $item_impaye->num_facture_format, 'ref_article' => $numero->ref_article]);
                        $numerosString = "";
                    }

                    // $auto_impayees->push([ $item_impaye, 'numero' => $tab]);

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
                            $mont = Frai::where('type', 'R')->get()[0]->montant;
                        } else {
                            // Ajouter la variable urgence si le statut n'est pas égal à 1
                            $numerosString .= '' . $urgence ."\n";
                            $mont = $type_auto->id == 4 ? 0 : Frai::where('type_autorisation_id', $type_auto->id)->where('type', $urgence)->get()[0]->montant;
                        }
                        // $tab[$key] = $numerosString;
                        // $mont = $type_auto->id == 4 ? 0 : Frai::where('type_autorisation_id', $type_auto->id)->where('type', $urgence)->get()[0]->montant;
                        $tab->push($numerosString);
                        $auto_impayees->push([ $item_impaye, 'numero' => $numerosString, 'montant' => $mont, 'num_facture' => $item_impaye->num_facture, 'num_facture_format' => $item_impaye->num_facture_format, 'ref_article' => $numero->ref_article]);
                        $numerosString = "";
                           
                    }
                    // $auto_impayees->push([ $item_impaye, 'numero' => $tab]);
                    
                    // dd('tab',$tab);
                }
                $u = $item_impaye->demande_id;
        }
        // die();
        // dd($auto_impayees);
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

                        if( Carbon::parse($routes[0]->demande->date_demande)->diffInDays($numero->route->date_route) > 4){
                            $urgence = 'N';
                        }else{
                            $urgence = 'U';
                        }
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
                            $mont = Frai::where('type', 'R')->get()[0]->montant;
                            // $numerosString .= '/R'; // Ajouter '/R' si statut est égal à 1
                        }else{
                            $mont = Frai::where('type_autorisation_id', $type_auto->id)->where('type', $caracteres)->get()[0]->montant;
                        }
                        // dd($urgence,$type_auto);
                       
                        // $mont = Frai::where('type_autorisation_id', $type_auto->id)->where('type', $caracteres)->get()[0]->montant;
                        // dd($urgence,$type_auto,$mont);
                        $tab1->push($numerosString);
                        // $auto_payees->push([ $item_paye, 'numero' => $numerosString, 'montant' => $mont]);
                        $auto_payees->push([ $item_paye, 'numero' => $numerosString, 'montant' => $mont, 'num_facture' => $item_paye->num_facture, 'num_facture_format' => $item_paye->num_facture_format, 'ref_article' => $numero->ref_article]);


                        $numerosString = "";    
                           
                    }
                    // $auto_payees->push([ $item_paye, 'numero' => $tab1]);

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
                            $numerosString .= "R"."\n"; 
                            $mont = Frai::where('type', 'R')->get()[0]->montant;// Ajouter '/R' si le statut est égal à 1
                        } else {
                            // Ajouter la variable urgence si le statut n'est pas égal à 1
                            $numerosString .= '' . $urgence ."\n";
                            $mont = $type_auto->id == 4 ? 0 : Frai::where('type_autorisation_id', $type_auto->id)->where('type', $urgence)->get()[0]->montant;
                        }
                       
                        // $mont = $type_auto->id == 4 ? 0 : Frai::where('type_autorisation_id', $type_auto->id)->where('type', $urgence)->get()[0]->montant;
                       
                        $tab1->push($numerosString);
                        // $auto_payees->push([ $item_paye, 'numero' => $numerosString, 'montant' => $mont]);
                        $auto_payees->push([ $item_paye, 'numero' => $numerosString, 'montant' => $mont, 'num_facture' => $item_paye->num_facture, 'num_facture_format' => $item_paye->num_facture_format, 'ref_article' => $numero->ref_article]);

                        $numerosString = "";
                           
                    }
                    // $auto_payees->push([ $item_paye, 'numero' => $tab1]);
                    // dd('tab',$tab);
                }
                $i = $item_paye->demande_id;

        }
        // dd($auto_payees,$auto_impayees);
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
        // dd($data);
        if ($montant_paye !=0 || $montant_impaye!=0) {
            # code...
            $donnees=new AutorisationExportSage($data);
            // return ($donnees)->download('data.xlsx');
            return Excel::download($donnees, 'facture.xlsx');
            
        }else{
            // $script = "<script>window.close();</script>";
            // return response($script);
            // return redirect()->back($script)->with('error','Aucun données se trouve');

        }


    }
}
