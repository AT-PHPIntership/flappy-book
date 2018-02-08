<?php
namespace App\Libraries\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }
    
    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }
                
        $collection = $this->paginate($collection)->toArray();
        $collectStruct = collect([
            'data' => $collection['data'],
            'meta' => [
                'pagination' => [
                    'total' =>  $collection['total'],
                    'count' =>  $collection['total'] % $collection['per_page'],
                    'per_page' =>  $collection['per_page'],
                    'current_page' =>  $collection['current_page'],
                    'total_pages' =>  $collection['last_page'],
                    'links' => [
                       'prev' => $collection['prev_page_url'],
                       'next' =>$collection['next_page_url']
                    ]
                ],
                'code' => $code,
            ]
        ]);
        return $this->successResponse($collectStruct, $code);
    }
    
    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse($instance, $code);
    }
    
    protected function filterData(Collection $collection)
    {
        $attribute = $collection->first()->filterable;
        foreach (request()->query() as $query => $value) {
            if (isset($value) && in_array($query, $attribute)) {
                $collection = $collection->where($query, $value);
            }
        }
        return $collection;
    }
    
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
