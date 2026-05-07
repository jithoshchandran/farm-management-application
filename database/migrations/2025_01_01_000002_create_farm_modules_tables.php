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
        Schema::create('milk_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cow_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('morning_yield', 8, 2)->default(0); 
            $table->decimal('evening_yield', 8, 2)->default(0);
            // total_yield calculated in model or stored. Stored is easier for fast summing.
            $table->decimal('total_yield', 8, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cow_id')->constrained()->cascadeOnDelete();
            $table->string('vaccine_name');
            $table->date('date_administered');
            $table->date('next_due_date')->nullable();
            $table->string('batch_number')->nullable();
            $table->string('administered_by')->nullable();
            $table->boolean('notification_sent')->default(false);
            $table->timestamps();
        });

        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cow_id')->constrained()->cascadeOnDelete();
            $table->string('diagnosis');
            $table->text('medication')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('withdrawal_days')->default(0);
            $table->date('withdrawal_end_date')->nullable();
            $table->string('status')->default('Active'); // Active, Completed
            $table->decimal('cost', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('feeds', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->decimal('quantity_in_stock', 10, 2)->default(0); // kg
            $table->decimal('cost_per_kg', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('feed_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feed_id')->constrained()->cascadeOnDelete();
            $table->string('target_group')->nullable(); 
            $table->foreignId('cow_id')->nullable()->constrained()->nullOnDelete(); 
            $table->decimal('amount', 10, 2); // kg
            $table->date('date');
            $table->decimal('cost', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_allocations');
        Schema::dropIfExists('feeds');
        Schema::dropIfExists('treatments');
        Schema::dropIfExists('vaccinations');
        Schema::dropIfExists('milk_productions');
    }
};
