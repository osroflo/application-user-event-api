<?php
namespace app\Lib\Response;

use App\Lib\Response\ApiResponse;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\TransformerAbstract;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use App\Transformers\Serializers\CustomDataSerializer;
use Illuminate\Http\Response;

/**
 * This class uses Fractal to format responses that
 * contains data. Go to https://fractal.thephpleague.com/
 * to learn more about Fractal response formatter.
 * Responses without data, like validation errors, exceptions are
 * formatted by the parent ApiResponse.
 *
 */
class FractalApiResponse extends ApiResponse
{
    protected $parse_includes = [];
    protected $with_pagination = false;

    /**
     * Create the response for an item.
     *
     * @param  mixed                $item
     * @param  TransformerAbstract  $transformer
     * @return Response
     */
    public function buildItem($item, TransformerAbstract $transformer)
    {
        $resource = new Item($item, $transformer);

        return $this->buildResourceResponse($resource);
    }

    /**
     * Create the response for a collection.
     *
     * @param  mixed                $collection
     * @param  TransformerAbstract  $transformer
     * @return Response
     */
    public function buildCollection($collection, TransformerAbstract $transformer)
    {
        $resource = new Collection($collection, $transformer);

        if ($this->with_pagination) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($collection));
        }

        return $this->buildResourceResponse($resource);
    }

    /**
     * Create the response for a resource.
     *
     * @param  ResourceAbstract  $resource
     * @param  integer $status
     * @return Response
     */
    protected function buildResourceResponse(ResourceAbstract $resource)
    {
        $manager = new Manager();
        $manager->setSerializer(new CustomDataSerializer());

        if ($this->parse_includes) {
            $manager->parseIncludes($this->parse_includes);
        }

        $data = $manager->createData($resource)->toArray();

        if (!empty($data['data'])) {
            $this->setData($data);
            return $this->success();
        } else {
            return $this->fail("No data was not found!");
        }
    }

    /**
     * Allows to return nested models
     *
     * @param array $parse_includes List of nested models to include.
     */
    public function setParseIncludes($parse_includes)
    {
        $this->parse_includes = $parse_includes;
    }

    /**
     * Breakdowns a huge result into pages, it
     * also returns the pagination information:
     * "meta": {
     *   "pagination": {
     *       "total": 22,
     *       "count": 10,
     *       "per_page": 10,
     *       "current_page": 1,
     *       "total_pages": 3,
     *       "links": {
     *           "next": "http://local.api.com/event/v1/log/Application?page=2"
     *       }
     *   }
     * }
     */
    public function withPagination()
    {
        $this->with_pagination = true;
    }

    /**
     * Create JSON for successful response
     *
     * @param  string  $message  Response message.
     * @return json
     */
    public function success($message = 'Great, we get some results!.')
    {
        // compose the format
        $this->setStatus(Response::HTTP_OK);
        $this->setMessage($message);

        $addKeys = $this->getPublicProperties();
        $data_array = is_array($this->data) ? $this->data : $this->data->toArray();

        $data = array_merge($addKeys, $data_array);

        return response()->json($data, $this->status_code);
    }
}
