<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UserGuideController extends Controller
{
    public function index(): View
    {
        return view('user-guide.index');
    }

    public function show(string $topic): View
    {
        $topics = [
            'getting-started' => 'Getting Started',
            'creating-entries' => 'Creating ISQM Entries',
            'editing-entries' => 'Editing Entries',
            'managing-clients' => 'Managing Clients',
            'using-filters' => 'Using Filters',
            'compliance-now' => 'Compliance Now',
            'reports-exports' => 'Reports & Exports',
            'user-management' => 'User Management',
            'monitoring-activities' => 'Monitoring Activities',
            'bulk-actions' => 'Bulk Actions',
            'importing-data' => 'Importing Data',
            'isqm-areas' => 'ISQM Areas',
            'dashboard' => 'Dashboard Overview',
            'notifications' => 'Notifications',
            'settings' => 'Settings',
        ];

        if (!isset($topics[$topic])) {
            abort(404, 'Guide topic not found');
        }

        return view('user-guide.show', [
            'topic' => $topic,
            'title' => $topics[$topic],
            'topics' => $topics,
        ]);
    }
}

