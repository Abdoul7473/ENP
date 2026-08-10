<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EntitesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('entites')->delete();
        
        \DB::table('entites')->insert(array (
            0 => 
            array (
                'created_at' => '2026-08-03 13:22:16',
                'entite_id' => NULL,
                'id' => 1,
                'libelle' => 'SECRETARIAT',
                'updated_at' => '2026-08-03 13:22:16',
            ),
            1 => 
            array (
                'created_at' => '2026-08-03 13:23:46',
                'entite_id' => NULL,
                'id' => 2,
                'libelle' => 'DÉPARTEMENT DE LA FORMATION',
                'updated_at' => '2026-08-03 13:23:46',
            ),
            2 => 
            array (
                'created_at' => '2026-08-03 13:25:28',
                'entite_id' => NULL,
                'id' => 3,
                'libelle' => 'DÉPARTEMENT DE L\'ADMINISTRATION ET DES MOYENS',
                'updated_at' => '2026-08-03 13:25:28',
            ),
            3 => 
            array (
                'created_at' => '2026-08-03 13:26:17',
                'entite_id' => NULL,
                'id' => 4,
                'libelle' => 'DÉPARTEMENT DU SERVICE INTERIEUR',
                'updated_at' => '2026-08-03 13:26:17',
            ),
            4 => 
            array (
                'created_at' => '2026-08-03 13:27:16',
                'entite_id' => NULL,
                'id' => 5,
                'libelle' => 'DÉPARTEMENT DE LA RECHERCHE ET DE LA DOCUMENTATION',
                'updated_at' => '2026-08-03 13:27:16',
            ),
            5 => 
            array (
                'created_at' => '2026-08-03 13:27:49',
                'entite_id' => NULL,
                'id' => 6,
                'libelle' => 'DÉPARTEMENT MEDICO-SOCIAL',
                'updated_at' => '2026-08-03 13:27:49',
            ),
            6 => 
            array (
                'created_at' => '2026-08-03 13:28:47',
                'entite_id' => 2,
                'id' => 7,
                'libelle' => 'SERVICE DE LA FORMATION INITIALE',
                'updated_at' => '2026-08-03 13:28:47',
            ),
            7 => 
            array (
                'created_at' => '2026-08-03 13:29:26',
                'entite_id' => 2,
                'id' => 8,
                'libelle' => 'SERVICE DE LA FORMATION CONTINUE',
                'updated_at' => '2026-08-03 13:29:26',
            ),
            8 => 
            array (
                'created_at' => '2026-08-03 13:30:04',
                'entite_id' => 2,
                'id' => 9,
                'libelle' => 'SERVICE DE LA FORMATION SPECIALISE',
                'updated_at' => '2026-08-03 13:30:04',
            ),
            9 => 
            array (
                'created_at' => '2026-08-03 13:31:05',
                'entite_id' => 2,
                'id' => 10,
                'libelle' => 'SERVICE DE SUIVI ET EVALUATION DE LA FORMATION ET DES STAGES',
                'updated_at' => '2026-08-03 13:31:05',
            ),
            10 => 
            array (
                'created_at' => '2026-08-03 13:31:50',
                'entite_id' => 3,
                'id' => 11,
                'libelle' => 'SERVICE DU PERSONNEL',
                'updated_at' => '2026-08-03 13:31:50',
            ),
            11 => 
            array (
                'created_at' => '2026-08-03 13:32:59',
                'entite_id' => 3,
                'id' => 12,
                'libelle' => 'SERVICE DU MATERIEL ET DES INFRASTRUCTURES',
                'updated_at' => '2026-08-03 13:32:59',
            ),
        ));
        
        
    }
}