<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->string('stock_id')->primary();
            $table->string('company_name');
            $table->enum('market_type', ['NOMU', 'TASI']);
            $table->string('sector');
            $table->decimal('current_price', 10, 2)->nullable();
            $table->decimal('previous_price', 10, 2)->nullable();
            $table->json('price_history')->nullable();
            
            $table->index(['market_type', 'sector', 'company_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};