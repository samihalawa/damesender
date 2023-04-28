<?php

/**
 * Crea tabla campaing_customers
 *
 * Para almacenar los contactos de una campaña
 *
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaingCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaing_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');

            $table->foreign('campaign_id')
                ->references('id')
                ->onDelete('cascade')
                ->on('campaigns');


            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')
                ->references('id')
                ->onDelete('cascade')
                ->on('customers');
            $table->text('aws_message_id');
            $table->text('hash');
            $table->boolean('complaint')->default(false);
            $table->boolean('bounced')->default(false);
            $table->boolean('unsuscribe')->default(false);
            $table->boolean('opened')->default(false);
            $table->boolean('clicked')->default(false);
            $table->boolean('delivered')->default(false);
            $table->boolean('sent')->default(false);
            $table->boolean('unsubscribed')->default(false);
            $table->boolean('aws')->default(false);
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
        Schema::dropIfExists('campaing_customers');
    }
}
