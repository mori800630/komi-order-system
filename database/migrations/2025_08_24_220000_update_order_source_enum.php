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
        Schema::table('orders', function (Blueprint $table) {
            // 既存のenum制約を削除して新しい制約を追加
            $table->enum('order_source', ['phone', 'store', 'pickup_site', 'delivery_site', 'email', 'event', 'other', 'website'])->default('phone')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 元の制約に戻す
            $table->enum('order_source', ['phone', 'store', 'pickup_site', 'delivery_site', 'email', 'event', 'other'])->default('phone')->change();
        });
    }
};
