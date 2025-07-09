<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->timestamp('creation_date');
            $table->float('stock_change');
            $table->string('stock_id');
            $table->timestamps();
            
            $table->foreign('stock_id')->references('stock_id')->on('stocks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};