<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TypeVolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('type_vols')->delete();

        \DB::table('type_vols')->insert(array(
            0 =>
            array(
                'libelle' => 'Vol passagers',
            ),
            1 =>
            array(
                'libelle' => 'Vol fret' ,
            ),
            2 =>
            array(
                'libelle' => 'Evacuation sanitaire' ,
            ),
            3 =>
            array(
                'libelle' => 'Diplomatique',
            ),
            4 =>
            array(
                'libelle' => 'Autre',
            ),
        ));
    }
}
