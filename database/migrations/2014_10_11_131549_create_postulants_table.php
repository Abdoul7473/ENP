<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostulantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulants', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('nom_raison_sociale')->nullable();
            $table->string('tel')->nullable();
            $table->string('tel2')->nullable();
            $table->string('adresse')->nullable();
            $table->string('fonction')->nullable();
            $table->string('fichier')->nullable();
            $table->string('numero_ordre')->nullable();
            $table->string('signature_cachet')->nullable();
            $table->foreignIdFor(\App\Models\TypePostulant::class)->nullable()
                ->index()
                ->references('id')->on('type_postulants');
            $table->foreignIdFor(\App\Models\Ville::class)->nullable()
                ->index()
                ->references('id')->on('villes');
            $table->timestamps();
        });
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('password')->nullable();
            $table->string('mailer')->nullable();
            $table->string('port')->nullable();
            $table->string('encryption')->nullable();
            $table->string('host')->nullable();
            $table->string('mail_from')->nullable();
            $table->string('name_from')->nullable();
            $table->boolean('statut')->default(0);
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
        Schema::dropIfExists('postulants');
        Schema::dropIfExists('emails');
    }
}
