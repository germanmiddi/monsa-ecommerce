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
        Schema::create('atribute', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idFamily')->constrained('family')->onDelete('cascade');
            $table->string('nombre')->nullable();
            $table->string('slug')->nullable();
            $table->string('valor')->nullable();

            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('atribute');
        Schema::enableForeignKeyConstraints();
        
    }
};
