<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanFeature;
use App\Models\PlanSubscription;
use App\Models\User;
use App\Models\PlanSubscriptionUsage;
use Illuminate\Http\Request;
use Log;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class SubscriptionController extends Controller {

    public function index() {
        $subscriptions = PlanSubscription::premium()->paginate(25);
        return view('backend.subscription.index', compact('subscriptions'));
    }

    public function destroy(Request $request, PlanSubscription $subscription) {
        $freePlan = Plan::whereSlug('free')->firstOrFail();
        $subscription->changePlan($freePlan);
        return redirect()->back()->with('success', 'User plan changed to basic');
    }

    /** This function extend user subscription for 1 more month and reset usage and search limits.
     * 
     * @param Request $request
     */
    public function updateSubscription(Request $request) {
        Log::channel('stripe')->info("Stripe - invoice.paid called", ['data' => $request->all()]);
        $requestData = $request->all();

        $data = $requestData['data']['object'];

        $customerID = $data['subscription'];
        $reason = $data['billing_reason'];
        if ($reason !== "subscription_cycle") {
            Log::channel('stripe')->info("Stripe - Billing reason is not subscription_cycle", ['billing_reason' => $reason, 'data' => $requestData]);
            return;
        }

        $plan = PlanSubscription::where('stripe_id', $customerID)->get()->first();
        if ($plan) {
            $userID = $plan->user_id;
            $subscription_id = $plan->id;
            $planID = $plan->plan_id;

            try {
                $user = User::findOrFail($userID);

                $planCredits = intval($user->subscription()->getFeatureValue('credits'));
                $usedCredits = intval($user->subscription()->getFeatureUsage('credits'));
                $unUsedCredits = $planCredits;
//                $unUsedCredits = max(0, $planCredits - $usedCredits);

                $creditsUsage = $user->subscription()->recordFeatureUsage('credits', $usedCredits, false);

                $creditsUsage->extra_usage += $unUsedCredits;
                $creditsUsage->save();

                $user->subscription()->recordFeatureUsage('search_limit', 0, false);

                $usages = PlanSubscriptionUsage::where('subscription_id', $subscription_id)->get();
                $updatedUsage = false;
                foreach ($usages as $usage) {
                    if ($usage->valid_until) {
//                        $usage->valid_until = $usage->valid_until->addDays(31);
                        $usage->valid_until = Carbon::now()->addDays(32);
                        $usage->save();
                        $updatedUsage = true;
                    }
                }
                if ($updatedUsage) {
                    Log::channel('stripe')->info("Updated usages to 0");
                }
                Log::channel('stripe')->info("Added valid_until 31 days");
            } catch (\Throwable $ex) {
                echo 'failed';
                echo $ex->getMessage();
                Log::channel('stripe')->info("Failed to update subscription", ['data' => $requestData, 'exception' => $ex->getMessage()]);
            }
        } else {
            Log::channel('stripe')->info("Didn't find plan for current subscription", ['data' => $requestData]);
        }
        Log::channel('stripe')->info("Stripe - invoice.paid finished");
        exit;
    }

    /** This function update user subscription and give credits + extend    
     * 
     * @param Request $request
     */
    public function updatePaypalSubscription(Request $request) {
        Log::channel('paypal')->info("Paypal - Update subscription called", ['data' => $request->all()]);
        $requestData = $request->all();

        if (isset($requestData['resource']['billing_agreement_id'])) { // billing_agreement_id determine if this sale come from subscription or not
            Log::channel('paypal')->info("Paypal - Found billing_agreement_id", ['billingAgreementID', $requestData['resource']['billing_agreement_id']]);
            $subscriptionID = $requestData['resource']['billing_agreement_id'];
            $paypalConfig = Config('services.paypal.production');

            $timeUri = "?start_time=2021-01-01T00:00:00.940Z&end_time=" . date("Y-m-d") . "T23:59:59.940Z";

            $url = $paypalConfig['base_url'] . "/v1/billing/subscriptions/{$subscriptionID}/transactions" . $timeUri;
            $response = Http::withBasicAuth($paypalConfig['client_id'], $paypalConfig['secret_id'])->get($url);
            $body = json_decode($response->body());

            if (isset($body->transactions) && count($body->transactions) > 1) { // 2nd transaction and more...
                Log::channel('paypal')->info("Paypal - Found recurring payment - give user credits", ['numberOfTransactions', count($body->transactions)]);

                $plan = PlanSubscription::where('paypal_id', $subscriptionID)->get()->first();
                if ($plan) {
                    Log::channel('paypal')->info("Paypal - Found PlanSubscription", ['PlanSubscription', $plan->id]);

                    $userID = $plan->user_id;
                    $subscription_id = $plan->id;
                    $planID = $plan->plan_id;

                    try {
                        $user = User::findOrFail($userID);

                        $planCredits = intval($user->subscription()->getFeatureValue('credits'));
                        $usedCredits = intval($user->subscription()->getFeatureUsage('credits'));
                        $unUsedCredits = $planCredits;
//                $unUsedCredits = max(0, $planCredits - $usedCredits);

                        $creditsUsage = $user->subscription()->recordFeatureUsage('credits', $usedCredits, false);

                        $creditsUsage->extra_usage += $unUsedCredits;
                        $creditsUsage->save();

                        $user->subscription()->recordFeatureUsage('search_limit', 0, false);

                        $usages = PlanSubscriptionUsage::where('subscription_id', $subscription_id)->get();
                        $updatedUsage = false;
                        foreach ($usages as $usage) {
                            if ($usage->valid_until) {
//                        $usage->valid_until = $usage->valid_until->addDays(31);
                                $usage->valid_until = Carbon::now()->addDays(32);
                                $usage->save();
                                $updatedUsage = true;
                            }
                        }
                        if ($updatedUsage) {
                            Log::channel('paypal')->info("Updated usages to 0");
                        }
                        Log::channel('paypal')->info("Added valid_until 31 days");
                    } catch (\Throwable $ex) {
                        echo 'failed';
                        echo $ex->getMessage();
                        Log::channel('paypal')->info("Failed to update subscription", ['data' => $requestData, 'exception' => $ex->getMessage()]);
                    }
                } else {
                    Log::channel('paypal')->info("Didn't find plan for current subscription", ['data' => $subscriptionID]);
                }
            } else {

                if (isset($body->transactions) && count($body->transactions) === 1) {
                    Log::channel('paypal')->info("Paypal - First transaction - abort");
                } else {
                    Log::channel('paypal')->info("Paypal - There is 0 transactions - abort");
                }
            }
        } else { // not a subscription because there is no billing_agreement_id
            Log::channel('paypal')->info("Paypal - Not a subscription payment - abort");
        }

        Log::channel('paypal')->info("Paypal PAYMENT.SALE.COMPLETED Finished");
        exit;
    }
        
    /**
     * 
     * @param Request $request
     */
    public function extendFreeUsersSubscriptions(Request $request) {
        Log::channel('subscriptions')->info("Subscriptions - Extend free users subscriptions is waking up!");
        $plan = Plan::whereSlug('free')->firstOrFail();
        if ($plan) {
            $freeFeaturesIDS = PlanFeature::where('plan_id', $plan->id)->get()->pluck('id')->toArray();
            $planSubscriptionsUsage = PlanSubscriptionUsage::whereIn('feature_id', $freeFeaturesIDS) // get all rows where feature_id is free
                    ->whereNotNull('valid_until') // get only rows that valid_until is not null
                    ->where('valid_until', '<', now()->addDay(1))// get only records that that expire tomorrow
                    ->update(['valid_until' => DB::raw("valid_until + INTERVAL 31 DAY")]); // Add 31 days to valid until

            if ($planSubscriptionsUsage && $planSubscriptionsUsage > 0) {
                Log::channel('subscriptions')->info("Updated {$planSubscriptionsUsage} rows.");
                echo "Updated {$planSubscriptionsUsage} rows";
            } else {
                Log::channel('subscriptions')->info("All rows is up to date.");
                echo "No rows was updated";
            }
        }
    }

    /**
     * 
     * @param Request $request
     */
    public function updateExpiredPaidSubscriptions(Request $request) {
        $plans = PlanSubscription::whereNotNull('change_to_free_plan')
                ->where('change_to_free_plan', '<', now())
                ->get();

        if (count($plans) > 0) {
            $freePlan = Plan::whereSlug('free')->firstOrFail();
            if (!$freePlan) {
                return;
            }


            foreach ($plans as $plan) {
                try {
                    $plan->usage()->delete();
                    $plan->plan_id = $freePlan->id;
                    $plan->change_to_free_plan = null;
                    $plan->save();
                    $plan->usage()->delete();
                    $plan->save();
                } catch (\Throwable $ex) {
                    continue;
                }
            }
        }
        echo "Total updated users: " . count($plans);
        exit;
    }

    public function cancelPaypalSubscriptionHook(Request $request) {
        $data = $request->all();
        try {
            $subscriptionID = $data['resource']['id'];
            if ($subscriptionID && $this->isPaypalSubscriptionCanceled($subscriptionID)) {
                $subscription = PlanSubscription::where('paypal_id', '=', $subscriptionID)->firstOrFail();
                if ($subscription) {
                    $user = User::findOrFail($subscription->user_id);
                    $plan = Plan::whereSlug('free')->firstOrFail();

                    $user->subscription()->paypal_id = null; // remove paypal ID
                    $user->subscription()->cancelPaypalPlan($plan, $user);
                    $user->subscription()->save();
                }
            }
            exit;
        } catch (\Throwable $ex) {
            exit;
        }
        exit;
    }

    public function isPaypalSubscriptionCanceled($subscriptionID) {
        try {
            $paypalConfig = Config('app.debug') ? Config('services.paypal.sandbox') : Config('services.paypal.production');
            $url = $paypalConfig['base_url'] . "/v1/billing/subscriptions/{$subscriptionID}";
            $response = Http::withBasicAuth($paypalConfig['client_id'], $paypalConfig['secret_id'])->get($url);

            $body = json_decode($response->body());
            return $body->status === "CANCELLED";
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

}
