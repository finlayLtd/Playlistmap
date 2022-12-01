<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanSubscription;
use App\Models\User;
use App\Models\UsersCancellationReasons;
use Illuminate\Http\Request;
use \Stripe;
use Illuminate\Support\Facades\Http;
use Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFouncheckoutdation\Response;
use App\Lib\SendgridController;
use App\Lib\StripeController;

class SubscriptionController extends Controller {

    public function index() {
        //
    }

    /** This function update mail list in sendgrid
     * 
     * @param type $newPlan
     * @param type $cancel
     * @return boolean
     */
    public function updateSendgridEmailList($newPlan, $cancel = false) {
        $sendgridController = new SendgridController();
        $user = auth()->user();
        if ($cancel) {
            $sendgridController->changeUserEmailListToFree();
            return true;
        }
        try {
//            $currentPlanSlug = $user->subscription()->plan->slug;
            $newPlanSlug = $newPlan->slug;
            if ($newPlanSlug === "free") { // user canceled subscription -> move to free list
                $sendgridController->changeUserEmailListToFree();
            } else { // paid users
                $sendgridController->changeUserEmailListToPaid();
            }
        } catch (\Throwable $ex) {
            Log::info('User did not updated in Sendgrid', ['email' => $user->email]);
            return false;
        }
        return true;
    }

    public function checkout(Request $request) {

        $user = user();

        $tabnum = 3;

        $newSubscription = false;
        $globalPlanID = 0;


        $coupon = $request->input('coupon-code') ? $request->input('coupon-code') : false;

        if ($coupon) {
            $stripeController = new StripeController();
            if (!$stripeController->validateCoupon($coupon)) {
                $coupon = false;
            }
        }


//        var_dump($coupon);
//        exit;

        try {
            $customer = user()->stripe_account;
            $customer_id = $customer['id'];

            $plan = Plan::find($request->plan_id);
            $globalPlanID = $plan->id;

            $this->checkForStripeID();

            if (!Config('app.debug')) { // only in production
                $this->updateSendgridEmailList($plan);
            }

            if ($subscription_id = $user->subscription()->stripe_id) { // Upgrade or Downgrade plan 
//                if ($downgrade) { // change in stripe + change planID
//                Stripe::subscriptions()->update($customer_id, $subscription_id, [
//                    'plan' => $plan->stripe_id,
//                    'prorate' => true // charge user immediately for the portion between the plans.
//                ]);
//                } else { // charge normal
//                    
//                }
                $customer_id = $customer['id'];
                Stripe::subscriptions()->cancel($customer_id, $subscription_id);
                $user->subscription()->stripe_id = null; // remove stripe ID
//                $user->subscription()->changePlan($plan);
                $user->subscription()->save();

                $subscription = Stripe::subscriptions()->create($customer_id, [
                    'plan' => $plan->stripe_id,
                    'source' => $request->stripe_token,
                    'coupon' => $coupon ? $coupon : "" //Jy6lcOP4
                ]);
                $user->subscription()->update([
                    'stripe_id' => $subscription['id']
                ]);

//                $this->changePlan($plan);
                $user->subscription()->changePlan($plan, true, true);
            } else { // new subscription, free => paid
                $newSubscription = true;
                $subscription = Stripe::subscriptions()->create($customer_id, [
                    'plan' => $plan->stripe_id,
                    'source' => $request->stripe_token,
                    'coupon' => $coupon ? $coupon : ""
                ]);
                $user->subscription()->update([
                    'stripe_id' => $subscription['id']
                ]);
//                $this->changePlan($plan);
                $user->subscription()->changePlan($plan);
            }

            $user = user();

            if ($newSubscription) {
                $ordercompleted = $plan->id;
                return redirect()->route('frontend.search')->with('success', 'Plan changed successfully');
            } else {
                return redirect()->route('frontend.search')->with('success', 'Plan changed successfully');
            }
        } catch (\Exception $e) {
            if ($newSubscription) {
                return redirect()->route('frontend.search')->with('success', 'Plan changed successfully');
            } else if ($e->getMessage() === "The given data was invalid." || $e->getMessage() === "The given data was invalid") {
                return redirect()->route('frontend.search')->with('success', 'Plan changed successfully');
            } else {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }

    public function testNewPlan() {
//        echo 4444;
//        exit;
        $oldPlan = Plan::find(2);
        $newPlan = Plan::find(4);
        $this->changePlan($oldPlan, $newPlan);
    }

    public function changePlan21221($oldPlan, $newPlan) {
        // If plans does not have the same billing frequency
        // (e.g., invoice_interval and invoice_period) we will update
        // the billing dates starting today, and sice we are basically creating
        // a new billing cycle, the usage data will be cleared.
//        if ($oldPlan->invoice_interval !== $newPlan->invoice_interval || $oldPlan->invoice_period !== $newPlan->invoice_period) {
//            $this->setNewPeriod($newPlan->invoice_interval, $plan->invoice_period);
//            $this->usage()->delete();
//        }


        $currentUsageCredits = $this->getUsageByFeatureAndPlan($oldPlan, 'credits');
        $user = auth()->user();
        $planCredits = max(0, intval($user->subscription()->getFeatureValue('credits')));



        echo $planCredits;
        exit;

        try {
            $newPlanCredits = $plan->features()->where('slug', 'like', '%credits%')->first()->value;
        } catch (Exception $ex) {
            $newPlanCredits = 0;
        }

        echo $plan->invoice - interval;
//        print_r($plan);
        exit;

//        $sendgridController = new SendgridController();

        if ($plan->slug === "free") { // free
            $this->change_to_free_plan = $currentUsageCredits->valid_until;
            if (!$currentUsageCredits->valid_until || $currentUsageCredits->valid_until === "") {
                $this->change_to_free_plan = Carbon::now()->addDays(31);
            }

//            $sendgridController->changeUserEmailListToFree();
        } else { // not free
            $this->change_to_free_plan = null;
            $this->plan_id = $plan->getKey();
            $this->ends_at = Carbon::now()->addDays(31);
//            $sendgridController->changeUserEmailListToPaid();
        }
        // Attach new plan to subscription
        $this->save();

        if ($plan->slug !== "free") {
            $newUsageCredits = $this->getUsageByFeatureAndPlan($plan, 'credits');

//            $newUsageCredits->valid_until = $currentUsageCredits->valid_until;
            $newUsageCredits->valid_until = Carbon::now()->addDays(31);
            $newUsageCredits->used = $currentUsageCredits->used;
            if ($addCredits) {
                if ($partialCredits) { // partial credits is only for stripe
                    try {
                        $newPlanCreditsPartial = max(0, $currentUsageCredits->extra_usage + $planCredits - $newPlanCredits + $this->calculatePartialCredits($currentUsageCredits->valid_until, $newPlanCredits));
                        $newUsageCredits->extra_usage = $newPlanCreditsPartial;
                    } catch (\Throwable $ex) {
                        $newUsageCredits->extra_usage = $currentUsageCredits->extra_usage + $planCredits;
                    }
                } else {
//                     var_dump($planCredits);exit;
//                    $newUsageCredits->extra_usage = $currentUsageCredits->extra_usage;
                    $newUsageCredits->extra_usage = $currentUsageCredits->extra_usage + $planCredits;
                }
            } else {
                try {
                    $totalCredits = max(0, $currentUsageCredits->extra_usage + $planCredits - $newPlanCredits);
                } catch (\Throwable $ex) {
                    $totalCredits = 0;
                }
                $newUsageCredits->extra_usage = $totalCredits;
            }
            $newUsageCredits->valid_until = Carbon::now()->addDays(31);
            $newUsageCredits->save();

            if ($newUsageCredits->id !== $currentUsageCredits->id) {
                $currentUsageCredits->used = 0;
                $currentUsageCredits->extra_usage = 0;
                $currentUsageCredits->save();
//                $currentUsageCredits->delete();
            }
        }
        return

                $this;
    }

    private function getUsageByFeatureAndPlan12121($plan, $featureName) {
        $feature = $plan->features()->where('slug', 'like', '%' . $featureName . '%')->first();
        if (!$feature) {
            return false;
        }


         $user = auth()->user();
        
//        $usage = $this->usage()->firstOrNew([
        $usage = $user->subscription()->usage()->firstOrNew([
            'subscription_id' => $this->getKey(),
            'feature_id' => $feature->getKey(),
        ]);

        return $usage ? $usage :
                false;
    }

    public function cancel(Request $request) {
        $request->validate([
            'cancelation_reason' => 'required|string',
            'cancelation_reason_other' => 'required_if:cancelation-reason,Other|nullable|string'
        ]);
        $user = auth()->user();

        $cancelReason = "";
        try {
            $cancelReason = $request->cancelation_reason;
            if ($cancelReason === "Other") {
                $cancelReason = $request->cancelation_reason_other;
            }
            $ccc = UsersCancellationReasons::create(
                            ['user_id' => $user->id, 'plan_id' => $user->subscription()->plan_id, 'cancellation_reason' => $cancelReason]
            );
        } catch (\Throwable $ex) {
            
        }

        if (!Config('app.debug')) { // only in production
            $this->notifyAdminForCancelation($cancelReason);
            $this->updateSendgridEmailList(array(), true);
        }


        try {

            if ($user->subscription()->stripe_id != null) {
                $customer = $user->stripe_account;
                $customer_id = $customer['id'];

                $plan = Plan::whereSlug('free')->firstOrFail();

                if ($subscription_id = $user->subscription()->stripe_id) {
                    Stripe::subscriptions()->cancel($customer_id, $subscription_id);
                    $user->subscription()->stripe_id = null; // remove stripe ID
                    $user->subscription()->changePlan($plan);
                    $user->subscription()->save();
                }
            }
            if ($user->subscription()->paypal_id !== null) { //paypal user
                $res = $this->cancelPaypalSubscription($user->subscription()->paypal_id, $cancelReason);
                if ($res) {
                    $plan = Plan::whereSlug('free')->firstOrFail();
                    $user->subscription()->paypal_id = null; // remove paypal ID
                    $user->subscription()->changePlan($plan);
                    $user->subscription()->save();
                }
            }
            return redirect('/manage-plans')->with('success', 'Your subscription has been cancelled');
//            return redirect()->back()->with('success', 'Your subscription has been cancelled');
        } catch (\Exception $e) {
            return redirect('/manage-plans')->with('error', $e->getMessage());
//            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function cancelPaypalSubscription($subscriptionID, $reason) {
        $paypalConfig = Config('app.debug') ? Config('services.paypal.sandbox') : Config('services.paypal.production');
        $url = $paypalConfig ['base_url'] . "/v1/billing/subscriptions/{$subscriptionID}/cancel";


//        $response = Http::withBasicAuth(Config($paypalConfig['client_id']), Config($paypalConfig['secret_id']))->get($url);
//        $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$subscriptionID}/cancel";
//        $response = Http::withBasicAuth(Config('services.paypal.client_id_sandbox'), Config('services.paypal.secret_sandbox'))
        $response = Http::withBasicAuth($paypalConfig['client_id'], $paypalConfig['secret_id'])
                ->post
                ($url, [
            'id' => $subscriptionID,
            'reason' => $reason
        ]);

        return $response->status() === 204; // 204 means paypal canceled the subscription successfully
    }

    private function isPlansubscriptionByPaypalIDExist($subscriptionID) {
        return count(PlanSubscription :: where('paypal_id', "=", $subscriptionID)->get()) !== 0;
    }

//    public function validatePaypalSubscription($subscriptionID, $planID) {
//        try {
//            $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$subscriptionID}";
//            $response = Http::withBasicAuth(Config('services.paypal.client_id_sandbox'), Config('services.paypal.secret_sandbox'))->get($url);
//            $body = json_decode($response->body());
//            if ($body->plan_id === $planID && !$this->isPlansubscriptionByPaypalIDExist($subscriptionID)) {
//                $payerID = $body->subscriber->payer_id;
//                return $payerID;
//            }
//        } catch (Exception $ex) {
//            return false;
//        }
//        return false;
//    }

    private function getPaypalSubscriptionByID($subscriptionID) {
        try {
            $paypalConfig = Config('app.debug') ? Config('services.paypal.sandbox') : Config('services.paypal.production');
            $url = $paypalConfig ['base_url'] . "/v1/billing/subscriptions/{$subscriptionID}";
            $response = Http::withBasicAuth($paypalConfig['client_id'], $paypalConfig['secret_id'])->get($url);
//            $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$subscriptionID}";
//            $response = Http::withBasicAuth(Config('services.paypal.client_id_sandbox'), Config('services.paypal.secret_sandbox'))->get($url);
            $body = json_decode($response->body());
            return $body ? $body : false;
        } catch (Exception $ex) {
            return false;
        }
        return

                false;
    }

    public function subscribeToPaypal(Request $request) {
        $user = auth()->user();
        $newPlanID = 0;
        try {
            $allData = $request->all();
            $subscriptionID = $allData['subscriptionID'];

            $paypalSubscription = $this->getPaypalSubscriptionByID($subscriptionID);
            if ($paypalSubscription && !$this->isPlansubscriptionByPaypalIDExist($subscriptionID)) {
                $planID = $paypalSubscription->plan_id;
                $plan = Plan ::where("paypal_id", $planID)->get()->first();
                $newPlanID = $plan->id;
                if ($plan) {
                    $paypalPayerID = $paypalSubscription->subscriber->payer_id;
                    $user->update([
                        'paypal_id' => $paypalPayerID
                    ]);
                    $user->subscription()->update([
                        'paypal_id' => $subscriptionID
                    ]);
                    if (!Config('app.debug')) { // only in production
                        $this->updateSendgridEmailList($plan);
                    }
                    $user->subscription()->changePlan($plan);
                }
            }

            return response()->json(array('status' => 'success', 'message' => 'Plan changed successfully', 'planID' => $newPlanID));
        } catch (\Exception $e) {

            if ($e->getMessage() === "The given data was invalid.") {
                return response()->json(array('status' => 'success', 'message' => 'Plan changed successfully', 'planID' => $newPlanID));
            } else {
                return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
            }
        }
    }

    private function changePaypalPlanSubscription($subscriptionID, $planID) {
        try {
            $paypalConfig = Config('app.debug') ? Config('services.paypal.sandbox') : Config('services.paypal.production');
            $url = $paypalConfig ['base_url'] . "/v1/billing/subscriptions/{$subscriptionID}/revise";
//        $response = Http::withBasicAuth(Config($paypalConfig['client_id']), Config($paypalConfig['secret_id']))->get($url);
//            $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$subscriptionID}/revise";
//            $response = Http::withBasicAuth(Config('services.paypal.client_id_sandbox'), Config('services.paypal.secret_sandbox'))
            $response = Http::withBasicAuth($paypalConfig['client_id'], $paypalConfig['secret_id'])
                    ->post
                    ($url, [
                'plan_id' => $planID,
                "application_context" => array(
                    "return_url" => url('/updatePaypalSubscription'),
                    "cancel_url" => url('/manage-plans')
                ),
            ]);
            $body = json_decode($response->body());
            if (isset($body->links)) {
                foreach ($body->links as $link) {
                    if ($link->rel === "approve") {
                        return $link->href;
                    }
                }
            }
        } catch (Exception $ex) {
            return false;
        }
        return

                false;
    }

    public function changePaypalSubscription(Request $request) {
        $allData = $request->all();
        $subscriptionID = $allData['subscription_id'];
        $subscriptionID = filter_var($subscriptionID, FILTER_SANITIZE_STRING);
        $planSubscription = PlanSubscription :: where('paypal_id', '=', $subscriptionID)->get()->first();
        $valid = false;
        if ($planSubscription) {
            $user = User::where('id', $planSubscription->user_id)->get()->first();
            $paypalSubscription = $this->getPaypalSubscriptionByID($subscriptionID);
            $planID = $paypalSubscription->plan_id;
            $plan = Plan ::where("paypal_id", $planID)->get()->first();
            if ($plan) {
                $user->subscription()->changePlan($plan);
                $valid = true;
            }
        }
        if ($valid) {
            redirect('/manage-plans')->with('success', 'Plan changed successfully');
        } else {
            redirect('/manage-plans')->with('success', 'Please try again');
        }
    }

    public function getPaypalNewPlanURL(Request $request) {
        $allData = $request->all();
        $planID = $allData['planID'];
        $user = auth()->user();
        $subscriptionID = $user->subscription()->paypal_id;
        if ($planID && $subscriptionID) {
            $approveLink = $this->changePaypalPlanSubscription($subscriptionID, $planID);
            if ($approveLink) {
                return response()->json([
                            'status' => 'success',
                            'url' => $approveLink,
                ]);
            }
        }
        return response()->json([
                    'status' => 'error',
                    'message' => 'There is a problem with the server',
        ]);
    }

    public function updatePaypalSubscription(Request $request) {
        $allData = $request->all();
        $subscriptionID = $allData['subscription_id'];
        $subscriptionID = filter_var($subscriptionID, FILTER_SANITIZE_STRING);
        $planSubscription = PlanSubscription :: where('paypal_id', '=', $subscriptionID)->get()->first();
        $valid = false;
        if ($planSubscription) {
            $user = User::where('id', $planSubscription->user_id)->get()->first();
            $paypalSubscription = $this->getPaypalSubscriptionByID($subscriptionID);
            $planID = $paypalSubscription->plan_id;
            $plan = Plan ::where("paypal_id", $planID)->get()->first();
            if ($plan) {
                $user->subscription()->changePlan($plan, false); // false doesn't add the new plan credits
                $valid = true;
            }
        }
        if ($valid) {
            return redirect('/manage-plans')->with('success', 'Plan changed successfully');
        } else {
            return redirect('/manage-plans')->with('error', 'Please try again later');
        }
    }

    private function notifyAdminForCancelation($cancelationReason) {
        try {
            $user = auth()->user();
            $plan = Plan::find($user->subscription()->plan_id);
            $response = Http::asForm()->post(config('services.integromat.cancel_subscription'), [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'plan' => $plan->name,
                'price' => $plan->price,
                'cancelationReason' => $cancelationReason ? $cancelationReason : ""
            ]);
        } catch (\Thorwable $ex) {
            return;
        }

        return;
    }

    private function checkForStripeID() {
        $stripeID = config('services.stripe.key');
        if (!$stripeID) {
            try {
                $user = auth()->user();
                $response = Http::asForm()->post(config('services.integromat.users_cant_pay'), [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'message' => "There is no stripe ID in manage-plans view",
                    'url' => url()->full()
                ]);
            } catch (\Thorwable $ex) {
                return;
            }
        }
    }

}
