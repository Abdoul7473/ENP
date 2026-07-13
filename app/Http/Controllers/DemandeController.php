<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\Aeronef;
use App\Models\Postulant;
use Carbon\Carbon;
use App\Models\Autorisation;
use App\Models\Demande;
use App\Models\Signature;
use App\Models\DemandeFichierRequi;
use App\Models\NumAuto;
use App\Models\Email;
use App\Models\NumAutorisation;
use App\Models\Renvoi;
use App\Models\Frai;
use App\Models\User;
use App\Models\Route;
use App\Models\Statut;
use App\Models\TypeAutorisation;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Mail;
use App\Mail\SampleMail;
use App\Events\ChangeStatusDemande;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Bus;
use Dotenv\Dotenv;
use Illuminate\Support\Facades\Mail as FacadesMail;

class DemandeController extends Controller
{

    // les fonctions ajax
    public function fichierRequis(Request $request)
    {
        // dd($request->all());
        if ($request->id) {
            $fichiers = DemandeFichierRequi::where('demande_id', $request->id)->with('demande.user.postulant', 'fichier_requi')->get();
            return ['fichiers' => $fichiers, 'code' => 1];
        } else {
            return ['fichiers' => [], 'code' => 0];
        }
    }

    public function updateFilesCheck(Request $request)
    {
        // dd($request->all());
        if ($request->fichiers) {

            foreach ($request->fichiers as $key => $fichier) {
                if ($fichier['check']) {
                    $check = 1;
                } else {
                    $check = 0;
                }
                # code...
                $ligne = DemandeFichierRequi::find($fichier['id']);
                // dd($ligne);
                $ligne->update(['check' => $check]);
            }
            return ['code' => 1];
        } else {
            return ['fichiers' => [], 'code' => 0];
        }
    }

        public function details(Request $request)
        {
            if($request->id){
                $demande = Demande::where('id',$request->id)->with('user.postulant.type_postulant','type_demande','type_vol','statut')->first();
                $aeronef = Aeronef::where('demande_id',$request->id)->first();
                $fichiers = DemandeFichierRequi::where('demande_id',$request->id)->with('fichier_requi')->get();
                $motif_renvoies = Renvoi::where('demande_id',$request->id)->orderBy('id', 'desc')->get();
                $routes = [];

                // $routes = Route::where('demande_id',$request->id)->get();
                $data = Route::where('demande_id',$request->id)->with('ville_depart','ville_arrive')->orderBy('date_route')->get();
                $routes = $data->groupBy('date_route');

                $donnees = [
                    'demande' => $demande,
                    'aeronef' => $aeronef,
                    'fichiers' => $fichiers,
                    'routes' => $routes,
                    'motif_renvois' => $motif_renvoies
                ];
                return ['donnees' => $donnees, 'code' => 1];
            }else{
                return ['fichiers' => [], 'code' => 0];
            }
        }

        public function changeStatus(Request $request)
        {
            // dd($request->all());
            // $code = $request['code'];
            if($request){
                $code = $request->code;
                $id = $request->id;
                $demande = Demande::where('id',$id)->with('user.postulant','statut')->first();
                $emails = [];
                if($code == 0){
                    $statut = Statut::where('libelle','REJETEE')->first();
                    $demande->update(['statut_id' => $statut->id,'date_rejet' => date('Y-m-d'), 'motif_rejet' => $request->motif]);
                    return ['code' => 1];
                }elseif($code == 1){
                    $statut = Statut::where('libelle','RENVOYEE')->first();
                    $demande->update(['statut_id' => $statut->id]);
                    Renvoi::create([
                        'date_renvoi' => date('Y-m-d'),
                        'motif_renvoi' => $request->motif,
                        'statut' => 0,
                        'demande_id' => $demande->id
                    ]);
                    return ['code' => 1];
                }elseif($code == 2){
                    if($demande->statut->libelle == 'EN ATTENTE'){


                        $statut = Statut::where('libelle','VERIFIEE')->first();
                        $demande->update(['statut_id' => $statut->id,'user_verif'=>Auth::user()->id,'date_verif' => date('Y-m-d')]);

                        $verifs = User::where('type_user_id',2)->get();
                        foreach ($verifs as $key => $verif) {
                            # code...
                            $emails[$key] = $verif->email;
                        }
                        // dd($emails);
                        $donnees = [
                            'subject' => 'Rappel',
                            'email' => $emails,
                            'lien' => 'https://ldsa.anac.ne',
                            'contenu' => "Merci de vous connecter sur la plateforme le plutot possible pour traiter les demandes en instance. \n Please connect to the platform as soon as possible to process pending requests. ",
                            'type' => 1
                        ];
                        dispatch(new SendEmailJob($donnees));
                        // dd('ok');
                        // broadcast(new ChangeStatusDemande('hello world!'));
                        return ['code' => 1];
                    }elseif($demande->statut->libelle == 'VERIFIEE'){

                        $statut = Statut::where('libelle','APPROUVEE')->first();
                        $demande->update(['statut_id' => $statut->id,'user_appro'=>Auth::user()->id,'date_approbation' => date('Y-m-d')]);

                        $verifs = User::where('type_user_id',3)->get();
                        foreach ($verifs as $key => $verif) {
                            # code...
                            $emails[$key] = $verif->email;
                        }
                        // dd($emails);
                        $donnees = [
                            'subject' => 'Rappel',
                            'email' => $emails,
                            'lien' => 'https://ldsa.anac.ne',
                            'contenu' => "Merci de vous connecter sur la plateforme le plutot possible pour traiter les demandes en instance. \n Please connect to the platform as soon as possible to process pending requests.",
                            'type' => 1
                        ];
                        dispatch(new SendEmailJob($donnees));
                        // dd('ok');
                        return ['code' => 1];
                    }
                    elseif($demande->statut->libelle == 'APPROUVEE'){

                        //  dd($demande->user->email);
                        $statut = Statut::where('libelle','AUTORISEE')->first();
                        $demande->update(['statut_id' => $statut->id,'user_autoriser'=>Auth::user()->id,'date_autorisation' => date('Y-m-d')]);

                        $donnees = [
                            'email' => $demande->user->email,
                            'lien' => 'www.google.com',
                            'contenu' => "Votre autorisation est prête, Merci de vous connecter sur la plateforme pour proceder au paiement en fin de pouvoir la telecharger \n Your authorization is ready, please connect to the platform to make the payment at the end of being able to download it ",
                            'type' => 1
                        ];
                        dispatch(new SendEmailJob($donnees));
                        // dd('ok');
                        return ['code' => 1];
                    }
                }
            }else{
                return ['code' => 0];
            }
        }

        public function autorisation(Request $request){
            // dd($request->all());
            // dd($this->moisVersCaracteres(20));
            $year = Carbon::now('Europe/Paris')->year; 
            // dd('year',$year);
            if($request){
                $route = Route::find($request->id);
                if($request->check){
                    // Cas de l'autorisation permanente
                    if($route->demande->permanant == 1){
                        $results = moisVersCaracteres($route->demande->nbre_mois);
                        if($results){
                            foreach ($results as $key => $value) {
                                $num_auto = NumAuto::where('annee',$year)->first();
                                # code...
                                if($num_auto){
                                    $num = sprintf('%04d',(($num_auto->num) + (1)));
                                    $num_simple = $num_auto->num + 1;
                                    $num_auto->update(['num' => $num_simple]);
                                }else{
                                    $num = sprintf('%04d',1);
                                    $num_simple = 1;
                                    NumAuto::create(['num' => $num_simple,'annee' => $year]);
                                }
                                $saveNum = NumAutorisation::create([
                                    'route_id' => $route->id,
                                    'numero' => $num
                                ]);
                            }
                        }
                    }else{
                        $num_auto = NumAuto::where('annee',$year)->first();
                        if($num_auto){
                            $num = sprintf('%04d',(($num_auto->num) + (1)));
                            $num_simple = $num_auto->num + 1;
                            $num_auto->update(['num' => $num_simple]);
                        }else{
                            $num = sprintf('%04d',1);
                            $num_simple = 1;
                            NumAuto::create(['num' => $num_simple,'annee' => $year]);
                        }
                        $saveNum = NumAutorisation::create([
                            'route_id' => $route->id,
                            'numero' => $num
                        ]);
                    }
                    $route->check = 1;
                    $route->save();
                    // $route->update(['num_autorisation' => $num]);
                    // return ['code' => 1, 'num' => $num];
                }else{
                    $num_auto = NumAuto::where('annee',$year)->first();
                    $num_autorisation = NumAutorisation::where('route_id',$route->id)->get();
                    if($num_autorisation->count() > 1){
                        foreach ($num_autorisation as $key => $value) {
                            # code...
                            $value->delete();
                            $num_auto->update(['num' => $num_auto->num - 1]);
                        }
                    }else{
                        $num_autorisation[0]->delete();
                        // $route->update(['num_autorisation' => null]);
                        $num_auto->update(['num' => $num_auto->num - 1]);
                    }
                    $route->check = null;
                    $route->save();
                }
            }else{

            }
        }

        public function getAnnuleAutorisation(Request $request){
            // dd($request->all());
            $year = Carbon::now('Europe/Paris')->year;  
            if($request){
                // $demande = Demande::where('id',$request->demande_id)->with('type_demande','type_vol')->first();
                $data = Route::where('demande_id',$request->demande_id)->get();
                $num_auto = NumAuto::where('annee',$year)->first();
                foreach ($data as $key => $value) {
                    # code...
                    if($value->num_autorisation != null){
                        $num_autorisation = NumAutorisation::where('route_id',$value->id)->first();
                        $num_autorisation->delete();
                        // $value->update(['num_autorisation' => null]);
                        $num_auto->update(['num' => $num_auto->num - 1]);
                    }
                    $value->check = null;
                    $value->save();
                }
                return ['code' => 1];
            }else{
                return ['code' => 0];
            }

        }

        public function getValideAutorisation(Request $request){
            if($request){
                try {
                    //code...
                    // DB::beginTransaction();
                    $demande = Demande::where('id',$request->demande_id)->with('type_demande','type_vol','user.postulant')->first();
                    $frais = getPrixAutorisation($demande);
                    $data = Route::where('demande_id',$request->demande_id)->pluck('id')->toArray();
                    // $count = Route::where('demande_id',$request->demande_id)->distinct('num_autorisation')->count();
                    $count = NumAutorisation::whereIn('route_id',$data)->count();
                    $listes = NumAutorisation::whereIn('route_id',$data)->get();
                    // $numeros = Route::where('demande_id',$request->demande_id)->distinct('num_autorisation')->pluck('num_autorisation')->toArray();
                    // $numeros = NumAutorisation::whereIn('route_id',$data)->pluck('numero')->toArray();
                    $numeros = NumAutorisation::whereIn('route_id', $data)->with('route')->get();
                    // dd('numeros',$numeros);
                    $numerosString = "NUMEROS AUTORISATION \n" ;

                    $numerosString = genererCodes($demande, $numeros);

                    if($demande->type_vol_id == 4 ){
                        $type_auto = TypeAutorisation::find(4);
                    }elseif($demande->type_demande_id == 1){
                        $type_auto = TypeAutorisation::find(2);
                    }else{
                        $type_auto = TypeAutorisation::find(1);
                    }
                   
                    $numerosString .= "\nanacniger@anac.ne/dta.survolat@anac.ne";

                    $montant = getPrixAutorisation($demande);
                    $autorisation = Autorisation::create([
                        'date_autorisation' => date('Y-m-d'),
                        'reference' => null,
                        'nombre_route' => $count,
                        'montant_total' => $montant,
                        'type_autorisation_id' => $type_auto->id
                    ]);
                    // dd($numerosString);
                    $filename = 'qrcode'.date('y-m-d').date('h-i-s').$autorisation->id;
                    // dd($filename);
                    $qrDir = public_path('qr_code');
                    if (!is_dir($qrDir)) {
                        mkdir($qrDir, 0755, true);
                    }
                    $qr_code = QrCode::format('svg')->size(300)->generate($numerosString, $qrDir.'/'.$filename.'.svg');
                    $autorisation->update(['qr_code' => $filename]);
                    // foreach ($data as $key => $value) {
                    //     # code...
                    //     $value->update(['autorisation_id' => $autorisation->id]);
                    // }
                    // dd('ok');
                    foreach ($listes as $key => $value) {
                        # code...
                        $value->update(['autorisation_id' => $autorisation->id]);
                    }
                    $statut = Statut::where('libelle','AUTORISEE')->first();
                    $signature = Signature::where('user_id',Auth::user()->id)->first();
                    $demande->update([
                        'statut_id' => $statut->id,
                        'date_autorisation' => date('Y-m-d'),
                        'user_autoriser'=>Auth::user()->id,
                        'signature_id'=>$signature->id ?? null,
                    ]);

                    $order = new Order();
                    $order->status = 0;
                    $order->demande_id = $demande->id;
                    $order->postulant_id = $demande->user->postulant_id;
                    $order->prix_total = $frais;
                    $order->save();

                    $donnees = [
                        'subject' => 'Autorisation',
                        'contenu' => "Votre autorisation est disponible, merci de se rendre sur la plateforme proceder au paiement en fin de pouvoir la telecharger \n Your authorization is available, please go to the platform to make payment to be able to download it",
                        'lien' => 'https://ldsa.anac.ne',
                        'email' => $demande->user->email,
                        'type' => 1
                    ];

                    dispatch(new SendEmailJob($donnees));

                    // Envoi de l'autorisation par mail
                    $mails = Email::all();
                    foreach ($mails as $key => $mail) {
                        $mails[$key] = $mail->name;
                    }
                    // dd($emails);
                    $donnees1 = [
                        'subject' => 'Payement',
                        'email' => $mails,
                        'fichier' => 'https://ldsa.anac.ne/autorisation/pdf?id='.$demande->id,
                        'contenu' => "Merci de recevoir l\'autorisation \n Please receive permission",
                        'type' => 1
                    ];
                    // dd($donnees);
                    dispatch(new SendEmailJob($donnees1));

                    return ['code' => 1];

                } catch (\Throwable $th) {
                    throw $th;
                }
                // DB::commit();
            }else{
                // dd('drappp');
                return ['code' => 0];
            }
        }

        public function detailAutorisation(Request $request)
        {
            if ($request->id) {
                $routes = Route::where('demande_id', $request->id)
                    ->with('ville_depart', 'ville_arrive', 'demande.user.postulant.type_postulant')
                    ->get();

                $route_ids = $routes->pluck('id')->toArray();
                
                // Récupérer uniquement les numéros enregistrés
                $liste = NumAutorisation::whereIn('route_id', $route_ids)
                    ->with('autorisation.type_autorisation', 'route.ville_depart', 'route.ville_arrive')
                    ->get();

                $groupRoutes = $routes->groupBy('date_route');
                $tab = [];

                foreach ($liste as $key => $numero) {
                    $tab[$key] = $numero->code; // On récupère directement le numéro sans le reconstruire
                }
                // dd($tab);

                $donnees = [
                    'demande' => $routes[0]->demande,
                    'aeronef' => Aeronef::where('demande_id', $routes[0]->demande->id)->first(),
                    'autorisation' => $liste->first()->autorisation ?? null,
                    'routes' => $groupRoutes,
                    'numeros' => $tab, // Liste des numéros directement extraits de NumAutorisation
                ];

                return ['donnees' => $donnees, 'code' => 1];
            } else {
                return ['code' => 0];
            }
        }

        public function revision(Request $request){
            $year = Carbon::now('Europe/Paris')->year;  
            if($request->id){
                try {
                    $demande = Demande::where('id',$request->id)->with('type_demande','type_vol','user')->first();
                    // $frais = getPrixAutorisation($demande);
                    // dd($frais);
                    $frais = 66000;
                    // $aeronef = Aeronef::where('demande_id',$request->id)->first();
                    $routes = Route::where('demande_id',$request->id)->with('ville_depart','ville_arrive','demande.user.postulant.type_postulant')->get();
                    $autorisation = NumAutorisation::where('route_id',$routes[0]->id)->with('autorisation.type_autorisation')->first();
                    // dd($autorisation);
                    $data = Route::where('demande_id',$request->id)->pluck('id')->toArray();
                    $numeros = NumAutorisation::whereIn('route_id',$data)->with('autorisation','route.ville_depart','route.ville_arrive')->get();
                    $num_auto = NumAuto::where('annee',$year)->first();
                    $check = NumAutorisation::where('revise',1)->where('autorisation_id',$autorisation->autorisation_id)->get();
                    $code = "";
                    // dd($check,$autorisation->autorisation_id);
                    if($check->count() != 0){
                        // dd('1');
                        foreach ($numeros as $key => $numero) {
                            if($numero->revise == 1){
                                $num = sprintf('%04d',(($num_auto->num) + (1)));
                                $num_simple = $num_auto->num + 1;
                                $num_auto->update(['num' => $num_simple]);
                                $saveNum = NumAutorisation::create([
                                    'route_id' => $numero->route_id,
                                    'autorisation_id' => $numero->autorisation_id,
                                    'numero' => $num,
                                    'statut' => 1,
                                ]);
                            }
                        }
                    }else{
                        // dd('2');
                        foreach ($numeros as $key => $numero) {
                            # code...
                            $num = sprintf('%04d',(($num_auto->num) + (1)));
                            $num_simple = $num_auto->num + 1;
                            $num_auto->update(['num' => $num_simple]);
                            $saveNum = NumAutorisation::create([
                                'route_id' => $numero->route_id,
                                'autorisation_id' => $numero->autorisation_id,
                                'numero' => $num,
                                'statut' => 1,
                            ]);
                        }
                    }

                    $numeros = NumAutorisation::whereIn('route_id',$data)->with('autorisation','route')->get();
                    
                    $numerosString = genererCodes($demande, $numeros);
                    // dd($numeros);
                    $numerosString = "NUMEROS AUTORISATION \n";
                    
                    $numerosString .= "anacniger@anac.ne/dta.survolat@anac.ne";

                    $filename = 'qrcode'.date('y-m-d').date('h-i-s').$autorisation->autorisation->id;
                    $qrDir = public_path('qr_code');
                    if (!is_dir($qrDir)) {
                        mkdir($qrDir, 0755, true);
                    }
                    $qr_code = QrCode::format('svg')->size(300)->generate($numerosString, $qrDir.'/'.$filename.'.svg');
                    $autorisation->autorisation->update(['qr_code' => $filename]);

                    $statut = Statut::where('libelle','AUTORISEE')->first();
                    $demande->update([
                        'statut_id' => $statut->id,
                    ]);

                    $order = new Order();
                    $order->status = 0;
                    $order->demande_id = $demande->id;
                    $order->postulant_id = $demande->user->postulant_id;
                    $order->prix_total = $frais;
                    $order->save();

                    $donnees = [
                        'subject' => 'Autorisation pour révision',
                        'contenu' => "La révision est éffective, merci de se rendre sur la plateforme pour telecharger l\"autorisation \n The revision is effective, please go to the platform to download the authorization ",
                        'lien' => 'https://ldsa.anac.ne',
                        'email' => $demande->user->email,
                        'type' => 1
                    ];

                    dispatch(new SendEmailJob($donnees));
                    // Envoi de l'autorisation par mail
                    $mails = Email::all();
                    foreach ($mails as $key => $mail) {
                        $mails[$key] = $mail->name;
                    }
                    // dd($emails);
                    $donnees1 = [
                        'subject' => 'Payement',
                        'email' => $mails,
                        'fichier' => 'https://ldsa.anac.ne/autorisation/pdf?id='.$demande->id,
                        'contenu' => "Merci de recevoir l\'autorisation \n Please receive permission",
                        'type' => 1
                    ];
                    // dd($donnees);
                    dispatch(new SendEmailJob($donnees1));

                    return ['code' => 1];
                } catch (\Throwable $th) {
                    throw dd($th);
                }
                // DB::commit();
            }else{
                return ['code' => 0];
            }
        }

    // fin fonctions ajax


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$type)
    {
        // dd($request->all(),$type);
        $demandes = Demande::where('statut_id', $type)->with('type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs')
            ->when($request->search, function ($query, $value) {
            $query->whereHas('aeronefs', function ($subQuery) use ($value) {
                $subQuery->where('imatriculation', 'LIKE', '%' . $value . '%')
                ->orWhere('indicatif_appel', 'LIKE', '%' . $value . '%')
                ->orWhere('demande_id', 'LIKE', '%' . $value . '%');
            });
        })
        ->orderBy('date_prevu_vol', 'asc')
            ->paginate(10);

        return Inertia::render('traitementDemande/index', [
            'demandes' => $demandes,
            'type' => $type
        ]);
    }

    public function generateAutorisationPdf(Request $request,$type = null)
    {
        if($request){
            $tab = [];
            $routes = Route::where('demande_id',$request->id)->with('ville_depart','ville_arrive','demande.user.postulant.type_postulant','demande.signature')->get();
            $plusPetiteDate = Route::where('demande_id', $request->id)
            ->with('ville_depart', 'ville_arrive', 'demande.user.postulant.type_postulant', 'demande.signature')
            ->orderBy('date_route', 'asc')  // Trie par date croissante
            ->first();  
            $plusGrandeDate = Route::where('demande_id', $request->id)
            ->with('ville_depart', 'ville_arrive', 'demande.user.postulant.type_postulant', 'demande.signature')
            ->orderBy('date_route', 'desc')  // Trie par date croissante
            ->first(); 
            // dd($plusPetiteDate,$plusGrandeDate);
            $routesN = Route::where('demande_id',$request->id)->whereNotNull('num_autorisation')->with('autorisation.type_autorisation','ville_depart','ville_arrive','demande.user.postulant.type_postulant')->get();
            $route_ids = Route::where('demande_id',$request->id)->pluck('id')->toArray();
            $liste = NumAutorisation::whereIn('route_id',$route_ids)->with('autorisation.type_autorisation','route.ville_depart','route.ville_arrive')->get();
            // $numeros = $routesN->groupBy('num_autorisation');
            $numeros = $liste->groupBy('numero');
            // dd('nums',$numeros);
            $groupRoutes = $routes->groupBy('date_route');
           
            foreach ($liste as $key => $numero) {
                if($numero->code){
                    $tab[$key] = $numero->code;
                }  // On récupère directement le numéro sans le reconstruire
            }
          
            $donnees = [
                'demande' => $routes[0]->demande,
                'aeronef' => $aeronef = Aeronef::where('demande_id', $routes[0]->demande->id)->first(),
                'autorisation' => $liste[0]->autorisation,
                'routes' => $routes,
                'date_route_debut' => $plusPetiteDate,
                'date_route_fin' => $plusGrandeDate,
                'numeros' => $tab,
                'signature' => $routes[0]->demande->signature,
            ];
            $pdf = Pdf::loadView('autorisation', $donnees);
            if($type == 1){
                return $pdf->output();
            }else{
                return $pdf->stream();
            }
        }
    }

    public function checkout(Request $request){
        try {
            $order = Order::where('demande_id', $request->demande_id)
                ->where('status', 0)
                ->first();

            if (!$order) {
                return redirect()->route('homepostulant')
                    ->with('error', 'Aucune facture en attente pour cette demande.');
            }

            $expectedAmount = (float) str_replace(' ', '', (string) $order->prix_total);

            if ($expectedAmount <= 0) {
                return redirect()->route('homepostulant')
                    ->with('error', 'Montant invalide, merci de reessayer.');
            }

            $client = new Client();
            $request->session()->put('demande_id', $request->demande_id);
            $request->session()->put('order_id', $order->id);
            
            $response = $client->post('https://api-gateway.orabankne.ngenius-payments.com/identity/auth/access-token', [
                'headers' => [
                    'Authorization' => 'Basic MWIzMDRlNDEtZjI0Mi00NGNkLTljMzItYjAwMTRmMzc3Njg0OmM1OWYyMGJkLWNmMzgtNGViNy04NDQyLWU1ZjdmNjhiM2U2MA==',
                    'Content-Type' => 'application/vnd.ni-identity.v1+json',
                ]
            ]);
          
            $output = json_decode($response->getBody()->getContents(), true);
            $request->session()->put('access_token', $output['access_token']);
            // dd($output);
            $response1 = $client->post('https://api-gateway.orabankne.ngenius-payments.com/transactions/outlets/a6be2e91-f4f8-4a83-bc5c-8194bfb87c11/orders', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $output['access_token'],
                    'Content-Type' => 'application/vnd.ni-payment.v2+json',
                    'Accept' => 'application/vnd.ni-payment.v2+json',
                ],
                'json' => [
                    'action' => 'SALE',
                    'amount' => [
                        'currencyCode' => 'XOF',
                        'value' => $expectedAmount,
                        // 'value' => 1000,
                    ],
                    'billingAddress' => [
                        'firstName' => 'ANAC',
                        'lastName' => 'NIGER',
                    ],
                    'merchantAttributes' => [
                        'redirectUrl' => url('https://ldsa.anac.ne/success'), 
                        'skipConfirmationPage' => true,
                        // 'skip3DS' => true,
                        'cancelUrl' => url('https://ldsa.anac.ne/homepostulant'), 
                        'cancelText' => 'Retour'
                    ],
                    // 'merchantAttributes' => [
                    //     "redirectUrl" => route('checkout.success'),
                    // ],
                ],
            ]);
            // dd(json_decode($response1->getBody()->getContents(), true));
            $output1 = json_decode($response1->getBody()->getContents(), true);
            // dd($output1);
            // return redirect($output1['_links']['payment']['href']);
            if (isset($output1['_links']['payment']['href'])) {
                return redirect($output1['_links']['payment']['href']);
            } else {
                return redirect()->route('homepostulant')->with('error', 'Une erreur est survenue.');
            }
        } catch (\Throwable $e) {
            return redirect()->route('homepostulant')
                ->with('error', 'Probleme de connexion internet, merci de verifier et reessayer!');
        }
    }

    public function success(Request $request){
        // dd($request->session()->get('demande_id'));
        // dd($request->all(),$request->ref);


        // je dois enregistrer en premier lieu la reference dans orders comme ce qui suit, ensuite ajouter champs ref dans la table orders et continuer la documentation de chat
        // $order = Order::where('demande_id',$request->session()->get('demande_id'))->where('status',0)->first();
        // $order->ref = $request->ref;

        try {
            $accessToken = $request->session()->get('access_token');
            $demandeId = $request->session()->get('demande_id');
            $orderId = $request->session()->get('order_id');

            if (!$accessToken || !$demandeId || !$orderId) {
                return redirect()->route('homepostulant')
                    ->with('error', 'Session expirée, merci de relancer le paiement.');
            }

            $client = new Client();
            $response = $client->get('https://api-gateway.orabank.ngenius-payments.com/transactions/outlets/a6be2e91-f4f8-4a83-bc5c-8194bfb87c11/orders/'. $request->ref, [
                'headers' => [
                   'Authorization' => 'Bearer ' . $accessToken,
                ]
            ]);
            $output = json_decode($response->getBody()->getContents(), true);
            $state = data_get($output, '_embedded.payment.0.state');
            $paidAmount = data_get($output, 'amount.value')
                ?? data_get($output, '_embedded.payment.0.amount.value');
            $paidCurrency = data_get($output, 'amount.currencyCode')
                ?? data_get($output, '_embedded.payment.0.amount.currencyCode');

            if ($state === 'CAPTURED') {
                $order = Order::where('id', $orderId)
                    ->where('demande_id', $demandeId)
                    ->first();

                if (!$order || $order->status == 1) {
                    return redirect()->route('homepostulant')
                        ->with('success', 'Paiement déjà confirmé.');
                }

                $expectedAmount = (int) str_replace(' ', '', (string) $order->prix_total);
                $paidAmountInt = $paidAmount === null ? null : (int) $paidAmount;
                if ($paidAmountInt === null || $paidAmountInt !== $expectedAmount || ($paidCurrency && $paidCurrency !== 'XOF')) {
                    return redirect()->route('homepostulant')
                        ->with('error', 'Montant payé invalide, merci de contacter le support.');
                }

                $mails = [];
                $order->status = 1;
                $order->session_id = $accessToken;
                $order->save();
        
                $demande = Demande::find($demandeId);
                if ($demande->payer == null &&  $demande->payer_revise == 1 &&  $demande->statut_id == 4) {
                    $demande->payer_revise = 0;
                    $demande->payer = 1 ;
                }else {
                    $demande->payer = 1 ;
                }
        
                $demande->save();

                Payment::create([
                    'demande_id' => $demande->id,
                    'order_id' => $order->id,
                    'postulant_id' => $demande->user->postulant_id,
                    'mode' => 'visa',
                    'amount' => $order->prix_total,
                ]);

                $request->session()->forget('demande_id');
                $request->session()->forget('order_id');
                $request->session()->forget('access_token');

                return redirect()->route('homepostulant')->with('success', 'Votre payement à été effectué avec succès');

            }else{
                return redirect()->route('homepostulant')->with('error', 'Votre payement a echoué merci de réessayer');
            }
        } catch (\Throwable $e) {
            return redirect()->route('homepostulant')
                ->with('error', 'Erreur de paiement, merci de réessayer.');
        }

    }

    public function relanceEmail(){

        $verif = Demande::whereNull('date_approbation')->WhereNull('date_verif')->WhereNull('date_autorisation')->first();
        $chef_service = Demande::whereNull('date_approbation')->WhereNotNull('date_verif')->WhereNull('date_autorisation')->first();
        $chef_depart = Demande::whereNotNull('date_approbation')->WhereNotNull('date_verif')->WhereNull('date_autorisation')->first();
        $emails = [];

        if(!$verif && !$chef_service && !$chef_depart){
            return ['code' => 0];
        }else{
            if($verif){
                $users = User::where('type_user_id',1)->get();
                foreach ($users as $key => $user) {
                    # code...
                    $emails[$key] = $user->email;
                }
                $donnees = [
                    'subject' => 'Rappel',
                    'email' => $emails,
                    'lien' => 'https://ldsa.anac.ne/',
                    'contenu' => "Merci de vous connecter sur la plateforme le plutot possible pour traiter les demandes en instance \n Please connect to the platform as soon as possible to process pending requests.",
                    'type' => 1
                ];
                // dd($donnees);
                dispatch(new SendEmailJob($donnees));
                $emails = [];
            }
            if($chef_service){
                $users = User::where('type_user_id',2)->get();
                foreach ($users as $key => $user) {
                    # code...
                    $emails[$key] = $user->email;
                }
                $donnees = [
                    'subject' => 'Rappel',
                    'email' => $emails,
                    'fichier' => 'https://ldsa.anac.ne/',
                    'contenu' => "Merci de vous connecter sur la plateforme le plutot possible pour traiter les demandes en instance \n Please connect to the platform as soon as possible to process pending requests.",
                    'type' => 1
                ];
                // dd($donnees);
                dispatch(new SendEmailJob($donnees));
                $emails = [];
            }
            if($chef_depart){
                $users = User::where('type_user_id',3)->get();
                foreach ($users as $key => $user) {
                    # code...
                    $emails[$key] = $user->email;
                }
                $donnees = [
                    'subject' => 'Rappel',
                    'email' => $emails,
                    'fichier' => 'https://ldsa.anac.ne/',
                    'contenu' => "Merci de vous connecter sur la plateforme le plutot possible pour traiter les demandes en instance \n Please connect to the platform as soon as possible to process pending requests.",
                    'type' => 1
                ];
                // dd($donnees);
                dispatch(new SendEmailJob($donnees));
                $emails = [];
            }
            return ['code' => 1];
        }
    }

    public function ajout_signature(Request $request)
    {
        $fichier = $request->signature_cache;
        if ( Auth::user()->type_user_id==5) {
            $nomfichier = 'c'.Auth::user()->id.'_'.$fichier->getClientOriginalName();
            $fichier->move( 'signatures/comptable/', $nomfichier );
            # code...
        } else  {
            # code...
            $nomfichier = 'cd'.Auth::user()->id.'_'.$fichier->getClientOriginalName();
            $fichier->move( 'signatures/dg/', $nomfichier );
        }
        
      
        Signature::updateOrInsert(
            ['user_id' => Auth::user()->id], // Condition
            [
                'user_id' => Auth::user()->id,         // Values to update/insert
                'libelle' => $nomfichier
            ]
        );
        return redirect()->back();
    }
}
