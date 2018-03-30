<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class EventLogTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'properties',
        'event_type'
    ];

    public function transform($eventLog)
    {
        // get event log attributes values
        $event_log_attributes =  $eventLog->attributes;
        $attributes = [];

        foreach ($event_log_attributes as $log_attribute) {
            $identifier = $log_attribute->attribute->identifier;
            $attributes[$identifier] = $log_attribute->value;
        }

        // response
        $items = [
            'id' => $eventLog->id,
            'date' => $eventLog->date,
            'ip_address' => $eventLog->ip_address
        ];

        return array_merge($items, $attributes);
    }

    public function includeProperties($eventLog)
    {
        return $this->item($eventLog->properties, new EventLogPropertyTransformer(), false);
    }

    public function includeEventType($eventLog)
    {
        return $this->item($eventLog->eventType, new EventTypeTransformer(), false);
    }
}
