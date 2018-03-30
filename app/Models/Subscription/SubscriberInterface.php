<?php
namespace App\Models\Subscription;

interface SubscriberInterface
{
    /**
     * Get the user profile related with the subscriber
     */
    public function profile();

    /**
     * Find a subscriber by application and user or member id
     *
     * @param  integer $application_id  The application id: Application, Resource, etc
     * @param  integer $user_identity   The member or the user id (it is just the identifier)
     */
    public static function findByUserIdentity($application_id, $user_identity);
}
