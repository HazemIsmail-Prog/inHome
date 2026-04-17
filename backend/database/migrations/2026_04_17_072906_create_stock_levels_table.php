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
        Schema::create('stock_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('quantity')->default(0);
            $table->integer('reserved_quantity')->default(0);
            $table->integer('minimum_quantity')->default(0);
            $table->integer('maximum_quantity')->nullable();
            $table->integer('reorder_point')->default(0);
            $table->integer('reorder_quantity')->default(0);
            $table->string('location_code')->nullable();
            $table->string('shelf_number')->nullable();
            $table->string('bin_number')->nullable();
            $table->integer('average_cost')->default(0); // in cents
            $table->integer('last_cost')->nullable(); // in cents
            $table->timestamp('last_movement_at')->nullable();
            $table->timestamps();
            
            $table->unique(['warehouse_id', 'product_id', 'product_variant_id'], 'stock_levels_unique');
            $table->index(['product_id', 'warehouse_id']);
            $table->index(['warehouse_id', 'quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_levels');
    }
};
