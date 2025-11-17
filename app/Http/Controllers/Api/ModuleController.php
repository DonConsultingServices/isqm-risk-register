<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
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
                'quality_objective' => $module->quality_objective,
                'description' => $module->description,
                'order' => $module->order,
                'stats' => [
                    'total' => $module->risks_count,
                    'open' => $module->open_count,
                    'monitoring' => $module->monitoring_count,
                    'closed' => $module->closed_count,
                    'severe' => $module->severe_count,
                    'pervasive' => $module->pervasive_count,
                ],
            ]);

        return response()->json([
            'data' => $modules,
        ]);
    }
}


