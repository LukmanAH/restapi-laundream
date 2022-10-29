<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('laundry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('catalog_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parfume_id')->constrained()->cascadeOnDelete();
            $table->string('serial')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('delivery_fee')->nullable();
            $table->float('distance',8,2)->nullable();
            $table->integer('service_type');
            $table->integer('payment_type');
            $table->text('address');
            $table->decimal('lat', 11, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->dateTime('estimation_complete')->nullable();
            $table->integer('status');
            $table->string('additional_information_user')->nullable();
            $table->string('additional_information_laundry')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
