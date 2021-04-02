<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('to_email_address', 50);
            $table->string('subject', 150);
            $table->text('message');
            $table->text('aws_message_id');
            $table->text('hash');
            $table->boolean('click')->default(false);
            $table->boolean('opened')->default(false);
            $table->boolean('delivered')->default(false);
            $table->boolean('complaint')->default(false);
            $table->boolean('bounced')->default(false);
            $table->bigInteger('campaing_id')->unsigned()->index();          
            $table->foreign('campaing_id')->references('id')->on('campaigns');
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
        Schema::dropIfExists('send_emails');
    }
}
