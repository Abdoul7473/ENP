<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TypeAutorisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('type_autorisations')->delete();

        \DB::table('type_autorisations')->insert(array(
            0 =>
            array(
                'libelle' => 'Survol et Atterissage',
                'code' => 'LND'
            ),
            1 =>
            array(
                'libelle' => 'Survol' ,
                'code' => 'OVF'
            ),
            3 =>
            array(
                'libelle' => 'Permanant' ,
                'code' => 'BOF'
            ),
            4 =>
            array(
                'libelle' => 'Diplômatique' ,
                'code' => 'DPL'
            ),
        ));
    }
}
