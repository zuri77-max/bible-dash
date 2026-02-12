# Bible API - Admin Authentication Setup

## ✅ What's Configured

This setup includes:
- **CodeIgniter Shield** for authentication
- **Admin-only login** (no public registration)
- **Password login** and **Magic Link login** (passwordless)
- **Tailwind v4** styled login pages
- **Protected admin dashboard**

## 🚀 Setup Instructions

### 1. Configure Database

Update your `.env` file with database credentials:

```env
database.default.hostname = localhost
database.default.database = your_database_name
database.default.username = your_db_username
database.default.password = your_db_password
database.default.DBDriver = MySQLi
database.default.DBPrefix =
```

### 2. Run Shield Migrations

Install Shield database tables:

```bash
php spark migrate --all
```

This creates the necessary authentication tables.

### 3. Create Admin User

Run the admin seeder:

```bash
php spark db:seed AdminSeeder
```

**Default Admin Credentials:**
- Email: `admin@bibleapi.com`
- Password: `admin123`

⚠️ **IMPORTANT:** Change this password after first login!

### 4. Compile Tailwind CSS

Make sure your Tailwind styles are compiled:

```bash
npm install
npx tailwindcss -i ./public/css/input.css -o ./public/css/output.css --watch
```

Or for production:

```bash
npx tailwindcss -i ./public/css/input.css -o ./public/css/output.css --minify
```

### 5. Configure Email (for Magic Links)

Update `.env` with your email settings:

```env
email.fromEmail = noreply@yourdomain.com
email.fromName = Bible API Admin
email.SMTPHost = smtp.gmail.com
email.SMTPUser = your-email@gmail.com
email.SMTPPass = your-app-password
email.SMTPPort = 587
email.SMTPCrypto = tls
```

## 📱 How to Use

### Login with Password

1. Visit: `http://yourdomain.com/login`
2. Enter email and password
3. Click "Sign in"

### Login with Magic Link (Passwordless)

1. Visit: `http://yourdomain.com/login`
2. Click "Use a login link"
3. Enter your email
4. Check your inbox for the magic link
5. Click the link to login instantly

## 🔐 Features

### Admin Dashboard
- Access at: `/admin`
- Shows welcome message, stats, and quick actions
- Auto-redirects after login

### Security Features
- ✅ Only admin users can login
- ✅ Public registration disabled
- ✅ Session-based authentication
- ✅ Magic link expires in 1 hour
- ✅ Password validation
- ✅ CSRF protection ready

### User Groups
The system supports these groups (configured in AuthGroups.php):
- `admin` - Day to day administrators
- `superadmin` - Complete control

### Permissions
Admin users have:
- `admin.access` - Can access admin area
- `users.create` - Can create users
- `users.edit` - Can edit users

## 📁 File Structure

```
app/
├── Config/
│   ├── Auth.php              # Shield auth config
│   ├── AuthGroups.php        # User groups & permissions
│   ├── Filters.php           # Shield filters registered
│   └── Routes.php            # Protected admin routes
├── Controllers/
│   └── Admin/
│       └── Dashboard.php     # Admin dashboard controller
├── Database/
│   └── Seeds/
│       └── AdminSeeder.php   # Creates admin user
└── Views/
    ├── auth/
    │   ├── layout.php            # Auth page layout
    │   ├── login.php             # Login form
    │   ├── magic_link.php        # Magic link request form
    │   └── magic_link_message.php # Success message
    └── admin/
        ├── layout.php            # Admin panel layout
        ├── dashboard.php         # Dashboard view
        └── partials/
            └── navbar.php        # Admin navigation
```

## 🎨 Customization

### Change Admin Email/Password

Edit `app/Database/Seeds/AdminSeeder.php`:

```php
$user = new User([
    'username' => 'admin',
    'email'    => 'your-email@example.com',  // Change this
    'password' => 'your-secure-password',     // Change this
]);
```

Then run: `php spark db:seed AdminSeeder`

### Add More Admin Users

You can create a new seeder or use the same AdminSeeder with different emails.

### Customize Redirects

Edit `app/Config/Auth.php`:

```php
public array $redirects = [
    'login'  => '/admin',  // Where to go after login
    'logout' => 'login',   // Where to go after logout
];
```

### Customize Email Template

The magic link email template is at:
`vendor/codeigniter4/shield/src/Views/Email/magic_link_email.php`

You can override it by creating:
`app/Views/Email/magic_link_email.php`

## 🔍 Testing

1. **Test Login:**
   - Go to `/login`
   - Use: admin@bibleapi.com / admin123
   - Should redirect to `/admin`

2. **Test Magic Link:**
   - Go to `/login`
   - Click "Use a login link"
   - Enter admin email
   - Check email for link

3. **Test Protection:**
   - Logout
   - Visit `/admin` directly
   - Should redirect to login

## ❓ Troubleshooting

### "Table 'users' doesn't exist"
Run migrations: `php spark migrate --all`

### "Call to undefined function auth()"
Shield not installed. Run: `composer require codeigniter4/shield`

### Magic link emails not sending
1. Check `.env` email settings
2. Enable email debugging in `app/Config/Email.php`
3. Check writable/logs for errors

### CSS not loading
1. Compile Tailwind: `npx tailwindcss -i ./public/css/input.css -o ./public/css/output.css`
2. Check file exists: `public/css/output.css`

### Can't access admin dashboard
1. Check user is in 'admin' group
2. Verify routes in `app/Config/Routes.php`
3. Check filters are registered in `app/Config/Filters.php`

## 🔗 Useful Commands

```bash
# Run migrations
php spark migrate --all

# Create admin user
php spark db:seed AdminSeeder

# Create new user programmatically
php spark shield:user create

# Add user to group
php spark shield:user addgroup <email> admin

# List all users
php spark shield:user list

# Rollback migrations (careful!)
php spark migrate:rollback

# Clear cache
php spark cache:clear
```

## 📚 Resources

- [Shield Documentation](https://shield.codeigniter.com/)
- [CodeIgniter 4 Docs](https://codeigniter.com/user_guide/)
- [Tailwind CSS](https://tailwindcss.com/)

---

**Ready to go!** 🎉

Login at: `http://yourdomain.com/login`
