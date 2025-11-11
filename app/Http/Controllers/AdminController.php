<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // Admin Home
    public function home()
    {
        return view('admin.adminHome');
    }

    // Admin Users
    public function users()
    {
        $users = User::all(); // fetch all users from database
        return view('admin.adminUsers', compact('users'));
    }

    // Admin Quests
    public function quests()
    {
        return view('admin.adminQuests');
    }

    // Admin Rewards
    public function rewards()
    {
        return view('admin.adminRewards');
    }

    // Admin Analytics
    public function analytics()
    {
        return view('admin.adminAnalytics');
    }

    // Admin System Alerts
    public function systemAlerts()
    {
        return view('admin.adminSystemAlerts');
    }

    // Admin Settings
    public function settings()
    {
        return view('admin.adminSettings');
    }

    // Admin Lifestyle
    public function lifestyle()
    {
        return view('admin.adminLifestyle');
    }
}
