<?php

namespace App\Models\Subscription\Application;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription\BaseSubscriber;
use App\Models\Subscription\SubscriberInterface;
use App\Models\User\Application\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Subscriber extends BaseSubscriber implements SubscriberInterface
{
    /**
     * Get the user profile related with the subscriber
     *
     * @return Application/User
     */
    public function profile()
    {
        return User::findByMemberId($this->user_identity);
    }
}
