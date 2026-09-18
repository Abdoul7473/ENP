<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MatieresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('matieres')->delete();
        
        \DB::table('matieres')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'id' => 1,
                'libelle' => 'DROIT PENAL GENERAL',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'created_at' => NULL,
                'id' => 2,
                'libelle' => 'DROIT PENAL SPECIAL',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'created_at' => NULL,
                'id' => 3,
                'libelle' => 'SECURITE PUBLIQUE',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'created_at' => NULL,
                'id' => 4,
                'libelle' => 'DROIT ADMNISTRATIF',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'created_at' => NULL,
                'id' => 5,
                'libelle' => 'TECHENIQUE D\'ENQUETE ET FORMALISME PROCEDURAL',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}