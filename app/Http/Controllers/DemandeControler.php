<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Frai;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Route;
use App\Models\Renvoi;
use App\Models\Aeronef;
use App\Models\Demande;
use App\Models\NumAuto;
use App\Models\TypeVol;
use App\Models\Aeroport;
use App\Models\Postulant;
use App\Models\AppSetting;
use App\Jobs\SendEmailJob;
use App\Models\TypeDemande;
use App\Models\Autorisation;
use App\Models\FichierRequi;
use Illuminate\Http\Request;
use App\Models\NumAutorisation;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TypeAutorisation;
use Illuminate\Support\Facades\DB;
use App\Events\ChangeStatusDemande;
use App\Models\DemandeFichierRequi;
use Illuminate\Support\Facades\Auth;

class DemandeControler extends Controller
{
    //

    public function index(Request $request)
    {
        // Logique pour la page d'accueil du contrôleur
        $demandes_en_attentes = Demande::where('user_id', Auth::user()->id)->where('statut_id', 1)->with('type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs')->orderBy('date_prevu_vol', 'asc')
            ->paginate($request->page_size ?? 10);
            // dd($demandes_en_attentes);
        return Inertia::render('Demandes/index', [
            'demandes_en_attentes' => $demandes_en_attentes,
        ]);
    }

    public function autoriser(Request $request)
    {
        // Logique pour la page d'accueil du contrôleur
        $demandes = Demande::where('user_id',Auth::user()->id);
        $demandes_attentes = Demande::where('user_id',Auth::user()->id)->where('statut_id',1);
        $demandes_revisees = Demande::where('user_id',Auth::user()->id)->where('revise',1);
        $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 );
        $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 );
        $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 );
        $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4)->with('type_demande','type_vol','statut','user.postulant','aeronefs')->orderBy('date_prevu_vol','asc')
        ->paginate($request->page_size ?? 10);
        return Inertia::render('Demandes/autoriser', [
            'demandes_autorisees' => $demandes_autorisees,
            'nbre_annule' => $demandes_annulees->count(),
            'nbre_renvoi' => $demandes_renvoyees->count(),
            'nbre_rejet' => $demandes_rejetees->count(),
            'nbre_auto' => $demandes_autorisees->count(),
            'nbre_demandes' => $demandes->count(),
            'nbre_attente' => $demandes_attentes->count(),
            'nbre_revisees' => $demandes_revisees->count(),
        ]);
    }
    public function ajout_signature(Request $request)
    {
        // Logique pour la page d'accueil du contrôleur
        $fichier = $request->signature_cache;
        $postulant = Postulant::find( Auth::user()->postulant_id );
        $nomfichier = 'P'.$postulant->id.'_'.$fichier->getClientOriginalName();
        $fichier->move( 'signatures/postulant/', $nomfichier );
        $postulant->update( [ 'signature_cachet'=>$nomfichier ] );
        return redirect()->back();
    }

    public function renvoyer( Request $request ) {
        // Logique pour la page d'accueil du contrôleur
        if ($request->demande_id){
            $renvoi = Renvoi::where('demande_id',$request->demande_id)->get();
            return $renvoi;
        }
        $demandes = Demande::where('user_id',Auth::user()->id);
        $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4);
        $demandes_attentes = Demande::where('user_id',Auth::user()->id)->where('statut_id',1);
        $demandes_revisees = Demande::where('user_id',Auth::user()->id)->where('revise',1);
        $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 );
        $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 );
        $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 )->with( 'type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs')->orderBy( 'date_prevu_vol', 'asc' )
        ->paginate( $request->page_size ?? 10 );
        return Inertia::render( 'Demandes/renvoyer', [
            'demandes_renvoyees' => $demandes_renvoyees,
            'nbre_annule' => $demandes_annulees->count(),
            'nbre_renvoi' => $demandes_renvoyees->count(),
            'nbre_rejet' => $demandes_rejetees->count(),
            'nbre_auto' => $demandes_autorisees->count(),
            'nbre_demandes' => $demandes->count(),
            'nbre_attente' => $demandes_attentes->count(),
            'nbre_revisees' => $demandes_revisees->count(),
        ] );
    }

    public function rejeter(Request $request)
    {
        // Logique pour la page d'accueil du contrôleur
        $demandes = Demande::where('user_id',Auth::user()->id);
        $demandes_attentes = Demande::where('user_id',Auth::user()->id)->where('statut_id',1);
        $demandes_revisees = Demande::where('user_id',Auth::user()->id)->where('revise',1);
        $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4);
        $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 );
        $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 );
        $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 )->with( 'type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs' )->orderBy( 'date_prevu_vol', 'asc' )
        ->paginate( $request->page_size ?? 10 );
        return Inertia::render( 'Demandes/rejeter', [
            'demandes_rejetees' => $demandes_rejetees,
            'nbre_annule' => $demandes_annulees->count(),
            'nbre_renvoi' => $demandes_renvoyees->count(),
            'nbre_rejet' => $demandes_rejetees->count(),
            'nbre_auto' => $demandes_autorisees->count(),
            'nbre_demandes' => $demandes->count(),
            'nbre_attente' => $demandes_attentes->count(),
            'nbre_revisees' => $demandes_revisees->count(),
        ] );
    }

    public function annuler( Request $request ) {
        // Logique pour la page d'accueil du contrôleur
        $demandes = Demande::where('user_id',Auth::user()->id);
        $demandes_attentes = Demande::where('user_id',Auth::user()->id)->where('statut_id',1);
        $demandes_revisees = Demande::where('user_id',Auth::user()->id)->where('revise',1);
        $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4);
        $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 );
        $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 );
        $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 )->with( 'type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs' )->orderBy( 'date_prevu_vol', 'asc' )
        ->paginate( $request->page_size ?? 10 );
        return Inertia::render( 'Demandes/annuler', [
            'demandes_annulees' => $demandes_annulees,
            'nbre_annule' => $demandes_annulees->count(),
            'nbre_renvoi' => $demandes_renvoyees->count(),
            'nbre_rejet' => $demandes_rejetees->count(),
            'nbre_auto' => $demandes_autorisees->count(),
            'nbre_demandes' => $demandes->count(),
            'nbre_attente' => $demandes_attentes->count(),
            'nbre_revisees' => $demandes_revisees->count(),
        ] );
    }

    public function attentes( Request $request ) {
        // Logique pour la page d'accueil du contrôleur
        $demandes = Demande::where('user_id',Auth::user()->id);
        $demandes_attentes = Demande::where('user_id',Auth::user()->id)->where('statut_id',1)->with( 'type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs' )->orderBy( 'date_prevu_vol', 'asc' )
        ->paginate( $request->page_size ?? 10 );
        $demandes_revisees = Demande::where('user_id',Auth::user()->id)->where('revise',1);
        $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4);
        $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 );
        $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 );
        $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 );
        return Inertia::render( 'Demandes/attentes', [
            'demandes_attentes' => $demandes_attentes,
            'nbre_annule' => $demandes_annulees->count(),
            'nbre_renvoi' => $demandes_renvoyees->count(),
            'nbre_rejet' => $demandes_rejetees->count(),
            'nbre_auto' => $demandes_autorisees->count(),
            'nbre_attente' => $demandes_attentes->count(),
            'nbre_demandes' => $demandes->count(),
            'nbre_revisees' => $demandes_revisees->count(),
        ] );
    }

    public function revisees( Request $request ) {
        // Logique pour la page d'accueil du contrôleur
        $demandes = Demande::where('user_id',Auth::user()->id);
        $demandes_attentes = Demande::where('user_id',Auth::user()->id)->where('statut_id',1);
        $demandes_revisees = Demande::where('user_id',Auth::user()->id)->where('revise',1)->with( 'type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs' )->orderBy( 'date_prevu_vol', 'asc' )
        ->paginate( $request->page_size ?? 10 );
        $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4);
        $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 );
        $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 );
        $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 );
        return Inertia::render( 'Demandes/revisees', [
            'demandes_revisees' => $demandes_revisees,
            'nbre_annule' => $demandes_annulees->count(),
            'nbre_renvoi' => $demandes_renvoyees->count(),
            'nbre_rejet' => $demandes_rejetees->count(),
            'nbre_auto' => $demandes_autorisees->count(),
            'nbre_attente' => $demandes_attentes->count(),
            'nbre_demandes' => $demandes->count(),
            'nbre_revisees' => $demandes_revisees->count(),
        ] );
    }

    public function create( Request $request ) {
        if ((int) Auth::user()->terme === 0) {
            $maxUnpaid = AppSetting::where('key', 'max_unpaid_demandes')->value('value');
            $maxUnpaid = is_numeric($maxUnpaid) ? (int) $maxUnpaid : 2;
            $unpaidCount = Demande::where('user_id', Auth::user()->id)
                // ->where('statut_id', 4)
                ->whereNull('payer')
                ->count();
            if ($unpaidCount >= $maxUnpaid) {
                return redirect()->route('homepostulant')->with('error', "Vous avez {$unpaidCount} demande(s) impayée(s). Veuillez régulariser avant de créer une nouvelle demande.");
            }
        }
        $demandes = Demande::where('user_id',Auth::user()->id);
        $demandes_attentes = Demande::where('user_id',Auth::user()->id)->where('statut_id',1);
        $demandes_revisees = Demande::where('user_id',Auth::user()->id)->where('revise',1);
        $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4);
        $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 );
        $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 );
        $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 );
        return Inertia::render( 'Demandes/create', [
            'type_demande' => TypeDemande::all(),
            'type_vol' => TypeVol::all(),
            'aeroport' => Aeroport::all(),
            'type_fichier' => FichierRequi::all(),
            'nbre_annule' => $demandes_annulees->count(),
            'nbre_renvoi' => $demandes_renvoyees->count(),
            'nbre_rejet' => $demandes_rejetees->count(),
            'nbre_auto' => $demandes_autorisees->count(),
            'nbre_demandes' => $demandes->count(),
        ] );
    }

    public function store( Request $request ) {
        if ((int) Auth::user()->terme === 0) {
            $maxUnpaid = AppSetting::where('key', 'max_unpaid_demandes')->value('value');
            $maxUnpaid = is_numeric($maxUnpaid) ? (int) $maxUnpaid : 2;
            $unpaidCount = Demande::where('user_id', Auth::user()->id)
                ->where('statut_id', 4)
                ->whereNull('payer')
                ->count();
            if ($unpaidCount >= $maxUnpaid) {
                return redirect()->route('homepostulant')->with('error', "Vous avez {$unpaidCount} demande(s) impayée(s). Veuillez régulariser avant de créer une nouvelle demande.");
            }
        }
        $isBlocPermis = ($request->infoDemande['type_demande'] ?? null) == 1;
        $permanant = $isBlocPermis ? ($request->infoDemande['permanant'] ?? null) : null;
        $nbreMois = ($isBlocPermis && $permanant == 1) ? ($request->infoDemande['nbre_mois'] ?? null) : null;
        DB::beginTransaction();
        try {
            //code...
            // Vous pouvez formater la date comme vous le souhaitez
            $gmtDate = Carbon::now( 'GMT' );
            $Date = $gmtDate->format( 'Y-m-d' );

            $postulant = Postulant::find( Auth::user()->postulant_id );
            $demande = Demande::create( [
                'ville_fait'=>$request->infoDemande[ 'ville_fait' ],
                'type_demande_id'=>$request->infoDemande[ 'type_demande' ],
                'type_vol_id'=>$request->infoDemande[ 'type_vol' ],
                'date_demande'=>$Date,
                'preciser'=>$request->infoDemande[ 'preciser' ],
                'user_id'=>Auth::user()->id,
                'date_prevu_vol'=>$request->infoDemande[ 'date_prevu_vol' ],
                'statut_id'=>null,
                'permanant'=>$permanant,
                'nbre_mois'=>$nbreMois,
                'numero_ordre'=>$postulant->numero_ordre,
            ] );

            // dd( $demande->id );
            Aeronef::create( [
                'imatriculation'=>$request->infoAeronef[ 'imatriculation' ],
                'type'=>$request->infoAeronef[ 'type' ],
                'indicatif_appel'=>$request->infoAeronef[ 'indicatif_appel' ],
                'proprietaire_aeronef'=>$request->infoAeronef[ 'propreitaire_aeronef' ],
                'commandant_bord'=>$request->infoAeronef[ 'commandant_bord' ],
                'nom_exploitant'=>$request->infoAeronef[ 'nom_exploitant' ],
                'email_exploitant'=>$request->infoAeronef[ 'email_exploitant' ],
                'tel_exploitant'=>$request->infoAeronef[ 'tel_exploitant' ],
                'demande_id'=>$demande->id,
            ] );

            foreach ( $request->infoRroutes[ 'Allroutes' ] as $key => $allroute ) {
                if ( $allroute[ 'date_route' ] != null ) {
                    # code...
                    foreach ( $allroute[ 'useroutes' ] as $key => $route ) {
                        if ( $route[ 'ville_depart' ] != null || $route[ 'ville_arrive' ] != null ) {
                            # code...
                            Route::create( [
                                'ville_depart'=>$route[ 'ville_depart' ],
                                'ville_arrive'=>$route[ 'ville_arrive' ],
                                'heure_depart'=>$route[ 'heure_depart' ],
                                'heure_arrive'=>$route[ 'heure_arrive' ],
                                'date_route'=>$allroute[ 'date_route' ],
                                'demande_id'=>$demande->id,
                                'autorisation_id'=>null,
                            ] );
                        }

                    }
                }

            }
            // die();

            foreach ( $request->infoFichier[ 'documents' ] as $key => $document ) {
                # code...
                if ( $document[ 'fichier' ] != null ) {
                    # code...
                    $doc = $document[ 'fichier' ];
                    //  dd( $fichier );
                    $nomdoc = 'd'.$demande->id.Auth::user()->id.'_'.$doc->getClientOriginalName();
                    $doc->move( 'documents/fichier_requis/', $nomdoc );
                    DemandeFichierRequi::create( [
                        'date_expire'=>$document[ 'date_expire' ],
                        'fichier'=>$nomdoc,
                        'fichier_requi_id'=>$document[ 'id_nomfichier' ],
                        'demande_id'=>$demande->id,
                    ] );
                } else {
                    DemandeFichierRequi::create( [
                        'date_expire'=>$document[ 'date_expire' ],
                        'fichier'=>null,
                        'fichier_requi_id'=>$document[ 'id_nomfichier' ],
                        'demande_id'=>$demande->id,
                    ] );
                }

            }
            DB::commit();
            return redirect()->route('homepostulant')->with( 'success',  'La demande a été enregistrée avec succès' );
        } catch ( \Throwable $th ) {
            //throw $th;
            DB::rollBack();
            // dd($th);
            return redirect()->route('homepostulant')->with( 'error', 'La demande n\'a pas été enregistrée avec succès');
        }
    }


    public function modifier( $id ) {
        $demandes = Demande::where('user_id',Auth::user()->id);
        $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4);
        $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 );
        $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 );
        $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 );
        $demande_modifier = Demande::with( 'type_demande', 'type_vol', 'statut', 'user.postulant' )->find( $id );
        $routes = Route::where( 'demande_id', $id )->get();
        $routes_dates = $routes->groupBy( 'date_route' );
        $aeronefs = Aeronef::where( 'demande_id', $id )->get();
        $demande_fichiers = DemandeFichierRequi::where( 'demande_id', $id )->with( 'fichier_requi' )->get();
        // dd( $routes_dates );
        return Inertia::render( 'Demandes/modifier', [
            'type_demande' => TypeDemande::all(),
            'type_vol' => TypeVol::all(),
            'aeroport' => Aeroport::all(),
            'type_fichier' => FichierRequi::all(),
            'demande_modifier' => $demande_modifier,
            'aeronefs' =>$aeronefs,
            'routes' => $routes_dates,
            'demande_fichiers' => $demande_fichiers,
            'nbre_annule' => $demandes_annulees->count(),
            'nbre_renvoi' => $demandes_renvoyees->count(),
            'nbre_rejet' => $demandes_rejetees->count(),
            'nbre_auto' => $demandes_autorisees->count(),
            'nbre_demandes' => $demandes->count(),
        ] );
    }

    public function update( Request $request ) {
        DB::beginTransaction();
        try {
            $demande = Demande::find( $request->infoDemande[ 'id_demande' ] );
            //code...

            // dd( $demande );
            //  dd( $request->infoRroutes[ 'Allroutes' ] );

            // $fichier = $request->infoDemande[ 'signature_cache' ];
            //  dd( $fichier );
            // $nomfichier = $fichier->getClientOriginalName();
            // $fichier->move( 'signatures/', $nomfichier );
            // dd( $Date );

            // $donne = [ $request->infoDemande[ 'ville_fait' ], $request->infoDemande[ 'type_demande' ], $request->infoDemande[ 'type_vol' ], $nomfichier, Auth::user()->id ];
            // dd( $donne );
            // $data = $this->validate( $request, [
            //     'name' => 'required|string',
            //     'job_title' => 'required|string',
            //     'email' => 'required|email',
            //     'address' => 'required|string'
            // ] );
            // dd($request->infoDemande[ 'date_prevu_vol' ]);
            $date = Carbon::createFromFormat('d-M-Y', $request->infoDemande[ 'date_prevu_vol' ]);
            // dd($date);
            $date_prevu_vol = $date->format('Y/m/d');
            $isBlocPermis = ($request->infoDemande['type_demande'] ?? null) == 1;
            $permanant = $isBlocPermis ? ($request->infoDemande['permanant'] ?? null) : null;
            $nbreMois = ($isBlocPermis && $permanant == 1) ? ($request->infoDemande['nbre_mois'] ?? null) : null;
            $demande->update( [
                'ville_fait'=>$request->infoDemande[ 'ville_fait' ],
                'type_demande_id'=>$request->infoDemande[ 'type_demande' ],
                'type_vol_id'=>$request->infoDemande[ 'type_vol' ],
                'preciser'=>$request->infoDemande[ 'preciser' ],
                'date_prevu_vol'=>$date_prevu_vol,
                'permanant'=>$permanant,
                'nbre_mois'=>$nbreMois,

            ] );
            //    dd( $demande );

            $aeronef = Aeronef::find( $request->infoAeronef[ 'id_aeronef' ] );
            $aeronef_verif= Aeronef::find( $request->infoAeronef[ 'id_aeronef' ] );
            $aeronef->update( [
                'imatriculation'=>$request->infoAeronef[ 'imatriculation' ],
                'type'=>$request->infoAeronef[ 'type' ],
                'indicatif_appel'=>$request->infoAeronef[ 'indicatif_appel' ],
                'proprietaire_aeronef'=>$request->infoAeronef[ 'propreitaire_aeronef' ],
                'commandant_bord'=>$request->infoAeronef[ 'commandant_bord' ],
                'nom_exploitant'=>$request->infoAeronef[ 'nom_exploitant' ],
                'email_exploitant'=>$request->infoAeronef[ 'email_exploitant' ],
                'tel_exploitant'=>$request->infoAeronef[ 'tel_exploitant' ],
            ] );

            $allrouts = Route::where( 'demande_id', $demande->id )->get();
            // dd( $allrouts );
            foreach ( $allrouts as $key => $allrout ) {
                $test = 0;
                foreach ( $request->infoRroutes[ 'Allroutes' ] as $key => $allroute ) {
                    foreach ( $allroute[ 'useroutes' ] as $key => $route ) {
                        if ( $route[ 'id_route' ] == $allrout->id ) {
                            # code...
                            $test = 1;
                        }
                    }
                }
                if ( $test == 0 ) {
                    # code...
                    $allrout->delete();
                }
                # code...
            }

            foreach ( $request->infoRroutes[ 'Allroutes' ] as $key => $allroute ) {
                foreach ( $allroute[ 'useroutes' ] as $key => $route ) {
                    // dd( $route );
                    # code...
                    // dump( $route, $allroute[ 'date_route' ], $route[ 'ville_depart' ], $route[ 'ville_arrive' ], $route[ 'heure_depart' ], $route[ 'heure_arrive' ], $demande->id );
                    if ( $route[ 'id_route' ] != null ) {
                        $routes = Route::find( $route[ 'id_route' ] );
                        // dd($demande->statut_id);
                        if ( $demande->statut_id == 4 ) {
                            // dd($aeronef->getAttributes() ,$aeronef_verif->getAttributes(),$aeronef->getAttributes() === $aeronef_verif->getAttributes());
                            # code...
                            if ($aeronef && $aeronef_verif && $aeronef->id === $aeronef_verif->id) {
                                if ($aeronef->getAttributes() === $aeronef_verif->getAttributes()) {
                                    # code...
                                    if ( $routes->ville_depart != $route[ 'ville_depart' ] || $routes->ville_arrive != $route[ 'ville_arrive' ] || $routes->heure_depart != $route[ 'heure_depart' ] || $routes->heure_arrive != $route[ 'heure_arrive' ] || $routes->date_route != $allroute[ 'date_route' ] ) {
                                        $num_autorisations = NumAutorisation::where( 'route_id', $routes->id )->get();
                                        foreach ($num_autorisations as $key =>$num_autorisation) {
                                            # code...
                                            if ( $num_autorisation->count() != 0 ) {
                                                $num_autorisation->update( [ 'revise'=>1 ] );
                                            }
                                        }
                                    }
                                }else{
                                    $num_autorisations = NumAutorisation::where( 'route_id', $routes->id )->get();
                                    foreach ($num_autorisations as $key =>$num_autorisation) {
                                        # code...
                                        if ( $num_autorisation->count() != 0 ) {
                                            $num_autorisation->update( [ 'revise'=>1 ] );
                                        }
                                    }

                                }


                            }
                        }
                        # code...
                        $routes->update( [
                            'ville_depart'=>$route[ 'ville_depart' ],
                            'ville_arrive'=>$route[ 'ville_arrive' ],
                            'heure_depart'=>$route[ 'heure_depart' ],
                            'heure_arrive'=>$route[ 'heure_arrive' ],
                            'date_route'=>$allroute[ 'date_route' ],
                        ] );
                    } else {
                        # code...
                        // dd( $route, $demande->id );
                        $ret = Route::create( [
                            'ville_depart'=>$route[ 'ville_depart' ],
                            'ville_arrive'=>$route[ 'ville_arrive' ],
                            'heure_depart'=>$route[ 'heure_depart' ],
                            'heure_arrive'=>$route[ 'heure_arrive' ],
                            'date_route'=>$allroute[ 'date_route' ],
                            'demande_id'=>$demande->id,
                            'autorisation_id'=>null,
                        ] );

                    }

                }

            }

            //     // die();

            foreach ( $request->infoFichier[ 'documents' ] as $key => $document ) {
                # code...
                $demandefichier = DemandeFichierRequi::find( $document[ 'id_fichier' ] );
                    $doc = $document['fichier'];
                    if ( $document[ 'fichier' ] != null ) {
                        // dump(  $doc,$demandefichier->fichier );

                            // dd( $nomdoc, $demandefichier->fichier );
                            if ( $doc->getClientOriginalName() != $demandefichier->fichier ) {
                                $nomdoc ='d'.$demande->id.Auth::user()->id.'_'.$doc->getClientOriginalName();
                                $doc->move( 'documents/fichier_requis/', $nomdoc );
                            }else {
                                #
                                $nomdoc=$demandefichier->fichier;
                            }
                            # code...
                            # code...

                            $demandefichier->update( [
                            'date_expire'=>$document[ 'date_expire' ],
                            'fichier'=>$nomdoc,
                            'fichier_requi_id'=>$document[ 'id_nomfichier' ],
                            'demande_id'=>$demande->id,
                        ] );
                    }
            }
        if ( $demande->statut_id != null )  {
            if ( $demande->statut_id == 4 ) {
                $mails = [];
                $demande->update( [ 'statut_id'=>8,'payer'=>null,'revise'=>1] );
                $chefs = User::where('type_user_id',3)->get();
                // foreach ($chefs as $key => $chef) {
                //     # code...
                //     $mails[$key] = $chef->email;
                // }
                // // dd($mails);
                // $donnees = [
                //     'email' => $mails,
                //     'lien' => 'http://localhost:8000/',
                //     'contenu' => 'Merci de vous connecter sur la plateforme le plutot possible pour traiter les demandes en instance',
                //     'type' => 1
                // ];
                // dispatch(new SendEmailJob($donnees));
            } else {
                # code...
                $demande->update( [ 'statut_id'=>1, ] );
            }

        }
            DB::commit();
            return redirect()->route( 'homepostulant' )->with( 'success',  'La demande a été modifiée avec succès' );
        } catch ( \Throwable $th ) {
            //  dd( $th );
            //throw $th;
            DB::rollBack();
            dd( $th );
            return redirect()->back()->with( 'error', 'La demande a été modifiée avec succès' );
        }

    }

    public function destroy( $id ) {
        $demande = Demande::find( $id );
        if($demande->statut_id < 3 || $demande->statut_id == 6 ){
            $demande->update( [ 'statut_id'=>7, ] );
            return redirect()->back()->with( 'success', 'La demande a été annulée avec succès' );
        }else{
            return redirect()->back()->with( 'error', 'La demande ne peut pas etre annuler' );
        }
    }

    public function generateDemandePdf(Request $request)
    {
        $demande = Demande::where('id', $request->id)->with('type_vol', 'type_demande', 'aeronefs', 'routes', 'routes.autorisation', 'user.postulant')->get()[0];
        // dd($demande->user->postulant);
        $routes = Route::where('demande_id', $request->id)->with('ville_depar', 'ville_arive')->get();
        $data = [
            "demande" => $demande,
            "routes" => $routes
        ];
        $pdf = Pdf::loadView('demande', $data);
        return $pdf->stream();
    }


    // public function soumettre(Request $request,$id)
    // {
    //     DB::beginTransaction();
    //     try {
    //         //code...
    //         $emails = [];
    //         $demande = Demande::find($id);
    //         $difference = Carbon::parse( $demande->date_prevu_vol )->diff($demande->date_demande);
    //         // dd($difference->days);
    //         $demande->update([
    //             'statut_id'=>1,
    //             'urgence'=>$difference->days,
    //         ]);
    //         $verifs = User::where('type_user_id',1)->get();
    //         foreach ($verifs as $key => $verif) {
    //             # code...
    //             $emails[$key] = $verif->email;
    //         }
    //         // dd($emails);
    //         $donnees = [
    //             'email' => $emails,
    //             'lien' => 'ldsa.anac.ne',
    //             'contenu' => 'Merci de vous connecter sur la plateforme le plutot possible pour traiter les demandes en instance',
    //             'type' => 1
    //         ];
    //         dispatch(new SendEmailJob($donnees));
    //         // broadcast(new ChangeStatusDemande(Auth::user(), $demande))->toOthers();
    //         DB::commit();
    //         return redirect()->back()->with('success',  'La demande a été envoyée avec succès');
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return redirect()->back()->with('error',  'Probleme de connexion, Merci de verifier et réessayer');
    //     }
    // }

    public function soumettre(Request $request, $id)
    {
        
        DB::beginTransaction();
        try {
            
            // Vérifier si la demande existe
            $demande = Demande::find($id);
            // dd($demande);
            if (!$demande) {
                return redirect()->back()->with('error', 'Demande introuvable.');
            }

            $aeronef = Aeronef::where('demande_id',$demande->id)->first();
            if (!$aeronef) {
                return redirect()->back()->with('error', 'Aeronef introuvable.');
            }

            // Vérifier que les dates sont valides
            if (!$demande->date_prevu_vol || !$demande->date_demande) {
                return redirect()->back()->with('error', 'Les dates de la demande sont invalides.');
            }
            

            // Vérifier si une demande avec les mêmes informations et statut soumis existe déjà
            // $demandeExistante = Aeronef::where('imatriculation', $aeronef->imatriculation)
            // ->where('indicatif_appel', $aeronef->indicatif_appel)
            // ->whereHas('demande', function ($query) use ($demande) {
            //     $query->where('date_demande', $demande->date_demande)->where('type_demande_id',$demande->type_demande_id)
            //     ->where('type_vol_id',$demande->type_vol_id) // Vérifier le numéro du vol
            //     ->where('statut_id', 1);
            // })->exists();

            $route = Route::where('demande_id',$demande->id)->get()[0];
            // dd($route);

            $demandeExistante = Aeronef::where('imatriculation', $aeronef->imatriculation)
            ->where('indicatif_appel', $aeronef->indicatif_appel)
            ->whereHas('demande', function ($query) use ($demande, $route) {
                $query->where('date_demande', $demande->date_demande)
                    ->where('type_demande_id', $demande->type_demande_id)
                    ->where('type_vol_id', $demande->type_vol_id)
                    ->where('statut_id', '!=', 7) // ⛔ exclure les statuts = 7
                    ->whereHas('routes', function ($q) use ($route) {
                        $q->where('ville_depart', $route->ville_depart)
                        ->where('ville_arrive', $route->ville_arrive)
                        ->where('date_route', $route->date_route);
                    });
            })
            ->exists();

            // dd($demandeExistante);
            if ($demandeExistante) {
                return redirect()->back()->with('error', 'Une demande similaire a déjà été soumise.');
            }

            // dd('ok');

            // Calculer la différence en jours
            $difference = Carbon::parse($demande->date_prevu_vol)->diff($demande->date_demande);

            // Mettre à jour la demande
            $demande->update([
                'statut_id' => 1,
                'urgence' => $difference->days,
                'date_soumis' => Carbon::now(),
            ]);

            // Récupérer les emails des vérificateurs
            $emails = User::where('type_user_id', 1)->pluck('email')->toArray();

            // Préparer les données pour l'email
            $donnees = [
                'email' => $emails,
                'lien' => 'test.anac.ne',
                'contenu' => 'Merci de vous connecter sur la plateforme le plus tôt possible pour traiter les demandes en instance',
                'type' => 1
            ];

            // Dispatch du job d'envoi d'email
            dispatch(new SendEmailJob($donnees));

            // dd('ok');

            // Valider la transaction
            DB::commit();
            return redirect()->back()->with('success', 'La demande a été envoyée avec succès.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th);
            // Log::error('Erreur lors de la soumission de la demande : ' . $th->getMessage());
            return redirect()->back()->with('error', 'Problème de connexion, veuillez réessayer.');
        }
    }


    public function payement(Request $request, $id)
    {
        $demandes = Demande::where('user_id',Auth::user()->id);
        $demande = Demande::find($id);
        $demand = Demande::where('id', $id)->with('type_demande')->get()[0];
        $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4);
        $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 );
        $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 );
        $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 );
        $frais = getPrixAutorisation($demande);
        return Inertia::render('Demandes/payement', [
            "frais" =>number_format($frais, 0, '', ' ') ,
            "demande" => $demand,
            'nbre_annule' => $demandes_annulees->count(),
            'nbre_renvoi' => $demandes_renvoyees->count(),
            'nbre_rejet' => $demandes_rejetees->count(),
            'nbre_auto' => $demandes_autorisees->count(),
            'nbre_demandes' => $demandes->count(),
        ]);
    }
    public function payer(Request $request){
        $demande = Demande::find($request->id);
        $demande->payer = 1 ;
        $demande->update();
        return redirect()->back()->with('success','Votre payement a été effectué avec succès');
    }
    public function deleteAutorisation(Request $request){
        $demande = Demande::find($request->id);
        $demande->motif_annuler = $request->motif;
        $demande->user_delete = Auth::user()->id;
        $demande->update();
        return redirect()->back()->with('success', "Autorisation annulé avec succès");
    }
}
