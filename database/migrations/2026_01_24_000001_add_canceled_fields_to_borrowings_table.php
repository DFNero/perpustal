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
        Schema::table('borrowings', function (Blueprint $table) {
            $table->timestamp('canceled_at')
                ->nullable()
                ->after('return_date')
                ->comment('When borrow was canceled by user');
            $table->text('cancel_reason')
                ->nullable()
                ->after('canceled_at')
                ->comment('Reason for cancellation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn(['canceled_at', 'cancel_reason']);
        });
    }
};
