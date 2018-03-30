<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class EventTypeCategoryTransformer extends TransformerAbstract
{
    public function transform($eventTypeCategory)
    {
        return [
            'id' => $eventTypeCategory->id,
            'label' => $eventTypeCategory->label,
            'description' => $eventTypeCategory->description,
        ];
    }
}
