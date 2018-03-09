<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Traits\ApiResponse;
use League\Fractal\TransformerAbstract;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use App\Transformers\ApiSerializers;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

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
     * @param Model|LengthAwarePaginator $resource resource
     * @param String                     $include  table include
     *
     * @return Array
     */
    public function transformerResource($resource, $include = '')
    {
        if ($resource instanceof Model) {
            $resource = new Item($resource, $this->transformer);
        } elseif ($resource instanceof LengthAwarePaginator) {
            $paginator = $resource;
            $resource = new Collection($resource->items(), $this->transformer);
            $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        }
        $this->fractal->parseIncludes($include);

        $resource = $this->fractal->createData($resource);
        $this->fractal->setSerializer(new ApiSerializers());

        return $resource->toArray();
    }
}
