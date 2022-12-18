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
        Schema::create('t_user_favorite_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_user');
            $table->foreignId('favorite_user_id')->constrained('t_user');
            $table->foreignId('post_id')->constrained('t_user_post');
            $table->integer('favorite_type');
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
        Schema::dropIfExists('t_user_favorite_post');
    }
};
