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
        Schema::create('cryocan_refills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cryocan_id')->constrained()->cascadeOnDelete();
            $table->date('refill_date');
            $table->decimal('quantity_liters', 8, 2)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cryocan_refills');
    }
};
