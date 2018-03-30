<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $table = 'event.event_type';
    protected $guarded = [
        'id'
    ];

    public function placeholders()
    {
        return $this->hasMany(EventTypePlaceHolder::class, 'event_type_id');
    }

    public function category()
    {
        return $this->belongsTo(EventTypeCategory::class, 'event_type_category_id');
    }

    /**
     * Bind params
     * Replace placeholders with actual values
     */
    public function bindParamsToMessage($params)
    {
        $message = $this->message;
        $pattern = '/{(.*?)}/';
        $replacement = '---';

        foreach ($params as $key => $value) {
            $message = str_replace('{' . $key . '}', $value, $message);
        }

        // If after binding a placeholder is found in the message {CONTACT_ID} it means that
        // there are not values set in DB for the placeholders. Just replace the
        // placeholders with ---
        return preg_replace($pattern, $replacement, $message);
    }

    public static function findByapplicationId($application_id = null)
    {
        if ($application_id) {
            return self::where(['application_id' => $application_id])->get();
        }

        return false;
    }
}
