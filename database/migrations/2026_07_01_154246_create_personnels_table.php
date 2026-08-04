<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonnelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->string('galon')->nullable();
            $table->timestamps();
        });
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->timestamps();
        });
        Schema::create('entites', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->foreignIdFor(\App\Models\Entite::class)->nullable()
                ->index()
                ->references('id')->on('entites');
            $table->timestamps();
        });
        Schema::create('encadreurs', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string("sexe")->nullable();
            $table->integer("tel")->nullable();
            $table->string('date_naiss')->nullable();
            $table->string('lieu_naiss')->nullable();
            $table->boolean('is_commandant')->nullable();
            $table->boolean('statut')->nullable();
            $table->string('groupe_sanguin')->nullable();
            $table->date('date_affectation')->nullable();
            $table->integer('type')->nullable();
            $table->string('num_decision')->nullable();
            $table->string('decision')->nullable();
            $table->string('document')->nullable();
            $table->foreignIdFor(\App\Models\Grade::class)->nullable()
                ->index()
                ->references('id')->on('grades');
            $table->foreignIdFor(\App\Models\Profil::class)->nullable()
                ->index()
                ->references('id')->on('profils');
            $table->foreignIdFor(\App\Models\Entite::class)->nullable()
                ->index()
                ->references('id')->on('entites');
            $table->timestamps();
        });
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->boolean('statut')->nullable();
            $table->foreignIdFor(\App\Models\Encadreur::class)->nullable()
                ->index()
                ->references('id')->on('encadreurs');
            $table->foreignIdFor(\App\Models\Compagnie::class)->nullable()
                ->index()
                ->references('id')->on('compagnies');
            $table->timestamps();
        });

        Schema::create('mois', function (Blueprint $table) {
            $table->id();
            $table->integer('indice')->nullable();
            $table->string('libelle')->nullable();
            $table->timestamps();
        });
        Schema::create('encadreur_mois', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Encadreur::class)->nullable()
                ->index()
                ->references('id')->on('encadreurs');
            $table->foreignIdFor(\App\Models\Mois::class)->nullable()
                ->index()
                ->references('id')->on('mois');
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
        Schema::dropIfExists('personnels_tables');
    }
}
