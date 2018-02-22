<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponse
{
    /**
     * Success response
     *
     * @param Object $data object
     * @param int    $code response status
     *
     * @return \Illuminate\Http\Response
     */
    private function successResponse($data, $code)
    {
        return response()->json([
            'meta' => [
                'status' => __('api.successfully'),
                'code' => $code
            ],
            'data' => $data
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
        return $this->successResponse($instance, $code);
    }
}
