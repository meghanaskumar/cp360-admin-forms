<?php

namespace App\Jobs;

use App\Mail\FormCreatedNotification;
use App\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFormCreatedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $form;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to('meghanaskumarit@gmail.com')->send(new FormCreatedNotification($this->form));
    }
}

