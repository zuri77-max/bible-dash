@echo off
echo ====================================
echo Bible API - Admin Setup Script
echo ====================================
echo.

echo Step 1: Running Shield Migrations...
php spark migrate --all
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Migrations failed! Please check your database configuration in .env
    pause
    exit /b 1
)
echo ✓ Migrations completed successfully
echo.

echo Step 2: Creating Admin User...
php spark db:seed AdminSeeder
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Seeder failed! Admin user may already exist.
    pause
    exit /b 1
)
echo ✓ Admin user created successfully
echo.

echo ====================================
echo Setup Complete! 🎉
echo ====================================
echo.
echo Default Admin Credentials:
echo Email: admin@bibleapi.com
echo Password: admin123
echo.
echo ⚠️  IMPORTANT: Change this password after first login!
echo.
echo Next Steps:
echo 1. Start your development server
echo 2. Visit: http://localhost:8080/login
echo 3. Login with the credentials above
echo.
echo For Magic Link login (passwordless):
echo - Configure email settings in your .env file
echo - See ADMIN_AUTH_SETUP.md for details
echo.
pause
