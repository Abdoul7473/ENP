<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            $table->string('num_facture')->nullable();
            $table->string('num_facture_format')->nullable();
            $table->string('prix_total')->nullable();
            $table->foreignIdFor(\App\Models\VirtualAccount::class)->nullable()
                ->index()
                ->references('id')->on('virtual_accounts');
            $table->foreignIdFor(\App\Models\Demande::class)->nullable()
                ->index()
                ->references('id')->on('demandes');
            $table->foreignIdFor(\App\Models\Postulant::class)->nullable()
                ->index()
                ->references('id')->on('postulants');
            $table->string('session_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('montant')->nullable();
            $table->string('rib')->nullable();
            $table->string('mode_payement')->nullable();
            $table->integer('payer')->default(0);
            $table->timestamps();
        });

        Schema::create('facture_orders', function (Blueprint $table) {
            $table->id(); 
            $table->foreignIdFor(\App\Models\Order::class)->nullable()
                ->index()
                ->references('id')->on('orders');
            $table->foreignIdFor(\App\Models\Facture::class)->nullable()
                ->index()
                ->references('id')->on('factures');
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
        Schema::dropIfExists('orders');
    }
}
