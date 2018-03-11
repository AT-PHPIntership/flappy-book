<?php

namespace App\Transformers;

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Serializer\SerializerAbstract;

class ApiSerializers extends SerializerAbstract
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey resourceKey
     * @param array  $data        data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return [$resourceKey ?: 'data' => $data];
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey resourceKey
     * @param array  $data        data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        return $resourceKey ?: $data;
    }

    /**
     * Serialize null resource.
     *
     * @return array
     */
    public function null()
    {
        return null;
    }

    /**
     * Serialize the included data.
     *
     * @param ResourceInterface $resource resource
     * @param array             $data     data
     *
     * @return array
     */
    public function includedData(ResourceInterface $resource, array $data)
    {
        return $resource?: $data;
    }

    /**
     * Serialize the meta.
     *
     * @param array $meta meta
     *
     * @return array
     */
    public function meta(array $meta)
    {
        if (empty($meta)) {
            return [];
        }
        return $meta;
    }

    /**
     * Serialize the paginator.
     *
     * @param PaginatorInterface $paginator paginator
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

    /**
     * Serialize the cursor.
     *
     * @param CursorInterface $cursor cursor
     *
     * @return array
     */
    public function cursor(CursorInterface $cursor)
    {
        $cursor = [
            'current' => $cursor->getCurrent(),
            'prev' => $cursor->getPrev(),
            'next' => $cursor->getNext(),
            'count' => (int) $cursor->getCount(),
        ];

        return ['cursor' => $cursor];
    }
}
