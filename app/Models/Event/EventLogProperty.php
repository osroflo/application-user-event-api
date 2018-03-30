<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventLogProperty extends Model
{
    protected $table = 'event.event_log_property';

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    public function placeholder()
    {
        return $this->hasone(EventPlaceHolder::class, 'id', 'event_placeholder_id');
    }

    public function log()
    {
        return $this->belongsTo(EventLog::class);
    }
}
