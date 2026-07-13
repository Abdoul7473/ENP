<?php

namespace App\Http\Controllers\Api;

use App\Models\Route;
use App\Models\Aeronef;
use App\Models\Redevance;
use App\Models\Autorisation;
use Illuminate\Http\Request;
use App\Models\AeroportConfig;
use App\Models\NumAutorisation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DateTime;


class APIController extends Controller
{
    public function getNumAutorisation(Request $request)
    {
        // dd('je suis là');
        $auto_rechercher = collect();
        $num_autos = NumAutorisation::whereHas('autorisation', function ($query) {
            $query->where('type_autorisation_id', 1);
        })->where('statut_redevance',0)->with('autorisation.type_autorisation', 'route.ville_depart', 'route.ville_arrive', 'route.demande')->get();
        // dd('non permanent',$numeros);

        foreach ($num_autos as $item) {
            $numerosString = '';
            $date = new DateTime($item->route->date_route);
            $type_auto = checkTypeAuto($item->route->ville_arrive,$item->route->ville_depart);

            if ($type_auto == 'LND') {
                $numerosString .= "N° DG/ANAC/" . $type_auto . '/' . date('Y') . '-' . $date->format('dm') . $item->numero;
                if ($item->route->demande->urgence > 4) {
                    $numerosString .= '/N';
                } else {
                    $numerosString .= '/U';
                }
                if ($item->statut == 1) {
                    $numerosString .= '/R';
                }
                $auto_rechercher->push(['id' => $item->id, 'numero' => $numerosString, 'id_demande' => $item->route->demande->id]);
            }
        }
        // dd($auto_rechercher);
        return $auto_rechercher;
    }
    public function index()
    {
        $redevances = Redevance::where('payer', 0)->with('autorisation')->get();
        return $redevances;
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $redevance = Redevance::create([
            'num_autorisation_id' => $request->reference,
            'demande_id' => $request->demande_id,
            'type_vol' => $request->type_vol,
            'user_id' => $user->id,
            'autorisation_excep' => $request->autorisation_exceptionnelle ? 1 : 0,
            'nbre_passagers_dep' => $request->passagers_departs,
            'nbre_passagers_arr' => $request->passagers_arrives,
            'marchand_valeur_arr' => $request->marchandises_valeures_arrivees,
            'marchand_valeur_dep' => $request->marchandises_valeures_depart,
            'autre_que_marchand_valeur_arr' => $request->fret_arrives,
            'autre_que_marchand_valeur_dep' => $request->fret_depart,
            'mode_payement' => $request->mode_payement,
            // 'payer' => 1,
            'montant' => montant_redevance($request->toArray())
        ]);
        $num_auto = NumAutorisation::find($request->reference);
        $num_auto->statut_redevance = 1;
        $num_auto->update();
        if ($request->type == 2) {
            $this->payement($request, $redevance->id);
        }
        return ['code' => 1];
    }
    public function facture(Request $request, $id)
    {
        $redevances = Redevance::where('id', $id)->with('autorisation')->get();
        $data = [
            "redevances" => $redevances,
            // "user" => Auth::user()
        ];
        return $data;
    }
    public function payement(Request $request, $id = null)
    {
        $redevance = Redevance::find($id ?? $request->id);
        // dd($redevance);
        $redevance->payer = 1;
        $redevance->mode_payement = $request->mode_payement;
        $redevance->rib = $request->ref_cheque;
        $redevance->update();
        return ['code' => 1];
    }
}
