<?php

namespace App\Models\User\Application;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReadOnlyTrait;
use App\Models\Organization\Application\Organization;
use App\Models\Network\Application\Network;

class UserMembership extends Model
{
    use ReadOnlyTrait;

    protected $table = 'cc.user_membership';
    protected $primaryKey = 'member_id';

    public function organization()
    {
        return $this->hasOne(Organization::class, 'org_id', 'org_id');
    }

    public function network()
    {
        return $this->hasOne(Network::class, 'network_id', 'network_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
}