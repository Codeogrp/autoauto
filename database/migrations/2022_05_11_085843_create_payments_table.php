<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->text('campaigns');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->double('amount');
            $table->string('tel');
            $table->enum('payment_method',['Online Payment', 'Offline Payment'])->default('Online Payment');
            $table->text('message');
            $table->string('feda_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
