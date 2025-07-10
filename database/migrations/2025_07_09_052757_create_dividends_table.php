<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dividends', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->decimal('amount', 15, 4);
            $table->string('distribution_way')->nullable();
            $table->timestamp('announce_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('distribution_date')->nullable();
            $table->string('stock_id');
            
            $table->foreign('stock_id')->references('stock_id')->on('stocks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dividends');
    }
};