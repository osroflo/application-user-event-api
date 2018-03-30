<?php

namespace App\Models\User\Application;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\UserInterface;
use App\Models\ReadOnlyTrait;
use App\Models\User\Application\UserMembership;

class User extends Model implements UserInterface
{
    use ReadOnlyTrait;

    protected $table = 'cc.user';
    protected $primaryKey = 'user_id';
    protected $hidden = ['last_activity', 'recent_contacts', 'password', 'hash_key', 'status_id'];

    public function getFullName()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function getEmail()
    {
        return $this->email_address;
    }

    public static function findByMemberId($member_id)
    {
        // get the member
        $member = UserMembership::find($member_id);

        return $member->user;
    }
}
