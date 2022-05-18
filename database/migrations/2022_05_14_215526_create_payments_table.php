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
            $table->text('campaigns')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->double('amount')->nullable();
            $table->string('tel')->nullable();
            $table->enum('payment_method',['Online Payment', 'Offline Payment'])->default('Online Payment');
            $table->text('message')->nullable();
            $table->string('transaction_number')->unique();
            $table->string('status')->nullable();
            $table->string('feda_id')->nullable();
            $table->json('detailtransaction')->nullable();
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
