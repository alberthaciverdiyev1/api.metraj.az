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
        Schema::table('users', function (Blueprint $table) {

            $table->string('address')->nullable();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->foreignId('subway_id')->nullable()->constrained('subways')->nullOnDelete();
            $table->foreignId('town_id')->nullable()->constrained('towns')->nullOnDelete();

            $table->string('phone_1')->unique();
            $table->string('phone_2')->unique();
            $table->string('phone_3')->unique();
            $table->string('phone_4')->unique();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_confirmed')->default(false);

            $table->boolean('is_agency')->default(false);
            $table->string('profile_image')->nullable();
            $table->string('background_image')->nullable();
            $table->string('location')->nullable();
            $table->text('short_description')->nullable();
            $table->text('work_hours')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address','city_id','district_id','subway_id','town_id','phone_1','phone_2','phone_3','phone_4','email','is_active','is_premium','is_confirmed']);
        });
    }
};
