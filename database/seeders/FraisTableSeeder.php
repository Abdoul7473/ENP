<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FraisTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('frais')->delete();

        \DB::table('frais')->insert(array (
            0 =>
            array (
                'created_at' => NULL,
                'id' => 1,
                'montant' => '98500',
                'periode' => NULL,
                'type' => 'U',
                'libelle' => "Survol et Atterissage urgent",
                'type_autorisation_id' => 1,
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'created_at' => NULL,
                'id' => 2,
                'montant' => '66000',
                'periode' => NULL,
                'type' => 'N',
                'libelle' => "Survol et Atterissage",
                'type_autorisation_id' => 1,
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'created_at' => NULL,
                'id' => 3,
                'montant' => '66000',
                'periode' => NULL,
                'type' => 'U',
                'libelle' => "Survol urgent",
                'type_autorisation_id' => 2,
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'created_at' => NULL,
                'id' => 4,
                'montant' => '46000',
                'periode' => NULL,
                'type' => 'N',
                'libelle' => "Survol",
                'type_autorisation_id' => 2,
                'updated_at' => NULL,
            ),
            4 =>
            array (
                'created_at' => NULL,
                'id' => 5,
                'montant' => '1000000',
                'periode' => '6',
                'type' => 'S',
                'libelle' => "Block d'autorisation semestrielle",
                'type_autorisation_id' => 3,
                'updated_at' => NULL,
            ),
            5 =>
            array (
                'created_at' => NULL,
                'id' => 6,
                'montant' => '660000',
                'periode' => '4',
                'type' => 'T',
                'libelle' => "Block d'autorisation trimestrielle",
                'type_autorisation_id' => 3,
                'updated_at' => NULL,
            ),
            6 =>
            array (
                'created_at' => NULL,
                'id' => 7,
                'montant' => '330000',
                'periode' => '1',
                'type' => 'M',
                'libelle' => "Block d'autorisation mensuelle",
                'type_autorisation_id' => 3,
                'updated_at' => NULL,
            ),
            7 =>
            array (
                'created_at' => NULL,
                'id' => 8,
                'montant' => '5000',
                'periode' => NULL,
                'type' => 'AETP',
                'libelle' => "Autorisation exceptionnelle de trafic pour tout passager au départ ou à l'arrivée",
                'type_autorisation_id' => NULL,
                'updated_at' => NULL,
            ),
            8 =>
            array (
                'created_at' => NULL,
                'id' => 9,
                'montant' => '50',
                'periode' => NULL,
                'type' => 'AETFT',
                'libelle' => "Autorisation exceptionnelle de trafic par tranche d'un kilogramme pour le fret au départ ou à l'arrivée",
                'type_autorisation_id' => NULL,
                'updated_at' => NULL,
            ),
            9 =>
            array (
                'created_at' => NULL,
                'id' => 10,
                'montant' => '5000',
                'periode' => NULL,
                'type' => 'RSAPID',
                'libelle' => "Redevance sécurité aérienne par passager de vols internationaux au départ",
                'type_autorisation_id' => NULL,
                'updated_at' => NULL,
            ),
            10 =>
            array (
                'created_at' => NULL,
                'id' => 11,
                'montant' => '1000',
                'periode' => NULL,
                'type' => 'RSAPDD',
                'libelle' => "Redevance sécurité aérienne par passager de vols domestiques au départ",
                'type_autorisation_id' => NULL,
                'updated_at' => NULL,
            ),
            11 =>
            array (
                'created_at' => NULL,
                'id' => 12,
                'montant' => '5000',
                'periode' => NULL,
                'type' => 'RSPID',
                'libelle' => "Redevance sûreté par passager de vols internationaux au départ",
                'type_autorisation_id' => NULL,
                'updated_at' => NULL,
            ),
            12 =>
            array (
                'created_at' => NULL,
                'id' => 13,
                'montant' => '1000',
                'periode' => NULL,
                'type' => 'RSPDD',
                'libelle' => "Redevance sûreté par passager de vols domestiques au départ",
                'type_autorisation_id' => NULL,
                'updated_at' => NULL,
            ),
            13 =>
            array (
                'created_at' => NULL,
                'id' => 14,
                'montant' => '10',
                'periode' => NULL,
                'type' => 'RFM',
                'libelle' => "Redevance fret aérien au départ et à l'arrivée par kilogramme autre que les marchandises de valeur",
                'type_autorisation_id' => NULL,
                'updated_at' => NULL,
            ),
            14 =>
            array (
                'created_at' => NULL,
                'id' => 15,
                'montant' => '15',
                'periode' => NULL,
                'type' => 'RFMV',
                'libelle' => "Redevance fret marchandises de valeur (or, argent, diamant, papier fiduclaire, etc) par gramme au départ et à l'arrivée",
                'type_autorisation_id' => NULL,
                'updated_at' => NULL,
            ),
            15 =>
            array (
                'created_at' => NULL,
                'id' => 16,
                'montant' => '3000',
                'periode' => NULL,
                'type' => 'RIT',
                'libelle' => "Redevance internationale de transport",
                'type_autorisation_id' => NULL,
                'updated_at' => NULL,
            ),
            16 =>
            array (
                'created_at' => NULL,
                'id' => 17,
                'montant' => '8500',
                'periode' => NULL,
                'type' => 'RAVC',
                'libelle' => "Redevance de l'Aviation Civile",
                'type_autorisation_id' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }
}
