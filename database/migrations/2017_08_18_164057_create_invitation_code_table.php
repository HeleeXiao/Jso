<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('invitation_code') ) {
            Schema::create('invitation_code', function (Blueprint $table) {
                $table->increments('id')->unsigned()->comment("邀请码表");
                $table->integer('code')->comment("邀请码");
                $table->integer('user_id')->comment("用户id");
                $table->tinyInteger('status')->comment("状态 0 正常 1:标记已经使用");
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitation_code');
    }
}
