<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event\EventLog;

class Notification extends Model
{
    protected $table = 'event.notification';
    protected $fillable = ['subscriber_id', 'event_log_id', 'was_read', 'delivered_by_email', 'email_sent'];

    public function eventLog()
    {
        return $this->belongsTo(EventLog::class, 'event_log_id');
    }
}
