# Logging System Implementation - TODO

## 🎯 Overall Goal
Implement comprehensive logging system for Users, Staff, and Admin with activity tracking, viewing capabilities, and filtering.

---

## 📋 PHASE 1: Database Planning & Questions

### ❓ QUESTIONS FOR USER (Before Implementation)

1. **Activity Log Table Structure:**
   - Should there be ONE unified `activity_logs` table with `type` column (user_review, user_borrow, user_return, staff_action, admin_action)?
   - Or separate tables (user_activities, staff_activities, admin_activities)?

2. **What data should we log for each activity type?**
   - User Borrow: `user_id, book_id, library_id, borrow_date, status`
   - User Return: `user_id, book_id, library_id, return_date, condition`
   - User Review: `user_id, book_id, rating, comment_text, review_date`
   - Staff Action: `staff_id, action_type, target_resource, description, timestamp`
   - Admin Action: `admin_id, action_type, target_resource, description, timestamp`

3. **Soft delete or hard delete for canceling borrow?**
   - Should canceled borrows be marked as `canceled_at` timestamp or deleted?

4. **Should we track staff/admin actions like:**
   - Approving/rejecting borrows?
   - Adding books to libraries?
   - Managing categories?
   - User management (banning, etc)?

---

## 📦 PHASE 2: Database & Models (To be done AFTER user answers)

- [ ] Create migration: `create_activity_logs_table` (or separate tables)
- [ ] Create `ActivityLog` model (if unified table)
- [ ] Add relationship to User, Book, Borrowing models
- [ ] Add `canceled_at` to borrowings table (if needed)

---

## 👤 PHASE 3: User Features

### 3.1 User Activity Log Page
- [ ] Create `UserActivityController` 
- [ ] Create route: `GET /user/activity` (show user's activity history)
- [ ] Create view: `resources/views/user/activity-log.blade.php`
- [ ] Display: Reviews, Borrows, Returns with filters & dates

### 3.2 User Borrowing List Page
- [ ] Create route: `GET /user/borrowings/list` or use existing borrowings page
- [ ] Modify view to show:
  - [ ] Current active borrows
  - [ ] Pending approvals
  - [ ] Cancel button (with conditions - only if not approved)
- [ ] Create `CancelBorrowController` or add to `BorrowingController`
- [ ] Handle borrow cancellation logic

### 3.3 Logging for User Actions
- [ ] Log review creation in `ReviewController@store`
- [ ] Log review deletion in `ReviewController@destroy`
- [ ] Log borrow creation in `BorrowingController@store`
- [ ] Log borrow approval/return in staff controllers

---

## 👔 PHASE 4: Staff Features

### 4.1 Staff Activity Log Page
- [ ] Create `StaffActivityController`
- [ ] Create route: `GET /staff/activity-log`
- [ ] Create view: `resources/views/staff/activity-log.blade.php`
- [ ] Show ONLY current staff's activities
- [ ] Display: Books added, borrows approved, returns processed, etc.

### 4.2 Logging for Staff Actions
- [ ] Log all staff actions (book additions, borrow approvals, returns)
- [ ] Create helper/service class for logging staff activities

---

## ⚙️ PHASE 5: Admin Features

### 5.1 Staff Activity Log Page
- [ ] Create `AdminActivityController`
- [ ] Create route: `GET /admin/staff-activity-log`
- [ ] Create view: `resources/views/admin/staff-activity-log.blade.php`
- [ ] Show ALL staff and admin activities
- [ ] Filters: Staff member, date range, action type

### 5.2 User Activity Log Page (NEW)
- [ ] Create route: `GET /admin/user-activity-log`
- [ ] Create view: `resources/views/admin/user-activity-log.blade.php`
- [ ] Show specific user's all activities:
  - [ ] Reviews (with comments)
  - [ ] Borrows (with dates, libraries)
  - [ ] Returns (with dates, conditions)
- [ ] Filters: User, date range, activity type, book

### 5.3 Admin Navigation Updates
- [ ] Add "Staff Activity Log" link to admin sidebar
- [ ] Add "User Activity Log" link to admin sidebar

---

## 🔧 PHASE 6: Shared Features (All Logs)

### 6.1 Filter Functionality
- [ ] Date range filter (from/to dates)
- [ ] Activity type filter (review, borrow, return, etc.)
- [ ] For admin: User filter, Staff filter

### 6.2 Search Functionality
- [ ] Search by book title
- [ ] Search by user name (for admin views)
- [ ] Search by description

### 6.3 Sorting
- [ ] Sort by date (newest/oldest)
- [ ] Sort by type
- [ ] Default: newest first

### 6.4 Pagination
- [ ] 25 items per page with links

---

## 📊 PHASE 7: Navigation Updates

- [ ] User sidebar: Add "My Activity" link
- [ ] Staff sidebar: Add "Activity Log" link
- [ ] Admin sidebar: Add "Staff Activity Log" and "User Activity Log" links

---

## 🧪 PHASE 8: Testing & Polish

- [ ] Test user cancel borrow functionality
- [ ] Test filters work correctly
- [ ] Test logs show correct data
- [ ] Verify permissions (staff only sees own, admin sees all)
- [ ] UI polish and styling

---

## 📝 QUESTIONS TO ASK USER NOW:

1. Unified table or separate tables for logs?
2. What staff/admin actions to track?
3. Soft delete or flag for canceled borrows?
4. Any other specific data fields to track?

