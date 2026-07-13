<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TypePostulantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('type_postulants')->delete();

        \DB::table('type_postulants')->insert(array(
            0 =>
            array(
                'libelle' => 'Operateurs',
            ),
            1 =>
            array(
                'libelle' => 'Operateurs Privés' ,
            ),
        ));
    }
}
