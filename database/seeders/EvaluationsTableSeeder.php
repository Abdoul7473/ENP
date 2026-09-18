<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EvaluationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('evaluations')->delete();
        
        \DB::table('evaluations')->insert(array (
            0 => 
            array (
                'assistants' => '["Ali Ousso", "Issa Issaka"]',
                'created_at' => NULL,
                'date_evaluation' => '2026-09-18',
                'enseignant_groupe_modulo_id' => 2,
                'id' => 1,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}