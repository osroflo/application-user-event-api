<?php
namespace App\Http\Controllers;

/**
 * Ensure that class will implement all these methods
 */
interface ApplicationInterface
{
    /**
     * This method will handle the logic to get current application id
     */
    public function getApplicationId();
}
