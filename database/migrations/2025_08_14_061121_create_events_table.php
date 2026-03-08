<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Event name/title
            $table->string('type');              // Event type: Wedding, Debut, etc.
            $table->text('description')->nullable(); // Event description
            $table->decimal('price', 10, 2)->nullable(); // Price if applicable
            $table->string('image')->nullable();       // Event image path
            $table->integer('capacity')->nullable();   // Number of adults
            $table->integer('capacity_children')->nullable(); // Number of children
            $table->date('available_date')->nullable(); // Available date for the event
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
