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
        Schema::table('semen_stocks', function (Blueprint $table) {
            $table->foreignId('cryocan_id')->nullable()->after('purchase_cost')->constrained('cryocans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('semen_stocks', function (Blueprint $table) {
            $table->dropForeign(['cryocan_id']);
            $table->dropColumn('cryocan_id');
        });
    }
};
