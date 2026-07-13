<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->date('date_demande')->nullable();
            $table->string('ville_fait')->nullable();
            $table->string('signature_cachet')->nullable();
            $table->date('date_rejet')->nullable();
            $table->date('date_prevu_vol')->nullable();
            $table->date('date_approbation')->nullable();
            $table->date('date_verif')->nullable();
            $table->date('date_autorisation')->nullable();
            $table->string('motif_rejet')->nullable();
            $table->string('motif_annuler')->nullable();
            $table->string('numero_ordre')->nullable();
            $table->string('preciser')->nullable();
            $table->integer('revise')->default(0);
            $table->boolean('permanant')->nullable();
            $table->integer('nbre_mois')->nullable();
            $table->integer('urgence')->nullable();
            $table->integer('payer_revise')->nullable();
            $table->foreignIdFor(\App\Models\TypeDemande::class)->nullable()
                ->index()
                ->references('id')->on('type_demandes');
            $table->foreignIdFor(\App\Models\Signature::class)->nullable()
                ->index()
                ->references('id')->on('signatures');
            $table->foreignIdFor(\App\Models\TypeVol::class)->nullable()
                ->index()
                ->references('id')->on('type_vols');
            $table->foreignIdFor(\App\Models\Statut::class)->nullable()
                ->index()
                ->references('id')->on('statuts');
            $table->foreignIdFor(\App\Models\User::class)->nullable()
                ->index()
                ->references('id')->on('users');
            $table->foreignIdFor(\App\Models\User::class,'user_appro')->nullable()
                ->index()
                ->references('id')->on('users');
            $table->foreignIdFor(\App\Models\User::class,'user_verif')->nullable()
                ->index()
                ->references('id')->on('users');
            $table->foreignIdFor(\App\Models\User::class,'user_autoriser')->nullable()
                ->index()
                ->references('id')->on('users');
            $table->foreignIdFor(\App\Models\User::class,'user_delete')->nullable()
                ->index()
                ->references('id')->on('users');
            $table->integer('payer')->nullable();
            $table->timestamps();
        });
        Schema::create('demande_fichier_requis',function (Blueprint $table){
            $table->id();
            $table->date('date_expire')->nullable();
            $table->string('fichier')->nullable();
            $table->boolean('check')->default(0);
            $table->foreignIdFor(\App\Models\Demande::class)->nullable()
                ->index()
                ->references('id')->on('demandes');
            $table->foreignIdFor(\App\Models\FichierRequi::class)->nullable()
                ->index()
                ->references('id')->on('fichier_requis');

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
        Schema::dropIfExists('demandes');
    }
}
