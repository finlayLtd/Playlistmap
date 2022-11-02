<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UsersData;

class DashboardController extends Controller {
   
    public function index(Request $request){
     
        $results = [];
        
        $results[] = ['label' => "Total Users", 'value' => count(User::all())];
        $results[] = ['label' => "Total Users with Spotify Artist", 'value' => count(UsersData::whereNotNull(('spotify_artist_id'))->get())];
        
        return view('backend.index', ['data' => $results]);
        
    }
    
}



