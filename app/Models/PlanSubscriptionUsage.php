<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\PlanFeature;
use \Rinvex\Subscriptions\Models\PlanSubscriptionUsage as BasePlanSubscriptionUsage;

class PlanSubscriptionUsage extends BasePlanSubscriptionUsage {

    public function scopeByFeatureSlug(Builder $builder, string $featureSlug): Builder {
        $feature = PlanFeature::where('slug', $featureSlug)->first();
        return $builder->where('feature_id', $feature->getKey() ?? null);
    }

}
