<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatieresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->timestamps();
        });

        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->string('horaire')->nullable();
            $table->string('coefficient')->nullable();
            $table->foreignIdFor(\App\Models\Matiere::class)->nullable()
                ->index()
                ->references('id')->on('matieres');
            $table->foreignIdFor(\App\Models\Corp::class)->nullable()
                ->index()
                ->references('id')->on('corps');
            $table->timestamps();
        });

        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->date('date_naiss')->nullable();
            $table->string('lieu_naiss')->nullable();
            $table->string('telephone')->nullable();
            $table->string('sexe')->nullable();
            $table->timestamps();
        });

        Schema::create('enseignant_groupe_modulos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Enseignant::class)->nullable()
                ->index()
                ->references('id')->on('enseignants');
            $table->foreignIdFor(\App\Models\Groupe::class)->nullable()
                ->index()
                ->references('id')->on('groupes');
            $table->foreignIdFor(\App\Models\Modulo::class)->nullable()
                ->index()
                ->references('id')->on('modulos');
            $table->timestamps();
        });
        Schema::create('avancements', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('nombre_heure')->nullable();
            $table->string('objectif_general')->nullable();
            $table->string('objectif_specific')->nullable();
            $table->string('heure_arrive')->nullable();
            $table->string('heure_depart')->nullable();
            $table->string('progression')->nullable();
            $table->foreignIdFor(\App\Models\EnseignantGroupeModulo::class)->nullable()
                ->index()
                ->references('id')->on('enseignant_groupe_modulos');
            $table->timestamps();
        });

        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->date('date_evaluation')->nullable();
            $table->string('type')->nullable();
            $table->json('assistants')->nullable();
            $table->foreignIdFor(\App\Models\EnseignantGroupeModulo::class)->nullable()
                ->index()
                ->references('id')->on('enseignant_groupe_modulos');
            $table->timestamps();
        });
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('note')->nullable();
            $table->foreignIdFor(\App\Models\Evaluation::class)->nullable()
                ->index()
                ->references('id')->on('evaluations');
            $table->foreignIdFor(\App\Models\Eleve::class)->nullable()
                ->index()
                ->references('id')->on('eleves');
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
        Schema::dropIfExists('matieres');
    }
}
