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
        Schema::create('performance_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->required();
            $table->foreignId('criteria_id')->required();
            $table->foreignId('sub_criteria_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_ratings');
    }
};
