<?php

namespace App\Jobs;

use App\Mail\MessageCreatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final class MessageCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public string $emailValue, public string $messageValue)
    {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            Mail::to($this->emailValue)->send(new MessageCreatedMail($this->messageValue));
            Log::info('Email was sent to: ' . $this->emailValue);
        } catch (\Throwable $e) {
            Log::error(__CLASS__ . ' ' .  $e->getMessage());
        }
    }
}
