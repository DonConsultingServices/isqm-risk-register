<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('settings.edit', [
            'org_name' => Setting::get('org_name', 'ISQM'),
            'brand_color' => Setting::get('brand_color', '#0f172a'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'org_name' => 'required|string|max:255',
            'brand_color' => 'required|string|regex:/^#([0-9a-fA-F]{3}){1,2}$/',
        ]);

        foreach ($data as $k => $v) {
            Setting::updateOrCreate(['key' => $k], ['value' => $v]);
        }

        return back()->with('status', 'Settings saved');
    }
}


