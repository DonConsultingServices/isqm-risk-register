<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $dbName = DB::connection()->getDatabaseName();
    echo "Creating dashboard tables in database: $dbName\n\n";
    
    // Create categories table
    echo "Creating categories table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `categories` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `slug` VARCHAR(255) NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT NULL DEFAULT NULL,
            `order` INT DEFAULT 0,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `categories_slug_unique` (`slug`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Categories table created\n";
    
    // Create monitoring_activities table
    echo "Creating monitoring_activities table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `monitoring_activities` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `description` TEXT NULL DEFAULT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `monitoring_activities_name_unique` (`name`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Monitoring activities table created\n";
    
    // Create deficiency_types table
    echo "Creating deficiency_types table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `deficiency_types` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `description` TEXT NULL DEFAULT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `deficiency_types_name_unique` (`name`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Deficiency types table created\n";
    
    // Create clients table
    echo "Creating clients table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `clients` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `industry` VARCHAR(255) NULL DEFAULT NULL,
            `email` VARCHAR(255) NULL DEFAULT NULL,
            `phone` VARCHAR(255) NULL DEFAULT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Clients table created\n";
    
    // Create modules table
    echo "Creating modules table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `modules` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `slug` VARCHAR(255) NOT NULL,
            `name` VARCHAR(255) NOT NULL,
            `quality_objective` TEXT NULL DEFAULT NULL,
            `description` TEXT NULL DEFAULT NULL,
            `order` INT DEFAULT 0,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `modules_slug_unique` (`slug`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Modules table created\n";
    
    // Create notifications table
    echo "Creating notifications table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `notifications` (
            `id` CHAR(36) NOT NULL,
            `type` VARCHAR(191) NOT NULL,
            `notifiable_type` VARCHAR(191) NOT NULL,
            `notifiable_id` BIGINT UNSIGNED NOT NULL,
            `data` TEXT NOT NULL,
            `read_at` TIMESTAMP NULL DEFAULT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`(100), `notifiable_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Notifications table created\n";
    
    // Create activity_logs table
    echo "Creating activity_logs table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `activity_logs` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_id` BIGINT UNSIGNED NULL DEFAULT NULL,
            `model_type` VARCHAR(191) NULL DEFAULT NULL,
            `model_id` BIGINT UNSIGNED NULL DEFAULT NULL,
            `action` VARCHAR(255) NOT NULL,
            `description` TEXT NULL DEFAULT NULL,
            `changes` TEXT NULL DEFAULT NULL,
            `ip_address` VARCHAR(45) NULL DEFAULT NULL,
            `user_agent` TEXT NULL DEFAULT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `activity_logs_user_id_index` (`user_id`),
            KEY `activity_logs_model_type_model_id_index` (`model_type`(100), `model_id`),
            KEY `activity_logs_action_index` (`action`(100))
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Activity logs table created\n";
    
    // Create attachments table
    echo "Creating attachments table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `attachments` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `isqm_entry_id` BIGINT UNSIGNED NULL DEFAULT NULL,
            `path` VARCHAR(255) NOT NULL,
            `filename` VARCHAR(255) NOT NULL,
            `size` BIGINT UNSIGNED NULL DEFAULT NULL,
            `mime_type` VARCHAR(255) NULL DEFAULT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `attachments_isqm_entry_id_index` (`isqm_entry_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ Attachments table created\n";
    
    // Create isqm_entries table
    echo "Creating isqm_entries table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS `isqm_entries` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(255) NULL DEFAULT NULL,
            `area` ENUM('governance_and_leadership', 'ethical_requirements', 'acceptance_and_continuance', 'engagement_performance', 'resources', 'information_and_communication') NULL DEFAULT NULL,
            `category_id` BIGINT UNSIGNED NULL DEFAULT NULL,
            `module_id` BIGINT UNSIGNED NULL DEFAULT NULL,
            `quality_objective` TEXT NULL DEFAULT NULL,
            `quality_risk` TEXT NULL DEFAULT NULL,
            `assessment_of_risk` TEXT NULL DEFAULT NULL,
            `likelihood` TINYINT(1) NULL DEFAULT NULL,
            `response` TEXT NULL DEFAULT NULL,
            `firm_implementation` TEXT NULL DEFAULT NULL,
            `toc` TEXT NULL DEFAULT NULL,
            `monitoring_activity_id` BIGINT UNSIGNED NULL DEFAULT NULL,
            `findings` TEXT NULL DEFAULT NULL,
            `deficiency_type_id` BIGINT UNSIGNED NULL DEFAULT NULL,
            `root_cause` TEXT NULL DEFAULT NULL,
            `severe` TINYINT(1) NULL DEFAULT NULL,
            `pervasive` TINYINT(1) NULL DEFAULT NULL,
            `adverse_effect` TINYINT(1) NULL DEFAULT NULL,
            `risk_applicable` TINYINT(1) NULL DEFAULT NULL,
            `risk_applicable_details` TEXT NULL DEFAULT NULL,
            `objective_met` TINYINT(1) NULL DEFAULT NULL,
            `remedial_actions` TEXT NULL DEFAULT NULL,
            `remedial_owner_id` BIGINT UNSIGNED NULL DEFAULT NULL,
            `remedial_target_date` DATE NULL DEFAULT NULL,
            `remedial_completed_at` DATETIME NULL DEFAULT NULL,
            `entity_level` TINYINT(1) NULL DEFAULT NULL,
            `engagement_level` TINYINT(1) NULL DEFAULT NULL,
            `status` ENUM('open', 'monitoring', 'closed') DEFAULT 'open',
            `implementation_status` VARCHAR(255) NULL DEFAULT NULL,
            `owner_id` BIGINT UNSIGNED NULL DEFAULT NULL,
            `client_id` BIGINT UNSIGNED NULL DEFAULT NULL,
            `due_date` DATE NULL DEFAULT NULL,
            `review_date` DATE NULL DEFAULT NULL,
            `import_source` VARCHAR(255) NULL DEFAULT NULL,
            `created_by` BIGINT UNSIGNED NULL DEFAULT NULL,
            `updated_by` BIGINT UNSIGNED NULL DEFAULT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            `deleted_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `isqm_entries_area_index` (`area`),
            KEY `isqm_entries_category_id_index` (`category_id`),
            KEY `isqm_entries_module_id_index` (`module_id`),
            KEY `isqm_entries_status_index` (`status`),
            KEY `isqm_entries_deleted_at_index` (`deleted_at`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✓ ISQM entries table created\n";
    
    // Seed categories
    echo "\nSeeding categories...\n";
    $categories = [
        ['slug' => 'governance-and-leadership', 'title' => 'Governance and leadership', 'description' => null, 'order' => 1],
        ['slug' => 'ethical-requirements', 'title' => 'Ethical requirements', 'description' => null, 'order' => 2],
        ['slug' => 'acceptance-and-continuance', 'title' => 'Acceptance and continuance', 'description' => null, 'order' => 3],
        ['slug' => 'engagement-performance', 'title' => 'Engagement performance', 'description' => null, 'order' => 4],
        ['slug' => 'resources', 'title' => 'Resources', 'description' => null, 'order' => 5],
        ['slug' => 'information-and-communication', 'title' => 'Information and communication', 'description' => null, 'order' => 6],
    ];
    
    foreach ($categories as $cat) {
        DB::table('categories')->insertOrIgnore(array_merge($cat, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));
    }
    echo "✓ Categories seeded\n";
    
    // Seed modules from categories
    echo "Seeding modules from categories...\n";
    $cats = DB::table('categories')->get();
    foreach ($cats as $cat) {
        DB::table('modules')->insertOrIgnore([
            'slug' => $cat->slug,
            'name' => $cat->title,
            'quality_objective' => $cat->description,
            'description' => $cat->description,
            'order' => $cat->order,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    echo "✓ Modules seeded\n";
    
    echo "\n✅ All dashboard tables created successfully!\n";
    echo "You can now access the dashboard.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
