<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('avatar')->nullable();        // user photo
        $table->string('location')->nullable();
        $table->string('title')->nullable();
        $table->text('content');
        $table->tinyInteger('rating')->default(5);   // 1-5 stars
        $table->date('stay_date')->nullable();
        $table->integer('helpful_votes')->default(0);
        $table->string('insider_tip')->nullable();
        $table->timestamps();
    });


    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
