<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class EventPlaceHolderTransformer extends TransformerAbstract
{
    public function transform($placeholders)
    {
        $transformed_data = [];

        foreach ($placeholders as $event_placeholder) {
            $placeholder = $event_placeholder->placeholder;

            $transformed_data[] = [
                'id' => $placeholder->id,
                'label' => $placeholder->label,
                'description' => $placeholder->description
            ];
        }

        return $transformed_data;
    }
}
