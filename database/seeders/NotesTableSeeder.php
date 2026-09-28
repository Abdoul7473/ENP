<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NotesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('notes')->delete();
        
        \DB::table('notes')->insert(array (
            0 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 2,
                'evaluation_id' => 1,
                'id' => 1,
                'note' => '12',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            1 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 4,
                'evaluation_id' => 1,
                'id' => 2,
                'note' => '11',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            2 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 6,
                'evaluation_id' => 1,
                'id' => 3,
                'note' => '13',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            3 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 8,
                'evaluation_id' => 1,
                'id' => 4,
                'note' => '10',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            4 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 10,
                'evaluation_id' => 1,
                'id' => 5,
                'note' => '15',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            5 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 12,
                'evaluation_id' => 1,
                'id' => 6,
                'note' => '17',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            6 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 14,
                'evaluation_id' => 1,
                'id' => 7,
                'note' => '17',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            7 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 16,
                'evaluation_id' => 1,
                'id' => 8,
                'note' => '18',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            8 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 22,
                'evaluation_id' => 1,
                'id' => 9,
                'note' => '13',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            9 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 24,
                'evaluation_id' => 1,
                'id' => 10,
                'note' => '16',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            10 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 26,
                'evaluation_id' => 1,
                'id' => 11,
                'note' => '13',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            11 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 30,
                'evaluation_id' => 1,
                'id' => 12,
                'note' => '14',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            12 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 32,
                'evaluation_id' => 1,
                'id' => 13,
                'note' => '15',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            13 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 34,
                'evaluation_id' => 1,
                'id' => 14,
                'note' => '16',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            14 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 36,
                'evaluation_id' => 1,
                'id' => 15,
                'note' => '17',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            15 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 42,
                'evaluation_id' => 1,
                'id' => 16,
                'note' => '17',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            16 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 44,
                'evaluation_id' => 1,
                'id' => 17,
                'note' => '15',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            17 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 46,
                'evaluation_id' => 1,
                'id' => 18,
                'note' => '15',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            18 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 48,
                'evaluation_id' => 1,
                'id' => 19,
                'note' => '14',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            19 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 49,
                'evaluation_id' => 1,
                'id' => 20,
                'note' => '15',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            20 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 54,
                'evaluation_id' => 1,
                'id' => 21,
                'note' => '17',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            21 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 56,
                'evaluation_id' => 1,
                'id' => 22,
                'note' => '18',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            22 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 58,
                'evaluation_id' => 1,
                'id' => 23,
                'note' => '11',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            23 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 60,
                'evaluation_id' => 1,
                'id' => 24,
                'note' => '12',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            24 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 62,
                'evaluation_id' => 1,
                'id' => 25,
                'note' => '12',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            25 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 66,
                'evaluation_id' => 1,
                'id' => 26,
                'note' => '12',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            26 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 72,
                'evaluation_id' => 1,
                'id' => 27,
                'note' => '16',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            27 => 
            array (
                'created_at' => '2026-09-24 22:39:14',
                'eleve_id' => 74,
                'evaluation_id' => 1,
                'id' => 28,
                'note' => '16',
                'updated_at' => '2026-09-24 22:39:14',
            ),
            28 => 
            array (
                'created_at' => '2026-09-24 22:39:15',
                'eleve_id' => 78,
                'evaluation_id' => 1,
                'id' => 29,
                'note' => '15',
                'updated_at' => '2026-09-24 22:39:15',
            ),
            29 => 
            array (
                'created_at' => '2026-09-24 22:39:15',
                'eleve_id' => 80,
                'evaluation_id' => 1,
                'id' => 30,
                'note' => '16',
                'updated_at' => '2026-09-24 22:39:15',
            ),
            30 => 
            array (
                'created_at' => '2026-09-24 22:39:15',
                'eleve_id' => 82,
                'evaluation_id' => 1,
                'id' => 31,
                'note' => '15',
                'updated_at' => '2026-09-24 22:39:15',
            ),
            31 => 
            array (
                'created_at' => '2026-09-24 22:39:15',
                'eleve_id' => 84,
                'evaluation_id' => 1,
                'id' => 32,
                'note' => '16',
                'updated_at' => '2026-09-24 22:39:15',
            ),
            32 => 
            array (
                'created_at' => '2026-09-24 22:39:15',
                'eleve_id' => 88,
                'evaluation_id' => 1,
                'id' => 33,
                'note' => '15',
                'updated_at' => '2026-09-24 22:39:15',
            ),
            33 => 
            array (
                'created_at' => '2026-09-24 22:39:15',
                'eleve_id' => 90,
                'evaluation_id' => 1,
                'id' => 34,
                'note' => '14',
                'updated_at' => '2026-09-24 22:39:15',
            ),
            34 => 
            array (
                'created_at' => '2026-09-24 22:39:15',
                'eleve_id' => 92,
                'evaluation_id' => 1,
                'id' => 35,
                'note' => '12',
                'updated_at' => '2026-09-24 22:39:15',
            ),
            35 => 
            array (
                'created_at' => '2026-09-24 22:39:15',
                'eleve_id' => 96,
                'evaluation_id' => 1,
                'id' => 36,
                'note' => '14',
                'updated_at' => '2026-09-24 22:39:15',
            ),
            36 => 
            array (
                'created_at' => '2026-09-24 22:39:15',
                'eleve_id' => 100,
                'evaluation_id' => 1,
                'id' => 37,
                'note' => '12',
                'updated_at' => '2026-09-24 22:39:15',
            ),
            37 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 2,
                'evaluation_id' => 2,
                'id' => 38,
                'note' => '12',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            38 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 4,
                'evaluation_id' => 2,
                'id' => 39,
                'note' => '19',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            39 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 6,
                'evaluation_id' => 2,
                'id' => 40,
                'note' => '19',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            40 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 8,
                'evaluation_id' => 2,
                'id' => 41,
                'note' => '18',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            41 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 10,
                'evaluation_id' => 2,
                'id' => 42,
                'note' => '16',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            42 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 12,
                'evaluation_id' => 2,
                'id' => 43,
                'note' => '16',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            43 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 14,
                'evaluation_id' => 2,
                'id' => 44,
                'note' => '17',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            44 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 16,
                'evaluation_id' => 2,
                'id' => 45,
                'note' => '15',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            45 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 22,
                'evaluation_id' => 2,
                'id' => 46,
                'note' => '12',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            46 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 24,
                'evaluation_id' => 2,
                'id' => 47,
                'note' => '11',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            47 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 26,
                'evaluation_id' => 2,
                'id' => 48,
                'note' => '10',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            48 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 30,
                'evaluation_id' => 2,
                'id' => 49,
                'note' => '18',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            49 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 32,
                'evaluation_id' => 2,
                'id' => 50,
                'note' => '18',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            50 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 34,
                'evaluation_id' => 2,
                'id' => 51,
                'note' => '18',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            51 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 36,
                'evaluation_id' => 2,
                'id' => 52,
                'note' => '18',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            52 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 42,
                'evaluation_id' => 2,
                'id' => 53,
                'note' => '17',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            53 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 44,
                'evaluation_id' => 2,
                'id' => 54,
                'note' => '16',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            54 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 46,
                'evaluation_id' => 2,
                'id' => 55,
                'note' => '17',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            55 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 48,
                'evaluation_id' => 2,
                'id' => 56,
                'note' => '18',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            56 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 49,
                'evaluation_id' => 2,
                'id' => 57,
                'note' => '16',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            57 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 54,
                'evaluation_id' => 2,
                'id' => 58,
                'note' => '16',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            58 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 56,
                'evaluation_id' => 2,
                'id' => 59,
                'note' => '17',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            59 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 58,
                'evaluation_id' => 2,
                'id' => 60,
                'note' => '17',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            60 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 60,
                'evaluation_id' => 2,
                'id' => 61,
                'note' => '17',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            61 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 62,
                'evaluation_id' => 2,
                'id' => 62,
                'note' => '19',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            62 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 66,
                'evaluation_id' => 2,
                'id' => 63,
                'note' => '12',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            63 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 72,
                'evaluation_id' => 2,
                'id' => 64,
                'note' => '19',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            64 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 74,
                'evaluation_id' => 2,
                'id' => 65,
                'note' => '17',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            65 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 78,
                'evaluation_id' => 2,
                'id' => 66,
                'note' => '10',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            66 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 80,
                'evaluation_id' => 2,
                'id' => 67,
                'note' => '18',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            67 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 82,
                'evaluation_id' => 2,
                'id' => 68,
                'note' => '17',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            68 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 84,
                'evaluation_id' => 2,
                'id' => 69,
                'note' => '18',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            69 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 88,
                'evaluation_id' => 2,
                'id' => 70,
                'note' => '18',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            70 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 90,
                'evaluation_id' => 2,
                'id' => 71,
                'note' => '17',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            71 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 92,
                'evaluation_id' => 2,
                'id' => 72,
                'note' => '10',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            72 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 96,
                'evaluation_id' => 2,
                'id' => 73,
                'note' => '16',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            73 => 
            array (
                'created_at' => '2026-09-24 22:40:45',
                'eleve_id' => 100,
                'evaluation_id' => 2,
                'id' => 74,
                'note' => '12',
                'updated_at' => '2026-09-24 22:40:45',
            ),
            74 => 
            array (
                'created_at' => '2026-09-24 22:42:05',
                'eleve_id' => 2,
                'evaluation_id' => 3,
                'id' => 75,
                'note' => '12',
                'updated_at' => '2026-09-24 22:42:05',
            ),
            75 => 
            array (
                'created_at' => '2026-09-24 22:42:05',
                'eleve_id' => 4,
                'evaluation_id' => 3,
                'id' => 76,
                'note' => '19',
                'updated_at' => '2026-09-24 22:42:05',
            ),
            76 => 
            array (
                'created_at' => '2026-09-24 22:42:05',
                'eleve_id' => 6,
                'evaluation_id' => 3,
                'id' => 77,
                'note' => '18',
                'updated_at' => '2026-09-24 22:42:05',
            ),
            77 => 
            array (
                'created_at' => '2026-09-24 22:42:05',
                'eleve_id' => 8,
                'evaluation_id' => 3,
                'id' => 78,
                'note' => '18',
                'updated_at' => '2026-09-24 22:42:05',
            ),
            78 => 
            array (
                'created_at' => '2026-09-24 22:42:05',
                'eleve_id' => 10,
                'evaluation_id' => 3,
                'id' => 79,
                'note' => '12',
                'updated_at' => '2026-09-24 22:42:05',
            ),
            79 => 
            array (
                'created_at' => '2026-09-24 22:42:05',
                'eleve_id' => 12,
                'evaluation_id' => 3,
                'id' => 80,
                'note' => '11',
                'updated_at' => '2026-09-24 22:42:05',
            ),
            80 => 
            array (
                'created_at' => '2026-09-24 22:42:05',
                'eleve_id' => 14,
                'evaluation_id' => 3,
                'id' => 81,
                'note' => '11',
                'updated_at' => '2026-09-24 22:42:05',
            ),
            81 => 
            array (
                'created_at' => '2026-09-24 22:42:05',
                'eleve_id' => 16,
                'evaluation_id' => 3,
                'id' => 82,
                'note' => '13',
                'updated_at' => '2026-09-24 22:42:05',
            ),
            82 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 22,
                'evaluation_id' => 3,
                'id' => 83,
                'note' => '16',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            83 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 24,
                'evaluation_id' => 3,
                'id' => 84,
                'note' => '18',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            84 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 26,
                'evaluation_id' => 3,
                'id' => 85,
                'note' => '12',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            85 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 30,
                'evaluation_id' => 3,
                'id' => 86,
                'note' => '12',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            86 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 32,
                'evaluation_id' => 3,
                'id' => 87,
                'note' => '12',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            87 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 34,
                'evaluation_id' => 3,
                'id' => 88,
                'note' => '18',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            88 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 36,
                'evaluation_id' => 3,
                'id' => 89,
                'note' => '17',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            89 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 42,
                'evaluation_id' => 3,
                'id' => 90,
                'note' => '18',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            90 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 44,
                'evaluation_id' => 3,
                'id' => 91,
                'note' => '17',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            91 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 46,
                'evaluation_id' => 3,
                'id' => 92,
                'note' => '16',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            92 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 48,
                'evaluation_id' => 3,
                'id' => 93,
                'note' => '16',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            93 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 49,
                'evaluation_id' => 3,
                'id' => 94,
                'note' => '12',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            94 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 54,
                'evaluation_id' => 3,
                'id' => 95,
                'note' => '12',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            95 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 56,
                'evaluation_id' => 3,
                'id' => 96,
                'note' => '19',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            96 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 58,
                'evaluation_id' => 3,
                'id' => 97,
                'note' => '10',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            97 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 60,
                'evaluation_id' => 3,
                'id' => 98,
                'note' => '10',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            98 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 62,
                'evaluation_id' => 3,
                'id' => 99,
                'note' => '11',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            99 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 66,
                'evaluation_id' => 3,
                'id' => 100,
                'note' => '14',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            100 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 72,
                'evaluation_id' => 3,
                'id' => 101,
                'note' => '17',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            101 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 74,
                'evaluation_id' => 3,
                'id' => 102,
                'note' => '12',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            102 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 78,
                'evaluation_id' => 3,
                'id' => 103,
                'note' => '18',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            103 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 80,
                'evaluation_id' => 3,
                'id' => 104,
                'note' => '18',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            104 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 82,
                'evaluation_id' => 3,
                'id' => 105,
                'note' => '15',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            105 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 84,
                'evaluation_id' => 3,
                'id' => 106,
                'note' => '17',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            106 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 88,
                'evaluation_id' => 3,
                'id' => 107,
                'note' => '10',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            107 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 90,
                'evaluation_id' => 3,
                'id' => 108,
                'note' => '19',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            108 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 92,
                'evaluation_id' => 3,
                'id' => 109,
                'note' => '18',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            109 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 96,
                'evaluation_id' => 3,
                'id' => 110,
                'note' => '12',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            110 => 
            array (
                'created_at' => '2026-09-24 22:42:06',
                'eleve_id' => 100,
                'evaluation_id' => 3,
                'id' => 111,
                'note' => '19',
                'updated_at' => '2026-09-24 22:42:06',
            ),
            111 => 
            array (
                'created_at' => '2026-09-24 22:44:26',
                'eleve_id' => 2,
                'evaluation_id' => 4,
                'id' => 112,
                'note' => '12',
                'updated_at' => '2026-09-24 22:44:26',
            ),
            112 => 
            array (
                'created_at' => '2026-09-24 22:44:26',
                'eleve_id' => 4,
                'evaluation_id' => 4,
                'id' => 113,
                'note' => '13',
                'updated_at' => '2026-09-24 22:44:26',
            ),
            113 => 
            array (
                'created_at' => '2026-09-24 22:44:26',
                'eleve_id' => 6,
                'evaluation_id' => 4,
                'id' => 114,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:26',
            ),
            114 => 
            array (
                'created_at' => '2026-09-24 22:44:26',
                'eleve_id' => 8,
                'evaluation_id' => 4,
                'id' => 115,
                'note' => '19',
                'updated_at' => '2026-09-24 22:44:26',
            ),
            115 => 
            array (
                'created_at' => '2026-09-24 22:44:26',
                'eleve_id' => 10,
                'evaluation_id' => 4,
                'id' => 116,
                'note' => '17',
                'updated_at' => '2026-09-24 22:44:26',
            ),
            116 => 
            array (
                'created_at' => '2026-09-24 22:44:26',
                'eleve_id' => 12,
                'evaluation_id' => 4,
                'id' => 117,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:26',
            ),
            117 => 
            array (
                'created_at' => '2026-09-24 22:44:26',
                'eleve_id' => 14,
                'evaluation_id' => 4,
                'id' => 118,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:26',
            ),
            118 => 
            array (
                'created_at' => '2026-09-24 22:44:26',
                'eleve_id' => 16,
                'evaluation_id' => 4,
                'id' => 119,
                'note' => '12',
                'updated_at' => '2026-09-24 22:44:26',
            ),
            119 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 22,
                'evaluation_id' => 4,
                'id' => 120,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            120 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 24,
                'evaluation_id' => 4,
                'id' => 121,
                'note' => '17',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            121 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 26,
                'evaluation_id' => 4,
                'id' => 122,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            122 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 30,
                'evaluation_id' => 4,
                'id' => 123,
                'note' => '16',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            123 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 32,
                'evaluation_id' => 4,
                'id' => 124,
                'note' => '17',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            124 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 34,
                'evaluation_id' => 4,
                'id' => 125,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            125 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 36,
                'evaluation_id' => 4,
                'id' => 126,
                'note' => '17',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            126 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 42,
                'evaluation_id' => 4,
                'id' => 127,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            127 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 44,
                'evaluation_id' => 4,
                'id' => 128,
                'note' => '17',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            128 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 46,
                'evaluation_id' => 4,
                'id' => 129,
                'note' => '16',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            129 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 48,
                'evaluation_id' => 4,
                'id' => 130,
                'note' => '17',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            130 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 49,
                'evaluation_id' => 4,
                'id' => 131,
                'note' => '17',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            131 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 54,
                'evaluation_id' => 4,
                'id' => 132,
                'note' => '17',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            132 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 56,
                'evaluation_id' => 4,
                'id' => 133,
                'note' => '12',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            133 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 58,
                'evaluation_id' => 4,
                'id' => 134,
                'note' => '12',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            134 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 60,
                'evaluation_id' => 4,
                'id' => 135,
                'note' => '17',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            135 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 62,
                'evaluation_id' => 4,
                'id' => 136,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            136 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 66,
                'evaluation_id' => 4,
                'id' => 137,
                'note' => '10',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            137 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 72,
                'evaluation_id' => 4,
                'id' => 138,
                'note' => '12',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            138 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 74,
                'evaluation_id' => 4,
                'id' => 139,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            139 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 78,
                'evaluation_id' => 4,
                'id' => 140,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            140 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 80,
                'evaluation_id' => 4,
                'id' => 141,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            141 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 82,
                'evaluation_id' => 4,
                'id' => 142,
                'note' => '19',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            142 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 84,
                'evaluation_id' => 4,
                'id' => 143,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            143 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 88,
                'evaluation_id' => 4,
                'id' => 144,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            144 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 90,
                'evaluation_id' => 4,
                'id' => 145,
                'note' => '18',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            145 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 92,
                'evaluation_id' => 4,
                'id' => 146,
                'note' => '17',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            146 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 96,
                'evaluation_id' => 4,
                'id' => 147,
                'note' => '12',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            147 => 
            array (
                'created_at' => '2026-09-24 22:44:27',
                'eleve_id' => 100,
                'evaluation_id' => 4,
                'id' => 148,
                'note' => '12',
                'updated_at' => '2026-09-24 22:44:27',
            ),
            148 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 2,
                'evaluation_id' => 5,
                'id' => 149,
                'note' => '19',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            149 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 4,
                'evaluation_id' => 5,
                'id' => 150,
                'note' => '19',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            150 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 6,
                'evaluation_id' => 5,
                'id' => 151,
                'note' => '18',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            151 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 8,
                'evaluation_id' => 5,
                'id' => 152,
                'note' => '15',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            152 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 10,
                'evaluation_id' => 5,
                'id' => 153,
                'note' => '16',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            153 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 12,
                'evaluation_id' => 5,
                'id' => 154,
                'note' => '13',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            154 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 14,
                'evaluation_id' => 5,
                'id' => 155,
                'note' => '14',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            155 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 16,
                'evaluation_id' => 5,
                'id' => 156,
                'note' => '15',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            156 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 22,
                'evaluation_id' => 5,
                'id' => 157,
                'note' => '16',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            157 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 24,
                'evaluation_id' => 5,
                'id' => 158,
                'note' => '11',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            158 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 26,
                'evaluation_id' => 5,
                'id' => 159,
                'note' => '11',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            159 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 30,
                'evaluation_id' => 5,
                'id' => 160,
                'note' => '17',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            160 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 32,
                'evaluation_id' => 5,
                'id' => 161,
                'note' => '17',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            161 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 34,
                'evaluation_id' => 5,
                'id' => 162,
                'note' => '17',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            162 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 36,
                'evaluation_id' => 5,
                'id' => 163,
                'note' => '19',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            163 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 42,
                'evaluation_id' => 5,
                'id' => 164,
                'note' => '19',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            164 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 44,
                'evaluation_id' => 5,
                'id' => 165,
                'note' => '12',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            165 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 46,
                'evaluation_id' => 5,
                'id' => 166,
                'note' => '17',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            166 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 48,
                'evaluation_id' => 5,
                'id' => 167,
                'note' => '17',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            167 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 49,
                'evaluation_id' => 5,
                'id' => 168,
                'note' => '18',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            168 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 54,
                'evaluation_id' => 5,
                'id' => 169,
                'note' => '18',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            169 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 56,
                'evaluation_id' => 5,
                'id' => 170,
                'note' => '18',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            170 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 58,
                'evaluation_id' => 5,
                'id' => 171,
                'note' => '18',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            171 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 60,
                'evaluation_id' => 5,
                'id' => 172,
                'note' => '14',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            172 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 62,
                'evaluation_id' => 5,
                'id' => 173,
                'note' => '17',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            173 => 
            array (
                'created_at' => '2026-09-24 22:45:59',
                'eleve_id' => 66,
                'evaluation_id' => 5,
                'id' => 174,
                'note' => '17',
                'updated_at' => '2026-09-24 22:45:59',
            ),
            174 => 
            array (
                'created_at' => '2026-09-24 22:46:00',
                'eleve_id' => 72,
                'evaluation_id' => 5,
                'id' => 175,
                'note' => '17',
                'updated_at' => '2026-09-24 22:46:00',
            ),
            175 => 
            array (
                'created_at' => '2026-09-24 22:46:00',
                'eleve_id' => 74,
                'evaluation_id' => 5,
                'id' => 176,
                'note' => '12',
                'updated_at' => '2026-09-24 22:46:00',
            ),
            176 => 
            array (
                'created_at' => '2026-09-24 22:46:00',
                'eleve_id' => 78,
                'evaluation_id' => 5,
                'id' => 177,
                'note' => '12',
                'updated_at' => '2026-09-24 22:46:00',
            ),
            177 => 
            array (
                'created_at' => '2026-09-24 22:46:00',
                'eleve_id' => 80,
                'evaluation_id' => 5,
                'id' => 178,
                'note' => '18',
                'updated_at' => '2026-09-24 22:46:00',
            ),
            178 => 
            array (
                'created_at' => '2026-09-24 22:46:00',
                'eleve_id' => 82,
                'evaluation_id' => 5,
                'id' => 179,
                'note' => '18',
                'updated_at' => '2026-09-24 22:46:00',
            ),
            179 => 
            array (
                'created_at' => '2026-09-24 22:46:00',
                'eleve_id' => 84,
                'evaluation_id' => 5,
                'id' => 180,
                'note' => '18',
                'updated_at' => '2026-09-24 22:46:00',
            ),
            180 => 
            array (
                'created_at' => '2026-09-24 22:46:00',
                'eleve_id' => 88,
                'evaluation_id' => 5,
                'id' => 181,
                'note' => '10',
                'updated_at' => '2026-09-24 22:46:00',
            ),
            181 => 
            array (
                'created_at' => '2026-09-24 22:46:00',
                'eleve_id' => 90,
                'evaluation_id' => 5,
                'id' => 182,
                'note' => '19',
                'updated_at' => '2026-09-24 22:46:00',
            ),
            182 => 
            array (
                'created_at' => '2026-09-24 22:46:00',
                'eleve_id' => 92,
                'evaluation_id' => 5,
                'id' => 183,
                'note' => '18',
                'updated_at' => '2026-09-24 22:46:00',
            ),
            183 => 
            array (
                'created_at' => '2026-09-24 22:46:00',
                'eleve_id' => 96,
                'evaluation_id' => 5,
                'id' => 184,
                'note' => '19',
                'updated_at' => '2026-09-24 22:46:00',
            ),
            184 => 
            array (
                'created_at' => '2026-09-24 22:46:00',
                'eleve_id' => 100,
                'evaluation_id' => 5,
                'id' => 185,
                'note' => '16',
                'updated_at' => '2026-09-24 22:46:00',
            ),
            185 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 2,
                'evaluation_id' => 6,
                'id' => 186,
                'note' => '12',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            186 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 4,
                'evaluation_id' => 6,
                'id' => 187,
                'note' => '19',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            187 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 6,
                'evaluation_id' => 6,
                'id' => 188,
                'note' => '10',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            188 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 8,
                'evaluation_id' => 6,
                'id' => 189,
                'note' => '10',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            189 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 10,
                'evaluation_id' => 6,
                'id' => 190,
                'note' => '15',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            190 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 12,
                'evaluation_id' => 6,
                'id' => 191,
                'note' => '16',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            191 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 14,
                'evaluation_id' => 6,
                'id' => 192,
                'note' => '19',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            192 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 16,
                'evaluation_id' => 6,
                'id' => 193,
                'note' => '7',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            193 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 22,
                'evaluation_id' => 6,
                'id' => 194,
                'note' => '18',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            194 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 24,
                'evaluation_id' => 6,
                'id' => 195,
                'note' => '18',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            195 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 26,
                'evaluation_id' => 6,
                'id' => 196,
                'note' => '16',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            196 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 30,
                'evaluation_id' => 6,
                'id' => 197,
                'note' => '17',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            197 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 32,
                'evaluation_id' => 6,
                'id' => 198,
                'note' => '16',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            198 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 34,
                'evaluation_id' => 6,
                'id' => 199,
                'note' => '15',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            199 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 36,
                'evaluation_id' => 6,
                'id' => 200,
                'note' => '11',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            200 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 42,
                'evaluation_id' => 6,
                'id' => 201,
                'note' => '11',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            201 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 44,
                'evaluation_id' => 6,
                'id' => 202,
                'note' => '19',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            202 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 46,
                'evaluation_id' => 6,
                'id' => 203,
                'note' => '9',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            203 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 48,
                'evaluation_id' => 6,
                'id' => 204,
                'note' => '10',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            204 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 49,
                'evaluation_id' => 6,
                'id' => 205,
                'note' => '18',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            205 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 54,
                'evaluation_id' => 6,
                'id' => 206,
                'note' => '11',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            206 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 56,
                'evaluation_id' => 6,
                'id' => 207,
                'note' => '18',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            207 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 58,
                'evaluation_id' => 6,
                'id' => 208,
                'note' => '17',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            208 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 60,
                'evaluation_id' => 6,
                'id' => 209,
                'note' => '18',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            209 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 62,
                'evaluation_id' => 6,
                'id' => 210,
                'note' => '10',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            210 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 66,
                'evaluation_id' => 6,
                'id' => 211,
                'note' => '10',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            211 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 72,
                'evaluation_id' => 6,
                'id' => 212,
                'note' => '19',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            212 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 74,
                'evaluation_id' => 6,
                'id' => 213,
                'note' => '18',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            213 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 78,
                'evaluation_id' => 6,
                'id' => 214,
                'note' => '19',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            214 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 80,
                'evaluation_id' => 6,
                'id' => 215,
                'note' => '18',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            215 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 82,
                'evaluation_id' => 6,
                'id' => 216,
                'note' => '10',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            216 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 84,
                'evaluation_id' => 6,
                'id' => 217,
                'note' => '19',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            217 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 88,
                'evaluation_id' => 6,
                'id' => 218,
                'note' => '8',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            218 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 90,
                'evaluation_id' => 6,
                'id' => 219,
                'note' => '19',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            219 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 92,
                'evaluation_id' => 6,
                'id' => 220,
                'note' => '16',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            220 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 96,
                'evaluation_id' => 6,
                'id' => 221,
                'note' => '16',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            221 => 
            array (
                'created_at' => '2026-09-24 22:47:39',
                'eleve_id' => 100,
                'evaluation_id' => 6,
                'id' => 222,
                'note' => '17',
                'updated_at' => '2026-09-24 22:47:39',
            ),
            222 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 2,
                'evaluation_id' => 7,
                'id' => 223,
                'note' => '10',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            223 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 4,
                'evaluation_id' => 7,
                'id' => 224,
                'note' => '11',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            224 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 6,
                'evaluation_id' => 7,
                'id' => 225,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            225 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 8,
                'evaluation_id' => 7,
                'id' => 226,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            226 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 10,
                'evaluation_id' => 7,
                'id' => 227,
                'note' => '17',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            227 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 12,
                'evaluation_id' => 7,
                'id' => 228,
                'note' => '17',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            228 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 14,
                'evaluation_id' => 7,
                'id' => 229,
                'note' => '17',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            229 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 16,
                'evaluation_id' => 7,
                'id' => 230,
                'note' => '15',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            230 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 22,
                'evaluation_id' => 7,
                'id' => 231,
                'note' => '16',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            231 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 24,
                'evaluation_id' => 7,
                'id' => 232,
                'note' => '16',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            232 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 26,
                'evaluation_id' => 7,
                'id' => 233,
                'note' => '17',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            233 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 30,
                'evaluation_id' => 7,
                'id' => 234,
                'note' => '18',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            234 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 32,
                'evaluation_id' => 7,
                'id' => 235,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            235 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 34,
                'evaluation_id' => 7,
                'id' => 236,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            236 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 36,
                'evaluation_id' => 7,
                'id' => 237,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            237 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 42,
                'evaluation_id' => 7,
                'id' => 238,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            238 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 44,
                'evaluation_id' => 7,
                'id' => 239,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            239 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 46,
                'evaluation_id' => 7,
                'id' => 240,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            240 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 48,
                'evaluation_id' => 7,
                'id' => 241,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            241 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 49,
                'evaluation_id' => 7,
                'id' => 242,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            242 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 54,
                'evaluation_id' => 7,
                'id' => 243,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            243 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 56,
                'evaluation_id' => 7,
                'id' => 244,
                'note' => '10',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            244 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 58,
                'evaluation_id' => 7,
                'id' => 245,
                'note' => '18',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            245 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 60,
                'evaluation_id' => 7,
                'id' => 246,
                'note' => '10',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            246 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 62,
                'evaluation_id' => 7,
                'id' => 247,
                'note' => '18',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            247 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 66,
                'evaluation_id' => 7,
                'id' => 248,
                'note' => '18',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            248 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 72,
                'evaluation_id' => 7,
                'id' => 249,
                'note' => '18',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            249 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 74,
                'evaluation_id' => 7,
                'id' => 250,
                'note' => '9',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            250 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 78,
                'evaluation_id' => 7,
                'id' => 251,
                'note' => '19',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            251 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 80,
                'evaluation_id' => 7,
                'id' => 252,
                'note' => '18',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            252 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 82,
                'evaluation_id' => 7,
                'id' => 253,
                'note' => '18',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            253 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 84,
                'evaluation_id' => 7,
                'id' => 254,
                'note' => '18',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            254 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 88,
                'evaluation_id' => 7,
                'id' => 255,
                'note' => '17',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            255 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 90,
                'evaluation_id' => 7,
                'id' => 256,
                'note' => '17',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            256 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 92,
                'evaluation_id' => 7,
                'id' => 257,
                'note' => '18',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            257 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 96,
                'evaluation_id' => 7,
                'id' => 258,
                'note' => '17',
                'updated_at' => '2026-09-24 22:48:59',
            ),
            258 => 
            array (
                'created_at' => '2026-09-24 22:48:59',
                'eleve_id' => 100,
                'evaluation_id' => 7,
                'id' => 259,
                'note' => '17',
                'updated_at' => '2026-09-24 22:48:59',
            ),
        ));
        
        
    }
}