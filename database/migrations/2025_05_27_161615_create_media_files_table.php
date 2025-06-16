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
        Schema::create('media_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('usage_id')->nullable();     // ID dari yang menggunakan. multi image (product_id, banner_id, etc.)
            $table->string('name')->nullable(); 
            $table->string('url');
            $table->string('usage_type')->nullable(); // 'product', 'gallery', 'banner', etc.
            $table->boolean('is_main')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};
