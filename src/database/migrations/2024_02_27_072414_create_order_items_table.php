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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('orderitems_order_id')->unsigned();
            $table->bigInteger('orderitems_product_id')->unsigned();
            $table->integer('quantity');
            $table->decimal('price', 16, 2);
            $table->decimal('total', 16, 2);

            $table->foreign('orderitems_order_id')->references('id')->on('orders');
            $table->foreign('orderitems_product_id')->references('id')->on('product');
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
        Schema::dropIfExists('order_items');
    }
};
