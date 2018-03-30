<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\Response\FractalApiResponse;
use App\Repositories\Eloquent\NotificationRepository;
use App\Transformers\NotificationTransformer;
use App\Transformers\Serializers\CustomDataSerializer;
use Illuminate\Http\Request;
use Validator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Illuminate\Validation\ValidationException;

class NotificationControllerBase extends Controller
{
    // response including child data
    public $parse_includes = ['event_log','event_log.event_type', 'event_log.properties'];

    /**
     * Inject all necessary objects
     *
     * @param NotificationRepository $eventLogs The notification repository object which containing all
     *                                          the mapping and logic to access the event log model
     * @param FractalApiResponse  $response     The json response formatter object
     * @param Request $request                  The request containing all the parameters passed from the client
     */
    public function __construct(NotificationRepository $notification, FractalApiResponse $response, Request $request)
    {
        $this->notification = $notification;
        $this->notification->setApplicationId($this->getApplicationId());
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * Show notification by id
     *
     * @param  integer $id Notification unique identifier
     * @return json
     */
    public function show($id)
    {
        // get entities from repository
        $notification = $this->notification->findById($id);
        $this->response->setParseIncludes($this->parse_includes);

        return $this->response->buildItem($notification, new NotificationTransformer);
    }

    /**
     * Show all notification
     *
     * @return json
     */
    public function index()
    {
        $events = $this->notification->findByApplicationId();
        $this->response->setParseIncludes($this->parse_includes);

        return $this->response->buildCollection($events, new NotificationTransformer);
    }

    /**
     * Show notifications by category
     *
     * @return json
     */
    public function byCategory()
    {
        $events = $this->notification->findByCategory($this->request->input('label'));
        $this->response->setParseIncludes($this->parse_includes);

        return $this->response->buildCollection($events, new NotificationTransformer);
    }
}
