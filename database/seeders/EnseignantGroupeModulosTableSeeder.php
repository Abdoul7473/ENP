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
        

        \DB::table('enseignant_groupe_modulos')->delete();
        
        \DB::table('enseignant_groupe_modulos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'enseignant_id' => 3,
                'groupe_id' => 1,
                'modulo_id' => 1,
                'created_at' => '2026-09-20 16:12:48',
                'updated_at' => '2026-09-20 16:12:48',
            ),
            1 => 
            array (
                'id' => 2,
                'enseignant_id' => 3,
                'groupe_id' => 1,
                'modulo_id' => 2,
                'created_at' => '2026-09-20 16:13:01',
                'updated_at' => '2026-09-20 16:13:01',
            ),
            2 => 
            array (
                'id' => 3,
                'enseignant_id' => 3,
                'groupe_id' => 1,
                'modulo_id' => 3,
                'created_at' => '2026-09-20 16:13:19',
                'updated_at' => '2026-09-20 16:13:19',
            ),
            3 => 
            array (
                'id' => 4,
                'enseignant_id' => 4,
                'groupe_id' => 1,
                'modulo_id' => 5,
                'created_at' => '2026-09-20 16:13:47',
                'updated_at' => '2026-09-20 16:13:47',
            ),
            4 => 
            array (
                'id' => 5,
                'enseignant_id' => 6,
                'groupe_id' => 1,
                'modulo_id' => 6,
                'created_at' => '2026-09-20 16:14:03',
                'updated_at' => '2026-09-20 16:14:03',
            ),
            5 => 
            array (
                'id' => 6,
                'enseignant_id' => 7,
                'groupe_id' => 1,
                'modulo_id' => 7,
                'created_at' => '2026-09-20 16:14:21',
                'updated_at' => '2026-09-20 16:14:21',
            ),
            6 => 
            array (
                'id' => 7,
                'enseignant_id' => 5,
                'groupe_id' => 1,
                'modulo_id' => 9,
                'created_at' => '2026-09-20 16:14:52',
                'updated_at' => '2026-09-20 16:14:52',
            ),
            7 => 
            array (
                'id' => 8,
                'enseignant_id' => 1,
                'groupe_id' => 1,
                'modulo_id' => 4,
                'created_at' => '2026-09-20 16:15:07',
                'updated_at' => '2026-09-20 16:15:07',
            ),
            8 => 
            array (
                'id' => 9,
                'enseignant_id' => 2,
                'groupe_id' => 1,
                'modulo_id' => 8,
                'created_at' => '2026-09-20 16:15:21',
                'updated_at' => '2026-09-20 16:15:21',
            ),
        ));
        
        
    }
}