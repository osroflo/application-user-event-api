<?php
namespace App\Transformers;

use App\Models\Event\EventType;
use League\Fractal\TransformerAbstract;

class EventTypeTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'category'
    ];

    public function transform($eventType)
    {
        return [
            'label' => $eventType->label,
            'message' => $eventType->message,
        ];
    }

    public function includeCategory($eventType)
    {
        return $this->item($eventType->category, new EventTypeCategoryTransformer(), false);
    }
}
