<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

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
         return response()->json($data, $code);
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
        $collection = $this->paginate($collection);
        $collection = $this->structJson($collection, $code);

        return $this->successResponse($collection, $code);
    }
    
    /**
     * Structure of json
     *
     * @param LengthAwarePaginator $collection result response
     * @param int                  $code       response status
     *
     * @return Illuminate\Support\Collection
     */
    public function structJson($collection, $code)
    {
        $collectionStruct = collect([
            'meta' => [
                'status' => 'successfully',
                'code' => $code
            ],
            'data' => $collection->toArray()['data'],
            'pagination' => [
                'total' =>  $collection->get('total'),
                'count' =>  $collection->count(),
                'per_page' =>  $collection->get('per_page'),
                'current_page' =>  $collection->get('current_page'),
                'total_pages' =>  $collection->get('last_page'),
                'links' => [
                   'prev' => $collection->get('prev_page_url'),
                   'next' =>$collection->get('next_page_url')
                ]
            ],
        ]);

        return $collectionStruct;
    }
        
    /**
     * Response detail of data
     *
     * @param object $data instance
     * @param int    $code response status
     *
     * @return \Illuminate\Http\Response
     */
    protected function responseSuccess($data = [], $code = 200)
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
}
