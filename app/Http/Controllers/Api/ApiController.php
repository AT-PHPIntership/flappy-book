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
     * @var Manager
     */
    protected $fractal;

    /**
     * @var PostTransformer
     */
    protected $transformer;

    function __construct(Manager $fractal, TransformerAbstract $transformer)
    {
        $this->fractal = $fractal;
        $this->transformer = $transformer;
    }

    public function getItem($resource, $transformer, $include = '')
    {
        $resource = new Item($resource, $transformer);
        $this->fractal->parseIncludes($include);

        $resource = $this->fractal->createData($resource);
        $this->fractal->setSerializer(new ArraySerializer());
        return $resource->toArray();
    }
}
