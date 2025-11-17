<?php

namespace App\Http\Controllers;

use App\Models\DeficiencyType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeficiencyTypeController extends Controller
{
    public function index(): View
    {
        return view('lists.deficiency.index', [
            'items' => DeficiencyType::orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('lists.deficiency.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:deficiency_types,name',
            'description' => 'nullable|string',
        ]);
        DeficiencyType::create($data);
        return redirect()->route('lists.deficiency.index')->with('status', 'Created');
    }

    public function edit(DeficiencyType $deficiency): View
    {
        return view('lists.deficiency.edit', ['item' => $deficiency]);
    }

    public function update(Request $request, DeficiencyType $deficiency): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:deficiency_types,name,'.$deficiency->id,
            'description' => 'nullable|string',
        ]);
        $deficiency->update($data);
        return redirect()->route('lists.deficiency.index')->with('status', 'Updated');
    }

    public function destroy(DeficiencyType $deficiency): RedirectResponse
    {
        $deficiency->delete();
        return back()->with('status', 'Deleted');
    }
}


