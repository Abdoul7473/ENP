<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapports', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->integer('statut')->nullable();
            $table->foreignIdFor(\App\Models\Encadreur::class)->nullable()
                ->index()
                ->references('id')->on('encadreurs');
            $table->timestamps();
        });
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('nombre')->nullable();
            $table->timestamps();
        });
        Schema::create('numeros', function (Blueprint $table) {
            $table->id();
            $table->integer('numero')->nullable();
            $table->boolean('statut')->nullable();
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
        Schema::dropIfExists('rapports');
    }
}
