<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Lot;
use App\Models\Numero;
use App\Models\Eleve;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Signature;
use App\Models\Annee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CarteController extends Controller
{
    public function index(Request $request)
    {
        $qr = (string) \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)
        ->generate('Bonjour Vue');
        $t = Numero::all();
        $total = Numero::count();
        $scanne = Numero::where('statut',1)->count();
        $restant = Numero::where('statut',0)->count();
        $cartes = $t->map(function($item){ 
            return [ 
                'qr' => (string) \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate($item->numero) ]; 
                });
        $lots = Lot::paginate($request->page_size ?? 10);
        return Inertia::render('cartes/index', [
            'total' => $total,
            'scanne' => $scanne,
            'restant' => $restant,
            'qr' => $qr,
            'lots' => $lots,
            'cartes' => $cartes
        ]);
    }
    public function store(Request $request){
        $annee = Annee::where('statut',1)->first();
        $carbon = Carbon::parse($annee->date_debut);
        $gmtDate = Carbon::now( 'GMT' );
        $date = $gmtDate->format( 'Y-m-d' );
        $nombre = $request->nombre;
        $lot =  Lot::create( [
                'nombre' =>  $nombre,
                'date' => $date,
            ] );
        
        for($i = 1; $i <= $request->nombre; $i++) {
            $num = Numero::create([
                'statut' => false,
                'lot_id' => $lot->id
            ]);
            $num->numero = Hash::make('DENP/'.$carbon->format('Y').'/'. $num->id);
            $num->update();
        }
        return redirect()->route('carte.index')->with( 'success',  'Numéro généré avec succès' );
    }
     public function generateCartePdf(Request $request)
    {
        $annee = Annee::where('statut',1)->first();
        $carbon = Carbon::parse($annee->date_debut);
        $rectos = Eleve::with('compagnie.corp')->where('compagnie_id',$request->compagnie_id)->get();
        $versos = Eleve::with('compagnie.corp')->get();
        $signature = Signature::first();
        $gmtDate = Carbon::now( 'GMT' );
        $date = $gmtDate->format( 'd-m-Y' );
        $data = [
            "rectos" => $rectos,
            "versos" => $versos,
            "signature" => $signature,
            "date" => $date,
            "annee" => $annee,
            "libelle" => $carbon->format('Y')
        ];
        // dd($cartes);
        $pdf = Pdf::loadView('carte', $data);
        return $pdf->stream();
    }
    public function scanner(Request $request)
{
    $qr_code = $request->qr_code;

    $verif = Numero::where('numero', $qr_code)->first();

    if (!$verif) {
        return response()->json([
            'success' => false,
            'message' => 'QR code introuvable'
        ], 404);
    }

    if ($verif->statut == 0) {
        $verif->statut = 1;
        $verif->save();

        $code = 0; 
    } else {
        $code = 1; 
    }

    return response()->json([
        'success' => true,
        'code' => $code
    ]);
}
    public function detail(Request $request,$id){
        $t = Numero::where('lot_id',$id)->get();
        $cartes = $t->map(function($item){ 
            return [ 
                'qr' => (string) \SimpleSoftwareIO\QrCode\Facades\QrCode::size(20)->generate($item->numero) ]; 
                });
        return Inertia::render('cartes/detail', [
            'cartes' => $cartes
        ]);
    }
    public function ajout_signature(Request $request)
    {
        $fichier = $request->fichier;
        $nomfichier = 'D'.Auth::user()->id.'_'.$fichier->getClientOriginalName();
        $fichier->move( 'signatures/', $nomfichier );
        Signature::updateOrInsert(
            [
                'user_id' => Auth::user()->id,
                'libelle' => $nomfichier
            ]
        );
        return redirect()->back();
    }
    public function generateInvitationPdf(Request $request,$id){
         $t = Numero::where('lot_id', $id)->get();
    
    $cartes = $t->map(function($item) { 
        return [ 
            'qr' => (string) \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)
                           ->format('svg')
                           ->generate($item->numero),
            'numero' => $item->numero
        ]; 
    });
        $data = [
            "cartes" => $cartes
        ];
        // dd($cartes);
        $pdf = Pdf::loadView('invitation', $data);
        return $pdf->stream();
    }
}
