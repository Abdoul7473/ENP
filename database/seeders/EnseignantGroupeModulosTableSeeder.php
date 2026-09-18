<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EnseignantGroupeModulosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('groupes')->delete();
        
        \DB::table('groupes')->insert(array (
            0 => 
            array (
                'created_at' => '2026-09-18 07:23:43',
                'libelle' => "Groupe 1",
                'corp_id' => 3,
                'effectif' => 40,
                'id' => 1,
                'updated_at' => '2026-09-18 07:23:43',
            ),
        ));
        \DB::table('modulos')->delete();
        
        \DB::table('modulos')->insert(array (
            0 => 
            array (
                'created_at' => '2026-09-18 07:23:43',
                'horaire' => "80",
                'coefficient' => "4",
                'corp_id' => 1,
                'matiere_id' => 1,
                'id' => 1,
                'updated_at' => '2026-09-18 07:23:43',
            ),
        ));
        \DB::table('enseignant_groupe_modulos')->delete();
        
        \DB::table('enseignant_groupe_modulos')->insert(array (
            0 => 
            array (
                'created_at' => '2026-09-18 07:23:43',
                'enseignant_id' => 1,
                'groupe_id' => 1,
                'id' => 1,
                'modulo_id' => 1,
                'updated_at' => '2026-09-18 07:23:43',
            ),
        ));

        
        
    }
}