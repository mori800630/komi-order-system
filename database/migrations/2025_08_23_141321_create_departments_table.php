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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 部門名（例：洋菓子製造部）
            $table->string('code')->unique(); // 部門コード（例：western_confectionery）
            $table->text('description')->nullable(); // 部門の説明
            $table->boolean('is_active')->default(true); // アクティブ状態
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
