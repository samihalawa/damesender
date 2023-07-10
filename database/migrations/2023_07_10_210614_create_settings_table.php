<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("mail_host")
                ->default("smtp.mailtrap.io");
            $table->string("mail_port")
                ->default("2525");
            $table->string("mail_username")
                ->default("null");
            $table->string("mail_password")
                ->default("null");
            $table->string("mail_encryption")
                ->default("null");
            $table->string("aws_access_key_id")
                ->default("null");
            $table->string("aws_secret_access_key")
                ->default("null");
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('settings');
    }
}
