<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\EventLogControllerBase;
use App\Http\Controllers\ApplicationInterface;
use Illuminate\Http\Request;
use App\Events\EventFired;
// for testing -------
use App\Models\Event\EventLog;
// use App\Models\Event\EventType;
use App\Models\Subscription\Subscription;

class EventLogController extends EventLogControllerBase implements ApplicationInterface
{
    use ApplicationTrait;

    /**
     * Store a newly created contact related event log.
     *
     * This method is useful to log events related with a contact
     * management.
     *
     * @param  Request  $request  The request containing all the parameters passed from the client
     * @return Json
     */
    public function storeContactRelated(Request $request)
    {
        // set the application validation rules
        $this->setValidationRules([
            'ip_address' => 'required|ip',
            'event_type_id' => 'required|integer',
            'contact_id' => 'required|integer',
            'member_id' => 'required|integer',
            'properties' => 'required|array'
        ]);

        return parent::store($request);
    }

    /**
     * Store a newly created non contact related event log.
     *
     * This method is useful to log events related with user
     * management for example:
     * - An user is created, enabled, disabled, updated.
     * - A role/privilege was added to a user.
     * - A membership was added to the user.
     *
     * @param  Request  $request The request containing all the parameters passed from the client
     * @return Json
     */
    public function storeUserRelated(Request $request)
    {
        // set the rules to validate request
        $this->setValidationRules([
            'ip_address' => 'required|ip',
            'event_type_id' => 'required|integer',
            'network_id' => 'sometimes|required|integer',
            'member_id' => 'sometimes|required|integer',
            'properties' => 'required|array',
        ]);

        // call parent store method
        return parent::store($request);
    }
}
