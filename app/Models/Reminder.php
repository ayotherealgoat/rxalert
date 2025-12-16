<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reminder extends Model
{
    protected $fillable = [
        'name',
        'dosage',
        'times_per_day',
        'first_dose_time',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'first_dose_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the next time this reminder should trigger.
     * In this simplified version, we only check the stored time.
     */
    public function getNextDoseTime()
    {
        $now = Carbon::now()->timezone(config('app.timezone'));
        $doseTime = Carbon::parse($this->first_dose_time)->timezone(config('app.timezone'));

        // If the scheduled time is in the past, assume it’s for tomorrow
        if ($doseTime->isPast()) {
            $doseTime->addDay();
        }

        return $doseTime;
    }
}
