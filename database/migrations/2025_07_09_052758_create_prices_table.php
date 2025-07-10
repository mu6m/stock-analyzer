<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->date('date')->primary();
            $table->decimal('open', 15, 4);
            $table->decimal('high', 15, 4);
            $table->decimal('low', 15, 4);
            $table->decimal('close', 15, 4);
            $table->bigInteger('volumeTraded');
            $table->bigInteger('noOfTrades');
            $table->decimal('turnOver', 20, 4);
            $table->string('stock_id');
            
            $table->foreign('stock_id')->references('stock_id')->on('stocks')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};