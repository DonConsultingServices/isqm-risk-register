<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\DeficiencyType;
use App\Models\MonitoringActivity;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ListController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'monitoring_activities' => MonitoringActivity::orderBy('name')->get(['id', 'name']),
            'deficiency_types' => DeficiencyType::orderBy('name')->get(['id', 'name']),
            'owners' => User::orderBy('name')->get(['id', 'name']),
            'clients' => Client::orderBy('name')->get(['id', 'name']),
            'status_options' => [
                ['value' => 'open', 'label' => 'Open'],
                ['value' => 'monitoring', 'label' => 'Monitoring'],
                ['value' => 'closed', 'label' => 'Closed'],
            ],
            'implementation_statuses' => [
                ['value' => 'not_started', 'label' => 'Not Started'],
                ['value' => 'in_progress', 'label' => 'In Progress'],
                ['value' => 'implemented', 'label' => 'Implemented'],
                ['value' => 'verified', 'label' => 'Verified'],
            ],
        ]);
    }
}


