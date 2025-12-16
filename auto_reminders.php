<?php
// Change working directory to the Laravel project root
chdir(__DIR__);

// Load Composer autoload
require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';

// Get the console kernel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Medication;
use App\Notifications\MedicationReminderNotification;
use Carbon\Carbon;

// Interval between checks in seconds
define('CHECK_INTERVAL', 60);

// Keep track of notifications sent for the day
$notified = [];

echo "[" . date('Y-m-d H:i:s') . "] Auto reminder script started...\n";

while (true) {
    $now = Carbon::now();
    $currentTime = $now->format('H:i');
    echo "[" . date('Y-m-d H:i:s') . "] Checking reminders for {$currentTime}...\n";

    // Get active medications
    $medications = Medication::where('is_active', 1)->get();

    foreach ($medications as $med) {
        $user = $med->user;
        if (!$user || !$user->email) {
            echo "Skipped '{$med->name}' — user email missing.\n";
            continue;
        }

        // Unique key per medication per day to avoid duplicates
        $medKey = $med->id . '_' . $now->toDateString();
        if (isset($notified[$medKey])) {
            continue;
        }

        // Scheduled dose time today
        $doseTime = Carbon::parse($med->first_dose_time)->setDate(
            $now->year,
            $now->month,
            $now->day
        );

        // Send 2 minutes before scheduled dose
        $sendWindowStart = $doseTime->copy()->subMinutes(2);
        $sendWindowEnd   = $doseTime->copy();

        if ($now->between($sendWindowStart, $sendWindowEnd)) {
            try {
                // Send email notification
                $user->notify(new MedicationReminderNotification($med));
                echo "✅ Reminder sent for '{$med->name}' to {$user->email}\n";

                // Play local alarm
                exec('powershell -c (New-Object Media.SoundPlayer "C:\\Users\\User\\Herd\\medication-reminder\\public\\alarm.mp3").PlaySync();');

                // Mark as notified
                $notified[$medKey] = true;

            } catch (\Exception $e) {
                echo "❌ Failed to send '{$med->name}': " . $e->getMessage() . "\n";
            }
        }
    }

    // Wait before next check
    sleep(CHECK_INTERVAL);
}
