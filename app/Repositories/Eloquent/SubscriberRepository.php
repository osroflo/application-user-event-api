<?php
namespace App\Repositories\Eloquent;

use App\Repositories\SubscriberInterface;
use App\Models\Subscription\SubscriberFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Carbon\Carbon;

use App\Models\User\Application\UserMembership;

/**
 * This class is the collection of Subscribers also
 * called repository
 */
class SubscriberRepository extends EloquentRepository implements SubscriberInterface
{

    /**
     * Create a new subscriber
     *
     * @param $data array  The data to create the notification
     *
     * @return Subscriber
     */
    public function create(array $data)
    {
        $member = UserMembership::find(42);
        return $member->user;

        // instantiate the proper subscriber model for the application
        $subscriber = SubscriberFactory::build($this->getApplicationName());

        // add application id
        $data['application_id'] = $this->getApplicationId();
        // if subscriber doesn't exist, create
        if ($subscriber->exists($data)) {
            throw new ConflictHttpException;
        }

        $newSubscriber = $subscriber->create($data);
        // add subscriptions to all events for the newly created subscriber
        $newSubscriber->subscribeToAll();
        // set subscriber default notification preference
        $newSubscriber->setPreference(['by_email' => true]);

        return $newSubscriber;
    }

    /**
     * Update a subscriber
     *
     * @param integer $id   The subscriber unique identifier
     * @param array $data   The data to create the notification
     *
     * @return Subscriber
     */
    public function update($id, array $data)
    {
        // instantiate the proper subscriber model for the application
        $subscriber = $this->findById($id);
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        // update
        $subscriber->update($data);
        // return a fresh model
        return $subscriber->fresh();
    }

    /**
     * Delete a subscriber
     *
     * This method apply the cascade delete in all subscriber relations
     *
     * @param $id integer   The subscriber unique identifier
     *
     * @return Subscriber
     */
    public function delete($id)
    {
        // instantiate the proper subscriber model for the application
        $subscriber = $this->findById($id);
        // delete the subscriber
        $subscriber->delete();

        return $subscriber;
    }

    /**
     * Find subscriber by id
     *
     * @param  integer $id  The subscriber unique identifier
     * @return Subscriber
     */
    public function findById($id = null)
    {
        // instantiate the proper subscriber model for the application
        $subscriberInstance = SubscriberFactory::build($this->getApplicationName());

        $subscriber = $subscriberInstance->find($id);

        if (!$subscriber) {
            throw new ModelNotFoundException;
        }

        return $subscriber;
    }

    /**
     * Add a Subscription event from subscriber
     *
     * @param integer $subscriber_id  The subscriber unique identifier
     * @param integer $event_type_id  The event type unique identifier
     * @return Subcriber              The subscriber with subscriptions
     */
    public function addSubscription($subscriber_id, $event_type_id)
    {
        // get the subscriber
        $subscriber = $this->findById($subscriber_id);
        $subscription = [
            'subscriber_id' => $subscriber_id,
            'event_type_id' => $event_type_id
        ];

        // subscribe the subscriber to get notification for the event
        return $subscriber->subscriptions()->firstOrCreate($subscription);
    }

    /**
     * Remove a Subscription event from subscriber
     *
     * @param integer $subscriber_id  The subscriber unique identifier
     * @param integer $event_type_id  The event type unique identifier
     * @return Subscriber
     */
    public function removeSubscription($subscriber_id, $event_type_id)
    {
        // get the subscriber
        $subscriber = $this->findById($subscriber_id);
        return $subscriber->deleteSubscription($event_type_id);
    }

    /**
     * Set Subscriber notification preferences
     *
     * @param integer $subscriber_id  The subscriber unique identifier
     * @param Subscriber
     */
    public function setPreference($subscriber_id, $data = [])
    {
        // get the subscriber
        $subscriber = $this->findById($subscriber_id);
        // set the subscriber preferences
        return $subscriber->setPreference($data);
    }

    /**
     * Find a subscriber by application logic
     *
     * @param $id integer   The member_id or the user id according to the application.
     *                      Application uses member_id concept, other applications can
     *                      use user_id unless other applications also has the concept
     *                      of memberships.
     *
     * @return Subscriber
     */
    public function findByApplication($id = null)
    {
        // instantiate the proper subscriber model for the application
        $subscriberInstance = SubscriberFactory::build($this->getApplicationName());
        // find the subscriber by user_id or member_id
        $subscriber = $subscriberInstance->findByApplication($this->getApplicationId(), $id);

        return $subscriber;
    }
}
