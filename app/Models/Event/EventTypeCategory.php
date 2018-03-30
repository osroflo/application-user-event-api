<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class EventTypeCategory extends Model
{
    protected $table = 'event.event_type_category';
    protected $guarded = [
        'id'
    ];

    public function events()
    {
        return $this->hasMany(EventType::class, 'event_type_category_id');
    }

}
