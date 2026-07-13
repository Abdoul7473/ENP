<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('grades')->delete();
        \DB::table('corps')->delete();
        \DB::table('corps')->insert(array(
            0 =>
            array(
                'nom' => 'Gardien de paix',
            ),
            1 =>
            array(
                'nom' => 'Inspecteur' ,
            ),
            2 =>
            array(
                'nom' => 'Officier' ,
            ),
            3 =>
            array(
                'nom' => 'Commissaire' ,
            ),
        ));
        \DB::table('grades')->insert(array(
            0 =>
            array(
                'libelle' => 'Gardien de paix stagiaire',
            ),
            1 =>
            array(
                'libelle' => 'Gardien de paix' ,
            ),
            2 =>
            array(
                'libelle' => 'Brigadier de paix' ,
            ),
            3 =>
            array(
                'libelle' => 'Brigadier de paix chef' ,
            ),
            4 =>
            array(
                'libelle' => 'Adjudant' ,
            ),
            5 =>
            array(
                'libelle' => 'Adjudant chef' ,
            ),
            6 =>
            array(
                'libelle' => 'Inspecteur stagiaire' ,
            ),
            7 =>
            array(
                'libelle' => 'Inspecteur deuxième classe' ,
            ),
            8 =>
            array(
                'libelle' => 'Inspecteur prémiere classe' ,
            )
        ));
        \DB::table('mois')->delete();

        \DB::table('mois')->insert(array(
            0 =>
            array(
                'indice' => 1,
                'libelle' => 'Janvier',
            ),
            1 =>
            array(
                'indice' => 2,
                'libelle' => 'Février',
            ),
            2 =>
            array(
                'indice' => 3,
                'libelle' => 'Mars',
            ),
            3 =>
            array(
                'indice' => 4,
                'libelle' => 'Avril',
            ),
            4 =>
            array(
                'indice' => 5,
                'libelle' => 'Mai',
            ),
            5 =>
            array(
                'indice' => 6,
                'libelle' => 'Juin',
            ),
            6 =>
            array(
                'indice' => 7,
                'libelle' => 'Juillet',
            ),
            7 =>
            array(
                'indice' => 8,
                'libelle' => 'Août',
            ),
            8 =>
            array(
                'indice' => 9,
                'libelle' => 'Septembre',
            ),
            9 =>
            array(
                'indice' => 10,
                'libelle' => 'Octobre',
            ),
            10 =>
            array(
                'indice' => 11,
                'libelle' => 'Novembre',
            ),
            11 =>
            array(
                'indice' => 12,
                'libelle' => 'Décembre',
            ),
        ));
    }
}
