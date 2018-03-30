<?php
namespace App\Repositories;

interface EventTypeInterface
{
    public function getAll();
    public function findByCategory($application_id);
    public function findByApplicationId($application_id);
}
