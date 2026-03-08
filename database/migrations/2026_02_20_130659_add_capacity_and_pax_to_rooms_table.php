<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {

            $table->integer('included_pax')
                  ->default(1)
                  ->after('price');

            $table->integer('max_capacity')
                  ->default(2)
                  ->after('included_pax');

        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn([
                'included_pax',
                'max_capacity'
            ]);
        });
    }
};