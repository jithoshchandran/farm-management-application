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
            $table->renameColumn('purchase_address', 'contact_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('semen_stocks', function (Blueprint $table) {
            $table->renameColumn('contact_details', 'purchase_address');
        });
    }
};
