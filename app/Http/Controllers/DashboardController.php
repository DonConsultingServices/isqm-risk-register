<?php

namespace App\Http\Controllers;

use App\Models\IsqmEntry;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Statistics
        $stats = [
            'total_entries' => IsqmEntry::count(),
            'open_entries' => IsqmEntry::where('status', 'open')->count(),
            'monitoring_entries' => IsqmEntry::where('status', 'monitoring')->count(),
            'closed_entries' => IsqmEntry::where('status', 'closed')->count(),
            'total_clients' => Client::count(),
            'overdue' => IsqmEntry::whereIn('status', ['open', 'monitoring'])
                ->whereNotNull('due_date')
                ->whereDate('due_date', '<', now())
                ->count(),
            'due_soon' => IsqmEntry::whereIn('status', ['open', 'monitoring'])
                ->whereNotNull('due_date')
                ->whereDate('due_date', '>=', now())
                ->whereDate('due_date', '<=', now()->addDays(7))
                ->count(),
        ];

        // Recent open items
        $recentOpen = IsqmEntry::whereIn('status', ['open', 'monitoring'])
            ->latest('updated_at')
            ->limit(10)
            ->with('module')
            ->get();

        // Recent notifications
        $notifications = $user->notifications()
            ->latest()
            ->limit(5)
            ->get();

        // Entries by module (area)
        $byArea = IsqmEntry::query()
            ->join('modules', 'modules.id', '=', 'isqm_entries.module_id')
            ->selectRaw('modules.name as module_name, modules.slug as module_slug, count(*) as count,
                sum(case when isqm_entries.status = "open" then 1 else 0 end) as open_count,
                sum(case when isqm_entries.status = "monitoring" then 1 else 0 end) as monitoring_count')
            ->groupBy('modules.name', 'modules.slug')
            ->get();

        return view('dashboard', compact('stats', 'recentOpen', 'notifications', 'byArea'));
    }
}

