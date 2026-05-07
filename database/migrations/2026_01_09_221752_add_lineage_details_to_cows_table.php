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
            // Repurpose existing sire_type if needed, but here we add more specific ones
            $table->string('sire_source')->default('Local Bull')->after('sire_id');
            $table->string('dam_source')->default('Local')->after('dam_id');
            
            $table->foreignId('p_grand_sire_id')->nullable()->after('sire_source')->constrained('cows')->nullOnDelete();
            $table->string('p_grand_sire_source')->default('Local Bull')->after('p_grand_sire_id');

            $table->foreignId('m_grand_mother_id')->nullable()->after('dam_source')->constrained('cows')->nullOnDelete();
            $table->string('m_grand_mother_source')->default('Local')->after('m_grand_mother_id');

            $table->json('external_lineage')->nullable()->after('m_grand_mother_source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cows', function (Blueprint $table) {
            $table->dropForeign(['p_grand_sire_id']);
            $table->dropForeign(['m_grand_mother_id']);
            $table->dropColumn([
                'sire_source',
                'dam_source',
                'p_grand_sire_id',
                'p_grand_sire_source',
                'm_grand_mother_id',
                'm_grand_mother_source',
                'external_lineage'
            ]);
        });
    }
};
