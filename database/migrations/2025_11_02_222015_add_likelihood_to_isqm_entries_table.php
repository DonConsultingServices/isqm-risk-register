<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('isqm_entries', function (Blueprint $table) {
            $table->boolean('likelihood')->nullable()->after('assessment_of_risk');
        });
    }

    public function down(): void
    {
        Schema::table('isqm_entries', function (Blueprint $table) {
            $table->dropColumn('likelihood');
        });
    }
};
