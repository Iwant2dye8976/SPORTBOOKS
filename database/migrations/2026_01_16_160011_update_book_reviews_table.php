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
        Schema::table('book_reviews', function (Blueprint $table) {
            $table->boolean('verified_purchase')
                ->default(false)
                ->after('comment');

            $table->json('metadata')
                ->nullable()
                ->after('verified_purchase');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
