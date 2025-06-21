@echo off
echo Starting PaperVault server with 100MB upload limits...

REM Check if php.ini exists
if not exist "php.ini" (
    echo Error: php.ini file not found!
    pause
    exit /b 1
)

REM Start the server with custom PHP configuration
php -c php.ini -S localhost:8000 -t public

echo Server started at http://localhost:8000
echo Upload limits: 100MB per file
pause 