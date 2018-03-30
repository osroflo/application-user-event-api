<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

/**
 * Look up model to get all event types with
 * possible placeholders.
 */
class EventTypePlaceHolder extends Model
{
    protected $table = 'event.event_type_placeholder';

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    // public function property()
    // {
    //     return $this->belongsTo(EventLogProperty::class);
    // }

    public function placeholder()
    {
        return $this->belongsTo(EventPlaceHolder::class, 'event_placeholder_id');
    }

    public static function findByLabel($value)
    {
        return self::where('label', '=', $value)->first();
    }
}
