<?php
namespace App\Repositories;

interface EventLogInterface
{
    public function getAll();
    public function create(array $data);
    public function findById($id);

}
