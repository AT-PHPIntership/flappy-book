<?php

namespace App\Libraries\Traits;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
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
                
        $collection = $this->filterData($collection);
        $collection = $this->paginate($collection);
        return $this->successResponse($collection, $code);
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
        
        $prePage = 5;
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
    
}