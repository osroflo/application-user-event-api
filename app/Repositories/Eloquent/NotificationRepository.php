<?php
namespace App\Repositories\Eloquent;

use App\Repositories\NotificationInterface;
use App\Models\Notification\Notification;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * This class is the collection of Notifications also called repository
 */
class NotificationRepository extends EloquentRepository implements NotificationInterface
{
    /**
     * Insert a notification
     *
     * This method will be used internally only (when an event is
     * triggered by send() method in the Notification logic). There is no use
     * case where the notification will be created externally using an api endpoint.
     *
     * @param $data array  The data to create the notification
     *
     * @return Notification
     */
    public function create(array $data)
    {
        if (empty($data)) {
            return false;
        }

        $notification = Notification::create($data);

        return $notification;
    }

    /**
     * Find event types by event type category label
     *
     * @param  integer $subscriber_id  The subscriber unique identifier
     * @return collection
     */
    public function findBySubscriberId($subscriber_id = null)
    {
        $notification  = Notification::where('subscriber_id', $subscriber_id)->get();

        if ($notification->isEmpty()) {
            throw new ModelNotFoundException;
        }

        return $notification;
    }

    /**
     * Find notification by id
     *
     * @param  integer $id  The notification unique identifier
     * @return Notification
     */
    public function findById($id = null)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            throw new ModelNotFoundException;
        }

        return $notification;
    }
}
