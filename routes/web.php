<?php


use App\Http\Controllers\MedicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Medication;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::view ('/', 'welcome');
// Route::view('/home', 'welcome'); // optional



// Authentication routes
Route::get ('/register', [AuthController::class, 'showRegisterForm'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest')->name('register.submit');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login.submit');


// After auth routes
Route::get('/dashboard', [MedicationController::class, 'index'])->middleware('auth')->name('reminders.index');
Route::get('/reminders/create', [MedicationController::class, 'create'])->middleware('auth')->name('reminders.create');
Route::get('/reminders/{reminder}/edit', [MedicationController::class, 'edit'])->name('reminders.edit');
Route::post('/reminders', [MedicationController::class, 'store'])->middleware('auth')->name('reminders.store');
Route::put('/reminders/{reminder}', [MedicationController::class, 'update'])->middleware('auth')->name('reminders.update');
Route::post('/reminders/{reminder}/take', [MedicationController::class, 'markAsTaken'])->middleware('auth')->name('reminders.take');
Route::post('/reminders/{reminder}/miss', [MedicationController::class, 'markAsMissed'])->middleware('auth')->name('reminders.miss');

// Admin routes
// Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
//     Route::get('/medications', [AdminController::class, 'medications'])->name('admin.medications');
// });


// for the dose time calculations
// Route::post('/calculate-dose-times', function (Request $request) {
//     $firstDose = Carbon::parse($request->first_dose_time);
//     $timesPerDay = $request->times_per_day;
//     $interval = 24 / $timesPerDay;
    
//     $times = collect([$firstDose->format('h:i A')]);
    
//     for ($i = 1; $i < $timesPerDay; $i++) {
//         $nextDose = $firstDose->copy()->addHours($interval * $i);
//         $times->push($nextDose->format('h:i A'));
//     }
    
//     return response()->json(['times' => $times]);
// })->name('calculate.doses')->middleware('auth');

// Notifications
Route::get('/notifications', function () {
    return auth()->user()
        ? auth()->user()->notifications
        : [];
});

// Alert message
// Route::get('/check-reminders', function () {
//     $now = Carbon::now();
//     $twoMinutesFromNow = $now->copy()->addMinutes(2);

//     $reminders = Medication::where('is_active', 1)
//         ->whereTime('first_dose_time', '>=', $now->format('H:i:s'))
//         ->whereTime('first_dose_time', '<=', $twoMinutesFromNow->format('H:i:s'))
//         ->get(['id', 'name']);

//     return response()->json(['reminders' => $reminders]);
// });

// Route::get('/check-reminders', function () {
//     $now = Carbon::now();
//     $twoMinutesFromNow = $now->copy()->addMinutes(2);
    
//     // Enhanced reminder check logic
//     $reminders = Medication::where('is_active', 1)
//         ->where('user_id', auth()->id()) // Add user check
//         ->where(function($query) use ($now) {
//             $query->whereRaw('MOD(TIMESTAMPDIFF(HOUR, first_dose_time, ?), 
//                   (24 / times_per_day)) = 0', [$now]);
//         })
//         ->get(['id', 'name', 'dosage']);

//     return response()->json(['reminders' => $reminders]);
// })->middleware('auth')->name('check.reminders'); // Add middleware

Route::get('/check-reminders', function () {
    $now = Carbon::now();
    $windowStart = $now->copy()->subMinutes(2);
    $windowEnd = $now->copy()->addMinutes(2);

    $reminders = Medication::where('is_active', 1)
        ->where('user_id', auth()->id())
        ->whereTime('first_dose_time', '>=', $windowStart->format('H:i:s'))
        ->whereTime('first_dose_time', '<=', $windowEnd->format('H:i:s'))
        ->get(['id', 'name', 'dosage', 'first_dose_time']);

    // Add the scheduled time to each reminder for client-side checks
    $reminders = $reminders->map(function ($reminder) use ($now) {
        $reminder->time = $now->format('Y-m-d H:i:s');
        return $reminder;
    });

    return response()->json(['reminders' => $reminders]);
})->middleware('auth')->name('check.reminders');



// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/reminders/create', [MedicationController::class, 'create'])->middleware('auth')->name('reminders.create');