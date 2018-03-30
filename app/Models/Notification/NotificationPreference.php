<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    protected $table = 'event.notification_preferences';
    protected $fillable = ['subscriber_id', 'by_email', 'updated_at'];
}
