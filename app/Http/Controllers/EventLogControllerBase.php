<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\Response\FractalApiResponse;
use App\Repositories\Eloquent\EventLogRepository;
use App\Transformers\EventLogTransformer;
use App\Transformers\Serializers\CustomDataSerializer;
use Illuminate\Http\Request;
use Validator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Illuminate\Validation\ValidationException;

class EventLogControllerBase extends Controller
{
    // response including child data
    public $parse_includes = ['properties', 'event_type.category'];

    /**
     * Inject all necessary objects
     *
     * @param EventLogRepository $eventLogs The Event log repository object which containing all
     *                                      the mapping and logic to access the event log model
     * @param FractalApiResponse $response  The json response formatter object
     */
    public function __construct(EventLogRepository $eventLogs, FractalApiResponse $response)
    {
        $this->eventLogs = $eventLogs;
        $this->eventLogs->setApplicationId($this->getApplicationId());
        $this->eventLogs->setApplicationName($this->getApplicationName());
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Json
     */
    public function index()
    {
        $events = $this->eventLogs->getAll();

        $this->response->setParseIncludes($this->parse_includes);
        $this->response->withPagination();

        return $this->response->buildCollection($events, new EventLogTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request The request containing all the parameters passed from the client
     * @return Json
     */
    public function store(Request $request)
    {
        // validate if the request has the required application parameters
        $validator = Validator::make($request->all(), $this->getValidationRules());
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // validate if the request has the required event parameters
        $this->eventLogs->setEventProperties($request->input('event_type_id'));
        $validator = Validator::make($request->all(), $this->eventLogs->getEventValidationRules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // log the event in the db
        $eventLog = $this->eventLogs->create($request->all());
        $this->response->setData($eventLog);

        return $this->response->success("The event was logged!");
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id  The event log unique identifier
     * @return Json
     */
    public function show($id)
    {
        // get entities from repository
        $log = $this->eventLogs->findById($id);
        $this->response->setParseIncludes($this->parse_includes);
        // the event log transformer will allow to transform the data to json
        return $this->response->buildItem($log, new EventLogTransformer);
    }
}
