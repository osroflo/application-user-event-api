<?php
namespace app\Lib\Response;

use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

/**
 * Provide a structured response for API calls.
 *
 * This creates a response object for different response statuses.
 * The properties are defined on this class to keep a consistent
 * response structure.
 * If there is a response use case where additional properties
 * are needed, this class should be extended.
 */

class ApiResponse
{
    public $status_code;
    public $message;

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

        return $this->json();
    }

    /**
     * Create JSON for failed response
     *
     * @param  integer $status  Status Code
     * @param  string  $message Response message.
     * @return ApiResponse
     */
    public function fail($status = 501, $message = 'Fail')
    {
        $this->setStatus($status);
        $this->setMessage($message);

        return $this;
    }


    /**
     * No results where found
     *
     * @param  string  $message  Response message.
     * @return json
     */
    public function noResults($message = 'No results were found!')
    {
        $this->setStatus(Response::HTTP_OK);
        $this->setMessage($message);

        return $this->json();
    }

    /**
     * Endpoint not found
     *
     * @param  string  $message  Response message.
     * @return json
     */
    public function notFound($message = 'Sorry, the api endpoint you are looking could not be found!')
    {
        $this->setStatus(Response::HTTP_NOT_FOUND);
        $this->setMessage($message);

        return $this->json();
    }

     /**
     * Method not allowed
     *
     * @param  string  $message  Response message.
     * @return json
     */
    public function methodNotAllowed($message = 'The method you are requesting is not allowed!')
    {
        $this->setStatus(Response::HTTP_METHOD_NOT_ALLOWED);
        $this->setMessage($message);

        return $this->json();
    }

    /**
     * Not valid
     *
     * @param  string  $message  Response message.
     * @return json
     */
    public function validationFail(ValidationException $exception)
    {
        $this->setStatus(Response::HTTP_BAD_REQUEST);
        $this->setMessage($exception->getMessage());
        $this->setError($exception->validator->errors());

        return $this->json();
    }

    /**
     * Unique record violation
     *
     * @param  string  $message  Response message.
     * @return json
     */
    public function duplicated($message = 'A record with same attributes already exists in the database!')
    {
        $this->setStatus(Response::HTTP_CONFLICT);
        $this->setMessage($message);

        return $this->json();
    }

    /**
     * Set status
     *
     * @param  integer  $status  Status Code.
     * @return void
     */
    public function setStatus($status)
    {
        $this->status_code = $status;
    }

    /**
     * Set message
     *
     * @param  string  $message  Response message.
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Set data
     *
     * @param  array  $data  Information from the executed API request.
     * @return ApiResponse
     */
    public function setData($data)
    {
        if ($data instanceof LengthAwarePaginator) {
            $data = $this->getPaginatorProperties($data);
        }

        $this->data = $data;

        return $this;
    }

    /**
     * Extracts the paginator parameters
     * and assign the properties to a predefined
     * properties for consistency.
     *
     * @param LengthAwarePaginator $paginator Collection object from Iluminate
     * @return array $data
     */
    public function getPaginatorProperties(LengthAwarePaginator $LengthAwarePaginator)
    {
        $paginator = $LengthAwarePaginator->toArray();

        $this->setCurrentPage($paginator['current_page']);
        $this->setFrom($paginator['from']);
        $this->setLastPage($paginator['last_page']);
        $this->setNextPageUrl($paginator['next_page_url']);
        $this->setPath($paginator['path']);
        $this->setPerPage($paginator['per_page']);
        $this->setPrevPageUrl($paginator['prev_page_url']);
        $this->setTo($paginator['to']);
        $this->setTotal($paginator['total']);

        return $paginator['data'];
    }

    /**
     * Format to json
     *
     * @return Json
     */
    public function json()
    {
        return response()->json($this, $this->status_code);
    }

    /**
     * Pagination
     *
     * @param $current_page integer
     */
    public function setCurrentPage($current_page)
    {
        $this->pagination['current_page'] = $current_page;
    }

    /**
     * Pagination
     * @param $from integer
     */
    public function setFrom($from)
    {
        $this->pagination['from'] = $from;
    }

    /**
     * Pagination
     * @param int $last_page
     */
    public function setLastPage(int $last_page)
    {
        $this->pagination['last_page'] = $last_page;
    }

    /**
     * Pagination
     * @param string $next_page_url
     */
    public function setNextPageUrl($next_page_url)
    {
        $this->pagination['next_page_url'] = $next_page_url;
    }

    /**
     * Pagination
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->pagination['path'] = $path;
    }

    /**
     * Pagination
     * @param int $per_page
     */
    public function setPerPage(int $per_page)
    {
        $this->pagination['per_page'] = $per_page;
    }

    /**
     * Pagination
     * @param string $prev_page_url
     */
    public function setPrevPageUrl($prev_page_url)
    {
        $this->pagination['prev_page_url'] = $prev_page_url;
    }

    /**
     * Pagination
     * @param int $to
     */
    public function setTo(int $to)
    {
        $this->pagination['to'] = $to;
    }

    /**
     * Paination
     * @param int $total
     */
    public function setTotal(int $total)
    {
        $this->pagination['total'] = $total;
    }

    public function setError($errors)
    {
        $this->error = $errors;
    }

    /**
     * Gets the public properties of the object.
     * Useful in case a custom response using array is needed.
     *
     * @return array
     */
    protected function getPublicProperties()
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        $array_properties = [];

        foreach ($properties as $property) {
            $array_properties[$property->getName()] = $property->getValue($this);
        }

        return $array_properties;
    }
}
