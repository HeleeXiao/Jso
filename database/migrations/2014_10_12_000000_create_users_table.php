<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (! Schema::hasTable('users') ) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('user_id')->unsigned()->comment("用户ID");
                $table->char('nickname',128)->unique()->comment("昵称");
                $table->char('email',32)->unique()->comment("E-mail");
                $table->char('password',64)->comment("密码");
                $table->text('description')->nullable()->comment("描述");
                $table->text('attr')->nullable()->comment("额外参数");
                $table->char('register_ip',32)->nullable()->comment("注册Ip");
                $table->char("mobile",32)->unique()->default('')->comment("");
                $table->integer('type')->default(0)->comment("玩家类型:0 普通用户 1游戏转入的推广员 2 专业推广员");
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
