<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('statuts')->delete();

        \DB::table('statuts')->insert(array(
            0 =>
            array(
                'libelle' => 'EN ATTENTE',
            ),
            1 =>
            array(
                'libelle' => 'VERIFIEE' ,
            ),
            2 =>
            array(
                'libelle' => 'APPROUVEE' ,
            ),
            3 =>
            array(
                'libelle' => 'AUTORISEE' ,
            ),
            4 =>
            array(
                'libelle' => 'REJETEE' ,
            ),
            5 =>
            array(
                'libelle' => 'RENVOYEE' ,
            ),
            6 =>
            array(
                'libelle' => 'ANNULEE' ,
            ),
            7 =>
            array(
                'libelle' => 'REVISEE' ,
            ),
        ));
    }
}
