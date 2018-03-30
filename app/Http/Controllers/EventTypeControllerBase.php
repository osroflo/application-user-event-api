<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\Response\FractalApiResponse;
use App\Repositories\Eloquent\EventTypeRepository;
use App\Transformers\EventTypePlaceHolderTransformer;
use App\Transformers\Serializers\CustomDataSerializer;
use Illuminate\Http\Request;
use Validator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Illuminate\Validation\ValidationException;

class EventTypeControllerBase extends Controller
{
    // response including child data
    public $parse_includes = ['placeholders', 'category'];

    /**
     * Inject all necessary objects
     *
     * @param EventTypeRepository $eventLogs The Event type repository object which containing all
     *                                       the mapping and logic to access the event log model
     * @param FractalApiResponse  $response  The json response formatter object
     * @param Request $request               The request containing all the parameters passed from the client
     */
    public function __construct(EventTypeRepository $eventTypes, FractalApiResponse $response, Request $request)
    {
        $this->eventTypes = $eventTypes;
        $this->eventTypes->setApplicationId($this->getApplicationId());
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * Show all the event types
     *
     * @return json
     */
    public function index()
    {
        $events = $this->eventTypes->findByApplicationId();
        $this->response->setParseIncludes($this->parse_includes);

        return $this->response->buildCollection($events, new EventTypePlaceHolderTransformer);
    }

    /**
     * Show event types by category
     *
     * @return json
     */
    public function byCategory()
    {
        $events = $this->eventTypes->findByCategory($this->request->input('label'));
        $this->response->setParseIncludes($this->parse_includes);

        return $this->response->buildCollection($events, new EventTypePlaceHolderTransformer);
    }
}
