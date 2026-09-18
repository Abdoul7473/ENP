<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupesTableSeeder extends Seeder
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
                'corp_id' => 3,
                'created_at' => '2026-09-18 07:23:43',
                'effectif' => 40,
                'id' => 1,
                'libelle' => 'Groupe 1',
                'updated_at' => '2026-09-18 07:23:43',
            ),
            1 => 
            array (
                'corp_id' => 3,
                'created_at' => '2026-09-18 11:30:41',
                'effectif' => 40,
                'id' => 2,
                'libelle' => 'GROUPE 4',
                'updated_at' => '2026-09-18 11:30:41',
            ),
            2 => 
            array (
                'corp_id' => 3,
                'created_at' => '2026-09-18 14:09:40',
                'effectif' => 40,
                'id' => 3,
                'libelle' => 'GROUPE 5',
                'updated_at' => '2026-09-18 14:09:40',
            ),
        ));
        
        
    }
}