<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trashes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['organic', 'non-organic', 'B3']);
            $table->decimal('volume', 10, 2); 
            $table->decimal('weight', 10, 2); 
            $table->date('collection_date');
            $table->enum('status', ['pending', 'collected', 'processed'])->default('pending');
            $table->timestamps();

            // Adding indexes
            $table->index('location_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trashes');
    }
};
