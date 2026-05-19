<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('startups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->text('description');
            $table->text('full_story')->nullable();
            $table->string('sector');
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('founded_year')->nullable();
            $table->string('location')->nullable();
            $table->string('founder_name');
            $table->string('founder_title')->nullable();
            $table->string('founder_photo')->nullable();
            $table->text('founder_bio')->nullable();
            $table->integer('team_size')->nullable();
            $table->string('stage');
            $table->string('cohort_batch')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->json('achievements')->nullable();
            $table->json('metrics')->nullable(); // e.g. {"revenue":"$50k","jobs":"10","users":"500"}
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('startups');
    }
};
