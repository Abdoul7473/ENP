<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSituationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('situations', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_present')->nullable();
            $table->string('nombre_absent')->nullable();
            $table->string('nombre_malade')->nullable();
            $table->boolean('statut')->nullable();
            $table->string('nombre_permissionnaire')->nullable();
            $table->foreignIdFor(\App\Models\Compagnie::class)->nullable()
                ->index()
                ->references('id')->on('compagnies');
            $table->foreignIdFor(\App\Models\Rapport::class)->nullable()
                ->index()
                ->references('id')->on('rapports');
            $table->timestamps();
        });

        Schema::create('absents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Situation::class)->nullable()
                ->index()
                ->references('id')->on('situations');
            $table->foreignIdFor(\App\Models\Eleve::class)->nullable()
                ->index()
                ->references('id')->on('eleves');
            $table->timestamps();
        });

        Schema::create('malades', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Situation::class)->nullable()
                ->index()
                ->references('id')->on('situations');
            $table->foreignIdFor(\App\Models\Eleve::class)->nullable()
                ->index()
                ->references('id')->on('eleves');
            $table->timestamps();
        });

        Schema::create('permissionnaires', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Situation::class)->nullable()
                ->index()
                ->references('id')->on('situations');
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
        Schema::dropIfExists('situations');
    }
}
