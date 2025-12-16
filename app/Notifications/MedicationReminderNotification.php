<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Medication;

class MedicationReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $medication;

    public function __construct(Medication $medication)
    {
        $this->medication = $medication;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🔔 Medication Reminder: ' . $this->medication->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('⏰It\'s time to take your medication:')
            ->line('Medication: ' . $this->medication->name)
            ->line('Dosage: ' . $this->medication->dosage)
            ->when($this->medication->notes, function ($message) {
                return $message->line('Instructions: ' . $this->medication->notes);
            })
            ->action('View Details', url('/dashboard'))
            ->line('Stay consistent and stay healthy! 🌟');
    }

    public function toArray($notifiable)
    {
        return [
            'medication_id' => $this->medication->id,
            'medication_name' => $this->medication->name,
            'dosage' => $this->medication->dosage,
            'time' => now()->format('h:i A'),
            'notes' => $this->medication->notes,
        ];
    }
}
