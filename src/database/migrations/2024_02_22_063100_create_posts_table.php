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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('image')->nullable();
            $table->boolean('featured')->default(false);
            $table->date('date_published');
            $table->string('author');
            $table->bigInteger('post_status_id')->unsigned();
            $table->bigInteger('post_category_id')->unsigned();
            $table->bigInteger('post_user_id')->unsigned();

            $table->foreign('post_status_id')->references('id')->on('post_statuses');
            $table->foreign('post_category_id')->references('id')->on('post_categories');
            $table->foreign('post_user_id')->references('id')->on('users');
            
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
        Schema::dropIfExists('posts');
    }
};
