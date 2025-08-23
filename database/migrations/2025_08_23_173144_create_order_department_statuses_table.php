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
        Schema::create('order_department_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // 注文ID
            $table->foreignId('department_id')->constrained(); // 部門ID
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started'); // ステータス
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // 更新者ID
            $table->timestamp('started_at')->nullable(); // 製造開始日時
            $table->timestamp('completed_at')->nullable(); // 製造完了日時
            $table->text('notes')->nullable(); // 備考
            $table->timestamps();
            
            // 注文と部門の組み合わせは一意
            $table->unique(['order_id', 'department_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_department_statuses');
    }
};
