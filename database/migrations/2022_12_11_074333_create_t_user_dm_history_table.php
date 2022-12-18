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
        Schema::create('t_user_dm_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_user');
            $table->foreignId('target_user_id')->constrained('t_user');
            $table->string('dm_text');
            $table->string('dm_img_url');
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
        Schema::dropIfExists('t_user_dm_history');
    }
};
