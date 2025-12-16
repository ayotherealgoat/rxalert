<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class UpcomingDoseNotification extends Notification
{
    use Queueable;

    protected $medication;
    protected $doseTime;
    protected $isUpcoming;

    public function __construct($medication, $doseTime, $isUpcoming = true)
    {
        $this->medication = $medication;
        $this->doseTime = $doseTime;
        $this->isUpcoming = $isUpcoming;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject($this->isUpcoming ? 'Upcoming Medication Reminder' : 'Time to Take Your Medication')
            ->line($this->isUpcoming 
                ? 'In 5 minutes, it will be time to take your medication:'
                : 'It is time to take your medication:')
            ->line('Medication: ' . $this->medication->name)
            ->line('Dosage: ' . $this->medication->dosage)
            ->line('Time: ' . $this->doseTime->format('h:i A'));

        if ($this->medication->remaining_doses <= 5) {
            $message->line('Warning: Only ' . $this->medication->remaining_doses . ' doses remaining!');
        }

        return $message;
    }

    public function toDatabase($notifiable)
    {
        return [
            'medication_id' => $this->medication->id,
            'message' => $this->isUpcoming 
                ? 'Upcoming dose at ' . $this->doseTime->format('h:i A')
                : 'Time to take your medication!',
            'dose_time' => $this->doseTime,
            'type' => $this->isUpcoming ? 'upcoming' : 'current',
        ];
    }
}