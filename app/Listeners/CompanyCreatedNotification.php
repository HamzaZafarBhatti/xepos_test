<?php

namespace App\Listeners;

use App\Events\CompanyCreated;
use App\Mail\CompanyCreated as MailCompanyCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class CompanyCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CompanyCreated $event): void
    {
        //
        Mail::to($event->company->email)->send(new MailCompanyCreated($event->company->name));
    }
}
