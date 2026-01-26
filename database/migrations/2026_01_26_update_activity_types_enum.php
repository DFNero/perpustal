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
        // Modify the activity_type enum to add new types
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn('activity_type');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
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
                'user_banned',  // Staff banning users
                // Admin activities
                'admin_ban_user',
                'admin_unban_user',
                'admin_delete_category',
                'admin_create_category',
                'admin_manage_staff'
            ])->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn('activity_type');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
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
            ])->after('user_id');
        });
    }
};
