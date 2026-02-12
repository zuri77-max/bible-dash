# Bible API - Setup & Testing Guide

## 🎉 What's Been Implemented

Your CodeIgniter 4 Bible API is ready! All endpoints from your Postman collection have been implemented identically.

### ✅ API Endpoints Created:
1. `GET /api/v1/bibles` - List all Bibles
2. `GET /api/v1/bibles?language=English` - Filter by language
3. `GET /api/v1/bibles/languages` - Get available languages
4. `GET /api/v1/bibles/{id}` - Get single Bible
5. `GET /api/v1/bibles/check-updates?last_sync=2025-01-01T00:00:00Z` - Check updates
6. `GET /api/v1/bibles/{id}/file-info` - Get file info
7. `GET /api/v1/bibles/{id}/download` - Download Bible

### ✅ Auth Endpoints:
- `POST /api/auth/token` - Generate Bearer token
- `POST /api/auth/revoke` - Revoke token
- `GET /api/auth/me` - Get current user info

---

## 🚀 Setup Instructions

### Step 1: Create Bibles Table

Visit this URL in your browser:
```
http://bible-api.test/setup/bibles
```

You should see: "Bibles table created successfully!"

### Step 2: Seed Sample Bibles Data

Run this command:
```bash
php spark db:seed BibleSeeder
```

This adds 5 sample Bibles:
- King James Version (KJV) - English
- New International Version (NIV) - English
- English Standard Version (ESV) - English
- Reina Valera 1960 (RVR60) - Spanish
- Louis Segond (LSG) - French

### Step 3: Generate API Token

**Option A: Using cURL** (PowerShell):
```powershell
$body = @{
    email = "admin@bibleapi.com"
    password = "admin123"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "http://bible-api.test/api/auth/token" -Method Post -Body $body -ContentType "application/json"
$response | ConvertTo-Json
```

**Option B: Using Postman**:

1. Open Postman
2. Create new request: `POST http://bible-api.test/api/auth/token`
3. Body (JSON):
```json
{
    "email": "admin@bibleapi.com",
    "password": "admin123"
}
```
4. Send request
5. Copy the `token` from the response

**Response Example**:
```json
{
    "status": "success",
    "message": "Token generated successfully",
    "data": {
        "token": "your-bearer-token-here",
        "expires_at": "2027-02-12 18:30:00",
        "user": {
            "id": 1,
            "email": "admin@bibleapi.com",
            "username": "admin"
        }
    }
}
```

---

## 📱 Testing with Postman

### Import Your Collection

Your existing Postman collection will work with just one change:

1. Update the `base_url` variable to: `http://bible-api.test`
2. Update the `auth_token` variable with the token you generated

### Test All Endpoints:

#### 1. List All Bibles
```
GET http://bible-api.test/api/v1/bibles
Authorization: Bearer {your-token}
```

**Expected Response**:
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "name": "King James Version",
            "abbreviation": "KJV",
            "language": "English",
            "version": "1.0",
            ...
        }
    ],
    "count": 5
}
```

#### 2. Filter by Language
```
GET http://bible-api.test/api/v1/bibles?language=English
Authorization: Bearer {your-token}
```

#### 3. Get Languages
```
GET http://bible-api.test/api/v1/bibles/languages
Authorization: Bearer {your-token}
```

**Expected Response**:
```json
{
    "status": "success",
    "data": ["English", "French", "Spanish"],
    "count": 3
}
```

#### 4. Get Single Bible
```
GET http://bible-api.test/api/v1/bibles/1
Authorization: Bearer {your-token}
```

#### 5. Check Updates
```
GET http://bible-api.test/api/v1/bibles/check-updates?last_sync=2025-01-01T00:00:00Z
Authorization: Bearer {your-token}
```

**Expected Response**:
```json
{
    "status": "success",
    "data": [...],
    "count": 5,
    "has_updates": true
}
```

#### 6. Get File Info
```
GET http://bible-api.test/api/v1/bibles/1/file-info
Authorization: Bearer {your-token}
```

**Expected Response**:
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "King James Version",
        "abbreviation": "KJV",
        "language": "English",
        "version": "1.0",
        "file_size": 5242880,
        "file_mime_type": "application/x-sqlite3",
        "download_url": "http://bible-api.test/api/v1/bibles/1/download"
    }
}
```

---

## 🔧 Flutter App Integration

### Update Your Flutter App Base URL

In your Flutter app, update the API base URL:

```dart
// Before (Laravel)
const String baseUrl = 'http://your-laravel-api.com';

// After (CodeIgniter)
const String baseUrl = 'http://bible-api.test'; // Or your production URL
```

**That's it!** Your Flutter app should work without any changes because:
- ✅ All endpoints are identical (`/api/v1/bibles/*`)
- ✅ Bearer token authentication works the same way
- ✅ Response format matches Laravel's JSON structure
- ✅ Status codes are consistent

### Sample Flutter Code:

```dart
// Get token
final response = await http.post(
  Uri.parse('$baseUrl/api/auth/token'),
  body: json.encode({
    'email': 'admin@bibleapi.com',
    'password': 'admin123',
  }),
  headers: {'Content-Type': 'application/json'},
);

final token = json.decode(response.body)['data']['token'];

// Use token to get Bibles
final biblesResponse = await http.get(
  Uri.parse('$baseUrl/api/v1/bibles'),
  headers: {
    'Authorization': 'Bearer $token',
    'Accept': 'application/json',
  },
);

final bibles = json.decode(biblesResponse.body)['data'];
```

---

## 📁 File Structure

```
app/
├── Controllers/
│   └── Api/
│       ├── AuthController.php          # Token generation
│       └── V1/
│           └── BibleController.php     # All Bible endpoints
├── Models/
│   └── BibleModel.php                  # Bible database model
├── Database/
│   ├── Migrations/
│   │   └── CreateBiblesTable.php       # Bible table schema
│   └── Seeds/
│       └── BibleSeeder.php             # Sample data
└── Config/
    └── Routes.php                      # API routes defined
```

---

## 🎯 Quick Commands

```bash
# Generate new token (PowerShell)
curl -X POST http://bible-api.test/api/auth/token `
  -H "Content-Type: application/json" `
  -d "{\`"email\`":\`"admin@bibleapi.com\`",\`"password\`":\`"admin123\`"}"

# Test list Bibles
curl http://bible-api.test/api/v1/bibles `
  -H "Authorization: Bearer YOUR-TOKEN"

# Test get languages
curl http://bible-api.test/api/v1/bibles/languages `
  -H "Authorization: Bearer YOUR-TOKEN"
```

---

## ❓ Troubleshooting

### "Unauthorized" errors
- Make sure you're including the Bearer token
- Token might be expired - generate a new one
- Admin user must be logged in initially

### "Bible file not found" on download
- The sample data uses placeholder paths
- Create actual Bible files in `public/uploads/bibles/`
- Or update the `file_path` in database to point to real files

### CORS errors from Flutter
Add CORS headers in `app/Config/Filters.php`:
```php
public array $globals = [
    'before' => ['cors'],
];
```

---

## 🎊 You're Ready!

Your CodeIgniter 4 API is now fully compatible with your existing Postman collection and Flutter app. No changes needed to your Postman collection or Flutter code - just update the base URL!

**Test it now:**
1. Visit `http://bible-api.test/setup/bibles`
2. Run `php spark db:seed BibleSeeder`
3. Generate a token
4. Test in Postman!
5. Update Flutter app base URL
6. Your offline Bible app works! 🎉
