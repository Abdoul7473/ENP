<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompagniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('compagnies')->delete();
        
        \DB::table('compagnies')->insert(array (
            0 => 
            array (
                'annee_id' => 1,
                'corp_id' => 4,
                'created_at' => '2026-08-05 10:58:06',
                'effectif' => '36',
                'id' => 1,
                'nom' => 'La 1',
                'passant' => '#E91E63FF',
                'sigle' => 'A',
                'updated_at' => '2026-08-05 10:58:06',
            ),
            1 => 
            array (
                'annee_id' => 1,
                'corp_id' => 3,
                'created_at' => '2026-08-05 11:00:53',
                'effectif' => '100',
                'id' => 2,
                'nom' => 'La 2',
                'passant' => '#000000FF',
                'sigle' => 'B',
                'updated_at' => '2026-08-05 11:00:53',
            ),
            2 => 
            array (
                'annee_id' => 1,
                'corp_id' => 3,
                'created_at' => '2026-08-05 11:01:35',
                'effectif' => '101',
                'id' => 3,
                'nom' => 'La 3',
                'passant' => '#000000FF',
                'sigle' => 'C',
                'updated_at' => '2026-08-05 11:01:35',
            ),
            3 => 
            array (
                'annee_id' => 1,
                'corp_id' => 2,
                'created_at' => '2026-08-05 11:02:06',
                'effectif' => '95',
                'id' => 4,
                'nom' => 'La 4',
                'passant' => '#8BC34AFF',
                'sigle' => 'D',
                'updated_at' => '2026-08-05 11:02:06',
            ),
            4 => 
            array (
                'annee_id' => 1,
                'corp_id' => 2,
                'created_at' => '2026-08-05 11:03:08',
                'effectif' => '95',
                'id' => 5,
                'nom' => 'La 5',
                'passant' => '#8BC34AFF',
                'sigle' => 'E',
                'updated_at' => '2026-08-05 11:03:08',
            ),
        ));
        
        
    }
}