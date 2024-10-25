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
        Schema::create('history_alternatif_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('history_id')->required();
            $table->foreignId('alternative_id')->required();
            $table->foreignId('criteria_id')->required();
            $table->string('name', 50)->nullable();
            $table->double('nilai_awal')->default(0);
            $table->double('nilai_normalisasi')->default(0);
            $table->double('nilai_preferensi')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_alternatif_values');
    }
};
