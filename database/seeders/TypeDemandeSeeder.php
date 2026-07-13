<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TypeDemandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('type_demandes')->delete();

        \DB::table('type_demandes')->insert(array(
            0 =>
            array(
                'libelle' => 'Survol',
            ),
            1 =>
            array(
                'libelle' => 'Survol/Atterrissage' ,
            ),
        ));
    }
}
