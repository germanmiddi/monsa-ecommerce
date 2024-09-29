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
        Schema::table('product', function (Blueprint $table) {
            $table->boolean('promo_active')->default(false);
            $table->float('promo_price')->nullable()->after('price_public');
            $table->date('promo_start_date')->nullable()->after('promo_price');
            $table->date('promo_end_date')->nullable()->after('promo_start_date');

            $table->integer('stock_disponible')->default(0)->nullable();
            $table->integer('stock_reservado')->default(0)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('promo_price');
        });
    }
};
