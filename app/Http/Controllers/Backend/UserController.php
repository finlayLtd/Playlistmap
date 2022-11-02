<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $users = User::paginate(25);
        return view('backend.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('backend.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'avatar' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|min:8',
        ]);

        $request->merge([
            'password' => bcrypt($request->password)
        ]);

        $user = User::create($request->except('avatar'));
        $user->uploadImage('avatar', 'images/users');
        return redirect()->route('backend.users.index')->with('success', 'User Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        return view('backend.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {
        $request->validate([
            'avatar' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string',
            'email' => "required|string|unique:users,email,$user->id",
            'password' => 'nullable|min:8',
        ]);

        if ($password = $request->input('password'))
            $user->update(['password' => bcrypt($password)]);

        $user->uploadImage('avatar', 'images/users');
        $user->update($request->except(['avatar', 'password']));

        return redirect()->route('backend.users.index')->with('success', 'User Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('backend.users.index')->with('success', 'User Deleted Successfully!');
    }

    public function verifyEmailAndLogIn(Request $request) {
        
        
        $user = User::find($request->route('id'));
        var_dump($user->email_verified_at);
        exit;

        
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->markEmailAsVerified())
            event(new Verified($user));

        return redirect($this->redirectPath())->with('verified', true);
    }

}
