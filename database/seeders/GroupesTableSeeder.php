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
                'id' => 1,
                'libelle' => 'GROUPE 4',
                'corp_id' => 3,
                'effectif' => 40,
                'created_at' => '2026-09-20 13:32:50',
                'updated_at' => '2026-09-20 13:32:50',
            ),
            1 => 
            array (
                'id' => 2,
                'libelle' => 'GROUPE 5',
                'corp_id' => 3,
                'effectif' => 40,
                'created_at' => '2026-09-23 19:48:26',
                'updated_at' => '2026-09-23 19:48:26',
            ),
        ));
        
        
    }
}