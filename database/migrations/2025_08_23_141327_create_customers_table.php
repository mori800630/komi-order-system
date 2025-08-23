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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_number')->unique(); // 顧客番号（自動採番）
            $table->string('name'); // 顧客名
            $table->string('email')->nullable(); // メールアドレス
            $table->string('phone')->nullable(); // 電話番号
            $table->string('postal_code')->nullable(); // 郵便番号
            $table->string('prefecture')->nullable(); // 都道府県
            $table->text('address')->nullable(); // 住所
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
        Schema::dropIfExists('customers');
    }
};
