<?php

namespace App\Listeners;

use App\Events\EventFired;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\NotificationFactory;

class NotifySubscribers implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EventFired  $event
     * @return void
     */
    public function handle(EventFired $event)
    {
        // get notification for application
        $notification = NotificationFactory::build($event->application_name, $event->event_log);
        $notification->send();
    }
}
