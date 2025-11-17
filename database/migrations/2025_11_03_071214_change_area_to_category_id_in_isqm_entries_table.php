<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, ensure categories are seeded
        $this->seedCategories();
        
        // Map old area values to category slugs
        $areaToSlug = [
            'governance_and_leadership' => 'governance-and-leadership',
            'ethical_requirements' => 'ethical-requirements',
            'acceptance_and_continuance' => 'acceptance-and-continuance',
            'engagement_performance' => 'engagement-performance',
            'resources' => 'resources',
            'information_and_communication' => 'information-and-communication',
        ];

        // Get category IDs
        $categoryMap = [];
        foreach ($areaToSlug as $area => $slug) {
            $cat = DB::table('categories')->where('slug', $slug)->first();
            if ($cat) {
                $categoryMap[$area] = $cat->id;
            }
        }

        Schema::table('isqm_entries', function (Blueprint $table) use ($categoryMap) {
            // Add category_id column
            $table->foreignId('category_id')->nullable()->after('area');
        });

        // Migrate data: convert area enum to category_id
        foreach ($categoryMap as $area => $categoryId) {
            DB::table('isqm_entries')
                ->where('area', $area)
                ->update(['category_id' => $categoryId]);
        }

        Schema::table('isqm_entries', function (Blueprint $table) {
            // Make category_id required and add foreign key
            $table->foreignId('category_id')->nullable(false)->change();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            
            // Drop old area column
            $table->dropColumn('area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('isqm_entries', function (Blueprint $table) {
            // Re-add area enum
            $table->enum('area', [
                'governance_and_leadership',
                'ethical_requirements',
                'acceptance_and_continuance',
                'engagement_performance',
                'resources',
                'information_and_communication',
            ])->nullable()->after('id');
        });

        // Migrate data back: convert category_id to area
        $slugToArea = [
            'governance-and-leadership' => 'governance_and_leadership',
            'ethical-requirements' => 'ethical_requirements',
            'acceptance-and-continuance' => 'acceptance_and_continuance',
            'engagement-performance' => 'engagement_performance',
            'resources' => 'resources',
            'information-and-communication' => 'information_and_communication',
        ];

        foreach ($slugToArea as $slug => $area) {
            $cat = DB::table('categories')->where('slug', $slug)->first();
            if ($cat) {
                DB::table('isqm_entries')
                    ->where('category_id', $cat->id)
                    ->update(['area' => $area]);
            }
        }

        Schema::table('isqm_entries', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }

    private function seedCategories(): void
    {
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
    }
};
