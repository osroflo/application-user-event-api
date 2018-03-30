<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * This is a custom transformer to present the data for event types in a format
 * that is easy to understand for users.
 *
 * The models involved are:
 * - event_type
 * - event_type_placeholder (look up table)
 * - event_type_category
 */
class EventTypePlaceHolderTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'placeholders',
        'category'
    ];

    public function transform($eventType)
    {
        return [
            'id' => $eventType->id,
            'active' => $eventType->active,
            'label' => $eventType->label,
            'message' => $eventType->message
        ];
    }

    public function includeCategory($eventType)
    {
        return $this->item($eventType->category, new EventTypeCategoryTransformer(), false);
    }

    public function includePlaceHolders($eventType)
    {
        return $this->item($eventType->placeholders, new EventPlaceHolderTransformer(), false);
    }
}
