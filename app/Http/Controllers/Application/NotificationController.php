<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\NotificationControllerBase;
use App\Http\Controllers\ApplicationInterface;

class NotificationController extends NotificationControllerBase implements ApplicationInterface
{
    use ApplicationTrait;
}
