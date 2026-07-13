<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisiteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visiteurs', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->nullable();
            $table->string("mat_vehicule")->nullable();
            $table->string("prenom")->nullable();
            $table->string("email")->nullable();
            $table->string("sexe")->nullable();
            $table->integer("tel")->nullable();
            $table->date("date_naiss")->nullable();
            $table->string("heure_arrive")->nullable();
            $table->string("heure_depart")->nullable();
            $table->string("localite")->nullable();
            $table->string("motif")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visiteurs');
    }
}
