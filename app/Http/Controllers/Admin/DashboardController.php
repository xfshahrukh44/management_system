<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $results = [];
        $users = User::whereNotNull('twitter_username')->get();
        foreach($users as $user){
            $result = curl($user->twitter_username);
            array_push($results, $result);
        }
        // dd($results);
        $tweets = [];
        foreach($results as $user){
            foreach($user as $tweet){
                $tweet['created_at'] = Carbon::parse($tweet['created_at']);
                array_push($tweets, $tweet);
            }
        }

        // sorting tweets
        // usort($tweets, function($a, $b) { //Sort the array using a user defined function
        //     return $a['created_at'] < $b['created_at'] ? -1 : 1; //Compare the scores
        // });  
        $tweets = collect($tweets)-> sortByDesc(function ($obj, $key) {
            return $obj['created_at'];
        });            

        return view('admin.post.feed', compact('tweets'));
    }
}
