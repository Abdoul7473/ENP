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
                'libelle' => 'PROCEDURE PENALE',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'created_at' => NULL,
                'id' => 4,
                'libelle' => 'CRIMINALITE TRANSNATIONNALE ORGANISE',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'created_at' => NULL,
                'id' => 5,
                'libelle' => 'TECHNIQUE D\'ENQUETE ET DE FORMALISME PROCEDURALE',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'created_at' => NULL,
                'id' => 6,
                'libelle' => 'CRIMINOLOGIE',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'created_at' => NULL,
                'id' => 7,
                'libelle' => 'GROGUE',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'created_at' => NULL,
                'id' => 8,
                'libelle' => 'POLICE TECHNIQUE ET SCIENTIFIQUE',
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'created_at' => NULL,
                'id' => 9,
                'libelle' => 'DROIT ADMINISTRATIF',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}