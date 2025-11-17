<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('isqm_entries', function (Blueprint $table) {
            // Add title field (short summary)
            $table->string('title')->nullable()->after('id');
            
            // Add implementation status workflow
            $table->enum('implementation_status', ['not_started', 'in_progress', 'implemented', 'verified'])
                  ->default('not_started')
                  ->after('status');
            
            // Enhance remedial actions with owner and dates
            $table->foreignId('remedial_owner_id')->nullable()
                  ->after('remedial_actions')
                  ->constrained('users')->nullOnDelete();
            $table->date('remedial_target_date')->nullable()->after('remedial_owner_id');
            $table->dateTime('remedial_completed_at')->nullable()->after('remedial_target_date');
            
            // Add import source tracking
            $table->string('import_source')->nullable()->after('remedial_completed_at');
            
            // Add created_by and updated_by for audit
            $table->foreignId('created_by')->nullable()->after('import_source')->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('isqm_entries', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'implementation_status',
                'remedial_owner_id',
                'remedial_target_date',
                'remedial_completed_at',
                'import_source',
                'created_by',
                'updated_by',
            ]);
        });
    }
};
