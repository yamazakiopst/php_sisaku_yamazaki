<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ONLINE_CATEGORY', function (Blueprint $table) {
            $table->integer('CTGR_ID')->primary();
            $table->string('NAME', 20);
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
        Schema::dropIfExists('ONLINE_CATEGORY');
    }
}
