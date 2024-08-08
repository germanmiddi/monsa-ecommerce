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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('shipment_id');
            $table->string('external_id');
            $table->string('delivery_id');
            $table->string('status');
            $table->string('status_name');
            $table->string('tracking_url');
            $table->string('carrier_name');
            $table->string('carrier_logo');
            $table->string('logistic_type');
            $table->text('destination');
            $table->text('packages');
            $table->string('service_type');
            $table->decimal('declared_value', 16, 2);
            $table->decimal('total', 16, 2);
            $table->decimal('price_incl_tax', 16, 2);
            $table->float('total_weight');
            $table->float('total_volume');
            $table->timestamp('estimated_delivery')->nullable();
            $table->string('shipment_created_at');
            $table->json('full_details');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
};
