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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('quantity');
            $table->integer('received_quantity')->default(0);
            $table->integer('unit_price'); // in cents
            $table->integer('tax_rate')->default(0); // in basis points
            $table->integer('tax_amount')->default(0); // in cents
            $table->integer('discount_rate')->default(0); // in basis points
            $table->integer('discount_amount')->default(0); // in cents
            $table->integer('total_price'); // in cents
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('purchase_order_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
