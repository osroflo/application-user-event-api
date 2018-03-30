<?php

namespace App\Models\Subscription;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notification\NotificationPreference;
use App\Models\Event\EventType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * The subscriber model is like a lookup table, used to solve the current challenge,
 * where users are stored in different tables depending on the application.
 *
 * Users are stored in different tables, for example:
 * - Application users are in cc.user. Also in Application an user can have multiple
 *   identities or memberships.
 *
 * - Resource users are in c.users or probably some new schema. Not all applications
 *   have users with multiple identities.
 *
 * A subscriber is an user (or an identity) that is registered to get event notifications.
 * It is composed by application_id and user_id or member_id.
 */
class BaseSubscriber extends Model
{
    protected $table = 'event.subscriber';
    protected $fillable = ['application_id', 'user_identity', 'active'];

    /**
     * Get subscriber by application and user identity
     *
     * The user identity  can be an user_id or a member_id:
     * - A user_id denotes that the user only have ONE identity in the whole application.
     * - A member id denotes that the user have MULTIPLE identities or memberships in the same application.
     *
     * The application id will dictate if the user identity is a user or a member.  For example:
     * - Application application should provide only member id.
     * - Other Application application should provide user id.
     * - Another applications, like resource, may have a different user identity
     *
     * NOTES:
     * - The user identity will be used to get the user profile information, like: first name, last name,
     *   email etc.
     * - User profiles can be stored in different tables or probably different databases or API.
     *
     * @param  integer $application_id  The application id
     * @param  integer $user_identity              The user or member id depending on the application
     * @return Subscriber
     */
    public static function findByUserIdentity($application_id, $user_identity)
    {
        $subscriber = self::where(['application_id' => $application_id, 'user_identity' => $user_identity])->first();

        if (empty($subscriber)) {
            throw new ModelNotFoundException;
        }

        return $subscriber;
    }

    /**
     * Check if subscriber has a subscription to get notifications
     * for the event type.
     *
     * @param  integer  $event_type_id    The id for the type of event
     * @return boolean
     */
    public function hasSubscription($event_type_id)
    {
        return (Subscription::where(['event_type_id' => $event_type_id])->exists());
    }

    /**
     * Get all the subscriber event subscriptions
     *
     * @return Collection
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'subscriber_id');
    }

    /**
     * Get subscriber notification preference
     *
     * like get notifications by: email, text, etc.
     *
     * @return NotificationPreference
     */
    public function notificationPreference()
    {
        return $this->belongsTo(NotificationPreference::class, 'id', 'subscriber_id');
    }

    /**
     * Check if the subscriber exists
     *
     * @param  array  $data Parameters
     * @return boolean
     */
    public function exists(array $data)
    {
        $subscriber = self::where($data)->get();

        return !$subscriber->isEmpty();
    }

    /**
     * Subscribes the subscriber to all events
     *
     * When a new subscriber is created it automatically
     * is subscribed to all application events.
     */
    public function subscribeToAll()
    {
        // get all event types for Application
        $eventTypes = EventType::findByapplicationId($this->application_id);
        // add subscriptions to subscriber
        $subscriptions = [];

        foreach ($eventTypes as $eventType) {
            $subscriptions[] = [
                'subscriber_id' => $this->id,
                'event_type_id' => $eventType->id
            ];
        }

        $this->addSubscriptions($subscriptions);
    }

    /**
     * Add subscription for user
     *
     * @param array $subscriptions [description]
     */
    public function addSubscriptions(array $subscriptions = [])
    {
        if ($subscriptions) {
            Subscription::createManyOrIgnore($subscriptions);
            // $this->subscriptions()->createMany($subscriptions);
        }
    }

    /**
     * update or create a notification preference for the subscriber
     *
     * @param array $data
     */
    public function setPreference(array $data = [])
    {
        if ($data) {
            $data['subscriber_id'] = $this->id;
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            // get subscriber preference (if any)
            $notificationPreference = $this->notificationPreference;
            // create or update the preference
            if (empty($notificationPreference)) {
                $notificationPreference = $this->notificationPreference()->create($data);
            } else {
                $notificationPreference->update($data);
            }

            return $notificationPreference;
        }
    }

    /**
     * Delete Subscription
     *
     * @param  integer  $event_type_id
     *
     * @return Subscription
     */
    public function deleteSubscription($event_type_id)
    {
        $data = [
            'subscriber_id' => $this->id,
            'event_type_id' => $event_type_id
        ];

        $subscription = Subscription::where($data)->first();

        if (!$subscription) {
            throw new ModelNotFoundException;
        }

        $subscription->delete();

        return $subscription;
    }
}
