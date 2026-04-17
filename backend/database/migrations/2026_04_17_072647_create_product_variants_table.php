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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();
            $table->string('name');
            $table->json('attributes'); // size, color, finish, etc.
            $table->integer('weight')->nullable(); // in grams
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('finish')->nullable(); // matte, gloss, etc.
            $table->boolean('is_active')->default(true);
            $table->json('images')->nullable();
            $table->timestamps();
            
            $table->index(['product_id', 'sku']);
            $table->index('barcode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
