<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Module;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'slug' => 'governance-and-leadership',
                'title' => 'Governance and leadership',
                'description' => 'Governance and leadership quality objectives',
                'order' => 1,
            ],
            [
                'slug' => 'ethical-requirements',
                'title' => 'Ethical requirements',
                'description' => 'Ethical requirements quality objectives',
                'order' => 2,
            ],
            [
                'slug' => 'acceptance-and-continuance',
                'title' => 'Acceptance and continuance',
                'description' => 'Acceptance and continuance quality objectives',
                'order' => 3,
            ],
            [
                'slug' => 'engagement-performance',
                'title' => 'Engagement performance',
                'description' => 'Engagement performance quality objectives',
                'order' => 4,
            ],
            [
                'slug' => 'resources',
                'title' => 'Resources',
                'description' => 'Resources quality objectives',
                'order' => 5,
            ],
            [
                'slug' => 'information-and-communication',
                'title' => 'Information and communication',
                'description' => 'Information and communication quality objectives',
                'order' => 6,
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);

            Module::firstOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['title'],
                    'quality_objective' => $cat['description'],
                    'order' => $cat['order'] ?? 0,
                ]
            );
        }
    }
}

