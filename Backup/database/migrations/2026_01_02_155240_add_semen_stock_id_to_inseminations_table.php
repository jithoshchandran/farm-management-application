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
        Schema::table('inseminations', function (Blueprint $table) {
            $table->foreignId('semen_stock_id')->nullable()->constrained('semen_stocks')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inseminations', function (Blueprint $table) {
            $table->dropForeign(['semen_stock_id']);
            $table->dropColumn('semen_stock_id');
        });
    }
};
