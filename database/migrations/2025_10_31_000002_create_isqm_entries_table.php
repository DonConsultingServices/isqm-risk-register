<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('isqm_entries', function (Blueprint $table) {
            $table->id();

            // Area/sheet this entry belongs to
            $table->enum('area', [
                'governance_and_leadership',
                'ethical_requirements',
                'acceptance_and_continuance',
                'engagement_performance',
                'resources',
                'information_and_communication',
            ])->index();

            // Core ISQM register fields
            $table->text('quality_objective');
            $table->text('quality_risk')->nullable();
            $table->text('assessment_of_risk')->nullable();
            $table->text('response')->nullable();
            $table->text('firm_implementation')->nullable();

            // Monitoring and remediation
            $table->foreignId('monitoring_activity_id')->nullable()->constrained('monitoring_activities')->nullOnDelete();
            $table->text('findings')->nullable();
            $table->foreignId('deficiency_type_id')->nullable()->constrained('deficiency_types')->nullOnDelete();
            $table->text('root_cause')->nullable();
            $table->boolean('severe')->nullable();
            $table->boolean('pervasive')->nullable();
            $table->boolean('adverse_effect')->nullable();
            $table->boolean('risk_applicable')->nullable();
            $table->boolean('objective_met')->nullable();
            $table->text('remedial_actions')->nullable();

            // Context flags
            $table->boolean('entity_level')->nullable();
            $table->boolean('engagement_level')->nullable();

            // Workflow
            $table->enum('status', ['open', 'monitoring', 'closed'])->default('open');

            // Ownership / dates
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('due_date')->nullable();
            $table->date('review_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('isqm_entries');
    }
};


