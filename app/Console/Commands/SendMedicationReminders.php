<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Medication;
use App\Notifications\MedicationReminderNotification;
use Carbon\Carbon;

class SendMedicationReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send medication reminders when dosage time is due';

    public function handle()
    {
        $currentTime = now()->format('H:i');
        $this->info(" Checking reminders at {$currentTime}");

        // Fetch all active medications
        $medications = Medication::where('is_active', 1)->get();

        if ($medications->isEmpty()) {
            $this->info("No active medications found.");
            return Command::SUCCESS;
        }

        $sent = 0;

        foreach ($medications as $med) {
            $user = $med->user;

            if (!$user || !$user->email) {
                $this->error("Skipped '{$med->name}' — user email missing.");
                continue;
            }

            // Parse first dose time (H:i:s) from DB
            $doseTime = Carbon::createFromFormat('H:i:s', $med->first_dose_time);

            // Allow sending if current time is within 2 minutes before or after scheduled dose
            $windowStart = $doseTime->copy()->subMinutes(2);
            $windowEnd = $doseTime->copy()->addMinutes(2);

            if (now()->between($windowStart, $windowEnd)) {
                try {
                    $user->notify(new MedicationReminderNotification($med));
                    $this->info(" Reminder sent for '{$med->name}' to {$user->email}");
                    $sent++;
                } catch (\Exception $e) {
                    $this->error(" Failed to send '{$med->name}': " . $e->getMessage());
                }
            }
        }

        if ($sent === 0) {
            $this->info("No reminders due at {$currentTime}.");
        } else {
            $this->info(" {$sent} reminder(s) sent successfully.");
        }

        return Command::SUCCESS;
    }
}
