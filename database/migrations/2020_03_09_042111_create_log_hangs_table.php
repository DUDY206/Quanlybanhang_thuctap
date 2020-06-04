<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_hangs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('hang_id');
            $table->string('phuongthuc');
            $table->string('noidung');
            $table->dateTime('thoigian');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_hangs');
    }
}
