<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModulosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('modulos')->delete();
        
        \DB::table('modulos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'horaire' => '34',
                'coefficient' => '2',
                'matiere_id' => 1,
                'corp_id' => 3,
                'created_at' => '2026-09-20 13:25:17',
                'updated_at' => '2026-09-20 13:25:17',
            ),
            1 => 
            array (
                'id' => 2,
                'horaire' => '74',
                'coefficient' => '4',
                'matiere_id' => 2,
                'corp_id' => 3,
                'created_at' => '2026-09-20 13:25:33',
                'updated_at' => '2026-09-20 13:25:33',
            ),
            2 => 
            array (
                'id' => 3,
                'horaire' => '28',
                'coefficient' => '1',
                'matiere_id' => 3,
                'corp_id' => 3,
                'created_at' => '2026-09-20 13:25:52',
                'updated_at' => '2026-09-20 13:25:52',
            ),
            3 => 
            array (
                'id' => 4,
                'horaire' => '38',
                'coefficient' => '2',
                'matiere_id' => 4,
                'corp_id' => 3,
                'created_at' => '2026-09-20 13:26:13',
                'updated_at' => '2026-09-20 13:26:13',
            ),
            4 => 
            array (
                'id' => 5,
                'horaire' => '103',
                'coefficient' => '4',
                'matiere_id' => 5,
                'corp_id' => 3,
                'created_at' => '2026-09-20 13:26:29',
                'updated_at' => '2026-09-20 13:26:29',
            ),
            5 => 
            array (
                'id' => 6,
                'horaire' => '22',
                'coefficient' => '1',
                'matiere_id' => 6,
                'corp_id' => 3,
                'created_at' => '2026-09-20 13:26:48',
                'updated_at' => '2026-09-20 13:26:48',
            ),
            6 => 
            array (
                'id' => 7,
                'horaire' => '31',
                'coefficient' => '1',
                'matiere_id' => 7,
                'corp_id' => 3,
                'created_at' => '2026-09-20 13:27:12',
                'updated_at' => '2026-09-20 13:27:12',
            ),
            7 => 
            array (
                'id' => 8,
                'horaire' => '50',
                'coefficient' => '2',
                'matiere_id' => 8,
                'corp_id' => 3,
                'created_at' => '2026-09-20 13:27:27',
                'updated_at' => '2026-09-20 13:27:27',
            ),
            8 => 
            array (
                'id' => 9,
                'horaire' => '34',
                'coefficient' => '3',
                'matiere_id' => 9,
                'corp_id' => 3,
                'created_at' => '2026-09-20 13:27:46',
                'updated_at' => '2026-09-20 13:27:46',
            ),
        ));
        
        
    }
}