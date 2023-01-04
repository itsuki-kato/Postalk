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
        Schema::create('t_user_notify', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_user');
            $table->foreignId('favorite_post_id')->nullable()->constrained('t_user_favorite_post');
            $table->foreignId('follow_id')->nullable()->constrained('t_user_follow');
            $table->foreignId('dm_history_id')->nullable()->constrained('t_user_dm_history');
            $table->integer('system_info_id')->nullable();
            $table->integer('read_flg')->default(0)->comment('既読フラグ');
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
        Schema::dropIfExists('t_user_notify');
    }
};
