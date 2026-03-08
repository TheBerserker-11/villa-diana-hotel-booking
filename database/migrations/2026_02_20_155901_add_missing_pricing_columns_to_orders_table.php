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
            if (!Schema::hasColumn('orders', 'total_guests')) {
                $table->integer('total_guests')->default(1);
            }
            if (!Schema::hasColumn('orders', 'extra_pax')) {
                $table->integer('extra_pax')->default(0);
            }
            if (!Schema::hasColumn('orders', 'extra_pax_fee')) {
                $table->integer('extra_pax_fee')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
        });
    }
};
