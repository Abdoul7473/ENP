<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedevancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redevances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\NumAutorisation::class)->nullable()
                ->index()
                ->references('id')->on('num_autorisations');
            $table->foreignIdFor(\App\Models\Demande::class)->nullable()
                ->index()
                ->references('id')->on('demandes');
            $table->foreignIdFor(\App\Models\User::class)->nullable()
                ->index()
                ->references('id')->on('users');
            $table->string('type_vol')->nullable();
            $table->integer('autorisation_excep');
            $table->string('nbre_passagers_arr')->nullable();
            $table->string('nbre_passagers_dep')->nullable();
            $table->string('marchand_valeur_arr')->nullable();
            $table->string('marchand_valeur_dep')->nullable();
            $table->string('autre_que_marchand_valeur_arr')->nullable();
            $table->string('autre_que_marchand_valeur_dep')->nullable();
            $table->string('rib')->nullable();
            $table->string('mode_payement')->nullable();
            $table->string('montant')->nullable();
            $table->string('aerodrome')->nullable();
            $table->string('poids_aeronef')->nullable();
            $table->integer('payer')->default(0);
            $table->string('session_id')->nullable();
            $table->timestamps();
        });

        Schema::create('r_factures', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('montant')->nullable();
            $table->string('rib')->nullable();
            $table->string('mode_payement')->nullable();
            $table->integer('payer')->default(0);
            $table->timestamps();
        });

        Schema::create('facture_redevances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Redevance::class)->nullable()
                ->index()
                ->references('id')->on('redevances');
            $table->foreignIdFor(\App\Models\RFacture::class)->nullable()
                ->index()
                ->references('id')->on('r_factures');
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
        Schema::dropIfExists('redevances');
    }
}
