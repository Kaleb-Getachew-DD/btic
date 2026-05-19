<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cohort_id')->constrained()->onDelete('cascade');

            // Startup basic info
            $table->string('startup_name');
            $table->string('tagline')->nullable();
            $table->text('description');
            $table->string('sector');
            $table->enum('stage', ['idea', 'prototype', 'mvp', 'early_traction', 'growth']);
            $table->string('website')->nullable();

            // Founder info
            $table->string('founder_name');
            $table->string('founder_email');
            $table->string('founder_phone');
            $table->string('founder_gender');
            $table->string('founder_age_range');
            $table->string('founder_education')->nullable();
            $table->string('university_affiliation')->nullable();

            // Team
            $table->integer('team_size')->default(1);
            $table->text('team_background')->nullable();

            // Problem & Solution
            $table->text('problem_statement');
            $table->text('solution');
            $table->text('target_market');
            $table->text('business_model')->nullable();
            $table->text('competitive_advantage')->nullable();

            // Traction
            $table->text('current_traction')->nullable();
            $table->string('monthly_revenue')->nullable();
            $table->boolean('has_funding')->default(false);
            $table->text('funding_details')->nullable();

            // Support needed
            $table->json('support_needed');
            $table->text('why_btic')->nullable();
            $table->text('goals')->nullable();

            // Documents
            $table->string('pitch_deck')->nullable();
            $table->string('business_plan')->nullable();

            // Status
            $table->enum('status', ['pending', 'under_review', 'shortlisted', 'approved', 'rejected', 'withdrawn'])->default('pending');
            $table->text('review_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();

            $table->string('reference_number')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
