# Revisions Implementation - 7 Phase Plan (Jan 26, 2026)

## 📋 Overview
Implementation of 3 major teacher revisions:
1. Staff can ban users (not just admin)
2. KTP system as collateral for bans
3. Borrowing due dates with duration selection

---

## ✅ **Phase 1: KTP Integration** (COMPLETED)

**Objective:** Require KTP during registration and store KTP photo

**Implementation:**
- Migration: Add `ktp_number` & `ktp_photo_path` to users table
- User model: Add fillable + accessor methods (getKtpPhotoUrlAttribute, hasKtpRegistered)
- Registration: Add KTP number input (16 digits) + photo upload with preview
- User profile: Show KTP info + allow re-upload with image zoom modal
- KTP display component: Reusable card showing KTP + photo (sm/md/lg sizes)
- Profile controller: Handle KTP photo upload/deletion from public storage

**Files Created:**
- `database/migrations/2026_01_26_add_ktp_to_users_table.php`
- `resources/views/components/ktp-card.blade.php`

**Files Updated:**
- `app/Models/User.php` (fillable, methods)
- `app/Http/Controllers/Auth/RegisteredUserController.php` (already done)
- `resources/views/auth/register.blade.php` (form fields + JS preview)
- `resources/views/profile/partials/update-profile-information-form.blade.php` (KTP section)
- `app/Http/Controllers/ProfileController.php` (handle upload/delete)
- `app/Http/Requests/ProfileUpdateRequest.php` (validation)

**Status:** ✅ DONE - Ready to test registration with KTP

---

## 🔄 **Phase 2: Staff Ban with KTP Display**

**Objective:** Allow staff to ban users + show KTP photo when banning

**Implementation:**
- Add ban permission check in staff middleware (only regular users, not staff/admin)
- Create ban modal component:
  - Display user KTP photo + number using KTP card component
  - Textarea for ban reason
  - Confirm/Cancel buttons
- Add "Ban User" button on:
  - Staff pending borrowings page
  - Staff approved borrowings page
- Update BorrowingController:
  - Add `banUser()` method with logic
  - Prevent login when banned (use isBanned() check)
  - Log action: activity_type='user_banned', metadata={reason, staff_id, ktp_held}
- Update staff views to show KTP card component
- Verify staff can't ban other staff or admins

**Files to Create:**
- `resources/views/components/ban-modal.blade.php` (reusable ban modal)

**Files to Update:**
- `app/Http/Controllers/Staff/BorrowingController.php` (add banUser method)
- `resources/views/staff/borrowings/index.blade.php` (pending - add ban button)
- `resources/views/staff/borrowings/approved.blade.php` (add ban button + KTP display)
- `app/Models/ActivityLog.php` (if needed - new activity type)

**Outcome:** Staff can ban users + users can't login if banned

---

## 📅 **Phase 3: Due Date System (Start/End Dates)**

**Objective:** Set return deadline when staff approves (1 day/week/month)

**Implementation:**
- Migration: Add columns to borrowings table:
  - `start_date` (TIMESTAMP - when approved)
  - `end_date` (TIMESTAMP - when must return)
  - `duration_type` (ENUM: '1_day', '1_week', '1_month')
  - `approved_at` (TIMESTAMP - approval time)
  - `approved_by` (BIGINT UNSIGNED - staff_id who approved)
- Borrowing model add methods:
  - `calculateEndDate($startDate, $durationType)` - Calculate based on duration
  - `isOverdue()` - Check if past end_date & not returned
  - `daysRemaining()` - Days until due_date
  - `getRemainingTime()` - Formatted string "5 hari, 3 jam"
- Update staff approve flow:
  - Show modal with 3 radio options:
    - 1 Hari (preview: Jan 27 14:00)
    - 1 Minggu (preview: Feb 2 14:00)
    - 1 Bulan (preview: Feb 26 14:00)
  - On submit: Set start_date=now(), end_date=calculated, duration_type=selected
- Save status as 'approved'

**Files to Create:**
- `database/migrations/2026_01_26_add_due_date_to_borrowings_table.php`

**Files to Update:**
- `app/Models/Borrowing.php` (add calculation methods)
- `app/Http/Controllers/Staff/BorrowingController.php` (update approve method)
- `resources/views/staff/borrowings/index.blade.php` (update approve modal)

**Outcome:** Staff can set borrow duration, system calculates due date

---

## 📝 **Phase 4: Return & Condition Form**

**Objective:** Staff records book condition on return + auto-adjust stock

**Implementation:**
- Create return condition modal:
  - Show: Book name, library, due date, actual return date
  - Radio buttons: Selamat / Rusak / Hilang
  - Textarea: Notes/damage description (optional)
  - Submit/Cancel buttons
- Update BorrowingController:
  - Add `receiveReturn()` method
  - Handle condition selection:
    - Selamat: No stock change
    - Rusak: Decrease stock by 1 + log reason
    - Hilang: Decrease stock by 1 + log reason
  - Set `condition` field (enum: selamat/rusak/hilang)
  - Set `returned_at` = now()
  - Set status = 'returned'
  - Log action with metadata (condition, damage notes)
- Update staff approved view:
  - Add "Terima Pengembalian" button (triggers modal)
  - Add "Ban User" button
  - Display due date + KTP card

**Files to Create:**
- `resources/views/components/return-modal.blade.php` (reusable modal)

**Files to Update:**
- `database/migrations/add_condition_returned_at_to_borrowings.php` (migration)
- `app/Models/Borrowing.php` (add condition & returned_at)
- `app/Http/Controllers/Staff/BorrowingController.php` (add receiveReturn)
- `resources/views/staff/borrowings/approved.blade.php` (add return button)

**Outcome:** Staff records return condition + stock auto-updates if damaged/lost

---

## 👤 **Phase 5: User-Facing Due Date Display**

**Objective:** Users see due date + countdown timer on borrowings

**Implementation:**
- Update user borrowing list (`GET /borrowings`):
  - Add columns: Book | Library | Status | Start | Due | Days Left
  - Show due date prominently: "Kembali: Feb 2, 14:00"
  - Display days remaining:
    - Green if > 3 days: "5 hari sisa"
    - Yellow if 1-3 days: "2 hari sisa"
    - Red if < 1 day: "12 jam sisa"
    - Red bold if overdue: "LEWAT 5 hari"
  - Add filter tabs: All / Active / Pending / Overdue
- Update borrowing card component:
  - Show timeline: Start → Due with visual bar
  - Show countdown: "5 hari sisa" with emoji
  - Color code based on urgency
- Add helper methods in Borrowing model:
  - `getStatusBadgeColor()` - Return color based on days remaining
  - `getFormattedDueDate()` - "Feb 2, 14:00" format
  - `getCountdownText()` - "5 hari sisa" or "12 jam sisa"

**Files to Create:**
- `resources/views/components/due-date-card.blade.php` (visual due date card)

**Files to Update:**
- `resources/views/borrowings/index.blade.php` (enhanced list with countdown)
- `app/Models/Borrowing.php` (add display helper methods)
- `app/Http/Controllers/BorrowingController.php` (add filters if needed)

**Outcome:** Users see clear due dates + countdown + overdue status

---

## 📊 **Phase 6: Activity Logging**

**Objective:** Log all actions (ban, approve, return, stock change) in activity_logs

**Implementation:**
- Update ActivityLog model if needed for new activity types:
  - `user_banned` - Staff banned a user
  - `borrow_approved` - Staff approved borrow with duration
  - `borrow_returned` - Staff received return with condition
  - `book_stock_adjusted` - Stock changed due to damage/loss
- Add logging calls to all controllers:
  - Staff approve: Log with metadata {duration_type, end_date, approved_by}
  - Staff return: Log with metadata {condition, damaged_notes}
  - Staff ban: Log with metadata {reason, ktp_held, staff_id}
  - Stock decrease: Log with metadata {old_stock, new_stock, reason}
- Ensure all activity logs include:
  - `user_id` - Who the action affects
  - `causer_id` - Who did the action (staff_id)
  - `activity_type` - Type of action
  - `metadata` - JSON with details

**Files to Update:**
- `app/Models/ActivityLog.php` (if adding new activity types)
- `app/Http/Controllers/Staff/BorrowingController.php` (add logging calls)
- All other controllers doing ban/approve/return actions

**Outcome:** Complete audit trail of all actions in activity_logs table

---

## 🧪 **Phase 7: Testing & Polish**

**Objective:** Full integration test + edge case handling + UI polish

**Testing:**
- **Happy path workflow:**
  1. User registers with KTP photo
  2. User borrows "Laskar Pelangi"
  3. Staff sees pending approval + KTP photo in modal
  4. Staff approves for "1 minggu"
  5. Borrowing shows start/end dates with countdown
  6. User sees "Due: Feb 2 (7 hari sisa)" on borrowing list
  7. Staff receives return, fills condition form (selamat)
  8. Borrowing marked as returned
  9. Activity log shows all actions

- **Edge cases:**
  - Month boundaries (Jan 26 + 1 month = Feb 26, not Jan 26 + 31 days)
  - Midnight calculations (14:00 + 1 day = 14:00 next day)
  - Leap years (Feb 29 handling)
  - Overdue calculations (past due_date)
  - Multiple users borrowing same book at different times

- **Error cases:**
  - Staff tries to ban another staff (should fail)
  - Invalid KTP number format (should reject at form)
  - File upload fails (should show error)
  - Stock goes negative (should prevent)

- **Performance:**
  - Eager load relationships (user, book, library, staff) in queries
  - Index database columns for filtering
  - Cache due date calculations if needed
  - Test with 1000+ borrowing records

- **UI Polish:**
  - Mobile responsive (all views work on phone/tablet)
  - Keyboard navigation (modals, buttons)
  - Loading spinners for long operations
  - Toast notifications for actions
  - Error messages clear & helpful (in Indonesian)

**Files to Update:**
- All files above - refinement & optimization
- CSS/views - Responsive design tweaks
- Tests - Unit & feature tests (optional)

**Outcome:** Fully working system, tested, polished, production-ready

---

## 📊 Progress Summary

| Phase | Status | Complexity | Est. Time |
|-------|--------|-----------|-----------|
| 1 | ✅ DONE | ⭐⭐ | 60 min |
| 2 | 🔄 NEXT | ⭐⭐⭐ | 45 min |
| 3 | ⏳ TODO | ⭐⭐⭐⭐ | 60 min |
| 4 | ⏳ TODO | ⭐⭐⭐ | 45 min |
| 5 | ⏳ TODO | ⭐⭐⭐ | 60 min |
| 6 | ⏳ TODO | ⭐⭐ | 45 min |
| 7 | ⏳ TODO | ⭐⭐⭐⭐ | 90 min |

**Total:** ~6.5 hours estimated

---

## 🎯 Next Action

Ready to start **Phase 2: Staff Ban with KTP Display**? 🚀
