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

        $collection = $this->paginate($collection);
        $collection = $this->structJson($collection->toArray(), $code);

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

    /**
     * Structure of json
     *
     * @param array $resonseArray array response
     * @param int   $code         response status
     *
     * @return Illuminate\Support\Collection
     */
    public function structJson($resonseArray, $code = 200)
    {
        $collection = collect([
            'meta' => [
                'status' => 'successfully',
                'code' => $code
            ],
            'data' => array_values($resonseArray['data']),
            'pagination' => [
                    'total' =>  $resonseArray['total'],
                    'per_page' =>  $resonseArray['per_page'],
                    'current_page' =>  $resonseArray['current_page'],
                    'total_pages' =>  $resonseArray['last_page'],
                    'links' => [
                       'prev' => $resonseArray['prev_page_url'],
                       'next' =>$resonseArray['next_page_url']
                    ]
            ]
        ]);

        return $collection;
    }
}
