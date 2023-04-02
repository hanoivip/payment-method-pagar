<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagarTransactions extends Migration
{
    public function up()
    {
        Schema::create('pagar_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trans');
            $table->string('channel')->nullable();
            $table->text('result')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagar_transactions');
    }
}
