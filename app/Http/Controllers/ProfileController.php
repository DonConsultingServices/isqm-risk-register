<?php

namespace App\Http\Controllers;

use App\Models\IsqmEntry;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        
        // Get user's statistics (with error handling for missing tables)
        try {
            $totalEntries = IsqmEntry::where('owner_id', $user->id)->count();
            $openEntries = IsqmEntry::where('owner_id', $user->id)->where('status', 'open')->count();
            $monitoringEntries = IsqmEntry::where('owner_id', $user->id)->where('status', 'monitoring')->count();
            $closedEntries = IsqmEntry::where('owner_id', $user->id)->where('status', 'closed')->count();
            
            // Get recent entries
            $recentEntries = IsqmEntry::where('owner_id', $user->id)
                ->with(['module', 'category'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Tables might not exist yet
            $totalEntries = 0;
            $openEntries = 0;
            $monitoringEntries = 0;
            $closedEntries = 0;
            $recentEntries = collect();
        }
        
        // Get recent activity (with error handling for missing table)
        try {
            $recentActivity = ActivityLog::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            // Activity log table might not exist
            $recentActivity = collect();
        }
        
        return view('profile.show', compact(
            'user',
            'totalEntries',
            'openEntries',
            'monitoringEntries',
            'closedEntries',
            'recentEntries',
            'recentActivity'
        ));
    }

    public function edit(): View
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        
        $user->save();

        // Log the activity (if activity_logs table exists)
        try {
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'updated',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'changes' => json_encode([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password_updated' => !empty($data['password']),
                ]),
            ]);
        } catch (\Exception $e) {
            // Activity log table might not exist, continue without logging
        }

        return redirect()->route('profile.show')->with('status', 'Profile updated successfully');
    }
}

