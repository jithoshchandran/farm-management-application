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
            $table->decimal('purchase_cost', 10, 2)->nullable()->after('purchase_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('semen_stocks', function (Blueprint $table) {
            $table->dropColumn('purchase_cost');
        });
    }
};
