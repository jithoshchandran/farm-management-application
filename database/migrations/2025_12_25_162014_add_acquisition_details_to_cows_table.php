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
        Schema::table('cows', function (Blueprint $table) {
            $table->string('acquisition_type')->default('Born')->after('status');
            $table->date('purchase_date')->nullable()->after('acquisition_type');
            $table->string('purchase_from')->nullable()->after('purchase_date');
            $table->string('purchase_age')->nullable()->after('purchase_from');
            $table->string('purchase_status')->nullable()->after('purchase_age');
            $table->string('purchase_pregnancy_type')->nullable()->after('purchase_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cows', function (Blueprint $table) {
            $table->dropColumn([
                'acquisition_type',
                'purchase_date',
                'purchase_from',
                'purchase_age',
                'purchase_status',
                'purchase_pregnancy_type'
            ]);
        });
    }
};
