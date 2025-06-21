
1. User Authentication Related Tables:
```bash
php artisan make:migration create_users_and_auth_tables --create=users,password_reset_tokens,personal_access_tokens
```

2. Job Processing Tables:
```bash
php artisan make:migration create_job_tables --create=jobs,failed_jobs
```

3. File Management Core Tables:
```bash
php artisan make:migration create_file_management_tables --create=files,file_shares,starred_files
```

4. File Storage Enhancement Tables (can be combined into one migration):
```bash
php artisan make:migration add_file_storage_enhancements --table=files
```

These commands will create migration files that you can then customize with the required schema. The last command combines the storage_path and uploaded_on_cloud additions into a single migration for better organization.

After creating these migrations, you can run them with:
```bash
php artisan migrate
```

To rollback these migrations if needed:
```bash
php artisan migrate:rollback
```
        
## Database Setup

Create models and migrations:
```bash
php artisan make:model Folder -m
php artisan make:model File -m
php artisan make:model Tag -m
php artisan make:migration create_file_tag_table
```

```bash
php artisan migrate
```

Install frontend dependencies:
```bash
npm install
npm run dev
```



To create these models using Laravel's Artisan command line tool, here are the commands:

1. Basic User model (with authentication):
```bash
php artisan make:model User -m
```

2. File model with migration:
```bash
php artisan make:model File -m
```

3. FileShare model with migration:
```bash
php artisan make:model FileShare -m
```

4. StarredFile model with migration:
```bash
php artisan make:model StarredFile -m
```

Command flag explanations:
- `-m` or `--migration`: Creates a migration file along with the model

Additional useful flags you can add:
- `-f` or `--factory`: Creates a factory for the model
- `-s` or `--seed`: Creates a seeder for the model
- `-c` or `--controller`: Creates a controller for the model
- `-r` or `--resource`: Creates a resource controller for the model

For example, to create a model with all related files:
```bash
php artisan make:model File -mfsc
```

This will create:
- The File model
- A migration file
- A factory file
- A seeder file
- A controller

All these files will be created in their respective directories within your Laravel project structure.
        