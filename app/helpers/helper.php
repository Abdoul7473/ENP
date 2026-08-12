<?php

use App\Models\Frai;
use App\Models\TypeAutorisation;
use App\Models\AeroportConfig;
use App\Models\Mois;
use App\Models\NumAutorisation;
use App\Models\Route;
use Carbon\Carbon;

if (!function_exists('genererCodes')) {
  function genererCodes($demande, $numeros)
  {
    // dd('dd:',$demande,$numeros);
    $numerosString = ''; // Stocker le résultat final

    // Détermination du type d'autorisation
    $type_auto = null;
    if ($demande->permanant == 1) {
      $type_auto = TypeAutorisation::find(3); // Type pour les demandes permanentes
      $caracteres = moisVersCaracteres($demande->nbre_mois);
    } else {
      $type_auto = match (true) {
        $demande->type_vol_id == 4 => TypeAutorisation::find(4),
        $demande->type_demande_id == 1 => TypeAutorisation::find(2),
        default => TypeAutorisation::find(1),
      };
    }

    // Parcourir les numéros et générer les codes
    foreach ($numeros as $index => $numero) {
      $type = checkTypeAuto($numero->route->ville_arrive, $numero->route->ville_depart);
      if ($numero->statut == 1) {
        if ($demande->permanant == 1) {
          $code = "NE-V" . date('y') . "{$numero->numero}R";
        } else {
          $code = "NE-{$type}" . date('y') . "{$numero->numero}R";
        }
      } else {
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

            $code = "NE-{$type}" . date('y') . "{$numero->numero}{$urgence}";
          }
        }
      }

      // Ajouter au résultat final
      $numerosString .= "\n {$code}\n";

      // dump('code :',$code);
      // dump('numero :',$numero);

      // Mettre à jour le numéro avec le code généré
      $ref_article = getNumeroFromCode($code);

      // Mettre à jour le numéro avec le code généré
      $numero->update(['code' => $code, 'ref_article' => $ref_article]);
      // $numero->update(['code' => $code]);
    }
    // die();

    return $numerosString; // Retourne la chaîne contenant tous les codes
  }
}

if (!function_exists('getNumeroFromCode')) {
  function getNumeroFromCode($code)
  {
    // Définition des correspondances
    $mapping = [
      'VN' => 1501,
      'VU' => 1502,
      'LN' => 1503,
      'LU' => 1504,
      'VR' => 1505,
      'LR' => 1506,
      'VM' => 1507,
      'VT' => 1508,
      'VS' => 1509,
    ];

    // Extraire la partie après le "-" (si elle existe)
    $parts = explode('-', $code);
    $suffix = $parts[1] ?? $code; // Prendre tout le code si pas de "-"

    // Extraire les lettres pertinentes (V, L, N, U, R, M, T, S)
    preg_match_all('/[VLNURMTS]/', $suffix, $matches);
    $letters = $matches[0] ?? [];

    // Debugging
    \Log::info('Lettres extraites : ' . implode(',', $letters));

    // Vérification qu'il y a au moins deux lettres
    if (count($letters) < 2) {
      return null;
    }

    // Construire la clé avec les deux premières lettres
    $key = $letters[0] . $letters[1];

    // Debugging
    \Log::info('Clé générée : ' . $key);

    return $mapping[$key] ?? null;
  }
}



if (!function_exists('montant_redevance')) {
  function montant_redevance($request)
  {
    // dd($request);
    $montant = 0;
    if (($request['type_vol']) == 1) {
      $sa = Frai::where('id', 11)->first()->montant * ($request['passagers_departs']);
      $s = Frai::where('id', 13)->first()->montant * ($request['passagers_departs']);
      $montant = $montant + ($sa + $s);
    } else {
      $sa = Frai::where('id', 10)->first()->montant * ($request['passagers_departs']);
      $s = Frai::where('id', 12)->first()->montant * ($request['passagers_departs']);
      $montant = $montant + ($sa + $s);
    }
    // dump('montant type vol:',$montant,$request);
    // $rfmv = Frai::where('id',15)->first()->montant * ;
    if ($request['autorisation_exceptionnelle'] != null) {
      // dump('avec royal');
      $aetft_dep = Frai::where('id', 9)->first()->montant * ($request['fret_depart']);
      $aetft_arr = Frai::where('id', 9)->first()->montant * ($request['fret_arrives']);
      $aetp_dep = Frai::where('id', 8)->first()->montant * ($request['passagers_departs']);
      $aetp_arr = Frai::where('id', 8)->first()->montant * ($request['passagers_arrives']);
      $montant = $montant + ($aetft_dep + $aetft_arr + $aetp_dep + $aetp_arr);
    } else {
      // dump('sans royal');
      $rfm_dep = Frai::where('id', 14)->first()->montant * ($request['fret_depart']);
      $rfm_arr = Frai::where('id', 14)->first()->montant * ($request['fret_arrives']);
      $montant = $montant + ($rfm_dep + $rfm_arr);
    }

    // dump('montant royal:',$montant);
    $rfmv_dep = Frai::where('id', 15)->first()->montant * ($request['marchandises_valeures_depart']);
    $rfmv_arr = Frai::where('id', 15)->first()->montant * ($request['marchandises_valeures_arrivees']);
    // $rti = Frai::where('id',16)->first()->montant;
    $montant = $montant + ($rfmv_dep + $rfmv_arr);
    $rit = Frai::where('id', 16)->first()->montant * ($request['passagers_departs']);
    $ravc = Frai::where('id', 17)->first()->montant * ($request['passagers_departs']);
    $montant = $montant + ($rit + $ravc);
    // dump('montant total:',$montant);
    // die();
    // dd($montant);
    return $montant;
    // return \Carbon\Carbon::parse($date)->format($format);
  }
}

if (!function_exists('moisVersCaracteres')) {
  function moisVersCaracteres($nombreMois)
  {
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

    if ($nombreMois > 0) {
      for ($i = 0; $i < $nombreMois; $i++) {
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
  function getPrixAutorisation($demande)
  {
    $frais = 0;
    $date1 = Carbon::createFromFormat('Y-m-d', $demande->date_demande);
    $date2 = Carbon::createFromFormat('d-M-Y', $demande->date_prevu_vol);
    $All_routes_id = Route::where('demande_id', $demande->id)->get()->pluck('id');
    $num_auto = NumAutorisation::whereIn('route_id', $All_routes_id)->where('revise', 1);
    $frais_lnd = 0;
    $frais_ovf = 0;
    if ($demande->type_vol_id != 4) {
      if ($num_auto->exists()) {
        $count = NumAutorisation::whereIn('route_id', $All_routes_id)->where('revise', 1)->distinct('route_id')->count();
      } else {
        $count = NumAutorisation::whereIn('route_id', $All_routes_id)->distinct('route_id')->count();
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
        $frais = ($frai_1 + $frai_2 + $frai_3) * $count;
      } else {
        // dd('uu');
        if ($num_auto->exists()) {
          $id_routes = NumAutorisation::whereIn('route_id', $All_routes_id)->where('revise', 1)->pluck('route_id');
        } else {
          $id_routes = NumAutorisation::whereIn('route_id', $All_routes_id)->pluck('route_id');
        }
        $id_aeroports = Route::whereIn('id', $id_routes)
          ->select('ville_depart', 'ville_arrive', 'date_route')
          ->get();
        foreach ($id_aeroports as $id_aeroport) {
          $d = Carbon::createFromFormat('Y-m-d', $demande->date_demande);
          $d1 = Carbon::createFromFormat('Y-m-d', $id_aeroport->date_route);
          $nbrj = $d1->diffInDays($d);
          $urgent = $nbrj <= 4;
          $check = checkTypeAuto($id_aeroport->ville_arrive, $id_aeroport->ville_depart);
          if ($check == "V") {
            $type_auto = TypeAutorisation::where('code', 'V')->first()->id;
          } else {
            $type_auto = TypeAutorisation::where('code', 'L')->first()->id;
          }
          $typeFrai = $urgent ? 'U' : 'N';
          $montantFrai = Frai::where('type_autorisation_id', $type_auto)
            ->where('type', $typeFrai)
            ->first()
            ->montant;
          $frais += $montantFrai;
        }
      }
    }
    return $frais;
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
  function million()
  {
    return 'millions';
  }
}
if (!function_exists('asLetters')) {
  function asLetters($number, $separateur = ",")
  {
    $convert = explode($separateur, $number);
    $num[17] = array(
      'zero',
      'un',
      'deux',
      'trois',
      'quatre',
      'cinq',
      'six',
      'sept',
      'huit',
      'neuf',
      'dix',
      'onze',
      'douze',
      'treize',
      'quatorze',
      'quinze',
      'seize'
    );

    $num[100] = array(
      20 => 'vingt',
      30 => 'trente',
      40 => 'quarante',
      50 => 'cinquante',
      60 => 'soixante',
      70 => 'soixante-dix',
      80 => 'quatre-vingt',
      90 => 'quatre-vingt-dix'
    );

    if (isset($convert[1]) && $convert[1] != '') {
      return asLetters($convert[0]) . ' et ' . asLetters($convert[1]);
    }
    if ($number < 0) return 'moins ' . asLetters(-$number);
    if ($number < 17) {
      return $num[17][$number];
    } elseif ($number < 20) {
      return 'dix-' . asLetters($number - 10);
    } elseif ($number < 100) {
      if ($number % 10 == 0) {
        return $num[100][$number];
      } elseif (substr($number, -1) == 1) {
        if (((int)($number / 10) * 10) < 70) {
          return asLetters((int)($number / 10) * 10) . '-et-un';
        } elseif ($number == 71) {
          return 'soixante-et-onze';
        } elseif ($number == 81) {
          return 'quatre-vingt-un';
        } elseif ($number == 91) {
          return 'quatre-vingt-onze';
        }
      } elseif ($number < 70) {
        return asLetters($number - $number % 10) . '-' . asLetters($number % 10);
      } elseif ($number < 80) {
        return asLetters(60) . '-' . asLetters($number % 20);
      } else {
        return asLetters(80) . '-' . asLetters($number % 20);
      }
    } elseif ($number == 100) {
      return 'cent';
    } elseif ($number < 200) {
      return asLetters(100) . ' ' . asLetters($number % 100);
    } elseif ($number < 1000) {
      return asLetters((int)($number / 100)) . ' ' . asLetters(100) . ($number % 100 > 0 ? ' ' . asLetters($number % 100) : '');
    } elseif ($number == 1000) {
      return 'mille';
    } elseif ($number < 2000) {
      return asLetters(1000) . ' ' . asLetters($number % 1000) . ' ';
    } elseif ($number < 1000000) {
      return asLetters((int)($number / 1000)) . ' ' . asLetters(1000) . ($number % 1000 > 0 ? ' ' . asLetters($number % 1000) : '');
    } elseif ($number == 1000000) {
      return 'un million';
    } elseif ($number < 2000000) {
      return asLetters(1000000) . ' ' . asLetters($number % 1000000);
    } elseif ($number < 1000000000) {
      return asLetters((int)($number / 1000000)) . ' ' . million() . ($number % 1000000 > 0 ? ' ' . asLetters($number % 1000000) : '');
    }
  }
}
function NbrPersonnelParGrade()
{
  $label = [];
  $data = [];
  $nbr_personnel_par_grade = DB::select("
        SELECT count(e.id) nbr_personnel,g.libelle libelle FROM encadreurs e,grades g
          where g.id = e.grade_id GROUP BY g.id
    ");
  foreach ($nbr_personnel_par_grade as $item) {
    $label[] = $item->libelle;
    $data[] = $item->nbr_personnel;
  }
  $datas = [
    'label' => $label,
    'data' => $data,
  ];
  return $datas;
}

function NbrEleveParCorp()
{
  $label = [];
  $data = [];
  $nbr_eleve_par_corp = DB::select("
        SELECT count(e.id) nbr_eleve,c.nom nom FROM eleves e,corps c,compagnies co
          where co.id = e.compagnie_id and c.id = co.corp_id GROUP BY c.id
    ");
  foreach ($nbr_eleve_par_corp as $item) {
    $label[] = $item->nom;
    $data[] = $item->nbr_eleve;
  }
  $datas = [
    'label' => $label,
    'data' => $data,
  ];
  return $datas;
}
function NbrVisiteurMois()
{
  $mois = Mois::all();
  foreach ($mois as $key => $moi) {
    
    return ;
    // 97 20 40 20
  }
  $nbr_visiteur_mois = DB::table('visiteurs')
    ->select(
      DB::raw('YEAR(date) as annee'),
      DB::raw('MONTHNAME(date) as mois'),
      DB::raw('MONTH(date) as mois_numero'),
      DB::raw('COUNT(id) as nombre_visiteurs')
    )
    ->whereYear('date', '=', date('Y'))
    ->groupBy('annee', 'mois', 'mois_numero')
    ->orderBy('annee')
    ->orderBy('mois_numero')
    ->get();
  $label = [];
  $data = [];
  foreach ($nbr_visiteur_mois as $item) {
    $label[] = $item->mois;
    $data[] = $item->nombre_visiteurs;
  }
  $datas = [
    'label' => $label,
    'data' => $data,
  ];
  return $datas;
}
