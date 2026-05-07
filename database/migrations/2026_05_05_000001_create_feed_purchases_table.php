<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('feeds', 'unit')) {
            Schema::table('feeds', function (Blueprint $table) {
                $table->string('unit')->default('kg')->after('category');
            });
        }

        Schema::create('feed_purchases', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            $table->foreignId('feed_id')->constrained()->cascadeOnDelete();
            $table->string('category')->nullable();
            $table->string('unit')->default('kg');
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('quantity', 10, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
        });

        DB::table('feeds')
            ->where(function ($query): void {
                $query->where('quantity_in_stock', '>', 0)
                    ->orWhere('cost_per_kg', '>', 0);
            })
            ->orderBy('id')
            ->get()
            ->each(function ($feed): void {
                $quantity = (float) ($feed->quantity_in_stock ?? 0);
                $unitPrice = (float) ($feed->cost_per_kg ?? 0);

                DB::table('feed_purchases')->insert([
                    'purchase_date' => now()->toDateString(),
                    'feed_id' => $feed->id,
                    'category' => $feed->category ?? null,
                    'unit' => $feed->unit ?? 'kg',
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'total' => round($quantity * $unitPrice, 2),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_purchases');

        if (Schema::hasColumn('feeds', 'unit')) {
            Schema::table('feeds', function (Blueprint $table) {
                $table->dropColumn('unit');
            });
        }
    }
};
