<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumAutorisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('num_autorisations', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->nullable();
            $table->string('code')->nullable();
            $table->string('ref_article')->nullable();
            $table->foreignIdFor(\App\Models\Autorisation::class)->nullable()
                ->index()
                ->references('id')->on('autorisations');
            $table->foreignIdFor(\App\Models\Route::class)->nullable()
                ->index()
                ->references('id')->on('routes');
            $table->integer('statut')->nullable();
            $table->boolean('statut_redevance')->default(0);
            $table->integer('revise')->nullable();
            $table->timestamps();
        });

    Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('nombre');
            $table->timestamps();
        });
    
    Schema::create('numeros', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->nullable();
            $table->boolean('statut')->default(0);
            $table->foreignIdFor(\App\Models\Lot::class)->nullable()
                ->index()
                ->references('id')->on('lots');
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
        Schema::dropIfExists('num_autorisations');
    }
}
