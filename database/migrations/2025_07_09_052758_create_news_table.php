<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->text('title');
            $table->text('description')->nullable();
            $table->timestamp('creation_date')->nullable();
            $table->string('stock_id')->nullable();

            
            $table->foreign('stock_id')
                  ->references('stock_id')
                  ->on('stocks')
                  ->onDelete('cascade')
                  ->nullable();
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};