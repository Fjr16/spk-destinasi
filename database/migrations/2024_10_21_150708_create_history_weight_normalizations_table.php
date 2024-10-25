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
        Schema::create('history_weight_normalizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('history_id')->required();
            $table->foreignId('criteria_id')->nullable();
            $table->string('bobot_normalisasi', 50)->nullable();
            $table->string('kriteria', 50)->nullable();
            $table->string('pembagi', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_weight_normalizations');
    }
};
