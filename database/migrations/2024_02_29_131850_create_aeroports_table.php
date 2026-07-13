<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAeroportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aeroports', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('code_iata')->nullable();
            $table->string('code_icao')->nullable();
            $table->string('region')->nullable();
            $table->string('pays')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE aeroports ADD COLUMN libelle varchar(255)");

        DB::unprepared('
            CREATE TRIGGER aeroport_before_insert BEFORE INSERT ON aeroports
            FOR EACH ROW
            BEGIN
                SET NEW.libelle = CONCAT(NEW.code_icao, "/", NEW.nom);
            END;
        ');
        Schema::create('aeroport_configs',function (Blueprint $table){
            $table->id();
            $table->foreignIdFor(\App\Models\Aeroport::class)->nullable()
                ->index()
                ->references('id')->on('aeroports');
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
        Schema::dropIfExists('aeroports');
        Schema::dropIfExists('aeroport_configs');
    }
}
