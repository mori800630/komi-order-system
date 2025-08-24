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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // 注文番号（自動採番）
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null'); // 顧客ID
            $table->foreignId('order_status_id')->constrained(); // 注文ステータスID
            $table->enum('order_source', ['phone', 'store', 'pickup_site', 'delivery_site', 'email', 'event', 'other'])->default('phone'); // 注文ソース
            $table->enum('delivery_method', ['pickup', 'delivery'])->default('pickup'); // 受け取り方法
            $table->decimal('total_amount', 10, 2)->default(0); // 合計金額
            $table->date('pickup_date')->nullable(); // 受け取り日
            $table->time('pickup_time')->nullable(); // 受け取り時間
            $table->text('notes')->nullable(); // 備考
            $table->boolean('requires_packaging')->default(false); // 梱包物流が必要か
            $table->timestamps();
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
