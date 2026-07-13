<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Autorisation;
use App\Models\Redevance;
use App\Models\NumAutorisation;
use App\Models\Route;
use App\Models\Aeronef;
use App\Models\FactureRedevance;
use App\Models\Frai;
use App\Models\RFacture;
use App\Models\Signature;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RedevanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $redevences_payees=Redevance::where('payer', '1')->with('demande','demande.aeronefs')->orderBy('id', 'asc')
        ->paginate($request->page_size ?? 10);
        $redevences_impayees=Redevance::where('payer', '0')->with('demande','demande.aeronefs')->orderBy('id', 'asc')
        ->paginate($request->page_size ?? 10);
        $aeronefs = Aeronef::select('nom_exploitant')
        ->distinct()
        ->get();
        // dd($redevences_impayees);
        $montant_paye=0;
        $montant_impaye=0;
        foreach ($redevences_payees as $key => $value) {
            # code...
            $montant_paye=$montant_paye+$value->montant;
        }
        foreach ( $redevences_impayees as $key => $value) {
            # code...
            $montant_impaye=$montant_impaye+$value->montant;

        }
        // dd($redevences_payees,$redevences_impayees);
        // dd($aeronefs);
        return Inertia::render('Redevance/index', [
            'aeronefs' =>$aeronefs,
            'redevences_payees' =>$redevences_payees,
            'redevences_impayees' =>$redevences_impayees,
            'montant_paye' =>number_format($montant_paye, 0, '', ' '),
            'montant_impaye' =>number_format($montant_impaye, 0, '', ' '),
        ]);
    }

    public function auto_rechercher(Request $request)
    {
        // dd($request->all());
        $auto_rechercher=NumAutorisation::where('autorisation_id', '1')->with('autorisation','route','autorisation.type_autorisation')->orderBy('id', 'asc')
        ->paginate($request->page_size ?? 10);
        return Inertia::render('Redevance/autorisation', [
            'auto_rechercher' =>$auto_rechercher,
        ]);
    }

    public function axiosfacture(Request $request)
    {
        // dd($request->all());

        $montant_paye=0;
        $montant_impaye=0;
        $date_debut=$request->date_debut;
        $date_fin=$request->date_fin;
        // dd($date_debut,$date_fin);
        if($date_debut!=null && $date_fin!=null){
            $redevences_payees=Redevance::where('payer', '1')->whereBetween('created_at',[$date_debut, $date_fin])->with('demande','demande.aeronefs')->get();
            $redevences_impayees=Redevance::where('payer', '0')->whereBetween('created_at',[$date_debut, $date_fin])->with('demande','demande.aeronefs')->get();
            foreach ($redevences_payees as $key => $value) {
                # code...
                $montant_paye=$montant_paye+$value->montant;
            }
            foreach ( $redevences_impayees as $key => $value) {
                # code...
                $montant_impaye=$montant_impaye+$value->montant;

            }

        }elseif($date_debut!=null && $date_fin==null){
            $redevences_payees=Redevance::where('payer', '1')->where('created_at', '>=', $date_debut)->with('demande','demande.aeronefs')->get();
            $redevences_impayees=Redevance::where('payer', '0')->where('created_at', '>=', $date_debut)->with('demande','demande.aeronefs')->get();
            foreach ($redevences_payees as $key => $value) {
                # code...
                $montant_paye=$montant_paye+$value->montant;
            }
            foreach ( $redevences_impayees as $key => $value) {
                # code...
                $montant_impaye=$montant_impaye+$value->montant;

            }
        }elseif($date_debut==null && $date_fin!=null){
            $redevences_payees=Redevance::where('payer', '1')->where('created_at','<=', $date_fin)->with('demande','demande.aeronefs')->get();
            $redevences_impayees=Redevance::where('payer', '0')->where('created_at','<=', $date_fin)->with('demande','demande.aeronefs')->get();
            foreach ($redevences_payees as $key => $value) {
                # code...
                $montant_paye=$montant_paye+$value->montant;
            }
            foreach ( $redevences_impayees as $key => $value) {
                # code...
                $montant_impaye=$montant_impaye+$value->montant;

            }
        }else {
            $redevences_payees=Redevance::where('payer', '1')->with('demande','demande.aeronefs')->latest()->take(20)->get();
            $redevences_impayees=Redevance::where('payer', '0')->with('demande','demande.aeronefs')->latest()->take(20)->get();
            foreach ($redevences_payees as $key => $value) {
                # code...
                $montant_paye=$montant_paye+$value->montant;
            }
            foreach ( $redevences_impayees as $key => $value) {
                # code...
                $montant_impaye=$montant_impaye+$value->montant;

            }
        }
        // dd($redevences_payees,$redevences_impayees);
        return ["redevences_payees" => $redevences_payees,"redevences_impayees" => $redevences_impayees,"montant_paye"=>$montant_paye,"montant_impaye"=>$montant_impaye];
    }

    public function generateRedevancePdf(Request $request)
    {
        //dd($request->all());
        $exploitant=$request->rapport['exploitant'];
        $montant_paye=0;
        $montant_impaye=0;
        $nbre_passagers_arr_d=0;
        $nbre_passagers_arr_i=0;
        $nbre_passagers_dep_d=0;
        $nbre_passagers_dep_i=0;
        $marchand_valeur =0;
        $autre_que_marchand_valeur=0;
        $nbre_passager_aut_excep=0;
        $nbre_fret_aut_excep=0;
        $total=0;
        $number='';
        $redevance_id=$request->rapport['id_redevance'];
        // dd($request->rapport['id_redevance']);
        if ($request->rapport['id_redevance']!='') {
            # code...
            $number = str_pad($request->rapport['id_redevance'], 7, '0', STR_PAD_LEFT);
            // dd( $number);
            $redevences_payees=Redevance::where('id', $request->rapport['id_redevance'])->where('payer', '1')->with('demande','demande.aeronefs')->get();
            $redevences_impayees=Redevance::where('id', $request->rapport['id_redevance'])->where('payer', '0')->with('demande','demande.aeronefs')->get();
        }else {
            $date_debut=$request->rapport['date_debut'];
            $date_fin=$request->rapport['date_fin'];
            if($date_debut!=null && $date_fin!=null){
                $redevences_payees=Redevance::where('payer', '1')->whereBetween('created_at',[$date_debut, $date_fin])->with('demande','demande.aeronefs')->get();
                $redevences_impayees=Redevance::where('payer', '0')->whereBetween('created_at',[$date_debut, $date_fin])->with('demande','demande.aeronefs')->get();

            }elseif($date_debut!=null && $date_fin==null){
                $redevences_payees=Redevance::where('payer', '1')->where('created_at', '>=', $date_debut)->with('demande','demande.aeronefs')->get();
                $redevences_impayees=Redevance::where('payer', '0')->where('created_at', '>=', $date_debut)->with('demande','demande.aeronefs')->get();


            }elseif($date_debut==null && $date_fin!=null){
                $redevences_payees=Redevance::where('payer', '1')->where('created_at','<=', $date_fin)->with('demande','demande.aeronefs')->get();
                $redevences_impayees=Redevance::where('payer', '0')->where('created_at','<=', $date_fin)->with('demande','demande.aeronefs')->get();
            }else {
                $redevences_payees=Redevance::where('payer', '1')->with('demande','demande.aeronefs')->get();
                $redevences_impayees=Redevance::where('payer', '0')->with('demande','demande.aeronefs')->get();
            }


        }

    // dd($redevences_impayees);

        foreach ($redevences_impayees as $key => $redevences_impaye) {
            # code...
            if ($redevences_impaye->demande->aeronefs[0]->nom_exploitant==$exploitant) {
                # code...
                $marchand_valeur = $marchand_valeur+intval($redevences_impaye->marchand_valeur_dep)+intval($redevences_impaye->marchand_valeur_arr);
                if ($redevences_impaye->type_vol=='1') {
                    # code...
                    $nbre_passagers_arr_d=$nbre_passagers_arr_d+intval($redevences_impaye->nbre_passagers_arr);
                    $nbre_passagers_dep_d=$nbre_passagers_dep_d+intval($redevences_impaye->nbre_passagers_dep);
                }else {
                    # code...
                    $nbre_passagers_arr_i= $nbre_passagers_arr_i+intval($redevences_impaye->nbre_passagers_arr);
                    $nbre_passagers_dep_i=$nbre_passagers_dep_i+intval($redevences_impaye->nbre_passagers_dep);
                }
                if ($redevences_impaye->autorisation_excep==0) {
                    # code...

                    $autre_que_marchand_valeur=$autre_que_marchand_valeur+intval($redevences_impaye->autre_que_marchand_valeur_arr)+intval($redevences_impaye->autre_que_marchand_valeur_dep);

                }else {
                    $nbre_passager_aut_excep=$nbre_passager_aut_excep+intval($redevences_impaye->nbre_passagers_arr)+intval($redevences_impaye->nbre_passagers_dep);
                    # code...
                    $nbre_fret_aut_excep=$nbre_fret_aut_excep+intval($redevences_impaye->autre_que_marchand_valeur_arr)+intval($redevences_impaye->autre_que_marchand_valeur_dep) ;

                }

            }
            $montant_impaye=$montant_impaye+$redevences_impaye->montant;

        }

        //  foreach ($redevences_payees as $key => $redevences_paye) {
        //     # code...
        //     if ($redevences_paye->demande->aeronefs[0]->nom_exploitant==$exploitant) {
        //         # code...
        //         $marchand_valeur = $marchand_valeur+intval($redevences_paye->marchand_valeur_dep)+intval($redevences_paye->marchand_valeur_arr);
        //         if ($redevences_paye->type_vol=='1') {
        //             # code...
        //             $nbre_passagers_arr_d=$nbre_passagers_arr_d+intval($redevences_paye->nbre_passagers_arr);
        //             $nbre_passagers_dep_d=$nbre_passagers_dep_d+intval($redevences_paye->nbre_passagers_dep);
        //         }else {
        //             # code...
        //             $nbre_passagers_arr_i= $nbre_passagers_arr_i+intval($redevences_paye->nbre_passagers_arr);
        //             $nbre_passagers_dep_i=$nbre_passagers_dep_i+intval($redevences_paye->nbre_passagers_dep);
        //         }
        //         if ($redevences_paye->autorisation_excep==0) {
        //             # code...

        //             $autre_que_marchand_valeur=$autre_que_marchand_valeur+intval($redevences_paye->autre_que_marchand_valeur_arr)+intval($redevences_paye->autre_que_marchand_valeur_dep);

        //         }else {
        //             $nbre_passager_aut_excep=$nbre_passager_aut_excep+intval($redevences_paye->nbre_passagers_arr)+intval($redevences_paye->nbre_passagers_dep);
        //             # code...
        //             $nbre_fret_aut_excep=$nbre_fret_aut_excep+intval($redevences_paye->autre_que_marchand_valeur_arr)+intval($redevences_paye->autre_que_marchand_valeur_dep) ;

        //         }

        //     }
        // }
        $frais=Frai::all();
        foreach ($frais as $key => $value) {
            # code...
            if($value->type=='RSAPID'){
                $total=$total+$nbre_passagers_dep_i*$value->montant;
            }else if($value->type=='RSPID'){
                $total=$total+$nbre_passagers_dep_i*$value->montant;
            }else if($value->type=='RSAPDD'){
                $total=$total+$nbre_passagers_dep_d*$value->montant;
            }else if($value->type=='RSPDD'){
                $total=$total+$nbre_passagers_dep_d*$value->montant;
            }else if($value->type=='RFM'){
                $total=$total+$autre_que_marchand_valeur*$value->montant;
            }else if($value->type=='RFMV'){
                $total=$total+$marchand_valeur*$value->montant;
            }else if($value->type=='AETP'){
                $total=$total+$nbre_passager_aut_excep*$value->montant;
            }else if($value->type=='AETFT'){
                $total=$total+$nbre_fret_aut_excep*$value->montant;
            }else if($value->type=='RIT'){
                $total=$total+$nbre_passagers_dep_d*$value->montant;
                $total=$total+$nbre_passagers_dep_i*$value->montant;
            }else if($value->type=='RAVC'){
                $total=$total+$nbre_passagers_dep_d*$value->montant;
                $total=$total+$nbre_passagers_dep_i*$value->montant;
            }
        }
        // $auto = Autorisation::where('reference',$request->ref)->first();
        $route=[];
        $aeronefs=[];
        $num_auto = NumAutorisation::find($request->rapport['id_redevance']);
        // dd($num_auto,$request->rapport['id_redevance']);
        if($num_auto){

            $route = Route::where('id',$num_auto->route_id)->with('demande','demande.aeronefs','ville_arive','ville_depar')->first();
            // $aeronef = Aeronef::where('demande_id',$demande->id)->first();
        }else{
            $aeronefs=Aeronef::where('nom_exploitant',$request->rapport['exploitant'])->first();
            $nom='facture de '.$aeronefs->nom_exploitant.' du '.date('d-m-Y');

            if (!$redevences_impayees->isEmpty()) {
                // dd( $montant_impaye);
                $facture= RFacture::create(['nom' => $nom,'montant' => $montant_impaye]);
                foreach ($redevences_impayees as $key => $value) {
                    FactureRedevance::create(['r_facture_id' => $facture->id,'redevance_id' => $value->id]);
                }
                $number = str_pad( $facture->id, 7, '0', STR_PAD_LEFT);
            }
        }
        // dd($route);
        $signature=Signature::where('user_id',Auth::user()->id)->first();
        $data = [
            "nbre_passagers_arr_d" => $nbre_passagers_arr_d,
            "nbre_passagers_arr_i" =>$nbre_passagers_arr_i,
            "nbre_passagers_dep_d" =>$nbre_passagers_dep_d,
            "nbre_passagers_dep_i" =>$nbre_passagers_dep_i,
            "marchand_valeur" =>$marchand_valeur,
            "autre_que_marchand_valeur" =>$autre_que_marchand_valeur,
            "nbre_passager_aut_excep" =>$nbre_passager_aut_excep,
            "nbre_fret_aut_excep" =>$nbre_fret_aut_excep,
            "exploitant"=> $exploitant,
            "frais"=>  $frais,
            "total"=>  $total,
            // 'autorisation' => $auto,
            'signature' => $signature,
            'route' => $route,
            'number' => $number,
            'redevences_impayees' => $redevences_impayees,
            'redevences_payees' => $redevences_payees,
            'montant_impaye' => $montant_impaye,
            'aeronefs' => $aeronefs,
            'redevance_id' =>$redevance_id
        ];
        // dd($frais[7]);
    //  dd($data);
        $pdf = Pdf::loadView('redevanceFacture', $data);
        return $pdf->stream();
    }

    public function getAutorisation(Request $request)
    {
        // dd($request->all());

        if($request){

            // $parts = explode('-', $request->ref);
            // $lastPart = end($parts);
            // $subString = strstr($lastPart, '/', true);
            // // Prendre les 4 derniers caractères
            // $num = substr($subString, -4);
            $num_auto = NumAutorisation::find($request->ref);
            if($num_auto){
                $auto = Autorisation::find($num_auto->autorisation_id);
                $demande = Route::where('id',$num_auto->route_id)->with('demande','demande.aeronefs')->first()->demande;
                $aeronef = Aeronef::where('demande_id',$demande->id)->first();
                $donnees = [
                    'autorisation' => $auto,
                    'demande' => $demande,
                    'aeronef' => $aeronef
                ];
                // dd($demande);
                return ['donnees' => $donnees, 'code' => 1 ];
            }else{
                return ['code' => 0 ];
            }
        }
    }

    public function payement(Request $request)
    {
        $redevance = Redevance::where('payer',0)->when($request->sort_by, function ($query, $value) {
            $query->orderBy($value, request('order_by', 'asc'));
        })->when($request->search, function ($query, $value) {
            $query->whereHas('num_autorisation', function ($q) use ($value){
                $q->where('numero','LIKE', '%' . $value . '%');
            });
        })->with('num_autorisation','num_autorisation.route','demande.aeronefs','demande')->paginate($request->page_size ?? 10);
        $redevances = $redevance->map(function ($value) {
            $numerosString = '';
            $date = new DateTime($value->num_autorisation->route->date_route);
            $type_auto = checkTypeAuto($value->num_autorisation->route->ville_arrive,$value->num_autorisation->route->ville_depart);
            if ($type_auto == 'L') {
                $numerosString .= "NE-" . $type_auto . date('y'). $value->num_autorisation->numero;
                if (Carbon::parse($value->num_autorisation->route->demande->date_demande)->diffInDays($value->num_autorisation->route->date_route) > 4) {
                    $urgence = '/N';
                } else {
                    $urgence = '/U';
                }
                 // Si le statut est égal à 1, on n'ajoute pas la variable urgence
                if ($value->num_autorisation->statut == 1) {
                    $numerosString .= "R"; // Ajouter '/R' si le statut est égal à 1
                } else {
                    // Ajouter la variable urgence si le statut n'est pas égal à 1
                    $numerosString .= '' . $urgence;
                }
            }
            return [
                "id" =>$value->id,
                "autorisation_excep" => $value->autorisation_excep,
                "type_vol" => $value->type_vol ,
                'numero' => $numerosString,
                "montant" => $value->montant,
                "nbre_passagers_arr" => $value->nbre_passagers_arr,
                "nbre_passagers_dep" => $value->nbre_passagers_dep,
                "marchand_valeur_arr" => $value->marchand_valeur_arr,
                "marchand_valeur_dep" => $value->marchand_valeur_dep,
                "autre_que_marchand_valeur_arr" => $value->autre_que_marchand_valeur_arr,
                "autre_que_marchand_valeur_dep" => $value->autre_que_marchand_valeur_dep,
                "rib" => $value->rib,
                "mode_payement" => $value->mode_payement,
            ];
        });
        // dd($redevances);
        return Inertia::render('Redevance/payement',[
            "redevances" => $redevances
        ]);
    }

    public function payer(Request $request, $id = null)
    {
        // dd($request->all());
        $redevance = Redevance::find($id ?? $request->id);
        // dd($redevance);
        $redevance->payer = 1;
        $redevance->mode_payement = $request->mode_payement;
        $redevance->rib = $request->ref_cheque;
        $redevance->update();
        return redirect()->back()->with('success','Payement a été effectué avec succès');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // dd(montant_redevance($request));
        $redevance = Redevance::create([
            'num_autorisation_id' => $request->reference,
            'demande_id' => $request->demande_id,
            'type_vol' => $request->type_vol,
            'autorisation_excep' => $request->autorisation_exceptionnelle ? 1 : 0,
            'nbre_passagers_dep' => $request->passagers_departs,
            'nbre_passagers_arr' => $request->passagers_arrives,
            'marchand_valeur_arr' => $request->marchandises_valeures_arrivees,
            'marchand_valeur_dep' => $request->marchandises_valeures_depart,
            'autre_que_marchand_valeur_arr' => $request->fret_arrives,
            'autre_que_marchand_valeur_dep' => $request->fret_depart,
            'mode_payement' => $request->mode_payement,
            'aerodrome' => $request->aerodrome,
            'poids_aeronef' => $request->poids_aeronef,
            'user_id' => Auth::user()->id,
            'montant' => montant_redevance($request->toArray())
        ]);
        $num_auto = NumAutorisation::find($request->reference);
        $num_auto->statut_redevance = 1;
        $num_auto->update();
        if($request->type == 2){
            $this->payer($request,$redevance->id);
        }
        return redirect()->back()->with('success', 'Redevance enregistrée avec succès.');
    }

    public function getMontantRedevance(Request $request)
    {

       return number_format(montant_redevance($request->data), 0, '', ' ');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $auto_rechercher = collect();
        $num_autos=NumAutorisation::whereHas('autorisation',function ($query){$query->where('type_autorisation_id',1);})->with('autorisation.type_autorisation','route.ville_depart','route.ville_arrive')->get();
        // dd('non permanent',$numeros);

        foreach ($num_autos as $item) {
            $numerosString = '';
            $date = new DateTime($item->route->date_route);
            $type_auto = checkTypeAuto($item->route->ville_arrive,$item->route->ville_depart);

                if($type_auto=='L'){
                    $numerosString .= "NE-".$type_auto.date('y').$item->numero;
                    if(Carbon::parse($item->route->demande->date_demande)->diffInDays($item->route->date_route) > 4){
                        $urgence = '/N';
                    }else{
                        $urgence = '/U';
                    }
                     // Si le statut est égal à 1, on n'ajoute pas la variable urgence
                    if ($item->statut == 1) {
                        $numerosString .= "R"; // Ajouter '/R' si le statut est égal à 1
                    } else {
                        // Ajouter la variable urgence si le statut n'est pas égal à 1
                        $numerosString .= '' . $urgence;
                    }
                    $auto_rechercher->push(['id' => $item->id, 'numero' => $numerosString]);
            }

        }
        // dd($auto_rechercher);
        return Inertia::render('Redevance/Enregistrement',[
            "auto_rechercher" => $auto_rechercher
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
