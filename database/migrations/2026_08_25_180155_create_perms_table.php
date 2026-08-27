<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perms', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->nullable();
            $table->integer('nombre_jour')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('heure_arrive')->nullable();
            $table->string('motif')->nullable();
            $table->string('lieu')->nullable();
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
        Schema::dropIfExists('perms');
    }
}
