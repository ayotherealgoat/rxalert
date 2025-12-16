<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Medication;
use App\Models\MedicationLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_medications' => Medication::count(),
            'total_active_reminders' => Medication::where('active', true)->count(),
            'total_logs' => MedicationLog::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::withCount(['medications', 'medicationLogs'])->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function medications()
    {
        $medications = Medication::with(['user', 'logs'])->paginate(10);
        return view('admin.medications', compact('medications'));
    }
}