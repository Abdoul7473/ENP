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
                'assistant1' => 'IP Sani Idi',
                'assistant2' => 'IP Salissou',
                'created_at' => '2026-09-20 17:02:18',
                'date_evaluation' => '2026-09-18',
                'enseignant_groupe_modulo_id' => 1,
                'id' => 1,
                'type_evaluation' => 'Dévoir',
                'updated_at' => '2026-09-20 17:02:18',
            ),
            1 => 
            array (
                'assistant1' => 'IP Sani Idi',
                'assistant2' => 'IP Salissou',
                'created_at' => '2026-09-21 12:03:23',
                'date_evaluation' => '2026-09-28',
                'enseignant_groupe_modulo_id' => 2,
                'id' => 2,
                'type_evaluation' => 'Dévoir',
                'updated_at' => '2026-09-21 12:03:23',
            ),
            2 => 
            array (
                'assistant1' => 'IP Sani Idi',
                'assistant2' => 'IP Salissou',
                'created_at' => '2026-09-24 15:58:07',
                'date_evaluation' => '2026-10-01',
                'enseignant_groupe_modulo_id' => 4,
                'id' => 3,
                'type_evaluation' => 'Dévoir',
                'updated_at' => '2026-09-24 15:58:07',
            ),
            3 => 
            array (
                'assistant1' => NULL,
                'assistant2' => NULL,
                'created_at' => '2026-09-24 22:42:30',
                'date_evaluation' => '2026-09-25',
                'enseignant_groupe_modulo_id' => 5,
                'id' => 4,
                'type_evaluation' => 'Dévoir',
                'updated_at' => '2026-09-24 22:42:30',
            ),
            4 => 
            array (
                'assistant1' => NULL,
                'assistant2' => NULL,
                'created_at' => '2026-09-24 22:44:48',
                'date_evaluation' => '2026-09-24',
                'enseignant_groupe_modulo_id' => 1,
                'id' => 5,
                'type_evaluation' => 'Examen',
                'updated_at' => '2026-09-24 22:44:48',
            ),
            5 => 
            array (
                'assistant1' => NULL,
                'assistant2' => NULL,
                'created_at' => '2026-09-24 22:46:15',
                'date_evaluation' => '2026-10-02',
                'enseignant_groupe_modulo_id' => 2,
                'id' => 6,
                'type_evaluation' => 'Examen',
                'updated_at' => '2026-09-24 22:46:15',
            ),
            6 => 
            array (
                'assistant1' => NULL,
                'assistant2' => NULL,
                'created_at' => '2026-09-24 22:47:52',
                'date_evaluation' => '2026-09-24',
                'enseignant_groupe_modulo_id' => 4,
                'id' => 7,
                'type_evaluation' => 'Examen',
                'updated_at' => '2026-09-24 22:47:52',
            ),
        ));
        
        
    }
}