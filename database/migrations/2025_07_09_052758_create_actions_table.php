<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('issueTypeDesc');
            $table->decimal('newCApital', 15, 4);
            $table->decimal('prevCApital', 15, 4);
            $table->timestamp('dueDate')->nullable();
            $table->timestamp('announceDate')->nullable();
            $table->string('stock_id');
            

            $table->foreign('stock_id')->references('stock_id')->on('stocks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};