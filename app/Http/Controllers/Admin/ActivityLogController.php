<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $users = User::withCount(['activityLogs'])->get();
        $recentActivities = ActivityLog::with('user')
            ->latest('last_seen_at')
            ->take(10)
            ->get();

        return view('admin.activity-logs.index', compact('users', 'recentActivities'));
    }

    public function userActivities(User $user)
    {
        $activities = $user->activityLogs()
            ->with('user')
            ->latest('last_seen_at')
            ->paginate(20);

        return view('admin.activity-logs.user', compact('user', 'activities'));
    }
}
