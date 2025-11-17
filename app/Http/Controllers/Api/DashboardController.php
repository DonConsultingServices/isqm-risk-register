<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\IsqmEntry;
use App\Models\Module;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $now = Carbon::now();
        $soon = Carbon::now()->addDays(7);

        $stats = [
            'total_entries' => IsqmEntry::count(),
            'open_entries' => IsqmEntry::where('status', 'open')->count(),
            'monitoring_entries' => IsqmEntry::where('status', 'monitoring')->count(),
            'closed_entries' => IsqmEntry::where('status', 'closed')->count(),
            'overdue' => IsqmEntry::whereIn('status', ['open', 'monitoring'])
                ->whereNotNull('due_date')
                ->whereDate('due_date', '<', $now)
                ->count(),
            'due_soon' => IsqmEntry::whereIn('status', ['open', 'monitoring'])
                ->whereNotNull('due_date')
                ->whereBetween('due_date', [$now, $soon])
                ->count(),
            'total_clients' => Client::count(),
        ];

        $modules = Module::query()
            ->orderBy('order')
            ->orderBy('name')
            ->withCount([
                'risks',
                'risks as open_count' => fn ($q) => $q->where('status', 'open'),
                'risks as monitoring_count' => fn ($q) => $q->where('status', 'monitoring'),
                'risks as closed_count' => fn ($q) => $q->where('status', 'closed'),
                'risks as severe_count' => fn ($q) => $q->where('severe', true),
                'risks as pervasive_count' => fn ($q) => $q->where('pervasive', true),
            ])
            ->get()
            ->map(fn (Module $module) => [
                'id' => $module->id,
                'slug' => $module->slug,
                'name' => $module->name,
                'total' => $module->risks_count,
                'open' => $module->open_count,
                'monitoring' => $module->monitoring_count,
                'closed' => $module->closed_count,
                'severe' => $module->severe_count,
                'pervasive' => $module->pervasive_count,
            ]);

        $recentOpen = IsqmEntry::with('module')
            ->whereIn('status', ['open', 'monitoring'])
            ->latest('updated_at')
            ->limit(10)
            ->get()
            ->map(function (IsqmEntry $entry) use ($now) {
                $dueDate = $entry->due_date?->format('Y-m-d');

                return [
                    'id' => $entry->id,
                    'module' => $entry->module?->name,
                    'quality_objective' => $entry->quality_objective,
                    'status' => $entry->status,
                    'due_date' => $dueDate,
                    'overdue' => $dueDate && $entry->due_date->isPast() && $entry->status !== 'closed',
                ];
            });

        $notifications = [];
        if (auth()->check()) {
            $notifications = auth()->user()->notifications()
                ->latest()
                ->limit(5)
                ->get()
                ->map(fn ($notification) => [
                    'id' => $notification->id,
                    'title' => data_get($notification->data, 'quality_objective', 'Notification'),
                    'created_at' => $notification->created_at->diffForHumans(),
                ]);
        }

        return response()->json([
            'stats' => $stats,
            'modules' => $modules,
            'recent_open' => $recentOpen,
            'notifications' => $notifications,
        ]);
    }
}
