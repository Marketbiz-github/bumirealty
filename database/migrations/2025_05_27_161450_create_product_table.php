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
            $table->uuid('id')->primary();
            $table->uuid('category_id');
            $table->string('sku')->unique()->nullable(); 
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 18, 2)->default(0.00);
            $table->decimal('discount', 5, 2)->default(0.00); // Discount in percentage
            $table->integer('stock')->default(0);
            $table->text('description')->nullable();
            $table->uuid('thumbnail_id')->nullable(); 
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
