<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('category') ) {
            Schema::create('category', function (Blueprint $table) {
                $table->increments('id')->comment("分类表");
                $table->char('name',128)->comment("名称");
                $table->char("english_name",64)->comment("英文名称");
                $table->char("parent_english_name",64)->comment("父级分类名称");
                $table->integer('level')->comment("分类层级");
                $table->char('meta',64)->comment("省份");
                $table->text('attr')->nullable()->comment("额外参数");
                $table->text('order_id')->nullable()->comment("额外参数");
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
        Schema::dropIfExists('category');
    }
}
