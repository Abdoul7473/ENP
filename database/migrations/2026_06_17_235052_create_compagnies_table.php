<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompagniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corps', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });

        Schema::create('annees', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->string('code')->nullable();
            $table->integer('statut')->nullable();
            $table->string('date_debut')->nullable();
            $table->string('date_fin')->nullable();
            $table->timestamps();
        });

        Schema::create('compagnies', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('sigle');
            $table->string('effectif');
            $table->string('passant');
            $table->foreignIdFor(\App\Models\Corp::class)->nullable()
                ->index()
                ->references('id')->on('corps');
            $table->foreignIdFor(\App\Models\Annee::class)->nullable()
                ->index()
                ->references('id')->on('annees');
            $table->timestamps();
        });

        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->nullable();
            $table->string('ordre')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('date_naiss')->nullable();
            $table->string("email")->nullable();
            $table->string("sexe")->nullable();
            $table->integer("tel")->nullable();
            $table->string('lieu_naiss')->nullable();
            $table->string('groupe_sanguin')->nullable();
            $table->string('photo')->nullable();
            $table->foreignIdFor(\App\Models\Compagnie::class)->nullable()
                ->index()
                ->references('id')->on('compagnies');
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
        Schema::dropIfExists('compagnies');
        Schema::dropIfExists('eleves');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('encadreurs');
        Schema::dropIfExists('affectations');
        Schema::dropIfExists('mois');
        Schema::dropIfExists('encadreur_mois');
    }
}
