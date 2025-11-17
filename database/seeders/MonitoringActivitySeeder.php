<?php

namespace Database\Seeders;

use App\Models\MonitoringActivity;
use Illuminate\Database\Seeder;

class MonitoringActivitySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // From Lists sheet → Monitoring activities
            'IRBA reviews (including their inspection report)',
            'Engagement Quality reviews',
            'Peer reviews',
            'Internal communications process',
            'Performance reviews',
            'Upward reviews',
            'Review of IRBA inspections',
            'Communication from regulatory authority for example LPC/EAAB feedback',
            'Media of other failures',
            'Partner reviews - inspection of completed engagements (1 engagement per partner on a cyclical basis) not only audit, but ALL engagements',
            'Complaints from clients',
            'Reports from service providers',
            'Inspection of ongoing Engagement files - ongoing basis',
            'Monitoring performed by network',
            'Employee questionnaire',
            'Response checklist (was response implemented)',
            "Compare last year's identified deficiencies with this year - did the remedial action of last year work?",
            'Evaluate changes in circumstances to identify if the SQOM addressed the new circumstances',
            'Objective was met, no finding identified',
            'NA',
        ];

        foreach ($items as $name) {
            MonitoringActivity::updateOrCreate(
                ['name' => $name],
                ['name' => $name]
            );
        }
        
        // Update any records with empty names to have proper names based on ID order
        // This handles cases where records were created without names
        $allActivities = MonitoringActivity::whereNull('name')->orWhere('name', '')->orderBy('id')->get();
        foreach ($allActivities as $index => $activity) {
            if ($index < count($items)) {
                $activity->update(['name' => $items[$index]]);
            }
        }
    }
}


