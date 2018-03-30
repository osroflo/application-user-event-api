<?php

namespace App\Models\Organization\Application;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReadOnlyTrait;

class Organization extends Model
{
    use ReadOnlyTrait;

    protected $table = 'cc.org';
    protected $primaryKey = 'org_id';
}