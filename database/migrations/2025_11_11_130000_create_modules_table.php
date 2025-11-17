<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('quality_objective')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::table('isqm_entries', function (Blueprint $table) {
            $table->foreignId('module_id')->nullable()->after('category_id');
        });

        // Seed modules table from existing categories if present
        if (Schema::hasTable('categories')) {
            $now = now();
            $categories = DB::table('categories')->get();

            foreach ($categories as $category) {
                DB::table('modules')->updateOrInsert(
                    ['slug' => $category->slug],
                    [
                        'name' => $category->title ?? $category->slug,
                        'quality_objective' => $category->description,
                        'description' => $category->description,
                        'order' => $category->order ?? 0,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }

            $moduleMap = DB::table('modules')->pluck('id', 'slug');

            $entries = DB::table('isqm_entries')
                ->select('id', 'category_id')
                ->whereNull('module_id')
                ->get();

            foreach ($entries as $entry) {
                if ($entry->category_id) {
                    $category = DB::table('categories')->where('id', $entry->category_id)->first();
                    if ($category && isset($moduleMap[$category->slug])) {
                        DB::table('isqm_entries')
                            ->where('id', $entry->id)
                            ->update(['module_id' => $moduleMap[$category->slug]]);
                    }
                }
            }
        }

        Schema::table('isqm_entries', function (Blueprint $table) {
            $table->foreign('module_id')->references('id')->on('modules')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('isqm_entries', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
            $table->dropColumn('module_id');
        });

        Schema::dropIfExists('modules');
    }
};


