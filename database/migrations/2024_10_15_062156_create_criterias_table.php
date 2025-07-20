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
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->nullable();
            $table->string('name', 100)->nullable(false);
            $table->enum('tipe',['cost', 'benefit'])->nullable(false);
            $table->enum('jenis',['kuantitatif', 'kualitatif'])->nullable(false);
            // $table->float('bobot')->default(0)->required();
            $table->enum('atribut', ['konstanta', 'dinamis'])->default('dinamis');
            $table->boolean('is_include')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criterias');
    }
};
