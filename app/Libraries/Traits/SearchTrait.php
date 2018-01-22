<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Facades\Schema;

trait SearchTrait
{

    /**
     * Search the result follow the search request and columns searchableFields.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query  of Model.
     * @param Request                               $search search
     * @param string                                $filter filter
     *
     * @return void.
     */
    public function scopeSearch($query, $search, $filter)
    {
        $query->select($this->getTable() . '.*');
        $this->makeJoins($query);
        foreach ($this->getColumns() as $value) {
            if ($filter == $value) {
                $query->where($value, "LIKE", "%$search%");
            }
            if ($filter == 'all') {
                $query->orwhere($value, "LIKE", "%$search%");
            }
        }
    }

    /**
     * Get columns searchableFields
     *
     * @return mixed
     */
    protected function getColumns()
    {
        return array_get($this->searchableFields, 'columns', []);
    }

    /**
     * Get joins
     *
     * @return mixed
     */
    protected function getJoins()
    {
        return array_get($this->searchableFields, 'joins', []);
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
