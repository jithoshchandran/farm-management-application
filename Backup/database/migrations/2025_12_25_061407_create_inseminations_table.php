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
        Schema::create('inseminations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cow_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->enum('type', ['Artificial Insemination', 'Natural']);
            $table->string('bull_tag')->nullable(); // For natural or general reference
            $table->string('semen_batch_code')->nullable(); // Specific for AI
            $table->string('technician_name')->nullable();
            $table->decimal('cost', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->boolean('is_successful')->nullable(); // Null = Pending, True = Pregnant, False = Failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inseminations');
    }
};
