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
            $table->string('contact_name')->nullable()->after('purchase_date');
            $table->string('contact_location')->nullable()->after('contact_name');
            $table->string('contact_phone_1')->nullable()->after('contact_location');
            $table->string('contact_phone_2')->nullable()->after('contact_phone_1');
            $table->dropColumn('contact_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('semen_stocks', function (Blueprint $table) {
            $table->text('contact_details')->nullable()->after('purchase_date');
            $table->dropColumn(['contact_name', 'contact_location', 'contact_phone_1', 'contact_phone_2']);
        });
    }
};
