<?php
namespace App\Models\Subscription;

class SubscriberFactory
{

    public static function build($applicationName)
    {
        $subscriberClass = "App\Models\Subscription\\$applicationName\Subscriber";

        if (class_exists($subscriberClass)) {
            return new $subscriberClass();
        } else {
            throw new \Exception("Invalid notification class name: $subscriberClass");
        }
    }
}
