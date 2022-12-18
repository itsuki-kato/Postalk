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
        Schema::create('t_user_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_user');
            $table->foreignId('category_id')->constrained('m_category');
            $table->string('post_title', 30);
            $table->text('post_text');
            $table->string('post_img_url');
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
        Schema::dropIfExists('t_user_post');
    }
};
