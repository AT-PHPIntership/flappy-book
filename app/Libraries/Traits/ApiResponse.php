<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Collection;

trait ApiResponse
{
    /**
     * Success response
     *
     * @param Collection $data collection
     * @param int        $code response status
     *
     * @return \Illuminate\Http\Response
     */
    private function successResponse($data, $code)
    {
        return response()->json([
            'meta' => [
                'status' => 'successfully',
                'code' => $code],
            'data' => $data
          ]);
    }
    
    /**
     * Response list data
     *
     * @param Collection $collection collection
     * @param int        $code       response status
     *
     * @return \Illuminate\Http\Response
     */
    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
        return $this->successResponse($collection, $code);
    }
}
