<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Carbon\Carbon;
use App\Models\Event\EventLog;

/**
 * This is a custom transformer to present the data for notifications in a format
 * that is easy to understand for users.
 *
 * The models involved are:
 * - event_log
 */
class NotificationTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'event_log'
    ];

    public function transform($notification)
    {
        return [
            'id' => $notification->id,
            'subscriber_id' => $notification->subscriber_id,
            'event_log_id' => $notification->event_log_id,
            'was_read' => (bool) $notification->was_read,
            'delivered_by_email' => (bool) $notification->delivered_by_email,
            'email_sent' => (bool) $notification->email_sent,
            'created_at' => $notification->created_at,
            'updated_at' => $notification->updated_at
        ];
    }

    public function includeEventLog($notification)
    {
        return $this->item($notification->eventLog, new EventLogTransformer(), false);
    }
}
