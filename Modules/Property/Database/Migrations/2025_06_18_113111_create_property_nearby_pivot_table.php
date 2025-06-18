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
        Schema::create('nearby_property', function (Blueprint $table) {
            $table->primary(['property_id', 'nearby_id']);
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->foreignId('nearby_id')->constrained('nearby_objects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nearby_property');
    }
};
