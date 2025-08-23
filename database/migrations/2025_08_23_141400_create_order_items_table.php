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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // 注文ID
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // 商品ID
            $table->integer('quantity'); // 数量
            $table->decimal('unit_price', 10, 2); // 単価
            $table->decimal('subtotal', 10, 2); // 小計
            $table->text('notes')->nullable(); // 備考
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
