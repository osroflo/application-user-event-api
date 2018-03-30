<?php
namespace App\Notifications;

use App\Models\Event\EventLog;

class NotificationFactory
{
    /**
     * Build the proper notification object
     *
     * @param  string   $applicationName  The application name
     * @param  EventLog $eventLog         The event log model
     */
    public static function build($applicationName, EventLog $eventLog)
    {
        $notificationClass = "App\Notifications\\$applicationName\Notification";

        if (class_exists($notificationClass)) {
            return new $notificationClass($eventLog);
        } else {
            throw new \Exception("Invalid notification class name: $notificationClass");
        }
    }
}
