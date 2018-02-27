<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Facades\Schema;

trait FilterTrait
{

    /**
     * Filter the result follow the filter request.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query  of Model.
     * @param array                                $fields fields
     *
     * @return void.
     */
    public function scopeFilter($query, $fields)
    {
        if (isset($fields)) {
            foreach ($fields as $field => $value) {
                foreach ($this->getColumns() as $key => $operator) {
                    if($key == $field) {
                        $query->where($key, $operator, $value);
                    }
                }
            }
        }
    }

    /**
     * Get columns filterableFields
     *
     * @return mixed
     */
    protected function getColumns()
    {
        return array_get($this->filterableFields, 'operator', []);
    }
}
