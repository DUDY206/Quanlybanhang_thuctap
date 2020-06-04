<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhapHangLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhap_hang_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('nhaphang_id');
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
        Schema::dropIfExists('nhap_hang_log');
    }
}
