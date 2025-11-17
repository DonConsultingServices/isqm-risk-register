# Database Fix Instructions

Your MySQL database has corruption issues. Here are the steps to fix it:

## Option 1: Recreate Database (Recommended)

1. Open MySQL command line or phpMyAdmin
2. Run these commands:

```sql
DROP DATABASE IF EXISTS isqm;
CREATE DATABASE isqm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. Then run migrations:
```bash
cd isqmapp
php artisan migrate
```

## Option 2: Fix MySQL Installation

If you're using XAMPP, you may need to:
1. Stop MySQL service
2. Repair MySQL installation
3. Restart MySQL service

## Option 3: Manual Table Creation

If the above doesn't work, you can manually create the essential tables. The most important one for login is the `users` table.

## Quick Fix for Login

If you just need to login immediately, you can create a user manually in MySQL:

```sql
USE isqm;
CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'user',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create a test user (password: password123)
INSERT INTO users (name, email, password, role, created_at, updated_at) 
VALUES ('Admin User', 'admin@isqm.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW());
```

Then you can login with:
- Email: admin@isqm.com
- Password: password123
