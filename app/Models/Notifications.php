<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class MedicationReminder extends Notification
{
    use Queueable;

    protected $medication;
    protected $doseNumber;
    protected $nextDoseTime;

    public function __construct($medication, $doseNumber, $nextDoseTime = null)
    {
        $this->medication = $medication;
        $this->doseNumber = $doseNumber;
        $this->nextDoseTime = $nextDoseTime;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('Time to take your medication: ' . $this->medication->name)
            ->line('This is a reminder to take your ' . $this->medication->name)
            ->line('Dosage: ' . $this->medication->dosage)
            ->line('Dose number: ' . $this->doseNumber . ' of ' . $this->medication->times_per_day);
            
        if ($this->nextDoseTime) {
            $message->line('Next dose due at: ' . Carbon::parse($this->nextDoseTime)->format('h:i A'));
        }
        
        if ($this->medication->notes) {
            $message->line('Notes: ' . $this->medication->notes);
        }
        
        return $message;
    }
}