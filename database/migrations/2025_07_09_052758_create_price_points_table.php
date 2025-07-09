<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_points', function (Blueprint $table) {
            $table->date('id')->primary();
            $table->decimal('open', 15, 4);
            $table->decimal('high', 15, 4);
            $table->decimal('low', 15, 4);
            $table->decimal('close', 15, 4);
            $table->bigInteger('volumeTraded');
            $table->bigInteger('noOfTrades');
            $table->decimal('turnOver', 20, 4);
            $table->uuid('price_id');
            $table->timestamps();
            
            $table->foreign('price_id')->references('id')->on('prices')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_points');
    }
};