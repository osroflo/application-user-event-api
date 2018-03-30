<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\Response\FractalApiResponse;
use App\Repositories\Eloquent\SubscriberRepository;
use App\Transformers\SubscriberTransformer;
use App\Transformers\Serializers\CustomDataSerializer;
use Illuminate\Http\Request;
use Validator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Illuminate\Validation\ValidationException;

class SubscriberControllerBase extends Controller
{
    // format the response including the following child data
    public $parse_includes = ['event_log','event_log.event_type', 'event_log.properties'];

    /**
     * Construct
     *
     * @param SubscriberRepository $subscriber The subscriber repository object which containing all
     *                                          the mapping and logic to access the event log model
     * @param FractalApiResponse               The json response formatter object
     * @param Request $request                 The request containing all the parameters passed from the client
     */
    public function __construct(SubscriberRepository $subscriber, FractalApiResponse $response, Request $request)
    {
        $this->subscriber = $subscriber;
        $this->subscriber->setApplicationId($this->getApplicationId());
        $this->subscriber->setApplicationName($this->getApplicationName());
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request The request containing all the parameters passed from the client
     * @return Json
     */
    public function store(Request $request)
    {
        // validate the request to make sure all required parameter were passed
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // log the event in the db
        $subscriber = $this->subscriber->create($request->all());

        $this->response->setData($subscriber);

        return $this->response->success("Subscriber was created!");
    }

    /**
     * Update a Subscriber
     *
     * @param integer $id       The subscriber unique identifier
     * @param  Request $request The request containing all the parameters passed from the client
     * @return Json
     */
    public function update($id, Request $request)
    {
        // validate the request to make sure all required parameter were passed
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // update the subscriber
        $subscriber = $this->subscriber->update($id, $request->all());

        $this->response->setData($subscriber);

        return $this->response->success("Subscriber was updated!");
    }

    /**
     * Destroy a Subscriber
     *
     * @param integer $id       The subscriber unique identifier
     * @param Request $request  The request containing all the parameters passed from the client
     *
     * @return Json
     */
    public function destroy($id)
    {
        // update the subscriber
        $subscriber = $this->subscriber->delete($id);
        $this->response->setData($subscriber);

        return $this->response->success("Subscriber was deleted!");
    }

    /**
     * Show the subscriber
     *
     * @param  integer $id Subscriber unique identifier
     * @return Json
     */
    public function show($id)
    {
        // get entities from repository
        $subscriber = $this->subscriber->findById($id);

        return $this->response->buildItem($subscriber, new subscriberTransformer);
    }

    /**
     * Store a Subscription
     *
     * @param  integer $id            The subscriber unique identifier
     * @param  integer $event_type_id The event type to subscribe
     *
     * @return Json
     */
    public function storeSubscription($id, $event_type_id)
    {
        $subscriber = $this->subscriber->addSubscription($id, $event_type_id);

        $this->response->setData($subscriber);

        return $this->response->success("Subscription was added!");
    }

    /**
     * Destroy a Subscription
     *
     * @param  integer $id            The subscriber unique identifier
     * @param  integer $event_type_id The event type to subscribe
     *
     * @return Json
     */
    public function destroySubscription($id, $event_type_id)
    {
        $subscriber = $this->subscriber->removeSubscription($id, $event_type_id);

        $this->response->setData($subscriber);

        return $this->response->success("Subscription was deleted!");
    }

    /**
     * Update Subscriber Preferences
     *
     * @param  integer $id        Subscriber unique identifier
     * @param  Request $request   The request containing all the parameters passed from the client
     *
     * @return Json
     */
    public function setPreference($id, Request $request)
    {
        // validate the request to make sure all required parameter were passed
        $validator = Validator::make($request->all(), $this->getValidationRules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // log the event in the db
        $subscriber = $this->subscriber->setPreference($id, $request->all());

        $this->response->setData($subscriber);

        return $this->response->success("Subscriber preference updated!");
    }
}
