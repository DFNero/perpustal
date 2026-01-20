# Admin City Management - Setup Instructions

## ✅ What Has Been Completed

### 1. Database Layer
- ✅ **City Model** created at `app/Models/City.php`
  - Fillable: name, latitude, longitude
  - Casts: latitude and longitude as decimal:8
  - Relationship: `users()` - returns users from this city

- ✅ **Cities Table Migration** created at `database/migrations/2026_01_20_120001_create_cities_table.php`
  - Columns: id, name (unique), latitude (decimal 10,8), longitude (decimal 11,8), timestamps
  - Status: Created, ready to migrate

- ✅ **Add Location to Users Migration** created at `database/migrations/2026_01_20_120000_add_location_to_users_table.php`
  - Adds: latitude, longitude columns to users table
  - Status: Created, ready to migrate

### 2. Backend (Controllers & Logic)
- ✅ **Admin CityController** (`app/Http/Controllers/Admin/CityController.php`)
  - Methods: index, create, store, edit, update, destroy
  - Validation: name unique, latitude -90 to 90, longitude -180 to 180
  - Safety: Prevents deletion if cities in use by users
  - User count: Uses `withCount('users')` for efficiency

- ✅ **LocationHelper** (`app/Helpers/LocationHelper.php`)
  - Methods: getCitiesForDropdown(), getCoordinatesByCity($cityId)
  - Now queries City model from database instead of hardcoded data

- ✅ **RegisteredUserController** (`app/Http/Controllers/Auth/RegisteredUserController.php`)
  - Enhanced with city selection during registration
  - Validates city exists in database
  - Stores user with latitude/longitude from selected city

### 3. Frontend (Views)
- ✅ **Admin Cities Index** (`resources/views/admin/cities/index.blade.php`)
  - Lists all cities with: name, latitude, longitude, user count, actions
  - Add button to create new city
  - Edit/Delete buttons for each city
  - Flash messages for success/error

- ✅ **Admin Cities Create** (`resources/views/admin/cities/create.blade.php`)
  - Form fields: name, latitude, longitude
  - Validation error display
  - Help text explaining coordinate format
  - Submit and cancel buttons

- ✅ **Admin Cities Edit** (`resources/views/admin/cities/edit.blade.php`)
  - Same as create but pre-populated with city data
  - Submit button for updates

- ✅ **Registration Form** (`resources/views/auth/register.blade.php`)
  - City/Kabupaten dropdown selector
  - Populated from database cities via LocationHelper

### 4. Routes
- ✅ **Admin City Routes** added to `routes/web.php`
  - GET /admin/cities - index
  - GET /admin/cities/create - create
  - POST /admin/cities - store
  - GET /admin/cities/{city}/edit - edit
  - PUT /admin/cities/{city} - update
  - DELETE /admin/cities/{city} - destroy

### 5. Navigation
- ✅ **Admin Sidebar Navigation** updated (`resources/views/layouts/navigation-admin.blade.php`)
  - Added "🗺️ Kota/Kabupaten" link to admin sidebar
  - Link highlights when on admin.cities.* routes

### 6. Data
- ✅ **CitySeeder** created at `database/seeders/CitySeeder.php`
  - Initial 8 cities for Java Timur region:
    - Surabaya: -7.2575, 112.7521
    - Sidoarjo: -7.4424, 112.7103
    - Gresik: -7.1620, 112.6670
    - Mojokerto: -7.4794, 112.4309
    - Lamongan: -6.8839, 112.2216
    - Bangkalan: -7.0452, 112.7457
    - Pamekasan: -7.1904, 113.4827
    - Sumenep: -7.0222, 113.8589

---

## ⏳ What's Next - Setup Steps for User

### Step 1: Run Migrations
```bash
php artisan migrate
```
This will create the cities table and add location columns to users table.

### Step 2: Seed Initial Cities
```bash
php artisan db:seed --class=CitySeeder
```
This will populate the database with the 8 initial cities for the East Java region.

### Step 3: Test the System
1. Go to `/admin/cities` - you should see the 8 seeded cities
2. Try creating a new city
3. Try editing a city
4. Register a new user - you should see all cities in the dropdown
5. After registering, user should be assigned latitude/longitude based on selected city

---

## 📝 Feature Overview

### For Admins
- **Manage Cities**: Add, edit, view, and delete cities
- **User Tracking**: See how many users are from each city
- **Safe Deletion**: Cannot delete a city if users are still using it
- **Easy Navigation**: Access via admin sidebar

### For Users
- **Choose City**: Select their city/kabupaten during registration
- **Location Assigned**: Automatically get coordinates assigned based on city selection
- **Not Hardcoded**: Cities are flexible and can be added/removed by admin

### Database Structure
- **Cities Table**:
  - id: auto increment
  - name: unique string (e.g., "Surabaya")
  - latitude: decimal with 8 decimal places
  - longitude: decimal with 8 decimal places
  - timestamps: created_at, updated_at

- **Users Table Addition**:
  - latitude: nullable decimal (stores user's city latitude)
  - longitude: nullable decimal (stores user's city longitude)

---

## 🎯 Next Phase (After Setup)

Once this is running, the next phase will be:
- **Nearest Library Calculation**: Show users the nearest libraries based on their city location
- **Location-Based Recommendations**: Suggest libraries closest to user's coordinates

---

## ✨ Key Files Created

1. `app/Models/City.php` - City model with relationships
2. `database/migrations/2026_01_20_120001_create_cities_table.php` - Cities table
3. `database/migrations/2026_01_20_120000_add_location_to_users_table.php` - User location columns
4. `app/Http/Controllers/Admin/CityController.php` - CRUD controller
5. `database/seeders/CitySeeder.php` - Initial city data
6. `resources/views/admin/cities/index.blade.php` - City list view
7. `resources/views/admin/cities/create.blade.php` - Create city view
8. `resources/views/admin/cities/edit.blade.php` - Edit city view

## ✨ Key Files Modified

1. `routes/web.php` - Added city routes and import
2. `app/Helpers/LocationHelper.php` - Refactored to use database queries
3. `app/Http/Controllers/Auth/RegisteredUserController.php` - Added city selection logic
4. `resources/views/auth/register.blade.php` - Added city dropdown
5. `app/Models/User.php` - Added latitude, longitude to fillable
6. `resources/views/layouts/navigation-admin.blade.php` - Added sidebar link
