<?php

namespace App\Notifications\Application;

use Illuminate\Support\Facades\Mail;
use App\Mail\Application\EventNotification;
use App\Models\Event\EventLog;
use App\Models\Subscription\Application\Subscriber;
use App\Repositories\Eloquent\NotificationRepository;

class Notification
{
    private $subscribers = [];

    /**
     * Inject all necessary objects
     *
     * @param EventLog $event_log  The event log model
     */
    public function __construct(EventLog $event_log)
    {
        $this->event_log = $event_log;
    }

    /**
     * Get all users involved in the event
     *
     * The subscribers should have a subscription to
     * get notification for the event.
     */
    public function getSubscribers()
    {
        $properties = $this->event_log->properties;
        $subscribers = [];

        foreach ($properties as $property) {
            $placeholder = $property->placeholder;
            // get all properties that are users
            if ($placeholder->is_user) {
                $member_id = $property->value;
                $subscriber = Subscriber::findByApplication($this->event_log->application_id, $member_id);

                // check if subscribers are subscribed to get notifications for this event
                if ($subscriber->hasSubscription($this->event_log->event_type_id)) {
                    $subscribers[] = $subscriber;
                }
            }
        }

        // store subscribers
        $this->subscribers = $subscribers;
    }

    /**
     * Send the notification to subscribers
     */
    public function send()
    {
        // get subscribers
        $this->getSubscribers();
        $delivered_by_email = false;
        $email_sent = false;
        // send notifications by the subscriber preferences
        foreach ($this->subscribers as $subscriber) {
            $preference = $subscriber->notificationPreference;

            if ($preference->by_email) {
                $delivered_by_email = true;
                $profile = $subscriber->profile();
                $email_sent = $this->sendByEmail($profile->getEmail());
            }

            // save notification in system db where users|members will be able to read it
            $notificationRepository = new NotificationRepository();
            $notification = $notificationRepository->create([
                'subscriber_id' => $subscriber->id,
                'event_log_id' => $this->event_log->id,
                'delivered_by_email' => $delivered_by_email,
                'email_sent' => $email_sent
            ]);
        }
    }

    /**
     * Send notification by email
     *
     * @param  string $email The subscriber email address
     * @return boolean
     */
    public function sendByEmail($email)
    {
        // send the notification by email
        Mail::to($email)->send(new EventNotification($this->event_log));

        return count(Mail::failures()) == 0;
    }
}
