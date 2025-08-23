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
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ステータス名（例：注文受付）
            $table->string('code')->unique(); // ステータスコード（例：order_received）
            $table->integer('sort_order'); // 表示順序
            $table->text('description')->nullable(); // 説明
            $table->boolean('is_active')->default(true); // アクティブ状態
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
