<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Clean up duplicates (keep the latest entry for each cow-date pair)
        $duplicates = DB::table('milk_productions')
            ->select('cow_id', 'date', DB::raw('MAX(id) as max_id'))
            ->groupBy('cow_id', 'date')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('milk_productions')
                ->where('cow_id', $duplicate->cow_id)
                ->where('date', $duplicate->date)
                ->where('id', '<', $duplicate->max_id)
                ->delete();
        }

        // 2. Add unique constraint
        Schema::table('milk_productions', function (Blueprint $table) {
            $table->unique(['cow_id', 'date'], 'cow_date_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('milk_productions', function (Blueprint $table) {
            $table->dropUnique('cow_date_unique');
        });
    }
};
