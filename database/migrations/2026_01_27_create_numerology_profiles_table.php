<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('numerology_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->date('birth_date');
            
            // Core Numbers
            $table->unsignedInteger('life_path')->nullable();
            $table->unsignedInteger('expression')->nullable();
            $table->unsignedInteger('hearts_desire')->nullable();
            $table->unsignedInteger('personality')->nullable();
            $table->unsignedInteger('birthday')->nullable();
            
            // Challenges and Pinnacles
            $table->unsignedInteger('first_pinnacle')->nullable();
            $table->unsignedInteger('second_pinnacle')->nullable();
            $table->unsignedInteger('third_pinnacle')->nullable();
            $table->unsignedInteger('fourth_pinnacle')->nullable();
            
            $table->unsignedInteger('first_challenge')->nullable();
            $table->unsignedInteger('second_challenge')->nullable();
            $table->unsignedInteger('third_challenge')->nullable();
            $table->unsignedInteger('fourth_challenge')->nullable();
            
            // Pythagorean Grid
            $table->json('grid_numbers')->nullable();
            $table->json('grid_arrows')->nullable();
            
            // Personal Cycles
            $table->unsignedInteger('personal_year')->nullable();
            $table->unsignedInteger('personal_month')->nullable();
            $table->unsignedInteger('personal_day')->nullable();
            
            // Karmic Information
            $table->json('karmic_lessons')->nullable();
            $table->json('karmic_debt_numbers')->nullable();
            $table->boolean('has_master_numbers')->default(false);
            
            $table->timestamps();
            $table->unique(['user_id', 'full_name', 'birth_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('numerology_profiles');
    }
};