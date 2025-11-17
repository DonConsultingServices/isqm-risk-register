<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $dbName = DB::connection()->getDatabaseName();
    echo "Creating essential tables in database: $dbName\n\n";
    
    // Create users table
    echo "Creating users table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `users` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
            `password` VARCHAR(255) NOT NULL,
            `role` VARCHAR(50) DEFAULT 'user',
            `remember_token` VARCHAR(100) NULL DEFAULT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `users_email_unique` (`email`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Users table created\n";
    
    // Create password_reset_tokens table
    echo "Creating password_reset_tokens table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
            `email` VARCHAR(191) NOT NULL,
            `token` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`email`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Password reset tokens table created\n";
    
    // Create sessions table
    echo "Creating sessions table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `sessions` (
            `id` VARCHAR(191) NOT NULL,
            `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
            `ip_address` VARCHAR(45) NULL DEFAULT NULL,
            `user_agent` TEXT NULL DEFAULT NULL,
            `payload` LONGTEXT NOT NULL,
            `last_activity` INT NOT NULL,
            PRIMARY KEY (`id`),
            KEY `sessions_user_id_index` (`user_id`),
            KEY `sessions_last_activity_index` (`last_activity`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Sessions table created\n";
    
    // Create settings table
    echo "Creating settings table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `settings` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `key` VARCHAR(255) NOT NULL,
            `value` TEXT NULL DEFAULT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `settings_key_unique` (`key`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Settings table created\n";
    
    // Create a default admin user if none exists
    $userCount = DB::table('users')->count();
    if ($userCount == 0) {
        echo "\nCreating default admin user...\n";
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@isqm.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✓ Default admin user created\n";
        echo "  Email: admin@isqm.com\n";
        echo "  Password: admin123\n";
    } else {
        echo "\nUsers table already has $userCount user(s)\n";
    }
    
    echo "\n✅ Essential tables created! You can now try logging in.\n";
    echo "\nNote: You may still need to run full migrations for other features.\n";
    echo "Run: php artisan migrate\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nThe MySQL database may be corrupted. Please:\n";
    echo "1. Open phpMyAdmin or MySQL command line\n";
    echo "2. Run: DROP DATABASE IF EXISTS isqm;\n";
    echo "3. Run: CREATE DATABASE isqm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
    echo "4. Then run: php artisan migrate\n";
    exit(1);
}
