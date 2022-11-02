<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use \Rinvex\Subscriptions\Models\PlanSubscription as BasePlanSubscription;
use Rinvex\Subscriptions\Models\PlanSubscriptionUsage;

class PlanSubscription extends BasePlanSubscription {

    protected $fillable = [
        'stripe_id',
        'paypal_id',
        'user_id',
        'user_type',
        'plan_id',
        'slug',
        'name',
        'description',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'cancels_at',
        'canceled_at',
        'change_to_free_plan'
    ];
    public $affirmativeValues = ['Y', 'true'];
    public $deniedValues = ['N', 'false'];

    public static function boot() {
        parent::boot();

        self::deleted(function ($subscription) {
            $subscription->usage()->delete();
        });
    }

    public function scopePremium(Builder $builder): Builder {
        return $builder->whereHas('plan', function($builder) {
                    $builder->where('price', '>', 0.00);
                });
    }

    public function getRenewAtAttribute() {
        return $this->ends_at->addSecond();
    }

    public function getFeatureSlug($featureName) {
        return $this->plan->feature($featureName)->slug;
    }

    public function featureIsUnlimited(string $featureName) {
        $featureValue = $this->getFeatureValue($featureName);

        return $featureValue === '-1' || in_array($featureValue, $this->affirmativeValues);
    }

    public function reduceFeatureUsage(string $featureName, int $uses = 1): ?PlanSubscriptionUsage {
        $featureSlug = $this->getFeatureSlug($featureName);

        $usage = $this->usage()->byFeatureSlug($featureSlug)->first();

        if (is_null($usage)) {
            return null;
        }

        $usage->used = max($usage->used - $uses, 0);

        $usage->save();

        return $usage;
    }

    public function canUseFeature(string $featureName): bool {
        $feature = $this->plan->feature($featureName);

        $featureValue = $this->getFeatureValue($featureName);
        $usage = $this->usage->where('feature_id', $feature->id)->first();

        if ($this->featureIsUnlimited($featureName)) {
            return true;
        }

        if (in_array($featureValue, $this->deniedValues)) {
            return false;
        }

        if (!$usage) {
            return true;
        }

        // If the feature value is zero, let's return false since
        // there's no uses available. (useful to disable countable features)
        if ($usage->expired() || is_null($featureValue) || $featureValue === '0' || $featureValue === 'false') {
            return false;
        }

        // Check for available uses
        return $this->getFeatureRemainings($featureName) > 0;
    }

    public function recordFeatureUsage(string $featureName, int $uses = 1, bool $incremental = true): PlanSubscriptionUsage {
        
        $featureSlug = $this->getFeatureSlug($featureName);

        $feature = $this->plan->features->where('slug', $featureSlug)->first();

        $usage = $this->usage()->firstOrNew([
            'subscription_id' => $this->getKey(),
            'feature_id' => $feature->getKey(),
        ]);

        if ($feature->resettable_period) {
            // Set expiration date when the usage record is new or doesn't have one.
            if (is_null($usage->valid_until)) {
                // Set date from subscription creation date so the reset
                // period match the period specified by the subscription's plan.
                $usage->valid_until = $feature->getResetDate($this->created_at);
            } elseif ($usage->expired()) {
                // If the usage record has been expired, let's assign
                // a new expiration date and reset the uses to zero.
                $usage->valid_until = $feature->getResetDate($usage->valid_until);
                if ($featureName !== "credits") { // credits never expired
                    $usage->used = 0;
                }
//                $usage->used = 0;
            }
        }

        $usage->used = ($incremental ? $usage->used + $uses : $uses);

        $usage->save();

        return $usage;
    }

    public function getFeatureRemainings(string $featureName): int {
        $number = $this->getFeatureValue($featureName) + $this->getExtraUsage($featureName) - $this->getFeatureUsage($featureName);
        return $number >= 0 ? $number : 0;
        if ($number < 0) {
            $number = 0;
        }
        return $number;
//        return $this->getFeatureValue($featureName) + $this->getExtraUsage($featureName) - $this->getFeatureUsage($featureName);
    }

    public function getExtraUsage(string $featureName): int {
        try {
            $feature = $this->plan->feature($featureName);
            $usage = $this->usage->where('feature_id', $feature->id)->first();
            return $usage->extra_usage;
        } catch (\Throwable $ex) {
            return 0;
        }
        $feature = $this->plan->feature($featureName);
        $usage = $this->usage->where('feature_id', $feature->id)->first();

        return $usage && !$usage->expired() ? $usage->used : 0;
    }

    public function getFeatureUsage(string $featureName): int {
        $feature = $this->plan->feature($featureName);
        $usage = $this->usage->where('feature_id', $feature->id)->first();
        if ($usage && $featureName === "credits") {
            return max($usage->used, 0);
        }

        return $usage && !$usage->expired() ? $usage->used : 0;
    }

    public function getFeatureValue(string $featureName) {
        $featureSlug = $this->getFeatureSlug($featureName);
        $feature = $this->plan->features->where('slug', $featureSlug)->first();

        return $feature->value ?? null;
    }

}
