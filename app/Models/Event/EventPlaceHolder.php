<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventPlaceHolder extends Model
{
    protected $table = 'event.event_placeholder';

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    public function property()
    {
        return $this->belongsTo(EventLogProperty::class);
    }

    public static function findByLabel($value)
    {
        return self::where('label', '=', $value)->first();
    }
}
