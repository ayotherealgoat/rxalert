<?php

// use Illuminate\Support\Facades\Route;
// use App\Models\Reminder;
// use Carbon\Carbon;

// Route::get('/reminders/due', function () {
//     $now = Carbon::now()->format('H:i'); // current time
//     $reminders = Reminder::where('first_dose_time', '<=', $now)
//         ->where('is_active', true)
//         ->get();

//     return response()->json($reminders);
// });
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

Route::get('/reminders/due', function () {
    // Later we’ll filter by user if you’re using authentication
    return DB::table('due_notifications')
        ->whereDate('notified_at', now()->toDateString())
        ->whereTime('notified_at', '>=', now()->subMinute()->format('H:i:s'))
        ->get();
});

