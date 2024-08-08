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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idFamily')->constrained('family')->onDelete('cascade');
            $table->foreignId('idBrand')->constrained('brand')->onDelete('cascade');
            $table->string('nombre');
            $table->string('slug')->nullable();
            $table->string('modelo')->nullable();
            $table->string('descripcion')->nullable();
            $table->text('imagen');
            $table->string('sku')->nullable();
            $table->float('precio')->nullable();
            $table->text('dimensiones')->nullable();
            $table->float('peso')->nullable();
            $table->enum('stock', ['alto', 'medio', 'bajo'])->default('medio');
            $table->string('stock_type', 45)->nullable();
            $table->string('stock_fijo', 45)->nullable();
            $table->integer('stock_quantity')->nullable();
            $table->integer('stock_limit1')->nullable();
            $table->integer('stock_limit2')->nullable();
            $table->enum('visibilidad', ['publicar', 'oculto', 'borrador'])->default('borrador');
            $table->enum('state', ['1', '0'])->default('1');
            $table->boolean('show_home')->default(false);
            $table->string('show', 50)->default('0');
            $table->integer('idParent')->nullable();
            $table->longText('search')->nullable();
            $table->timestamps();
            $table->integer('alto')->nullable();
            $table->integer('ancho')->nullable();
            $table->integer('largo')->nullable();

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
        Schema::dropIfExists('product');
        Schema::enableForeignKeyConstraints();
    }
};
