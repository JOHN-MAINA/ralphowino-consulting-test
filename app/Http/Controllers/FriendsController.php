<?php

namespace App\Http\Controllers;

use App\User;
use GetStream\Stream\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class FriendsController extends Controller
{
    public $successStatus = 200;

    public function get_friends($id = false){
        if($id){
            $user = User::find($id);
            $friends = $user->getFriends();

            return response()->json($friends, $this->successStatus);
        }

        $user = Auth::user();
        $friends = $user->getFriends();

        return response()->json($friends, $this->successStatus);
    }

    public function get_friends_count($user_id){
        $user = User::find($user_id);
        $friends_count = $user->getFriendsCount();

        return response()->json($friends_count, $this->successStatus);
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

    public function fetch_pending_friend_requests($sender_id){
        $user = User::find($sender_id);

        $pendingFriendships = $user->getPendingFriendships();

        return response()->json($pendingFriendships, $this->successStatus);
    }
    public function accept_friend_request($sender_id){
        $user = Auth::user();
        $sender = User::find($sender_id);
        $user->acceptFriendRequest($sender);

        // Instantiate a new client, find your API keys in the dashboard.
        $client = new Client(Config::get('stream.key'), Config::get('stream.secret'));

        // Instantiate a feed object
        $userFeed = $client->feed('user', $sender_id);

        // Follow user feed
        $userFeed->follow('user', $user->id);

        $friend_requests = $user->getFriendRequests();
        return response()->json($friend_requests, $this->successStatus);
    }

    public function block_user($sender_id){
        $user = Auth::user();
        $friend = User::find($sender_id);
        $user->blockFriend($friend);

        // Instantiate a new client, find your API keys in the dashboard.
        $client = new Client(Config::get('stream.key'), Config::get('stream.secret'));

        // Instantiate a feed object
        $userFeed = $client->feed('user', $sender_id);

        // Follow user feed
        $userFeed->unfollow('user', $user->id);

        $friend_requests = $user->getFriendRequests();
        return response()->json($friend_requests, $this->successStatus);
    }
    public function unblock_user($friend_id){
        $user = Auth::user();
        $friend = User::find($friend_id);
        $user->unblockFriend($friend);

        // Instantiate a new client, find your API keys in the dashboard.
        $client = new Client(Config::get('stream.key'), Config::get('stream.secret'));

        // Instantiate a feed object
        $userFeed = $client->feed('user', $friend_id);

        // Follow user feed
        $userFeed->follow('user', $user->id);

        $blocked_users = $user->getBlockedFriendships();
        return response()->json($blocked_users, $this->successStatus);
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
