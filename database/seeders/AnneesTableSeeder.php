<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AnneesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('annees')->delete();
        
        \DB::table('annees')->insert(array (
            0 => 
            array (
                'code' => '25',
                'created_at' => '2026-08-04 16:00:59',
                'date_debut' => '2025-12-20',
                'date_fin' => '2027-06-19',
                'id' => 1,
                'libelle' => '025',
                'statut' => 1,
                'updated_at' => '2026-08-04 16:01:07',
            ),
        ));
        
        
    }
}