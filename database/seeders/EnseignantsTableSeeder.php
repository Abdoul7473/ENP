<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EnseignantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('enseignants')->delete();
        
        \DB::table('enseignants')->insert(array (
            0 => 
            array (
                'created_at' => '2026-09-18 07:19:22',
                'date_naiss' => '1990-01-01',
                'id' => 1,
                'lieu_naiss' => 'Zinder',
                'nom' => 'Abdoul Aziz',
                'prenom' => 'SIDIKOU BOUREIMA',
                'sexe' => 'Masculin',
                'telephone' => '99753957',
                'updated_at' => '2026-09-18 07:19:22',
            ),
            1 => 
            array (
                'created_at' => '2026-09-18 07:20:28',
                'date_naiss' => '1996-01-01',
                'id' => 2,
                'lieu_naiss' => 'Niamey',
                'nom' => 'Boubacar',
                'prenom' => 'MOUMOUNI',
                'sexe' => 'Masculin',
                'telephone' => '99000000',
                'updated_at' => '2026-09-18 07:20:28',
            ),
        ));
        
        
    }
}