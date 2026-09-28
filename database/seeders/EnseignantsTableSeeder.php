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
                'id' => 1,
                'nom' => 'Abdoul Aziz',
                'prenom' => 'SIDIKOU BOUREIMA',
                'date_naiss' => '1990-01-01',
                'lieu_naiss' => 'Zinder',
                'telephone' => '99753957',
                'sexe' => 'Masculin',
                'created_at' => '2026-09-18 07:19:22',
                'updated_at' => '2026-09-18 07:19:22',
            ),
            1 => 
            array (
                'id' => 2,
                'nom' => 'Boubacar',
                'prenom' => 'MOUMOUNI',
                'date_naiss' => '1996-01-01',
                'lieu_naiss' => 'Niamey',
                'telephone' => '99000000',
                'sexe' => 'Masculin',
                'created_at' => '2026-09-18 07:20:28',
                'updated_at' => '2026-09-18 07:20:28',
            ),
            2 => 
            array (
                'id' => 3,
                'nom' => 'Maman Sani',
                'prenom' => 'GANDOU',
                'date_naiss' => '1974-01-01',
                'lieu_naiss' => 'Niamey',
                'telephone' => '90909090',
                'sexe' => 'Masculin',
                'created_at' => '2026-09-20 13:45:08',
                'updated_at' => '2026-09-20 13:45:08',
            ),
            3 => 
            array (
                'id' => 4,
                'nom' => 'Mahamadou',
                'prenom' => 'ABOUBACAR',
                'date_naiss' => '1987-01-01',
                'lieu_naiss' => 'Zinder',
                'telephone' => '90909090',
                'sexe' => 'Masculin',
                'created_at' => '2026-09-20 13:46:20',
                'updated_at' => '2026-09-20 13:46:20',
            ),
            4 => 
            array (
                'id' => 5,
                'nom' => 'Kadri',
                'prenom' => 'SOUMANA',
                'date_naiss' => '1978-01-01',
                'lieu_naiss' => 'Zinder',
                'telephone' => '90909090',
                'sexe' => 'Masculin',
                'created_at' => '2026-09-20 13:47:03',
                'updated_at' => '2026-09-20 13:47:03',
            ),
            5 => 
            array (
                'id' => 6,
                'nom' => 'Aminou',
                'prenom' => 'CHAIBOU',
                'date_naiss' => '1970-01-01',
                'lieu_naiss' => 'Zinder',
                'telephone' => '90909090',
                'sexe' => 'Masculin',
                'created_at' => '2026-09-20 13:48:11',
                'updated_at' => '2026-09-20 13:48:11',
            ),
            6 => 
            array (
                'id' => 7,
                'nom' => 'Mariama',
                'prenom' => 'FANAMI',
                'date_naiss' => '1980-01-01',
                'lieu_naiss' => 'Zinder',
                'telephone' => '90909090',
                'sexe' => 'Féminin',
                'created_at' => '2026-09-20 16:12:06',
                'updated_at' => '2026-09-20 16:12:06',
            ),
        ));
        
        
    }
}