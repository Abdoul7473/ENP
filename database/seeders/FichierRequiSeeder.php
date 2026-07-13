<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FichierRequiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('fichier_requis')->delete();

        \DB::table('fichier_requis')->insert(array(
            0 =>
            array(
                'libelle' => 'Certificat d\'immatriculation',
            ),
            1 =>
            array(
                'libelle' => 'Permit d\'exploitation aérienne' ,
            ),
            3 =>
            array(
                'libelle' => 'Spécification Opérationnelle' ,
            ),
            4 =>
            array(
                'libelle' => 'Licence de la station radio' ,
            ),
            5 =>
            array(
                'libelle' => 'Certificat de Navigabilité'
            ),
            6 =>
            array(
                'libelle' => 'Assurance' ,
            ),
            7 =>
            array(
                'libelle' => 'Licence des pilotes' ,
            ),
            8 =>
            array(
                'libelle' => 'Certificat médical des pilotes' ,
            ),
            9 =>
            array(
                'libelle' => 'Autre' ,
            ),
        ));
    }
}
