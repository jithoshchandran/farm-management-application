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
            $table->string('sire_type')->default('Local Bull')->after('dam_id');
            $table->foreignId('sire_semen_stock_id')->nullable()->after('sire_type')->constrained('semen_stocks')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cows', function (Blueprint $table) {
            $table->dropForeign(['sire_semen_stock_id']);
            $table->dropColumn(['sire_type', 'sire_semen_stock_id']);
        });
    }
};
