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
        Schema::create('alternatives', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->foreignId('travel_category_id')->required();
            $table->text('deskripsi')->nullable();
            $table->text('alamat')->nullable();
            $table->decimal('harga', 10,2)->required();
            $table->string('maps_lokasi')->required();
            $table->string('foto')->nullable();
            $table->integer('rating')->default(0);
            $table->integer('jumlah_fasilitas')->default(0);
            $table->enum('status', ['accepted', 'denied', 'waiting'])->default('waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatives');
    }
};
