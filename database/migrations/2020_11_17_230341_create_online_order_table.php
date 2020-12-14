<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ONLINE_ORDER', function (Blueprint $table) {
            $table->integer('ORDER_NO')->autoIncrement();
            $table->integer('MEMBER_NO');
            $table->foreign('MEMBER_NO')->references('MEMBER_NO')->on('ONLINE_MEMBER');
            $table->bigInteger('TOTAL_MONEY');
            $table->bigInteger('TOTAL_TAX');
            $table->date('ORDER_DATE', 1);
            $table->string('COLLECT_NO', 16)->unique();
            $table->timestamp('LAST_UPD_DATE');
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
        Schema::dropIfExists('ONLINE_ORDER');
    }
}
