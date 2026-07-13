<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorisations', function (Blueprint $table) {
            $table->id();
            $table->date('date_autorisation')->nullable();
            $table->string('nombre_route')->nullable();
            $table->string('reference')->nullable();
            $table->string('montant_total')->nullable();
            $table->string('qr_code')->nullable();
            $table->foreignIdFor(\App\Models\TypeAutorisation::class)->nullable()
                ->index()
                ->references('id')->on('type_autorisations');
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
        Schema::dropIfExists('autorisations');
    }
}
