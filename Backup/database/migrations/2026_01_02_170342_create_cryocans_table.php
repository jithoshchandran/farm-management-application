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
        Schema::create('cryocans', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->decimal('tank_size_liters', 8, 2)->nullable();
            
            // Nitrogen Refill Tracking
            $table->date('last_refill_date')->nullable();
            $table->decimal('refill_quantity_liters', 8, 2)->nullable();
            $table->decimal('refill_price', 10, 2)->nullable();
            $table->date('next_scheduled_refill')->nullable();
            
            // Level Tracking
            $table->decimal('current_level_cm', 8, 2)->nullable();
            
            // Supplier/Technician
            $table->string('supplier_name')->nullable();
            $table->string('technician_contact')->nullable();
            
            $table->text('notes')->nullable();
            $table->string('status')->default('Active'); // Active, Maintenance, Empty
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cryocans');
    }
};
