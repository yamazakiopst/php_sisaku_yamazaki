<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ONLINE_STAFF', function (Blueprint $table) {
            $table->integer('STAFF_NO')->primary();
            $table->string('PASSWORD', 8);
            $table->string('NAME', 20);
            $table->integer('AGE');
            $table->char('SEX', 1);
            $table->date('REGISTER_DATE');
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
        Schema::dropIfExists('ONLINE_STAFF');
    }
}
