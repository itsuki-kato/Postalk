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
        Schema::create('t_user_dm_apply', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_user');
            $table->foreignId('apply_user_id')->constrained('t_user');
            $table->integer('apply_status');
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
        Schema::dropIfExists('t_user_dm_apply');
    }
};
