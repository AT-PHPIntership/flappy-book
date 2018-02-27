<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ApiResponse
{

    /**
     * Response list data
     *
     * @param LengthAwarePaginator $responseData list resource
     * @param int                  $code         response status
     *
     * @return \Illuminate\Http\Response
     */
    protected function responsePaginate(LengthAwarePaginator $responseData, $code = 200)
    {
        
        return response()->json([
            'meta' => [
                'status' => __('api.successfully'),
                'code' => $code
            ],
            'data' => $responseData->toArray()['data'],
            'pagination' => [
                'total' =>  $responseData->total(),
                'per_page' =>  $responseData->perPage(),
                'current_page' =>  $responseData->currentPage(),
                'total_pages' =>  $responseData->lastPage(),
                'links' => [
                   'prev' => $responseData->previousPageUrl(),
                   'next' =>$responseData->nextPageUrl(),
                ]
            ],
        ]);
    }

    /**
     * Response detail of data
     *
     * @param Model $instance instance
     * @param int   $code     response status
     *
     * @return \Illuminate\Http\Response
     */
    protected function showOne(Model $instance, $code = 200)
    {
        return response()->json([
            'meta' => [
                'status' => __('api.successfully'),
                'code' => $code
            ],
            'data' => $instance
        ]);
    }
}
