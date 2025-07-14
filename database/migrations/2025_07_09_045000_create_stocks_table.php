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
            
            $table->index(['market_type', 'sector', 'company_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};