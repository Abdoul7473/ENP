<?php

use App\Models\Frai;
use App\Models\TypeAutorisation;
use App\Models\AeroportConfig;
use App\Models\NumAutorisation;
use App\Models\Route;
use Carbon\Carbon;

if (!function_exists('genererCodes')) {
    function genererCodes($demande, $numeros) {
      // dd('dd:',$demande,$numeros);
        $numerosString = ''; // Stocker le résultat final

        // Détermination du type d'autorisation
        $type_auto = null;
        if ($demande->permanant == 1) {
            $type_auto = TypeAutorisation::find(3); // Type pour les demandes permanentes
            $caracteres = moisVersCaracteres($demande->nbre_mois);
        } else {
            $type_auto = match(true) {
                $demande->type_vol_id == 4 => TypeAutorisation::find(4),
                $demande->type_demande_id == 1 => TypeAutorisation::find(2),
                default => TypeAutorisation::find(1),
            };
        }


        // Parcourir les numéros et générer les codes
        foreach ($numeros as $index => $numero) {
          $type = checkTypeAuto($numero->route->ville_arrive, $numero->route->ville_depart);
            if ($demande->permanant == 1) {
                // Génération pour les demandes permanentes
                $caractere = $caracteres[$index % count($caracteres)];
                $code = "NE-{$type}" . date('y') . "{$numero->numero}{$caractere}";
            } else {
                // Génération pour les demandes non permanentes
                $urgence = Carbon::parse($demande->date_demande)->diffInDays($numero->route->date_route) > 4 ? 'N' : 'U';

                if ($type_auto->id == 4) {
                    $code = "NE-" . date('y') . "{$numero->numero}";
                } else {
                    
                    $code = "NE-{$type}" . date('y') . "{$numero->numero}/{$urgence}";
                }
            }

            // Ajouter au résultat final
            $numerosString .= "\n {$code}\n";

            // Mettre à jour le numéro avec le code généré
            $numero->update(['code' => $code]);
        }

        return $numerosString; // Retourne la chaîne contenant tous les codes
    }
  }



if (!function_exists('montant_redevance')) {
    function montant_redevance($request) {
        // dd($request);
        $montant = 0;
        if(($request['type_vol']) == 1){
            $sa = Frai::where('id',11)->first()->montant * ($request['passagers_departs']);
            $s = Frai::where('id',13)->first()->montant * ($request['passagers_departs']);
            $montant = $montant + ($sa+$s);
        }else{
            $sa = Frai::where('id',10)->first()->montant * ($request['passagers_departs']);
            $s = Frai::where('id',12)->first()->montant * ($request['passagers_departs']);
            $montant = $montant + ($sa+$s);
        }
        // dump('montant type vol:',$montant,$request);
        // $rfmv = Frai::where('id',15)->first()->montant * ;
        if($request['autorisation_exceptionnelle'] != null){
            // dump('avec royal');
            $aetft_dep = Frai::where('id',9)->first()->montant * ($request['fret_depart']);
            $aetft_arr = Frai::where('id',9)->first()->montant * ($request['fret_arrives']);
            $aetp_dep = Frai::where('id',8)->first()->montant * ($request['passagers_departs']);
            $aetp_arr = Frai::where('id',8)->first()->montant * ($request['passagers_arrives']);
            $montant = $montant + ($aetft_dep+$aetft_arr+$aetp_dep+$aetp_arr);
        }else{
            // dump('sans royal');
            $rfm_dep = Frai::where('id',14)->first()->montant * ($request['fret_depart']);
            $rfm_arr = Frai::where('id',14)->first()->montant * ($request['fret_arrives']);
            $montant = $montant + ($rfm_dep+$rfm_arr);
        }

        // dump('montant royal:',$montant);
        $rfmv_dep = Frai::where('id',15)->first()->montant * ($request['marchandises_valeures_depart']);
        $rfmv_arr = Frai::where('id',15)->first()->montant * ($request['marchandises_valeures_arrivees']);
        // $rti = Frai::where('id',16)->first()->montant;
        $montant = $montant + ($rfmv_dep+$rfmv_arr);
        $rit = Frai::where('id',16)->first()->montant * ($request['passagers_departs']);
        $ravc = Frai::where('id',17)->first()->montant * ($request['passagers_departs']);
        $montant = $montant + ($rit+$ravc);
        // dump('montant total:',$montant);
        // die();
        // dd($montant);
        return $montant;
        // return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('moisVersCaracteres')) {
    function moisVersCaracteres($nombreMois) {
        $tableauCaracteres = array();

        // Calcul du nombre de semestres, trimestres et mois restants
        $semestres = floor($nombreMois / 6);
        $nombreMois -= $semestres * 6;
        $trimestres = floor($nombreMois / 3);
        $nombreMois -= $trimestres * 3;

        // Ajout des caractères au tableau en fonction des calculs
        if ($semestres > 0) {
            for ($i = 0; $i < $semestres; $i++) {
                $tableauCaracteres[] = 'S';
            }
        }
        if ($trimestres > 0) {
            for ($i = 0; $i < $trimestres; $i++) {
                $tableauCaracteres[] = 'T';
            }

        }

        if ($nombreMois > 0) 
        {
          for ($i = 0; $i < $nombreMois; $i++) 
          {
            $tableauCaracteres[] = 'M';
          }
        }

        // ici c'est quand on veut que ça soit majoré
        // if ($nombreMois > 0) {
        //     // for ($i = 0; $i < $nombreMois; $i++) {
        //         if ($nombreMois > 1) {
        //             $tableauCaracteres[] = 'T';
        //         } else {
        //             $tableauCaracteres[] = 'M';
        //         }
        //     // }
        // }

        return $tableauCaracteres;
    }
}



if (!function_exists('getPrixAutorisation')) {
    function getPrixAutorisation($demande){
        $frais = 0;
        $date1 = Carbon::createFromFormat('Y-m-d', $demande->date_demande);
        $date2 = Carbon::createFromFormat('d-M-Y', $demande->date_prevu_vol);
        $All_routes_id = Route::where('demande_id',$demande->id)->get()->pluck('id');
        $num_auto = NumAutorisation::whereIn('route_id',$All_routes_id)->where('revise',1);
        $frais_lnd = 0;
        $frais_ovf = 0;
        if ($demande->type_vol_id != 4) {
          if($num_auto->exists()){
              $count = NumAutorisation::whereIn('route_id',$All_routes_id)->where('revise',1)->distinct('route_id')->count();
          }else {
              $count = NumAutorisation::whereIn('route_id',$All_routes_id)->distinct('route_id')->count();
          }
          $nbr_jour = $date2->diffInDays($date1);
          if ($demande->nbre_mois !== null) {
              $type_auto = TypeAutorisation::find(3);
              $resultat_1 = $demande->nbre_mois / 6;
              $quotient_1 = intval($resultat_1);
              $reste_1 = ($demande->nbre_mois - 6 * $quotient_1);
              $frai_1 = Frai::where('type_autorisation_id', $type_auto->id)->where('type', 'S')->get()[0]->montant * $quotient_1;
              $resultat_2 = $reste_1 / 3;
              $quotient_2 = intval($resultat_2);
              $reste_2 = ($reste_1 - 3 * $quotient_2);
              $frai_2 = Frai::where('type_autorisation_id', $type_auto->id)->where('type', 'T')->get()[0]->montant * $quotient_2;
              $frai_3 = Frai::where('type_autorisation_id', $type_auto->id)->where('type', 'M')->get()[0]->montant * $reste_2;
              $frais = ($frai_1 + $frai_2 + $frai_3)*$count;
          } else {
              // dd('uu');
              if($num_auto->exists()){
                  $id_routes = NumAutorisation::whereIn('route_id',$All_routes_id)->where('revise',1)->pluck('route_id');
              }else {
                  $id_routes = NumAutorisation::whereIn('route_id',$All_routes_id)->pluck('route_id');
              }
              $nbr_ovf = 0;
              $nbr_lnd = 0;
              $id_aeroports = Route::whereIn('id', $id_routes)->select('ville_depart', 'ville_arrive')->get();
              foreach ($id_aeroports as $key => $id_aeroport) {
                  $check = checkTypeAuto($id_aeroport->ville_arrive,$id_aeroport->ville_depart);
                  if ($check == "V"){
                      $nbr_ovf+=1;
                      $type_auto = TypeAutorisation::where('code', 'V')->get()[0]->id;
                      if ($nbr_jour > 0 && $nbr_jour <= 4) {
                          $frais_ovf = Frai::where('type_autorisation_id', $type_auto)->where('type', 'U')->get()[0]->montant*$nbr_ovf;
                      } else {
                          $frais_ovf = Frai::where('type_autorisation_id', $type_auto)->where('type', 'N')->get()[0]->montant*$nbr_ovf;
                      }
                  }else if ($check == "L"){
                      $nbr_lnd+=1;
                      $type_auto = TypeAutorisation::where('code', 'L')->get()[0]->id;
                      if ($nbr_jour > 0 && $nbr_jour <= 4) {
                          $frais_lnd = Frai::where('type_autorisation_id', $type_auto)->where('type', 'U')->get()[0]->montant*$nbr_lnd;
                      } else {
                          $frais_lnd = Frai::where('type_autorisation_id', $type_auto)->where('type', 'N')->get()[0]->montant*$nbr_lnd;
                      }
                  }
              }
              // dd($nbr_lnd,$nbr_ovf);
              $frais = $frais_lnd + $frais_ovf;
          }
        }
        return $frais ;
    }
}

if (!function_exists('checkTypeAuto')) {
  function checkTypeAuto($idAVerifier, $secondId = null)
  {
      $ids = AeroportConfig::pluck('aeroport_id')->toArray();
      
      if (in_array($idAVerifier, $ids)) {
          return 'L';
      }
      
      if ($secondId !== null && in_array($secondId, $ids)) {
          return 'L';
      }

      return 'V';
  }
}

if (!function_exists('million')) {
    function million (){
        return 'millions';
    }
}
if (!function_exists('asLetters')) {
    function asLetters($number,$separateur=",") {
        $convert = explode($separateur, $number);
        $num[17] = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit',
                         'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize');

        $num[100] = array(20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
                          60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingt', 90 => 'quatre-vingt-dix');

        if (isset($convert[1]) && $convert[1] != '') {
          return asLetters($convert[0]).' et '.asLetters($convert[1]);
        }
        if ($number < 0) return 'moins '.asLetters(-$number);
        if ($number < 17) {
          return $num[17][$number];
        }
        elseif ($number < 20) {
          return 'dix-'.asLetters($number-10);
        }
        elseif ($number < 100) {
          if ($number%10 == 0) {
            return $num[100][$number];
          }
          elseif (substr($number, -1) == 1) {
            if( ((int)($number/10)*10)<70 ){
              return asLetters((int)($number/10)*10).'-et-un';
            }
            elseif ($number == 71) {
              return 'soixante-et-onze';
            }
            elseif ($number == 81) {
              return 'quatre-vingt-un';
            }
            elseif ($number == 91) {
              return 'quatre-vingt-onze';
            }
          }
          elseif ($number < 70) {
            return asLetters($number-$number%10).'-'.asLetters($number%10);
          }
          elseif ($number < 80) {
            return asLetters(60).'-'.asLetters($number%20);
          }
          else {
            return asLetters(80).'-'.asLetters($number%20);
          }
        }
        elseif ($number == 100) {
          return 'cent';
        }
        elseif ($number < 200) {
          return asLetters(100).' '.asLetters($number%100);
        }
        elseif ($number < 1000) {
          return asLetters((int)($number/100)).' '.asLetters(100).($number%100 > 0 ? ' '.asLetters($number%100): '');
        }
        elseif ($number == 1000){
          return 'mille';
        }
        elseif ($number < 2000) {
          return asLetters(1000).' '.asLetters($number%1000).' ';
        }
        elseif ($number < 1000000) {
          return asLetters((int)($number/1000)).' '.asLetters(1000).($number%1000 > 0 ? ' '.asLetters($number%1000): '');
        }
        elseif ($number == 1000000) {
          return 'un million';
        }
        elseif ($number < 2000000) {
          return asLetters(1000000).' '.asLetters($number%1000000);
        }
        elseif ($number < 1000000000) {
          return asLetters((int)($number/1000000)).' '.million().($number%1000000 > 0 ? ' '.asLetters($number%1000000): '');
        }
      }
}
