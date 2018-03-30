<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class SubscriberTransformer extends TransformerAbstract
{
    // protected $availableIncludes = [
    //     'properties',
    //     'event_type'
    // ];

    public function transform($subscriber)
    {
        $items = [
            'id' => $subscriber->id,
            'application_id' => $subscriber->application_id,
            'user_id' => $subscriber->user_id,
            'member_id' => $subscriber->member_id,
            'created_at' => $subscriber->created_at
        ];

        if (empty($subscriber->member_id)) {
            unset($items['member_id']);
        }

        if (empty($subscriber->user_id)) {
            unset($items['user_id']);
        }

        return $items;
    }

    // public function includeProperties($eventLog)
    // {
    //     return $this->item($eventLog->properties, new EventLogPropertyTransformer(), false);
    // }

    // public function includeEventType($eventLog)
    // {
    //     return $this->item($eventLog->eventType, new EventTypeTransformer(), false);
    // }
}
