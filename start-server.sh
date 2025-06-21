#!/bin/bash

# Start Laravel development server with custom PHP configuration for document digitization
echo "Starting PaperVault server with 100MB upload limits..."

# Check if php.ini exists
if [ ! -f "php.ini" ]; then
    echo "Error: php.ini file not found!"
    exit 1
fi

# Start the server with custom PHP configuration
php -c php.ini -S localhost:8000 -t public

echo "Server started at http://localhost:8000"
echo "Upload limits: 100MB per file" 