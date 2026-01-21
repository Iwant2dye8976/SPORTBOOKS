<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('orders', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('user_id');
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->unsignedBigInteger('deliverer_id');
        //     $table->string('recipient_name', 255);
        //     $table->string('shipping_address', 255);
        //     $table->string('phone_number', 10);
        //     $table->text('note')->nullable();
        //     $table->double('shipping_fee')->default(0.6);
        //     $table->double('books_price');
        //     $table->double('total')->storedAs('ROUND(books_price + shipping_fee, 2)');
        //     $table->smallInteger('status')->default(-1); //-1:pending , 0:canceled , 1:wait for payment, 2: pay successfully
        //     $table->timestamps();
        // });
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('deliverer_id')->nullable();
            $table->string('recipient_name', 255);
            $table->string('shipping_address', 255);
            $table->string('phone_number', 15);
            $table->text('note')->nullable();
            $table->double('shipping_fee')->default(0.6);
            $table->double('books_price');
            $table->double('total')->storedAs('ROUND(books_price + shipping_fee, 2)');
            $table->smallInteger('status')->default(-1); // -1: pending, 0: canceled, 1: wait, 2: paid
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
