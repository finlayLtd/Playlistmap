<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Log;

class PlanController extends Controller {

    public function index() {
        $plans = Plan::all();
        return view('backend.plan.index', compact('plans'));
    }

    public function update(Request $request) {
        $request->validate([
            'plans.*.price' => 'required|min:0',
            'plans.*.id' => 'required'
        ]);

        $checkboxes = ['message_builder', 'exclusive_playlists'];

        foreach ($request->plans as $planData) {
            $plan = Plan::find($planData['id']);
            $plan->update([
                'name' => $planData['name'],
                'price' => $planData['price'],
            ]);
            foreach ($planData['features'] as $name => $featureValue) {
                $feature = $plan->features->where('name', $name)->first();
                if ($feature && in_array($name, ['search_limit', 'credits', 'dynamic_templates'])) {
                    $feature->update([
                        'value' => $featureValue
                    ]);
                }
            }
            foreach ($checkboxes as $checkboxFeature) {
                $feature = $plan->features->where('name', $checkboxFeature)->first();
                $feature->update([
                    'value' => isset($planData['features'][$checkboxFeature]) ? 'Y' : 'N'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Plans Updated Successfully');
    }

}
