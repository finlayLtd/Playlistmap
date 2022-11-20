<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\UsersData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller {

    public function index() {
        $user = auth()->user();
        $playlists = $user->unlockedPlaylists()->paginate(12);

        return view('frontend.profile.index', compact('user', 'playlists'));
    }

    public function myplaylist(){
        $user = auth()->user();
        $playlists = $user->unlockedPlaylists()->paginate(12);
        return view('frontend.profile.myplaylist', compact('user', 'playlists'));
    }

    public function security() {
        $user = auth()->user();
        $playlists = $user->unlockedPlaylists()->paginate(12);

        return view('frontend.profile.security', compact('user', 'playlists'));
    }

    public function subscription() {
        $user = auth()->user();
        $playlists = $user->unlockedPlaylists()->paginate(12);

        return view('frontend.profile.subscription', compact('user', 'playlists'));
    }

    public function update(Request $request) {
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
        ]);

        if ($name = $request->input('name'))
            $user->update(['name' => $name]);
        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }

    public function updateAvatar(Request $request) {
        $user = auth()->user();
        $user->uploadImage('avatar', 'images/users');
        return redirect()->back()->with('success', 'Profile Avatar Updated Successfully');
    }

    public function updatePassword(Request $request){
        
        $user = auth()->user();

        $request->validate([
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password|min:6'
        ]);

        if ($password = $request->input('password'))
            $user->update(['password' => bcrypt($password)]);
        return redirect()->back()->with('success', 'Password Updated Successfully');
    }

    public function plans(Request $request) {
        $data = array();

        $user = auth()->user();
        if ($user) {
            $plans = Plan::all();

            $data['user'] = $user;
            $data['plans'] = $plans;
            $data['subscription'] = $user->subscription();
            $data['chosen_plan_id'] = $user->subscription()->plan_id;

            try {
                $currentUsageCredits = $user->subscription()->getUsageByFeatureAndPlan($user->subscription()->plan, 'credits');

                $data['valid_until'] = $currentUsageCredits->valid_until->subDays(1);
            } catch (\Throwable $ex) {
                $data['valid_until'] = Carbon::now()->addDays(30);
            }
            $this->checkForStripeID();


            if ($user->subscription()->change_to_free_plan !== null) {
                $freePlan = Plan::whereSlug('free')->firstOrFail();
                if ($freePlan) {
                    $data['chosen_plan_id'] = $freePlan->id;
                }
            }
        }

        $request->validate([
            'coupon' => 'string|nullable',
        ]);
        $coupon = $request->coupon ? $request->coupon : "";
        
        $data['coupon'] = $coupon;

        return view('pages.pricing', $data);
//        return view('frontend.profile.plan_management', $data);
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

    public function updateArtistID(Request $request) {
        $user = auth()->user();


        $request->validate([
            'artistID' => 'required|string',
            'artistImage' => 'url|nullable',
            'artistName' => 'string|nullable',
        ]);

        $user->avatar = $request->artistImage;

        if (isset($request->artistName) && $request->artistName !== "") {
            $user->name = $request->artistName;
        }

        $user->save();

        UsersData::updateOrCreate(
                ['user_id' => $user->id],
                ['spotify_artist_id' => $request->artistID]
        );

        return json_encode(["status" => "success"]);
        exit;
    }

}
