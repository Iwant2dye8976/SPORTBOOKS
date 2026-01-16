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
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('event_id')->unique();        // chống trùng event
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('book_id')->nullable()->index();
            $table->string('action', 32)->index();     // view, add_to_cart, purchase, review
            $table->smallInteger('weight')->default(1);
            $table->string('session_id')->nullable();
            $table->string('source')->nullable();      // web, mobile
            $table->json('properties')->nullable();
            $table->index(['user_id', 'book_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};
