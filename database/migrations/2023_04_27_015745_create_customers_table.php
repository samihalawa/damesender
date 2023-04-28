<?php

/**
 * Crea tabla customers
 *
 * Para almacenar los contactos
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string("email")->unique();
            $table->string("first_name")->nullable();
            $table->boolean('complaint')->default(false);
            $table->boolean('bounced')->default(false);
            $table->boolean('unsuscribe')->default(false);
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
        Schema::dropIfExists('customers');
    }
}
