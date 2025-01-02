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
            $table->enum('type', ['organic', 'anorganic', 'B3']);
            $table->decimal('weight', 10, 2); // Volume is removed, only weight is kept
            $table->decimal('earnings', 15, 2)->default(0); // Tambahkan kolom earnings
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->date('collection_date');
            $table->enum('status', ['pending', 'collected', 'processed'])->default('pending');
            $table->timestamps();
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
