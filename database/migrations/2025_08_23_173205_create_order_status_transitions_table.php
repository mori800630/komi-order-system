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
        Schema::create('order_status_transitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_status_id')->constrained('order_statuses'); // 現在のステータスID
            $table->foreignId('to_status_id')->constrained('order_statuses'); // 次のステータスID
            $table->string('required_role')->nullable(); // 必要なロール（admin, store, manufacturing, logistics）
            $table->boolean('requires_all_departments_completed')->default(false); // 全部門完了が必要か
            $table->text('description')->nullable(); // 遷移の説明
            $table->boolean('is_active')->default(true); // アクティブ状態
            $table->timestamps();
            
            // 同じ遷移の重複を防ぐ
            $table->unique(['from_status_id', 'to_status_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_transitions');
    }
};
