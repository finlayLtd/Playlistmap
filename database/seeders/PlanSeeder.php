<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Rinvex\Subscriptions\Models\PlanFeature;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $free = app('rinvex.subscriptions.plan')->create([
            'name' => 'Free',
            'description' => 'Free Plan',
            'price' => 0,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 0,
            'trial_interval' => 'day',
            'sort_order' => 1,
            'currency' => 'USD',
        ]);

        $basic = app('rinvex.subscriptions.plan')->create([
            'name' => 'Basic',
            'description' => 'Basic plan',
            'price' => 9.99,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 15,
            'trial_interval' => 'day',
            'sort_order' => 2,
            'currency' => 'USD',
        ]);

        $plus = app('rinvex.subscriptions.plan')->create([
            'name' => 'Plus',
            'description' => 'Plus plan',
            'price' => 13.99,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 15,
            'trial_interval' => 'day',
            'sort_order' => 3,
            'currency' => 'USD',
        ]);

        $premium = app('rinvex.subscriptions.plan')->create([
            'name' => 'Premium',
            'description' => 'Ultimate plan',
            'price' => 13.99,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 15,
            'trial_interval' => 'day',
            'sort_order' => 3,
            'currency' => 'USD',
        ]);

        $free->features()->saveMany([
            new PlanFeature(['name' => 'credits', 'value' => 5, 'sort_order' => 1, 'resettable_period' => 1, 'resettable_interval' => 'month']),
            new PlanFeature(['name' => 'message_builder', 'value' => 'N', 'sort_order' => 5]),
            new PlanFeature(['name' => 'dynamic_templates', 'value' => 0, 'sort_order' => 5]),
            new PlanFeature(['name' => 'exclusive_playlists', 'value' => 'N', 'sort_order' => 5]),
            new PlanFeature(['name' => 'search_limit', 'value' => 3, 'sort_order' => 5]),
        ]);

        $basic->features()->saveMany([
            new PlanFeature(['name' => 'credits', 'value' => 100, 'sort_order' => 1, 'resettable_period' => 1, 'resettable_interval' => 'month']),
            new PlanFeature(['name' => 'message_builder', 'value' => 'Y', 'sort_order' => 5]),
            new PlanFeature(['name' => 'dynamic_templates', 'value' => 3, 'sort_order' => 5]),
            new PlanFeature(['name' => 'exclusive_playlists', 'value' => 'Y', 'sort_order' => 5]),
            new PlanFeature(['name' => 'search_limit', 'value' => 100, 'sort_order' => 5]),
        ]);

        $plus->features()->saveMany([
            new PlanFeature(['name' => 'credits', 'value' => 1000, 'sort_order' => 1, 'resettable_period' => 1, 'resettable_interval' => 'month']),
            new PlanFeature(['name' => 'message_builder', 'value' => 'Y', 'sort_order' => 5]),
            new PlanFeature(['name' => 'dynamic_templates', 'value' => 20, 'sort_order' => 5]),
            new PlanFeature(['name' => 'exclusive_playlists', 'value' => 'Y', 'sort_order' => 5]),
            new PlanFeature(['name' => 'search_limit', 'value' => 1000, 'sort_order' => 5]),
        ]);

        $premium->features()->saveMany([
            new PlanFeature(['name' => 'credits', 'value' => 1000, 'sort_order' => 1, 'resettable_period' => 1, 'resettable_interval' => 'month']),
            new PlanFeature(['name' => 'message_builder', 'value' => 'Y', 'sort_order' => 5]),
            new PlanFeature(['name' => 'dynamic_templates', 'value' => 20, 'sort_order' => 5]),
            new PlanFeature(['name' => 'exclusive_playlists', 'value' => 'Y', 'sort_order' => 5]),
            new PlanFeature(['name' => 'search_limit', 'value' => 1000, 'sort_order' => 5]),
        ]);
    }
}
