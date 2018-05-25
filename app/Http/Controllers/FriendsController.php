<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    public $successStatus = 200;

    public function get_friends(){
        $user = Auth::user();
        $friends = $user->getFriends();

        return response()->json($friends, $this->successStatus);
    }

    public function find_friends(){
        $user = User::where('id', '!=', Auth::user()->id)->paginate(20);
        return response()->json($user, $this->successStatus);
    }

    public function send_request($recipient_id) {
        $user = Auth::user();
        $recipient = User::find($recipient_id);

        $user->befriend($recipient);
        return response()->json(['statusText' => 'Friend request sent'], $this->successStatus);
    }

    public function fetch_friend_requests(){
        $user = Auth::user();
        $friend_requests = $user->getFriendRequests();
        return response()->json($friend_requests, $this->successStatus);
    }

    public function accept_friend_request($sender_id){
        $user = Auth::user();
        $sender = User::find($sender_id);
        $user->acceptFriendRequest($sender);

        $friend_requests = $user->getFriendRequests();
        return response()->json($friend_requests, $this->successStatus);
    }

    public function block_user($sender_id){
        $user = Auth::user();
        $friend = User::find($sender_id);
        $user->blockFriend($friend);

        $friend_requests = $user->getFriendRequests();
        return response()->json($friend_requests, $this->successStatus);
    }

    public function deny_friend_request($sender_id){
        $user = Auth::user();
        $sender = User::find($sender_id);
        $user->denyFriendRequest($sender);

        $friend_requests = $user->getFriendRequests();
        return response()->json($friend_requests, $this->successStatus);
    }

    public function fetch_blocked_users(){
        $user = Auth::user();
        $blocked_users = $user->getBlockedFriendships();

        return response()->json($blocked_users, $this->successStatus);
    }
}
