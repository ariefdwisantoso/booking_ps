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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ps_unit_id')->constrained('ps_units')->onDelete('cascade'); // Relasi dengan ps_units
            $table->string('customer_name');
            $table->string('customer_contact');
            $table->string('customer_email')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->decimal('cost', 10, 2);
            $table->decimal('weekend_surcharge', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
