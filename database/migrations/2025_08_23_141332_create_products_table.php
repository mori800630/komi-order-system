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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->onDelete('cascade'); // 部門ID
            $table->string('name'); // 商品名
            $table->text('description')->nullable(); // 商品説明
            $table->decimal('price', 10, 2); // 価格
            $table->enum('status', ['pre_sale', 'on_sale', 'discontinued'])->default('on_sale'); // 販売ステータス
            $table->boolean('requires_packaging')->default(false); // 梱包物流が必要か
            $table->text('notes')->nullable(); // 備考
            $table->boolean('is_active')->default(true); // アクティブ状態
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
