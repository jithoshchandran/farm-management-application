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
        Schema::create('semen_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('bull_name')->nullable();
            $table->string('bull_tag')->nullable();
            $table->string('breed')->nullable();
            $table->date('batch_date')->nullable();
            $table->date('collection_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->text('purchase_address')->nullable();
            $table->string('sire_name')->nullable();
            $table->string('dam_name')->nullable();
            $table->string('bull_image')->nullable();
            $table->string('sire_image')->nullable();
            $table->string('dam_image')->nullable();
            $table->text('notes')->nullable();
            $table->integer('initial_quantity')->default(0);
            $table->integer('remaining_quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semen_stocks');
    }
};
