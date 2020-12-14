<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineOrderListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ONLINE_ORDER_LIST', function (Blueprint $table) {
            $table->integer('LIST_NO')->autoIncrement();
            $table->string('COLLECT_NO', 16);
            $table->String('PRODUCT_CODE', 14);
            $table->foreign('PRODUCT_CODE')->references('PRODUCT_CODE')->on('ONLINE_PRODUCT');
            $table->integer('ORDER_COUNT');
            $table->bigInteger('ORDER_PRICE');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ONLINE_ORDER_LIST');
    }
}
