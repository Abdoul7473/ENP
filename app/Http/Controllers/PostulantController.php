<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostulantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $demandes_revisees = Demande::where('user_id',Auth::user()->id)->where('revise',1)->with('type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs');
        $demandes_attentes = Demande::where('user_id',Auth::user()->id)->where('statut_id',1);
        $demandes_revisees = Demande::where('user_id',Auth::user()->id)->where('revise',1);
        $demandes_autorisees = Demande::where('user_id',Auth::user()->id)->where('statut_id',4)->with('type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs');
        $demandes = Demande::where('user_id',Auth::user()->id)->with('type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs');
        $demandes_renvoyees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 6 )->with('type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs');
        $demandes_rejetees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 5 )->with('type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs');
        $demandes_annulees = Demande::where( 'user_id', Auth::user()->id )->where( 'statut_id', 7 )->with('type_demande', 'type_vol', 'statut', 'user.postulant','aeronefs');
        $demandes_en_attentes = Demande::where('user_id',Auth::user()->id)->with('type_demande','type_vol','statut','user.postulant','user','aeronefs')->orderBy('id','desc')
        ->paginate($request->page_size ?? 10);
        return Inertia::render('Demandes/index', [
            'demandes_en_attentes' => $demandes_en_attentes,
            'nbre_annule' => $demandes_annulees->count(),
            'nbre_renvoi' => $demandes_renvoyees->count(),
            'nbre_rejet' => $demandes_rejetees->count(),
            'nbre_auto' => $demandes_autorisees->count(),
            'nbre_demandes' => $demandes->count(),
            'nbre_attente' => $demandes_attentes->count(),
            'nbre_revisees' => $demandes_revisees->count(),
        ]);
    }

}
