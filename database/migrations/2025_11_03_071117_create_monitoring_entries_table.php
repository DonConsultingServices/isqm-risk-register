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
        Schema::create('monitoring_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('isqm_entry_id')->constrained('isqm_entries')->cascadeOnDelete();
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('performed_at');
            $table->text('outcome');
            $table->enum('status', ['ok', 'finding', 'action_required'])->default('ok');
            // Note: attachment_id will be added later if attachments table exists, or we can store as JSON path
            $table->string('evidence_path')->nullable();
            $table->date('next_due_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_entries');
    }
};
