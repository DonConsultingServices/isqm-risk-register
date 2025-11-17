<?php

namespace App\Http\Controllers;

use App\Models\MonitoringActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MonitoringActivityController extends Controller
{
    public function index(): View
    {
        return view('lists.monitoring.index', [
            'items' => MonitoringActivity::orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('lists.monitoring.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:monitoring_activities,name',
            'description' => 'nullable|string',
        ]);
        MonitoringActivity::create($data);
        return redirect()->route('lists.monitoring.index')->with('status', 'Created');
    }

    public function edit(MonitoringActivity $monitoring): View
    {
        return view('lists.monitoring.edit', ['item' => $monitoring]);
    }

    public function update(Request $request, MonitoringActivity $monitoring): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:monitoring_activities,name,'.$monitoring->id,
            'description' => 'nullable|string',
        ]);
        $monitoring->update($data);
        return redirect()->route('lists.monitoring.index')->with('status', 'Updated');
    }

    public function destroy(MonitoringActivity $monitoring): RedirectResponse
    {
        $monitoring->delete();
        return back()->with('status', 'Deleted');
    }
}


