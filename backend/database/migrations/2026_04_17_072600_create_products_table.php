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
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('specifications')->nullable();
            $table->enum('product_type', ['finished_good', 'raw_material', 'service', 'component'])->default('finished_good');
            $table->enum('unit_of_measure', ['piece', 'kg', 'liter', 'meter', 'set', 'box', 'pair'])->default('piece');
            $table->integer('weight')->nullable(); // in grams
            $table->string('weight_unit')->nullable();
            $table->json('dimensions')->nullable(); // length, width, height in cm
            $table->string('manufacturer')->nullable();
            $table->string('brand')->nullable();
            $table->string('model_number')->nullable();
            $table->string('color')->nullable();
            $table->string('material')->nullable(); // wood, metal, fabric, etc.
            $table->integer('warranty_months')->nullable();
            $table->boolean('is_taxable')->default(true);
            $table->integer('tax_rate')->default(0); // in basis points (e.g., 1000 = 10%)
            $table->boolean('is_active')->default(true);
            $table->boolean('is_purchasable')->default(true);
            $table->boolean('is_sellable')->default(true);
            $table->boolean('track_inventory')->default(true);
            $table->json('images')->nullable();
            $table->json('attributes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['sku', 'barcode']);
            $table->index(['category_id', 'product_type']);
            $table->index('is_active');
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
