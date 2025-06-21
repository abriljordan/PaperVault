# 📁 PaperVault

A modern, Google Drive-like file management system built with Laravel, Livewire, and Tailwind CSS. PaperVault provides a sleek, intuitive interface for organizing, uploading, and managing your digital files and folders.

![PaperVault](https://img.shields.io/badge/Laravel-12.x-red?style=for-the-badge&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-3.x-orange?style=for-the-badge)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css)

## ✨ Features

- **📂 File & Folder Management**: Create, organize, and manage files and folders with an intuitive interface
- **☁️ File Upload**: Drag-and-drop file upload with progress tracking
- **🔍 Search & Navigation**: Easy navigation through folder hierarchies with breadcrumbs
- **👥 User Authentication**: Secure user registration and login system
- **🎨 Modern UI**: Beautiful, responsive design inspired by Google Drive
- **⚡ Real-time Updates**: Livewire-powered real-time interactions without page refreshes
- **📱 Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **🔒 User Isolation**: Each user has their own private file space

## 🛠️ Tech Stack

### Backend
- **Laravel 12.x** - PHP framework for robust backend development
- **Livewire 3.x** - Full-stack framework for dynamic interfaces
- **MySQL/SQLite** - Database management
- **Laravel Breeze** - Authentication scaffolding

### Frontend
- **Tailwind CSS 4.x** - Utility-first CSS framework
- **Reka UI** - Modern UI component library
- **Vite** - Fast build tool and development server
- **Alpine.js** - Lightweight JavaScript framework (included with Livewire)

### Development Tools
- **Laravel Pint** - PHP code style fixer
- **ESLint & Prettier** - Code formatting and linting
- **PHPUnit** - Testing framework

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL, PostgreSQL, or SQLite

### Step 1: Clone the Repository
```bash
git clone https://github.com/yourusername/papervault.git
cd papervault
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Step 3: Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure Database
Edit your `.env` file and configure your database connection:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=papervault
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 5: Run Migrations
```bash
# Run database migrations
php artisan migrate

# (Optional) Seed with sample data
php artisan db:seed
```

### Step 6: Build Assets
```bash
# Build for development
npm run dev

# Or build for production
npm run build
```

### Step 7: Start the Server
```bash
# Start Laravel development server
php artisan serve

# Or use the combined dev script
composer run dev
```

Visit `http://localhost:8000` to access PaperVault!

## 📖 Usage

### Getting Started
1. **Register/Login**: Create an account or log in to access your file space
2. **Upload Files**: Use the "Upload Files" button or drag-and-drop files directly
3. **Create Folders**: Click "New" → "New Folder" to organize your files
4. **Navigate**: Click on folders to explore their contents
5. **Manage Files**: Use the file actions menu to delete, rename, or share files

### File Management
- **Upload**: Supported file types with automatic storage
- **Organize**: Create nested folder structures
- **Search**: Find files quickly with the search functionality
- **Share**: Share files with other users (coming soon)

## 🏗️ Project Structure

```
PaperVault/
├── app/
│   ├── Livewire/           # Livewire components
│   │   ├── FileManager.php # Main file management component
│   │   ├── FileActions.php # File operation actions
│   │   └── UploadFiles.php # File upload handling
│   ├── Models/             # Eloquent models
│   │   ├── File.php        # File model
│   │   ├── Folder.php      # Folder model
│   │   └── User.php        # User model
│   └── Http/Controllers/   # Traditional controllers
├── resources/
│   ├── views/
│   │   └── livewire/       # Livewire Blade views
│   └── css/                # Tailwind CSS styles
├── database/
│   └── migrations/         # Database migrations
└── routes/                 # Application routes
```

## 🔧 Configuration

### File Storage
Configure your file storage in `config/filesystems.php`:
```php
'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app'),
    ],
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
]
```

### Environment Variables
Key environment variables to configure:
```env
APP_NAME=PaperVault
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=papervault
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run tests with coverage
php artisan test --coverage
```

## 📝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation as needed
- Use conventional commit messages

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 Support

- **Issues**: [GitHub Issues](https://github.com/yourusername/papervault/issues)
- **Discussions**: [GitHub Discussions](https://github.com/yourusername/papervault/discussions)
- **Email**: support@papervault.com

## 🙏 Acknowledgments

- [Laravel](https://laravel.com/) - The PHP framework for web artisans
- [Livewire](https://laravel-livewire.com/) - Full-stack framework for Laravel
- [Tailwind CSS](https://tailwindcss.com/) - A utility-first CSS framework
- [Reka UI](https://reka-ui.com/) - Modern UI component library

---

**Made with ❤️ by the PaperVault Team**
