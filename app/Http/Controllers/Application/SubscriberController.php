<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\SubscriberControllerBase;
use App\Http\Controllers\ApplicationInterface;
use Illuminate\Http\Request;
use App\Models\Subscription\Application\Subscriber;

class SubscriberController extends SubscriberControllerBase implements ApplicationInterface
{
    use ApplicationTrait;

    /**
     * Show a subscriber by searching for member id
     *
     * @param  integer $id   The member unique identifier
     * @return Json
     */
    public function showByMember($id)
    {
        // log the event in the db
        $subscriber = $this->subscriber->findByApplication($id);

        $this->response->setData($subscriber);

        return $this->response->success();
    }

    /**
     * Store a Subscriber
     *
     * @param  Request $request The request containing all the parameters passed from the client
     * @return Json
     */
    public function store(Request $request)
    {
        // set the rules to validate request
        $this->setValidationRules([
            'user_identity' => 'required|integer'
        ]);

        // call parent store method
        return parent::store($request);
    }

    /**
     * Update a Subscriber by passing a member id
     *
     * @param integer $id       The member unique identifier
     * @param Request $request  User parameters
     *
     * @return Json
     */
    public function updateByMember($id, Request $request)
    {
        // set the rules to validate request
        $this->setValidationRules([
            'active' => 'required|boolean'
        ]);

        // update the subscriber
        $subscriber = $this->subscriber->findByApplication($id);

        return parent::update($subscriber->id, $request);
    }

    /**
     * Delete a subscriber by member id
     *
     * The majority of the uses cases to delete a subscriber will be from the
     * application (when administrators are disabling users). The application may
     * not store a relation between member or user id and the subscriber
     *
     * @param  integer $id The member unique identifier
     * @return Json
     */
    public function destroyByMember($id)
    {
        // log the event in the db
        $subscriber = $this->subscriber->findByApplication($id);

        return parent::destroy($subscriber->id);
    }

    /**
     * Set Preference notification preferences
     *
     * @param integer  $id      The subscriber unique identifier
     * @param Request $request  Extra parameters
     */
    public function setPreference($id, Request $request)
    {
        // set the rules to validate request
        $this->setValidationRules([
            'by_email' => 'required|boolean'
        ]);

        // call parent store method
        return parent::setPreference($id, $request);
    }
}
