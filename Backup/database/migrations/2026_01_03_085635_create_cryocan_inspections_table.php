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
        Schema::create('cryocan_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cryocan_id')->constrained()->cascadeOnDelete();
            $table->date('inspection_date');
            $table->decimal('liquid_level_cm', 5, 2)->nullable();
            $table->string('vacuum_status')->nullable(); // Excellent, Good, Poor, Warning
            $table->string('physical_condition')->nullable(); // No Damage, Scratches, Dents, Heavy Frost
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cryocan_inspections');
    }
};
