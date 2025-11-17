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
            $table->text('toc')->nullable()->after('firm_implementation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('isqm_entries', function (Blueprint $table) {
            $table->dropColumn('toc');
        });
    }
};
