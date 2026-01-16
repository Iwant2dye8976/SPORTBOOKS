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
        // Schema::create('order_details', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('book_id');
        //     $table->unsignedBigInteger('order_id');
        //     $table->unsignedBigInteger('deliverer_id');
        //     $table->unsignedSmallInteger('book_quantity')->default(1);
        //     $table->double('price');
        //     $table->double('total_price')->storedAs('book_quantity * price');
        //     $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        //     $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        //     $table->foreign('deliverer_id')->references('deliverer_id')->on('orders')->onDelete('cascade');
        //     $table->timestamps();
        // });
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedSmallInteger('book_quantity')->default(1);
            $table->unsignedSmallInteger('discount')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('total_price', 12, 2)->storedAs('book_quantity * price');
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
