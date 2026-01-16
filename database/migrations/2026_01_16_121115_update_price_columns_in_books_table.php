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
       Schema::table('books', function (Blueprint $table) {
            // đổi tên price -> origin_price
            $table->renameColumn('price', 'origin_price');

            // thêm cột final_price
            $table->double('final_price')->after('origin_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('books', function (Blueprint $table) {
            $table->renameColumn('origin_price', 'price');
            $table->dropColumn('final_price');
        });
    }
};
