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
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_id')->constrained('chart_of_accounts')->cascadeOnDelete();
            $table->enum('entry_type', ['debit', 'credit']);
            $table->integer('amount'); // in cents
            $table->string('reference_number')->nullable();
            $table->text('description')->nullable();
            $table->morphs('reference'); // polymorphic: invoices, payments, etc.
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index('journal_id');
            $table->index('account_id');
            $table->index('entry_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};
