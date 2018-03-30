<?php
namespace App\Repositories;

interface NotificationInterface
{
    public function findBySubscriberId($subscriber_id);
    public function create(array $data);
    public function findById($id);

}
