<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();

            // relasi ke orders
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            // status response
            $table->enum('type', ['diterima', 'ditolak']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('responses');
    }
}
