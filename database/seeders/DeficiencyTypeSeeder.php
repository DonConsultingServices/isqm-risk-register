<?php

namespace Database\Seeders;

use App\Models\DeficiencyType;
use Illuminate\Database\Seeder;

class DeficiencyTypeSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // From Lists sheet → Deficiency (Entity level)
            'Entity level: Quality objective was not met',
            'Entity level: A risk exist that was not identified or properly assessed',
            'Entity level: The response does not adequately mitigate the risk identified',
            'Entity level: Responsibility not assigned properly',
            'Entity level: Risk assessment process not performed properly',
            'Entity level: Monitoring and remediation process not functioning properly',
            'Entity level: Evaluation of system not properly designed',
            // From Lists sheet → Deficiency (Engagement level)
            'Engagement level: Required procedures were omitted',
            'Engagement level: Report issued may be inappropriate',
        ];

        foreach ($items as $name) {
            DeficiencyType::updateOrCreate(
                ['name' => $name],
                ['name' => $name]
            );
        }
        
        // Update any records with empty names to have proper names based on ID order
        // This handles cases where records were created without names
        $allDeficiencies = DeficiencyType::whereNull('name')->orWhere('name', '')->orderBy('id')->get();
        foreach ($allDeficiencies as $index => $deficiency) {
            if ($index < count($items)) {
                $deficiency->update(['name' => $items[$index]]);
            }
        }
    }
}


