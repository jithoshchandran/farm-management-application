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
            $table->foreignId('breed_id')->after('status')->nullable()->constrained('breeds')->onDelete('set null');
            $table->dropColumn('breed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cows', function (Blueprint $table) {
            $table->string('breed')->after('status')->nullable();
            $table->dropForeign(['breed_id']);
            $table->dropColumn('breed_id');
        });
    }
};
