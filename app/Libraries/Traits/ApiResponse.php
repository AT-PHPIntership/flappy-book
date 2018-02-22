<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * Pagination
     *
     * @param Collection $collection collection
     *
     * @return \Illuminate\Http\Response
     */
    protected function paginate(Collection $collection)
    {
        $rules = [
            'pre_page' => 'integer|min:2|max:50'
        ];
        
        Validator::validate(request()->all(), $rules);
        
        $page = LengthAwarePaginator::resolveCurrentPage();
        
        $prePage = 10;
        if (request()->has('pre_page')) {
            $prePage = request()->pre_page;
        }
        
        $result = $collection->slice(($page - 1) * $prePage, $prePage);
        
        $paginated = new LengthAwarePaginator($result, $collection->count(), $prePage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        
        $paginated->appends(request()->all());
        
        return $paginated;
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
}
