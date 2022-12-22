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
        Schema::create('t_user', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('user_id')->unique();
            $table->string('user_name');
            $table->string('password');
            $table->rememberToken();
            $table->integer('sex')->nullable();
            $table->date('birth')->nullable();
            $table->string('pf_img_url')->nullable();
            $table->string('bg_img_url')->nullable();
            $table->string('intro')->nullable();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
