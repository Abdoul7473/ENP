<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AvancementsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('avancements')->delete();
        
        \DB::table('avancements')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'date' => '2026-09-18',
                'enseignant_groupe_modulo_id' => 1,
                'heure_arrive' => '8:00',
                'heure_depart' => '10:00',
                'id' => 1,
                'nombre_heure' => '2',
                'objectif_general' => 'OG2',
                'objectif_specific' => 'Sack',
                'progression' => 'Normal',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'created_at' => '2026-09-18 09:35:15',
                'date' => '2026-09-18',
                'enseignant_groupe_modulo_id' => 1,
                'heure_arrive' => '10:00',
                'heure_depart' => '10:00',
                'id' => 2,
                'nombre_heure' => '2',
                'objectif_general' => 'OG1',
                'objectif_specific' => 'TEST',
                'progression' => 'Normal',
                'updated_at' => '2026-09-18 09:35:15',
            ),
            2 => 
            array (
                'created_at' => '2026-09-18 09:47:28',
                'date' => '2026-09-18',
                'enseignant_groupe_modulo_id' => 1,
                'heure_arrive' => '10:15',
                'heure_depart' => '12:14',
                'id' => 3,
                'nombre_heure' => '2',
                'objectif_general' => 'OG3',
                'objectif_specific' => 'AZERTYUIO',
                'progression' => 'Normal',
                'updated_at' => '2026-09-18 09:47:28',
            ),
        ));
        
        
    }
}