<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Traits\ApiResponse;
use League\Fractal\TransformerAbstract;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;

class ApiController extends Controller
{
    use ApiResponse;

    /**
     * Declare fractal
     *
     * @var Manager
     */
    protected $fractal;

    /**
     * Declare teansformer
     *
     * @var TransformerAbstract
     */
    protected $transformer;

    /**
     * Create a resource item transformer and Transform data
     *
     * @param Model               $resource    resource
     * @param TransformerAbstract $transformer transformer
     * @param String              $include     table include
     *
     * @return Array
     */
    public function getItem($resource, $transformer, $include = '')
    {
        $resource = new Item($resource, $transformer);
        $this->fractal->parseIncludes($include);

        $resource = $this->fractal->createData($resource);
        $this->fractal->setSerializer(new ArraySerializer());
        return $resource->toArray();
    }
}
