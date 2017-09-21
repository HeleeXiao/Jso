<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileDisabledTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('mobile_disabled') ) {
            Schema::create('mobile_disabled', function (Blueprint $table) {
                $table->increments('id')->unsigned()->comment("被禁用的手机");
                $table->char('mobile',32)->comment("号码");
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
        Schema::dropIfExists('mobile_disabled');
    }
}
