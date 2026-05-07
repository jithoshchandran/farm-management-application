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
            $table->integer('straws_used')->default(1)->after('semen_stock_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inseminations', function (Blueprint $table) {
            $table->dropColumn('straws_used');
        });
    }
};
