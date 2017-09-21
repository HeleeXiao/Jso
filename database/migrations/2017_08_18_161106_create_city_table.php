<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('city') ) {
            Schema::create('city', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned()->comment("城市");
                $table->char("city_id",128)->unique()->comment("城市id");
                $table->char('province',32)->comment("省份");
                $table->char('name',128)->comment("名称");
                $table->char('english_name',64)->comment("英文名称");
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
        Schema::dropIfExists('city');
    }
}
