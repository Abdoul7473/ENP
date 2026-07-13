<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenvoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renvois', function (Blueprint $table) {
            $table->id();
            $table->date('date_renvoi')->nullable();
            $table->string('motif_renvoi')->nullable();
            $table->string('statut')->nullable();
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
        Schema::dropIfExists('renvois');
    }
}
