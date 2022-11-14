<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Rinvex\Subscriptions\Models\Plan as BasePlan;
use Illuminate\Support\Facades\DB;

class Plan extends BasePlan
{
    public function getFeatureByName($name)
    {
        // return $this->features->where('name', $name)->first();
        return DB::table('plan_features')->where('slug', $name)->first();
    }

    public function feature($name)
    {
        return $this->features->where('name', $name)->first();
    }

    public function templates()
    {
        return $this->belongsToMany(Template::class);
    }
}
