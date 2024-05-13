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
        Schema::create('label_product', function (Blueprint $table) {
            $table->unsignedBigInteger('label_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('label_id')
                ->references('id')
                ->on('labels')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('NO ACTION')
                ->onUpdate('NO ACTION');

            $table->primary(['label_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('label_product');
    }
};
