<?php

namespace App\Events;

use App\Models\Event\EventLog;

/**
 * This class generic event. Since there are so many
 * possible events this will taje any event that was
 * fired.
 *
 * The listener will send notifications to
 * subscribers.
 */
class EventFired extends Event
{
    public $event_log;
    public $application_name;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(EventLog $eventLog, $application_name)
    {
        $this->event_log = $eventLog;
        $this->application_name = $application_name;
    }
}
