<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dosage',
        'times_per_day',
        'first_dose_time',
        'dose_interval',
        'notes',
        'user_id',
        'start_date',
        'end_date',
        'remaining_doses',
        'total_doses',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get all dose times for the day
     */
    public function isOverdue(): bool
{
    $now = now();
    $firstDoseTime = Carbon::parse($this->first_dose_time);
    
    // Get all dose times for today
    $doseTimes = $this->getDoseTimes();
    
    // If we're before the first dose of the day
    if ($now->format('H:i') < $firstDoseTime->format('H:i')) {
        return false;
    }

    // Check if any dose is overdue
    foreach ($doseTimes as $doseTime) {
        $doseDateTime = Carbon::parse($doseTime);
        
        // If this dose is in the future, break
        if ($now < $doseDateTime) {
            break;
        }
        
        // Check if this dose was taken
        $taken = $this->logs()
            ->whereDate('created_at', today())
            ->whereTime('scheduled_time', $doseTime)
            ->exists();
            
        if (!$taken) {
            return true;
        }
    }

    return false;
}

public function getDoseTimes(): array
{
    $times = [];
    $firstDose = Carbon::parse($this->first_dose_time);
    
    // Add first dose
    $times[] = $firstDose->format('H:i');
    
    // Calculate interval between doses
    $hoursInterval = 24 / $this->times_per_day;
    
    // Add subsequent doses
    for ($i = 1; $i < $this->times_per_day; $i++) {
        $nextDose = $firstDose->copy()->addHours($hoursInterval * $i);
        $times[] = $nextDose->format('H:i');
    }
    
    return $times;
}

public function getNextDoseTime(): ?Carbon
{
    $now = now();
    $doseTimes = $this->getDoseTimes();
    
    foreach ($doseTimes as $doseTime) {
        $doseDateTime = Carbon::parse($doseTime);
        
        // If this dose time is in the future
        if ($now->format('H:i') < $doseTime) {
            return $doseDateTime;
        }
        
        // If this dose hasn't been taken yet
        $taken = $this->logs()
            ->whereDate('created_at', today())
            ->whereTime('scheduled_time', $doseTime)
            ->exists();
            
        if (!$taken) {
            return $doseDateTime;
        }
    }
    
    // If all doses for today are taken/passed, return first dose time for tomorrow
    return Carbon::parse($this->first_dose_time)->addDay();
}
    /**
     * Get the last dose time for today
     */
    private function getLastDoseTimeOfDay(): Carbon
    {
        $today = Carbon::today()->timezone(config('app.timezone'));
        $firstDoseTime = Carbon::parse($this->first_dose_time)->timezone(config('app.timezone'));
        $interval = $this->dose_interval ?? (24 / max(1, $this->times_per_day));
        
        return $today->copy()
            ->setHour($firstDoseTime->hour)
            ->setMinute($firstDoseTime->minute)
            ->addHours($interval * ($this->times_per_day - 1));
    }

    /**
     * Relationship: belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: has many logs (records)
     */
    public function logs()
    {
        return $this->hasMany(MedicationLog::class);
    }

    /**
     * Mark medication as taken
     */
    public function markAsTaken($scheduled_time)
    {
        return $this->logs()
            ->where('scheduled_time', $scheduled_time)
            ->update([
                'status' => 'taken',
                'taken_at' => now(),
            ]);
    }

    /**
     * Mark medication as missed
     */
    public function markAsMissed($scheduled_time)
    {
        return $this->logs()
            ->where('scheduled_time', $scheduled_time)
            ->update(['status' => 'missed']);
    }
}
