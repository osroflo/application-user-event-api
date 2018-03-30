<?php
namespace App\Repositories;

interface SubscriberInterface
{
    public function create(array $data);
    public function findById($id);

}
