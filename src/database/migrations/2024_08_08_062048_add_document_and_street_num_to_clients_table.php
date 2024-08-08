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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('document')->nullable()->after('email');
            $table->string('cuit')->nullable()->after('document');
            $table->string('street_num')->nullable()->after('address');
            $table->string('street_extras')->nullable()->after('street_num');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('document');
            $table->dropColumn('street_num');
            $table->dropColumn('cuit');
            $table->dropColumn('street_extras');

        });
    }
};
