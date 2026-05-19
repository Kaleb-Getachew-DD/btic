<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cohorts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('batch_number');
            $table->date('application_start');
            $table->date('application_end');
            $table->date('program_start')->nullable();
            $table->date('program_end')->nullable();
            $table->integer('max_startups')->default(20);
            $table->enum('status', ['upcoming', 'open', 'closed', 'active', 'completed'])->default('upcoming');
            $table->json('focus_areas')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cohorts');
    }
};
