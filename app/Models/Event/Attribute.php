<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'event.attribute';

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];
}
