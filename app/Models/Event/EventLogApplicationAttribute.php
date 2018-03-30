<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventLogApplicationAttribute extends Model
{
    protected $table = 'event.event_log_application_attribute';

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    public function properties()
    {
        return $this->hasMany(EventLogProperty::class);
    }

    public function eventType()
    {
        return $this->hasOne(EventType::class, 'id', 'event_type_id');
    }

    public function addProperties(array $properties = [])
    {
        if ($properties) {
            $this->properties()->createMany($properties);
        }
    }

    /**
     * GetMessage
     *
     * This method return the binded message for the event log, the placeholders
     * are replaced with actual value
     *
     * @return string
     */
    public function getMessage()
    {
        $logProperties = $this->properties;
        $params = [];

        // Get all properties tied to this log
        foreach ($this->properties as $property) {
            $placeholder = $property->placeholder;
            $value = $property->value;
            $params[$placeholder->label] = $value;
        }

        // Format the log message by using the properties and the placeholder.
        // If event is not found then return null to avoid crash the UI
        // an event is not found if the event_type_id is not set in the event.event_log table
        return $this->eventType->bindParamsToMessage($params) ?: null;
    }
}
