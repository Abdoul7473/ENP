<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->time('heure_arrive')->nullable();
            $table->time('heure_depart')->nullable();
            $table->date('date_route')->nullable();
            $table->string('remarque')->nullable();
            $table->string('num_autorisation')->nullable();
            $table->boolean('check')->nullable();
            $table->foreignIdFor(\App\Models\Aeroport::class,'ville_depart')->nullable()
                ->index()
                ->references('id')->on('aeroports');
            $table->foreignIdFor(\App\Models\Aeroport::class,'ville_arrive')->nullable()
                ->index()
                ->references('id')->on('aeroports');
            $table->foreignIdFor(\App\Models\Demande::class)->nullable()
                ->index()
                ->references('id')->on('demandes');
            $table->foreignIdFor(\App\Models\Autorisation::class)->nullable()
                ->index()
                ->references('id')->on('autorisations');
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
        Schema::dropIfExists('routes');
    }
}
