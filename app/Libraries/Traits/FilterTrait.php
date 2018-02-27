<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Facades\Schema;

trait FilterTrait
{

    /**
     * Search the result follow the search request and columns filterableFields.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query  of Model.
     * @param string                                $filter filter
     *
     * @return void.
     */
    public function scopeFilter($query, $filter)
    {
        $query->select($this->getTable() . '.*');
        $this->makeJoins($query);
        if (!empty($filter)) {
            foreach ($this->getColumns() as $value) {
                $query->where($value, $filter);
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
        return array_get($this->filterableFields, 'columns', []);
    }

    /**
     * Get joins
     *
     * @return mixed
     */
    protected function getJoins()
    {
        return array_get($this->filterableFields, 'joins', []);
    }

    /**
     * Make joins
     *
     * @param Builder $query query model
     *
     * @return void
     */
    protected function makeJoins($query)
    {
        foreach ($this->getJoins() as $table => $keys) {
            $query->leftJoin($table, function ($join) use ($keys) {
                $join->on($keys[0], '=', $keys[1]);
            });
        }
    }
}
