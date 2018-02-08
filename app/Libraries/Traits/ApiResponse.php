<?php
namespace App\Libraries\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
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
     * Success response
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
                
        $collection = $this->paginate($collection)->toArray();

        $count = count($collection['data']) % $collection['per_page'];
        $collectStruct = collect([
            'data' => $collection['data'],
            'meta' => [
                'pagination' => [
                    'total' =>  $collection['total'],
                    'count' =>  $count != 0 ? $count : $collection['per_page'],
                    'per_page' =>  $collection['per_page'],
                    'current_page' =>  $collection['current_page'],
                    'total_pages' =>  $collection['last_page'],
                    'links' => [
                       'prev' => $collection['prev_page_url'],
                       'next' =>$collection['next_page_url']
                    ]
                ],
                'status' => 'successfully',
                'code' => $code
            ]
        ]);

        return $this->successResponse($collectStruct, $code);
    }
    
    /**
     * Success response
     *
     * @param Model $instance instance of Model
     * @param int   $code     response status
     *
     * @return \Illuminate\Http\Response
     */
    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse($instance, $code);
    }
    
    /**
     * Success response
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
        
        $perPage = 10;
        if (request()->has('pre_page')) {
            $perPage = request()->per_page;
        }
        
        $result = $collection->slice(($page - 1) * $perPage, $perPage);
        
        $paginated = new LengthAwarePaginator($result, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        
        $paginated->appends(request()->all());

        return $paginated;
    }
}
