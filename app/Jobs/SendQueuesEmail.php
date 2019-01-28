<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use Illuminate\Console\Command;

class SendQueuesEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;
    private $fileName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $email, string $fileName)
    {
        $this->email = $email;
        $this->fileName = $fileName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::raw('Excel.csv', function ($message) {
            $message->to($this->email);
            $message->subject('Report data!');
            $message->attach(storage_path('app/'.$this->fileName));
        });
    }
}
