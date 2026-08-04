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
                'libelle' => 'Gardien de la paix stagiaire',
                'galon' => 'gpxsta.png'
            ),
            1 =>
            array(
                'libelle' => 'Gardien de la paix' ,
                'galon' => 'gpx.png'
            ),
            2 =>
            array(
                'libelle' => 'Brigadier de la paix' ,
                'galon' => 'bpx.png'
            ),
            3 =>
            array(
                'libelle' => 'Brigadier chef  de paix' ,
                'galon' => 'bcpx.png'
            ),
            4 =>
            array(
                'libelle' => 'Adjudant de paix' ,
                'galon' => 'apx.png'
            ),
            5 =>
            array(
                'libelle' => 'Adjudant chef de paix' ,
                'galon' => 'acpx.png'
            ),
            6 =>
            array(
                'libelle' => 'Inspecteur de police stagiaire' ,
                'galon' => 'ipsta.png'
            ),
            7 =>
            array(
                'libelle' => 'Inspecteur de police de deuxième classe' ,
                'galon' => 'ip2c.png'
            ),
            8 =>
            array(
                'libelle' => 'Inspecteur de police de prémiere classe' ,
                'galon' => 'ip1c.png'
            ),

            9 =>
            array(
                'libelle' => 'Inspecteur de police principale' ,
                'galon' => 'ipp.png'
            ),
            10 =>
            array(
                'libelle' => 'Inspecteur divisionnaire de police' ,
                'galon' => 'idp.png'
            ),
            11 =>
            array(
                'libelle' => 'Inspecteur divisionnaire de police de classe exceptionnelle' ,
                'galon' => 'idpce.png'
            ),
            12 =>
            array(
                'libelle' => 'Officier de police stagiaire' ,
                'galon' => 'opsta.png'
            ),
            13 =>
            array(
                'libelle' => 'Officier de police de deuxième classe' ,
                'galon' => 'op2c.png'
            ),
            14 =>
            array(
                'libelle' => 'Officier de police de prémiere classe' ,
                'galon' => 'op1c.png'
            ),
            15 =>
            array(
                'libelle' => 'Officier de police principale' ,
                'galon' => 'opp.png'
            ),
            16 =>
            array(
                'libelle' => 'Officier divisionnaire de police' ,
                'galon' => 'odp.png'
            ),
            17 =>
            array(
                'libelle' => 'Officier divisionnaire de police de classe exceptionnlle' ,
                'galon' => 'odpce.png'
            ),
            18 =>
            array(
                'libelle' => 'Commissaire de police stagiaire' ,
                'galon' => 'cpsta.png'
            ),
            19 =>
            array(
                'libelle' => 'Commissaire de police de deuxième classe' ,
                'galon' => 'cp2c.png'
            ),
            20 =>
            array(
                'libelle' => 'Commissaire de police principale' ,
                'galon' => 'cpp.png'
            ),
            21 =>
            array(
                'libelle' => 'Commissaire divisionnaire de police' ,
                'galon' => 'cdp.png'
            ),
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

        \DB::table('profils')->insert(array(
            0 =>
            array(
                'libelle' => 'DIRECTEUR DE L\'ECOLE NATIONALE DE POLICE ET DE FORMATION PERMANANTE',
            ),
            1 =>
            array(
                'libelle' => 'SECRETAIRE',
            ),
            2 =>
            array(
                'libelle' => 'CHEF DEPARTEMENT DE L\'ADMINISTRATION ET DES MOYENS',
            ),
            3 =>
            array(
                'libelle' => 'CHEF DEPARTEMENT DU SERVICE INTERIEUR',
            ),
            4 =>
            array(
                'libelle' => 'Chef service informatique',
            ),
            5 =>
            array(
                'libelle' => 'Chef département formation',
            )
        ));
    }
}
