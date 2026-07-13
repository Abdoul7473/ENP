<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('statut')->default(0);
            $table->integer('terme')->default(0);
            $table->boolean('first_login')->default(0);
            $table->foreignIdFor(\App\Models\TypeUser::class)->nullable()
                ->index()
                ->references('id')->on('type_users');
            $table->foreignIdFor(\App\Models\Postulant::class)->nullable()
                ->index()
                ->references('id')->on('postulants');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->foreignIdFor(\App\Models\User::class)->nullable()
                ->index()
                ->references('id')->on('users');
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
