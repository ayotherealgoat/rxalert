<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Throwable;

class TestEmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify mail configuration';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $recipient = 'ayomideoyelola12@gmail.com';

        try {
            Mail::raw('✅ Test email from Medication Reminder. Your mail configuration works!', function ($message) use ($recipient) {
                $message->to($recipient)
                        ->subject('Medication Reminder - Test Email');
            });

            $this->info("Test email sent successfully to {$recipient}.");
            return Command::SUCCESS;
        } catch (Throwable $e) {
            $this->error('❌ Email failed: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
