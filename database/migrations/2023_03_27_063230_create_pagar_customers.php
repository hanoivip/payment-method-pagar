<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagarCustomers extends Migration
{
    public function up()
    {
        Schema::create('pagar_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('info')->nullable();
            $table->text('billing')->nullable();
            $table->text('shipping')->nullable();
            $table->text('param')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagar_customers');
    }
}
