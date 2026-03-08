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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'sub_total')) {
                $table->decimal('sub_total', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('orders', 'vat_amount')) {
                $table->decimal('vat_amount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('orders', 'nights')) {
                $table->integer('nights')->nullable()->default(1);
            }
            if (!Schema::hasColumn('orders', 'price_per_night')) {
                $table->decimal('price_per_night', 10, 2)->nullable()->default(0);
            }
            if (!Schema::hasColumn('orders', 'extra_pax')) {
                $table->integer('extra_pax')->nullable()->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'sub_total',
                'vat_amount',
                'total_amount',
                'nights',
                'price_per_night',
                'extra_pax',
            ]);
        });
    }
};
