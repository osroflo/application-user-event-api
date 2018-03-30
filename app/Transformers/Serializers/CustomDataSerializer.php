<?php
namespace App\Transformers\Serializers;

use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Pagination\PaginatorInterface;

/**
 * This custom serializer will allow:
 *
 * 1 - Include the status_code:
 *
 *     It is important to explain that a transformer only will be
 *     transforming a successful response (200).
 *
 *     If a different status code is needed then the API Response will
 *     take care of that.
 *
 * 2 - Override the data name space wrapper.
 *
 *     If for example, instead data wrapper you want a results wrapper,
 *     just include it in the 3rd parameter:
 *     - $resource = new Item($event_log, new EventLogTransformer(), 'results');
 *
 *
 */
class CustomDataSerializer extends DataArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey === false) {
            return $data;
        }
        return array($resourceKey ?: 'data' => $data);
    }

    public function item($resourceKey, array $data)
    {
        if ($resourceKey === false) {
            return $data;
        }
        return array($resourceKey ?: 'data' => $data);
    }

    /**
     * Serialize the meta.
     *
     * @param array $meta
     *
     * @return array
     */
    public function meta(array $meta)
    {
        if (empty($meta)) {
            return [];
        }

        return ['meta' => $meta];
    }

    /**
     * Serialize the paginator.
     *
     * @param PaginatorInterface $paginator
     *
     * @return array
     */
    public function paginator(PaginatorInterface $paginator)
    {
        $currentPage = (int) $paginator->getCurrentPage();
        $lastPage = (int) $paginator->getLastPage();

        $pagination = [
            'total' => (int) $paginator->getTotal(),
            'count' => (int) $paginator->getCount(),
            'per_page' => (int) $paginator->getPerPage(),
            'current_page' => $currentPage,
            'total_pages' => $lastPage,
        ];

        $pagination['links'] = [];

        if ($currentPage > 1) {
            $pagination['links']['previous'] = $paginator->getUrl($currentPage - 1);
        }

        if ($currentPage < $lastPage) {
            $pagination['links']['next'] = $paginator->getUrl($currentPage + 1);
        }

        return ['pagination' => $pagination];
    }
}
