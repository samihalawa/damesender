<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('name');
            // file id
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')
                ->references('id')
                ->onDelete('cascade')
                ->on('files');
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
        Schema::dropIfExists('file_contacts');
    }
}
