<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->bigInteger('order_user_id')->unsigned()->nullable();
            $table->bigInteger('order_status_id')->unsigned();
            $table->bigInteger('order_client_id')->unsigned();
            $table->string('payment_order_number')->nullable();
            $table->string('payment_status')->nullable();
            
            $table->string('delivery_number')->nullable();
            $table->string('delivery_traking_number')->nullable();
            $table->string('delivery_status')->nullable();
            
            $table->decimal('delivery_amount', 16, 2);
            $table->decimal('total', 16, 2);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('order_user_id')->references('id')->on('users');
            $table->foreign('order_status_id')->references('id')->on('order_statuses');
            $table->foreign('order_client_id')->references('id')->on('clients');

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
};
