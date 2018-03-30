<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class EventLogPropertyTransformer extends TransformerAbstract
{
    /**
     * Transform the response using a specific format.
     *
     * Since the user will get the properties and replace them in the message,
     * it is needed to return an object instead of an array.
     *
     * @param  Collection $event_log_property  Array with logProperty models
     * @return array
     */
    public function transform($event_log_property)
    {
        $formatted_response = [];
        foreach ($event_log_property as $property) {
            $placeholder = $property->placeholder;
            $key = strtolower($placeholder->label);
            $value = $property->value;
            $formatted_response[$key] = ['value' => $value ];
        }

        return $formatted_response;
    }
}
