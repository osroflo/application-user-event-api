<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventLogAttributeValue extends Model
{
    protected $table = 'event.event_log_attribute_value';

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    public function attribute()
    {
        return $this->belongsTo(EventLogApplicationAttribute::class, 'event_log_application_attribute_id');
    }

    public function eventLog()
    {
        return $this->belongsTo(EventLog::class, 'event_log_id');
    }
}
