<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('compSymbolCode');
            $table->text('holdingSite')->nullable();
            $table->timestamp('modifiedDt')->nullable();
            $table->string('meetingReason')->nullable();
            $table->string('natureOfGenMetng')->nullable();
            $table->string('status')->nullable();
            

            $table->foreign('compSymbolCode')->references('stock_id')->on('stocks')->onDelete('cascade');
            $table->index('compSymbolCode');
            $table->index('modifiedDt');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};