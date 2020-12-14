<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateOnlineProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ONLINE_PRODUCT', function (Blueprint $table) {
            $table->string('PRODUCT_CODE', 14)->primary();
            $table->integer('CATEGORY_ID');
            $table->foreign('CATEGORY_ID')->references('CTGR_ID')->on('ONLINE_CATEGORY');
            $table->string('PRODUCT_NAME', 50);
            $table->string('MAKER', 20);
            $table->integer('STOCK_COUNT');
            $table->date('REGISTER_DATE');
            $table->bigInteger('UNIT_PRICE');
            $table->string('PICTURE_NAME', 100)->nullable();
            $table->string('MEMO', 255)->nullable();
            $table->char('DELETE_FLG', 1)->default(0);
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
        Schema::dropIfExists('ONLINE_PRODUCT');
    }
}
