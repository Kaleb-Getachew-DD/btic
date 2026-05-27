<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('password_reset_requests', function (Blueprint $table) {
            $table->boolean('is_cancelled')->default(false)->index()->after('status');
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete()->after('is_cancelled');
            $table->timestamp('cancelled_at')->nullable()->after('cancelled_by');
        });
    }

    public function down(): void
    {
        Schema::table('password_reset_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cancelled_by');
            $table->dropColumn(['is_cancelled', 'cancelled_at']);
        });
    }
};

