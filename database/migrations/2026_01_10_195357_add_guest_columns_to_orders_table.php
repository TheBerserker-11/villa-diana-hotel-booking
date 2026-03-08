<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
        public function up(): void
        {
            Schema::table('orders', function (Blueprint $table) {
        if (!Schema::hasColumn('orders', 'adults')) {
            $table->integer('adults')->default(1);
        }
        if (!Schema::hasColumn('orders', 'children')) {
            $table->integer('children')->default(0);
        }
        if (!Schema::hasColumn('orders', 'infants')) {
            $table->integer('infants')->default(0);
        }
        if (!Schema::hasColumn('orders', 'pets')) {
            $table->integer('pets')->default(0);
        }
    });

    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['adults', 'children', 'infants', 'pets']);
        });
    }
};
