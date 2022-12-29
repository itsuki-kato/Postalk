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
        Schema::table('t_user_follow', function (Blueprint $table) {
            $table->integer('follow_status')
                ->comment('0:フォロー申請中、1:フォロー中')
                ->after('follow_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_user_follow', function (Blueprint $table) {
            //
        });
    }
};
