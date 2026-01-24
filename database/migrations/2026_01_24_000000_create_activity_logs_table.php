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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // Who did the action
            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnDelete();
            
            // Type of activity
            $table->enum('activity_type', [
                // User activities
                'user_borrow',
                'user_return_request',
                'user_cancel_borrow',
                'user_review',
                'user_delete_review',
                // Staff activities
                'staff_approve_borrow',
                'staff_reject_borrow',
                'staff_process_return',
                'staff_add_book',
                'staff_update_book',
                'staff_add_book_to_library',
                'staff_update_stock',
                'staff_remove_book_from_library',
                // Admin activities
                'admin_ban_user',
                'admin_unban_user',
                'admin_delete_category',
                'admin_create_category',
                'admin_manage_staff'
            ]);
            
            // What resource was affected
            $table->enum('resource_type', [
                'Book',
                'Borrowing',
                'Review',
                'User',
                'Category',
                'Library'
            ]);
            
            // ID of the affected resource
            $table->unsignedBigInteger('resource_id');
            
            // Description of what happened
            $table->text('description')->nullable();
            
            // Additional metadata (JSON)
            $table->json('metadata')->nullable();
            
            // Timestamp
            $table->timestamps();
            
            // Indexes for querying
            $table->index('user_id');
            $table->index('activity_type');
            $table->index('resource_type');
            $table->index('created_at');
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
