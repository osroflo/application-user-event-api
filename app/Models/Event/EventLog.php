<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    protected $table = 'event.event_log';

    public $timestamps = false;

    protected $fillable = ['event_type_id', 'ip_address', 'application_id'];

    /**
     * Event log properties relation
     *
     * Properties that are used to pass placeholders values.
     *
     * @return array Collection
     */
    public function properties()
    {
        return $this->hasMany(EventLogProperty::class);
    }

    /**
     * Event log identifiers relation
     *
     * Get extra attributes that are required to create a log. The
     * attributes are unique per application. Like: network_id,
     * contact_id, etc.
     *
     * @return array Collection
     */
    public function attributes()
    {
        return $this->hasMany(EventLogAttributeValue::class);
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

    public function addAttributes(array $attributes = [])
    {
        if ($attributes) {
            $this->attributes()->createMany($attributes);
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
