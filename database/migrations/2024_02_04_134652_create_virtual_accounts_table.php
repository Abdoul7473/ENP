<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVirtualAccountsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('virtual_accounts')) {
            Schema::create('virtual_accounts', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(\App\Models\User::class)
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
                $table->decimal('balance', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('deposits')) {
            Schema::create('deposits', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(\App\Models\VirtualAccount::class)
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
                $table->decimal('amount', 10, 2);
                $table->string('code', 10);
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('deposits');
        Schema::dropIfExists('virtual_accounts');
    }
}