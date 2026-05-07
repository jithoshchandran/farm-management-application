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
        \DB::statement("
            CREATE VIEW milk_production_summaries AS
            SELECT 
                cow_id, 
                SUM(total_yield) as aggregate_yield,
                MIN(date) as first_date,
                MAX(date) as last_date,
                COUNT(*) as record_count
            FROM milk_productions
            GROUP BY cow_id
        ");
    }

    public function down(): void
    {
        \DB::statement("DROP VIEW IF EXISTS milk_production_summaries");
    }
};
