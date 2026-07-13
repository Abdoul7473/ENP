<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAeronefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aeronefs', function (Blueprint $table) {
            $table->id();
            $table->string('imatriculation')->nullable();
            $table->string('type')->nullable();
            $table->string('indicatif_appel')->nullable();
            $table->string('proprietaire_aeronef')->nullable();
            $table->string('commandant_bord')->nullable();
            $table->string('nom_exploitant')->nullable();
            $table->string('email_exploitant')->nullable();
            $table->string('tel_exploitant')->nullable();
            $table->foreignIdFor(\App\Models\Demande::class)->nullable()
                ->index()
                ->references('id')->on('demandes');
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
        Schema::dropIfExists('aeronefs');
    }
}
