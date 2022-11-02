<?php

namespace App\Traits;


use Illuminate\Support\Facades\Schema;
use Str;

trait Sortable
{
    public function scopeSort($query){
        $order_by = request()->query('order_by');
        $order = request()->query('order', 'desc');
        $order = $order == 'desc' ? 'asc' : 'desc';
        if (Schema::hasColumn($this->getTable(), $order_by)) {
            $query->orderBy($order_by, $order);
        } else{
            $query->orderBy('id', 'desc');
        }
        return $query;
    }
}
