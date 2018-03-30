<?php

namespace App\Models\Network\Application;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReadOnlyTrait;

class Network extends Model
{
    use ReadOnlyTrait;

    protected $table = 'cc.network';
    protected $primaryKey = 'network_id';
}