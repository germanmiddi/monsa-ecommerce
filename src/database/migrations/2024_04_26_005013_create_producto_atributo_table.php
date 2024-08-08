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
        Schema::create('product_atribute', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_atribute');
            $table->string('valores')->nullable();
            $table->boolean('is_variacion')->nullable();
            
            // Definir las claves foráneas
            $table->foreign('id_product')->references('id')->on('product')->onDelete('cascade');
            $table->foreign('id_atribute')->references('id')->on('atribute')->onDelete('cascade');
         
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('product_atribute');
        Schema::enableForeignKeyConstraints();
    }
};
