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
        Schema::create('cows', function (Blueprint $table) {
            $table->id();
            $table->string('tag_number')->unique();
            $table->string('name')->nullable();
            $table->date('dob');
            $table->enum('gender', ['Female', 'Male'])->default('Female');
            $table->string('status')->default('Active'); // Active, Dry, Pregnant, Sick, Sold, Lactating
            $table->string('breed')->nullable();
            $table->decimal('weight', 8, 2)->nullable(); // kg
            $table->decimal('milk_production_avg', 8, 2)->nullable(); // L/day
            $table->date('last_calving_date')->nullable();
            $table->integer('breeding_cycle')->default(0);
            $table->date('last_heat_date')->nullable();
            $table->date('next_expected_heat')->nullable();
            
            // Lineage
            $table->foreignId('sire_id')->nullable()->constrained('cows')->nullOnDelete();
            $table->foreignId('dam_id')->nullable()->constrained('cows')->nullOnDelete();
            
            // For external ancestors not tracked as full cows, we might just use these fields if sire_id is null?
            // Or strictly use records. Let's add these for flexibility in UI.
            // Actually, best practice is to require a record for lineage. I'll stick to strict keys for now.
            // If user inputs "Bull 505", we create a placeholder Cow with 'Reference' status.
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cows');
    }
};
