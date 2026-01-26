# Teacher Revisions - Jan 26, 2026

## 🎯 3 Major Revisions

---

## 1️⃣ STAFF BAN USERS (Currently Admin Only)

**Current State:** Only admin can ban users  
**Required Change:** Staff should also have permission to ban users  

**What needs to change:**
- Update staff borrowing controller to add ban functionality
- Add ban button on staff pending/approved borrowing pages
- Ensure activity logs track staff ban actions
- Verify staff can't ban other staff or admins

**No DB changes needed** - uses existing ban/users table structure

---

## 2️⃣ KTP (ID CARD) REQUIREMENT & COLLATERAL SYSTEM

**Current State:** 
- No KTP verification
- Ban only needs reason text (user might think it's just online library ban)

**Required Change:**
- Make KTP **REQUIRED** during registration
- Store KTP number + KTP photo (as collateral/"jaminan")
- When banning user, HOLD their KTP as guarantee
- Display KTP info/photo when viewing ban record

**Why KTP instead of fine/denda?** 
User wants to redeem their KTP → must comply with rules → creates accountability

**Database Changes Needed:**
```sql
ALTER TABLE users ADD COLUMN ktp_number VARCHAR(16) UNIQUE NOT NULL;
ALTER TABLE users ADD COLUMN ktp_photo_path VARCHAR(255);
```

**Files to Create/Update:**
1. **Migration:** `2026_01_26_add_ktp_to_users_table.php`
2. **User Model:** Add `ktp_number`, `ktp_photo_path` to fillable
3. **Registration Form:** Add KTP number input + photo upload
4. **User Profile View:** Show KTP info, allow re-upload
5. **Ban Modal:** Show KTP photo before confirming ban
6. **Activity Log:** Track "ktp_held" action

---

## 3️⃣ BORROWING RETURN DATE & DURATION SELECTION

**Current State:** 
- Approval just marks as `approved`
- No tracking of when book should be returned
- Staff can't set return duration

**Required Change:**
When staff APPROVES a borrow request:
1. Show modal with 3 duration options:
   - **1 Hari** (1 day) → due_date = tomorrow
   - **1 Minggu** (1 week) → due_date = next week
   - **1 Bulan** (1 month) → due_date = next month
2. Calculate & save `due_date` to borrowing record
3. Display `due_date` on approved borrowings page
4. Show "Days Remaining" indicator
5. Flag overdue books in red if past due_date

**Example Flow:**
```
Jan 26: User borrows "Laskar Pelangi"
↓
Staff clicks "Approve"
↓
Modal: "Durasi Peminjaman?" with options:
  ○ 1 Hari (Kembali: Jan 27)
  ○ 1 Minggu (Kembali: Feb 2)
  ○ 1 Bulan (Kembali: Feb 26)
↓
Staff selects "1 Minggu" → Confirm
↓
Borrowing saved with due_date: Feb 2
↓
Approved page shows: "Laskar Pelangi | Due: Feb 2 (7 days)"
```

**Database Changes Needed:**
```sql
ALTER TABLE borrowings ADD COLUMN start_date TIMESTAMP NULL; -- When approved
ALTER TABLE borrowings ADD COLUMN end_date TIMESTAMP NULL; -- When must return
ALTER TABLE borrowings ADD COLUMN duration_type ENUM('1_day', '1_week', '1_month') NULL;
ALTER TABLE borrowings ADD COLUMN approved_at TIMESTAMP NULL;
ALTER TABLE borrowings ADD COLUMN approved_by BIGINT UNSIGNED NULL;
ALTER TABLE borrowings ADD COLUMN condition ENUM('selamat', 'rusak', 'hilang') NULL; -- When returned
ALTER TABLE borrowings ADD COLUMN returned_at TIMESTAMP NULL;
ALTER TABLE borrowings ADD COLUMN is_overdue BOOLEAN DEFAULT 0;
-- Add foreign key for approved_by to users table
```

**New Fields Explained:**
- `start_date` → When staff approved (approval time)
- `end_date` → When book must be returned (calculated from duration)
- `duration_type` → Which option was selected (1_day/1_week/1_month)
- `approved_by` → Which staff approved it
- `condition` → Filled when returning (selamat/rusak/hilang)
- `returned_at` → When actually returned
- `is_overdue` → Flag for quick overdue lookup

**Files to Create/Update:**
1. **Migration:** `2026_01_26_add_due_date_to_borrowings_table.php`
2. **Borrowing Model:** 
   - Add `due_date`, `duration_type` to fillable
   - Add method `isOverdue()` → returns true if due_date < now() & not returned
   - Add method `daysRemaining()` → calculates days until due
3. **Staff Approve Modal:** Add duration radio buttons + calculate due_date
4. **Staff Approved View:** Display due_date & days remaining
5. **User Borrowing Card:** Show due_date & status
6. **Helper/Service:** Calculate due_date based on duration_type

---

## 📋 IMPLEMENTATION PLAN (REVISED)

### **Phase 1: KTP Integration** 
- [ ] Create migration: add `ktp_number` (unique), `ktp_photo_path` to users
- [ ] Update User model: add fillable + KTP accessor methods
- [ ] Update RegisteredUserController: handle KTP image upload to public storage
- [ ] Update registration form: add KTP inputs (number + file upload)
- [ ] Update user profile view: show KTP info, allow re-upload
- [ ] Add KTP display component: reusable card showing KTP number + photo
- [ ] Test: register user with KTP → verify stored in public storage

### **Phase 2: Staff Ban with KTP Display**
- [ ] Add ban logic to staff borrowing controller (prevent login)
- [ ] Update staff borrowing view: add "Ban User" button on pending page
- [ ] Create ban modal: show user KTP photo + confirm reason
- [ ] Log action: track staff ban in activity_logs
- [ ] Test: staff bans user → KTP shown → user can't login

### **Phase 3: Due Date System (Start/End Dates)**
- [ ] Create migration: add `start_date`, `end_date`, `duration_type`, `approved_at`, `approved_by`, `condition`, `returned_at`, `is_overdue`
- [ ] Update Borrowing model:
  - [ ] Add methods: `isOverdue()`, `daysRemaining()`, `getRemainingTime()`
  - [ ] Add calculation: $end_date = $start_date + duration
  - [ ] Format helper: display "Kembali: Feb 2, 14:00 (7 hari sisa)"
- [ ] Update staff approve modal:
  - [ ] Show duration selector (1 hari/minggu/bulan)
  - [ ] Calculate end_date in real-time as preview
  - [ ] On confirm, save start_date (now), end_date (calculated)
- [ ] Update staff approved view:
  - [ ] Show KTP photo (use component from Phase 1)
  - [ ] Show book details + borrowing info
  - [ ] Display end_date with countdown: "Kembali: Feb 2 (5 hari sisa)"
  - [ ] Add "Terima Pengembalian" button with condition form

### **Phase 4: Return & Condition Form**
- [ ] Create return form modal with:
  - [ ] Radio buttons: Selamat / Rusak / Hilang
  - [ ] Textarea: notes/damage description (optional)
  - [ ] Submit button
- [ ] Update staff controller:
  - [ ] Save condition to borrowing
  - [ ] If rusak/hilang: decrease library.book stock
  - [ ] Set returned_at timestamp
  - [ ] Log action in activity_logs
- [ ] Update borrowing status: mark as "returned"
- [ ] Verify stock updates correctly

### **Phase 5: User-Facing Due Date Display**
- [ ] Update user borrowing list page (`/borrowings`):
  - [ ] Add columns: Book, Library, Status, Start Date, End Date, Days Left
  - [ ] Show end_date prominently: "Due: Feb 2, 14:00"
  - [ ] Show days remaining: "5 hari sisa" (green if > 3 days, red if < 3)
  - [ ] Add countdown: days + hours if < 1 day
  - [ ] Show overdue indicator (red badge "LEWAT") if past end_date
- [ ] Update borrowing card component:
  - [ ] Show start_date → end_date as timeline
  - [ ] Show remaining time as countdown timer

### **Phase 6: Activity Logging**
- [ ] Log all new actions:
  - [ ] staff approved with duration
  - [ ] user received approval with due date
  - [ ] user returned book with condition
  - [ ] staff marked as overdue (if applicable)
  - [ ] stock decreased (if damaged/lost)

### **Phase 7: Testing & Polish**
- [ ] Full workflow test:
  - [ ] User registers with KTP
  - [ ] User borrows book
  - [ ] Staff approves with 1 minggu duration
  - [ ] User sees "Due: Feb 2, 14:00 (7 days left)"
  - [ ] Staff can view KTP photo in pending + approved
  - [ ] Staff receives return with condition form
  - [ ] If rusak: stock decreases automatically
- [ ] Edge cases:
  - [ ] Midnight/timezone handling
  - [ ] Month boundaries (Jan 26 + 1 month = Feb 26)
  - [ ] Leap year handling
- [ ] Responsive design
- [ ] Activity log verification

---

## ❓ CLARIFICATION QUESTIONS FOR YOU

### **Q1: KTP Photo Handling** ✅ ANSWERED
- **Storage:** Public storage (`storage/app/public`)
- **Access:** Staff can view KTP photos in BOTH:
  - Pending borrowings list
  - Approved borrowings list
- **Note:** Simulation - can use random placeholder images

### **Q2: Ban System Details** ✅ ANSWERED
- **Ban Effect:** Same as admin - user CANNOT login
- **No duration** - ban stays until admin/staff manually removes it

### **Q3: Overdue & Damage Handling** ✅ ANSWERED
- **Denda (Fine):** Can be deducted from KTP collateral (simulation)
- **Condition Form:** Staff must fill in approved borrowing:
  - Radio: ✓ Barang Selamat (Safe/Good condition)
  - Radio: ✗ Barang Rusak (Damaged)
  - Radio: ✗ Barang Hilang (Lost)
- **Stock Impact:**
  - If rusak/hilang → decrease library book stock
  - If selamat → normal, stock unchanged

### **Q4: Due Date Display** ✅ ANSWERED
- **Show:** Both days remaining AND full timestamp
- **Display Location:**
  - Staff approved page: show due timestamp + days left
  - User borrowing list: show due timestamp + countdown + days left
  - Must be prominent (red if < 3 days remaining)

### **Q5: Duration Calculation** ✅ ANSWERED
- **Method:** Calendar-based with time
- **Store:** Both `start_date` (approval time) & `end_date` (due date)
- **Examples:**
  - 1 Hari: Jan 26 14:00 → Jan 27 14:00
  - 1 Minggu: Jan 26 14:00 → Feb 2 14:00
  - 1 Bulan: Jan 26 14:00 → Feb 26 14:00

---

## 📝 DETAILED REQUIREMENTS

### **KTP System**
- Public storage path: `storage/app/public/ktp-photos/`
- Staff can view KTP in:
  - Pending approvals page (before approve)
  - Approved borrowings page (after approve)
- Display: KTP number + photo in modal/card

### **Return Condition Form (Staff)**
When staff clicks "Terima Pengembalian" on approved borrowing:
```
Modal: Kondisi Pengembalian Buku
┌─────────────────────────────────┐
│ Buku: Laskar Pelangi            │
│ Library: Perpustal Pusat         │
│ Due: Feb 2, 14:00               │
│ Dikembalikan: Jan 27, 10:00     │
│                                  │
│ Kondisi Barang:                 │
│ ○ Selamat (Baik)               │
│ ○ Rusak                         │
│ ○ Hilang                        │
│                                  │
│ Keterangan:                      │
│ [________________]              │
│                                  │
│ [Batalkan] [Terima]             │
└─────────────────────────────────┘
```

**Actions Based on Selection:**
- **Selamat:** Save condition, mark returned, no stock change
- **Rusak:** Save condition, decrease stock by 1, mark returned
- **Hilang:** Save condition, decrease stock by 1, mark returned

### **User Borrowing List Display**
```
Peminjaman Saya

[Status Filter: All / Active / Pending / Overdue]

┌─────────────────────────────────────────────────────┐
│ Buku: Laskar Pelangi                                │
│ Perpustal: Perpustal Pusat                          │
│ Status: Approved (selamat dikembalikan)             │
│                                                      │
│ Mulai: 26 Jan, 14:00 | Kembali: 02 Feb, 14:00     │
│ Sisa: 5 hari, 23 jam 45 menit (GREEN)              │
│                                                      │
│ [Lihat Detail]                                      │
└─────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────┐
│ Buku: Filosofi Jawa                                 │
│ Perpustal: Perpustal Cabang                         │
│ Status: Pending (Menunggu Persetujuan)              │
│ Requested: 25 Jan, 11:00                            │
│                                                      │
│ [Batalkan]                                          │
└─────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────┐
│ Buku: Parang Kusuma                                 │
│ Perpustal: Perpustal Pusat                          │
│ Status: LEWAT (RED) | Harusnya: 20 Jan              │
│                                                      │
│ Mulai: 13 Jan, 14:00 | Harusnya: 20 Jan, 14:00    │
│ TUNGGAKAN: 6 hari (RED WARNING)                     │
│                                                      │
│ [Kembalikan Segera]                                 │
└─────────────────────────────────────────────────────┘
```

### **Staff Approved Borrowings Display**
```
Peminjaman Disetujui

┌─────────────────────────────────────────────────────┐
│ User: Ahmad Rizki | KTP: [Foto KTP]                │
│ Buku: Laskar Pelangi                                │
│ Perpustal: Perpustal Pusat                          │
│                                                      │
│ Status: Approved                                    │
│ Mulai: 26 Jan, 14:00 | Kembali: 02 Feb, 14:00     │
│ Sisa: 5 hari, 23 jam 45 menit                       │
│                                                      │
│ [Lihat KTP] [Terima Pengembalian] [Ban User]       │
└─────────────────────────────────────────────────────┘
```

---

## ✅ CHECKLIST

**Before Starting Code:**
- [x] Clarifications answered
- [x] Database schema finalized
- [x] UI/UX mocked out
- [x] Implementation phases defined

**Ready to Start:** Phase 1 - KTP Integration

