<?php

namespace App\Traits;


use Illuminate\Support\Facades\Schema;
use Str;

trait Searchable
{
    public function scopeWhereAnyColumnLike($query, $term = '', $columns = array(), $relations = array())
    {
        $query->orwhere(function ($query) use ($term, $columns) {

            // If columns are not provided at scope level and set at model level
            if (isset($this->searchable_columns) && !empty($this->searchable_columns) && empty($columns)) {
                $columns = $this->searchable_columns;
            }

            if (empty($columns)) {
                $columns = Schema::getColumnListing($this->getTable());
            }

            foreach ($columns as $column) {
                $query->orWhere($column, 'LIKE', '%' . $term . '%');
            }
        });
        if (is_array($relations) && !empty($relations)) {
            foreach ($relations as $relation) {
                $query->whereRelatedColumnsLike($relation, $term);
            }
        } else if ($relations) {
            $query->whereRelatedColumnsLike($relations, $term);
        }
        return $query;
    }

    public function scopeWhereRelatedColumnsLike($query, $relation, $term = '', $columns = array())
    {
        $model_str = 'App\\Models\\' . ucfirst(Str::singular($relation));
        $model = new $model_str();

        $columns = empty($columns) ? Schema::getColumnListing($model->getTable()) : $columns;

        $query->orwhere(function ($query) use ($term, $columns, $relation) {
            foreach ($columns as $column) {
                $query->orWhereHas($relation, function ($q) use ($column, $term) {
                    $q->where($column, 'LIKE', '%' . $term . '%');
                });
            }
        });
        return $query;
    }
}
