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
        Schema::create('pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ps_unit_id')->constrained('ps_units')->onDelete('cascade'); // Relasi dengan ps_units
            $table->decimal('base_rate', 10, 2); // Tarif dasar per jam
            $table->decimal('weekend_surcharge', 10, 2)->default(0); // Surcharge untuk Sabtu/Minggu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing');
    }
};
