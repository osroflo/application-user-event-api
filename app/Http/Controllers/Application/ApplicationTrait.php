<?php
namespace App\Http\Controllers\Application;

/**
 * Application trait to share application id
 * across Application controllers.
 */
trait ApplicationTrait
{
    private $application_id = 1;
    private $application_name = 'Application';

    /**
     * Get the application id for the current
     * class implementing this trait
     *
     * @return integer The application id
     */
    public function getApplicationId()
    {
        return $this->application_id;
    }

    /**
     * Get the application name or label for the current
     * class implementing this trait
     *
     * @return string The application name
     */
    public function getApplicationName()
    {
        return $this->application_name;
    }
}
