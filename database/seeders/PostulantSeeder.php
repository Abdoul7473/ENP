<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostulantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('postulants')->delete();

        \DB::table('postulants')->insert(array(
            0 =>
            array(
                "nom_raison_sociale" => "SynetCom",
                "tel" => '["8002145", "82545578", "74569002"]',
                "adresse" => "Cité Caisse",
                "fonction" => "Informaticien",
                'ville_id' => 1,
                "type_postulant_id" => 1
            ),
            1 =>
            array(
                "nom_raison_sociale" => "UAM",
                "tel" => '["90987456", "98745624", "98742231"]',
                "adresse" => "Pays Bas",
                "fonction" => "Demarcheur",
                'ville_id' => 2,
                "type_postulant_id" => 1
            ),
            2 =>
            array(
                "nom_raison_sociale" => "Adamou Issa",
                "tel" => '["98744742", "887499000", "90099002"]',
                "adresse" => "Yarobanda",
                "fonction" => "Dev",
                'ville_id' => 3,
                "type_postulant_id" => 2
            ),
        ));
    }
}
