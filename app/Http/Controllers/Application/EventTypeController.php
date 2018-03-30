<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\EventTypeControllerBase;
use App\Http\Controllers\ApplicationInterface;

class EventTypeController extends EventTypeControllerBase implements ApplicationInterface
{
    use ApplicationTrait;
}
