<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponse
{
   
    /**
     * Response list categories
     *
     * @param Collection $instance instance
     * @param int        $code     response status
     *
     * @return \Illuminate\Http\Response
     */
    protected function showOne(Model $instance, $code = 200)
    {
        return response()->json([
            'meta' => [
            'status' => __('api.successfully'),
            'code' => $code],
            'data' => $instance
        ]);
    }
}
