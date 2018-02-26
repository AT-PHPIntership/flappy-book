<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
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

    /**
     * Response list data
     *
     * @param LengthAwarePaginator $data list resource
     * @param int                  $code response status
     *
     * @return \Illuminate\Http\Response
     */
    protected function showAll(LengthAwarePaginator $data, $code = 200)
    {
        return response()->json([
            'meta' => [
                'status' => __('api.successfully'),
                'code' => $code
            ],
            'data' => $data->toArray()['data'],
            'pagination' => [
                'total' =>  $data->total(),
                'per_page' =>  $data->perPage(),
                'current_page' =>  $data->currentPage(),
                'total_pages' =>  $data->lastPage(),
                'links' => [
                   'prev' => $data->previousPageUrl(),
                   'next' =>$data->nextPageUrl(),
                ]
            ],
        ]);
    }
}
