<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VisiteursTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('visiteurs')->delete();
        
        \DB::table('visiteurs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nom' => 'Aziz',
                'num_carte' => 'AZERRTYYTYTF65567',
                'mat_vehicule' => 'AF 5027',
                'prenom' => 'Marou',
                'email' => 'maroukimbaabdoulaziz123@gmail.com',
                'statut' => 1,
                'sexe' => '1',
                'date' => '2026-06-11',
                'tel' => 9807654,
                'date_naiss' => '1984-05-09',
                'heure_arrive' => '17:27',
                'heure_depart' => '17:28',
                'localite' => NULL,
                'motif' => 'RAS',
                'created_at' => '2026-08-11 18:27:08',
                'updated_at' => '2026-08-11 18:28:12',
            ),
            1 => 
            array (
                'id' => 2,
                'nom' => 'Almoustapha',
                'num_carte' => 'AZERGUYUVB',
                'mat_vehicule' => 'AR 9876',
                'prenom' => 'Sani',
                'email' => NULL,
                'statut' => 1,
                'sexe' => '1',
                'date' => '2026-07-11',
                'tel' => 90874545,
                'date_naiss' => '2008-08-13',
                'heure_arrive' => '17:25',
                'heure_depart' => '17:28',
                'localite' => 'Surveillance',
                'motif' => 'RAS',
                'created_at' => '2026-08-11 18:28:06',
                'updated_at' => '2026-08-11 18:28:21',
            ),
            2 => 
            array (
                'id' => 3,
                'nom' => 'Tassiou',
                'num_carte' => 'AZERTYUIO',
                'mat_vehicule' => 'AD 5432',
                'prenom' => 'Issa',
                'email' => NULL,
                'statut' => 0,
                'sexe' => '1',
                'date' => '2026-08-11',
                'tel' => 98988567,
                'date_naiss' => '1980-05-07',
                'heure_arrive' => '17:30',
                'heure_depart' => NULL,
                'localite' => 'Salle de Gym',
                'motif' => 'RAS',
                'created_at' => '2026-08-11 18:38:16',
                'updated_at' => '2026-08-11 18:38:16',
            ),
            3 => 
            array (
                'id' => 4,
                'nom' => 'Idi',
                'num_carte' => 'GHJKLTHFTYGUYUY65678',
                'mat_vehicule' => 'AF 5027',
                'prenom' => 'Boube',
                'email' => NULL,
                'statut' => 0,
                'sexe' => '1',
                'date' => '2026-07-11',
                'tel' => 98765448,
                'date_naiss' => '1993-05-05',
                'heure_arrive' => '17:30',
                'heure_depart' => NULL,
                'localite' => 'Infirmerie',
                'motif' => 'RAS',
                'created_at' => '2026-08-11 18:39:09',
                'updated_at' => '2026-08-11 18:39:09',
            ),
        ));
        
        
    }
}