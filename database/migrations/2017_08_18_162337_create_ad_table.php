<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('ad') ) {
            Schema::create('ad', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned()->comment('文章');
                $table->char("title",32)->comment("文章标题");
                $table->char("category_names",128)->comment("分类名称 : [待定]");
                $table->char("category_english_names",128)->comment("分类名称 : [待定]");
                $table->char("area_names",128)->comment("区域名集合");
                $table->integer("user_id")->comment("用户id");
                $table->longText("description")->comment("内容");
                $table->char("attr",64)->comment("邮箱");
                $table->char("user_ip",64)->comment("用户发帖ip");
                $table->integer("area_city_level_id")->comment("区域层级id");
                $table->integer("area_first_level_id")->comment("区域第一级id");
                $table->integer("area_second_level_id")->comment("区域第二级id");
                $table->integer("status")->comment("状态 [0：待审核 1：审核通过 2：驳回 3：置顶]");
                $table->text("image_flag")->comment("图片地址");
                $table->char("master_nick_name",64)->comment("发布者");
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
        Schema::dropIfExists('ad');
    }
}
