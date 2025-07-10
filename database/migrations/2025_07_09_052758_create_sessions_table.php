<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('stock_id');
            $table->string('session_type');
            $table->text('requirement');
            $table->text('submission_method');
            $table->string('no_of_bod');
            $table->date('session_start_date')->nullable();
            $table->date('session_end_date')->nullable();
            $table->date('app_start_date')->nullable();
            $table->date('app_end_date')->nullable();
            $table->timestamps();
            
            $table->foreign('stock_id')->references('stock_id')->on('stocks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};