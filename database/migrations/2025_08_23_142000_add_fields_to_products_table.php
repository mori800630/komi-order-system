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
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_number')->nullable()->after('id')->comment('商品番号');
            $table->string('name_kana')->nullable()->after('name')->comment('商品名（ふりがな）');
            $table->enum('decoration', ['available', 'unavailable'])->default('unavailable')->after('requires_packaging')->comment('デコレーション');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['product_number', 'name_kana', 'decoration']);
        });
    }
};
