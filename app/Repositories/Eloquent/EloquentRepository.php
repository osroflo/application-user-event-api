<?php
namespace App\Repositories\Eloquent;

use App\Models\Event\EventLogApplicationAttribute;

/**
 * Base class for eloquent repositories
 */
class EloquentRepository
{
    protected $application_id = null;
    protected $application_name = null;

    public function setApplicationId($application_id)
    {
        $this->application_id = $application_id;
    }

    public function getApplicationId()
    {
        return $this->application_id;
    }

    public function setApplicationName($application_name)
    {
        $this->application_name = $application_name;
    }

    public function getApplicationName()
    {
        return $this->application_name;
    }

    /**
     * Get all the identifier attributes from DB
     *
     * The attributes are needed to create a log and are very
     * specific per application.
     *
     * @return array  Collection of event log models
     */
    public function getApplicationIdentifiers()
    {
        return EventLogApplicationAttribute::where('application_id', $this->getApplicationId())->get();
    }
}
