<?php

namespace App\Http\Controllers;

use GetStream\Stream\Client;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Config;

class PostController extends Controller
{
    private $successStatus = 200;

    /**
     * Fetch user feed activities
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($user_id, $page_number = 1){
        $feedActivityCount = 10;
        $offset = 0;

        if($page_number != 1){
            $offset = $page_number * $feedActivityCount;
        }
        // Instantiate a feed object
        $client = new Client(Config::get('stream.key'), Config::get('stream.secret'));
        // Instantiate a feed object
        $userFeed = $client->feed('user', $user_id);
        // Get the latest activities for this user's personal feed, based on who they are following.
        $response = $userFeed->getActivities($offset, $feedActivityCount);

        $posts = array();
        // Fetch posts per activity
        foreach ($response['results'] as $key => $activity) {
            $post_ref = explode(":",$activity['object']);
            $post = Post::with(['user'])->find((int)$post_ref[1]);
            $posts[$key]['activity'] = $activity;
            $posts[$key]['post'] = $post;
        }

        return response()->json(['posts' => $posts, 'next_page' => ++$page_number], $this->successStatus);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){

        $post = new Post();
        $post->user_id = $request->user_id;
        $post->body = $request->body;

        $post->save();
        // Instantiate a feed object
        $client = new Client(Config::get('stream.key'), Config::get('stream.secret'));
        // Instantiate a feed object
        $userFeed = $client->feed('user', $post->user_id);
        // Get the latest activities for this user's personal feed, based on who they are following.
        $response = $userFeed->getActivities(0, 2);
        return response()->json(['post' => $post, 'feedActivities' => $response], $this->successStatus);
    }

    public function delete_post($post_id, $activity_id = false, $user_id = false){
        Post::destroy($post_id);

        if($activity_id && $user_id){
            $client = new Client(Config::get('stream.key'), Config::get('stream.secret'));

            $userFeed = $client->feed('user', $user_id);
            // Remove an activity by its id
            $userFeed->removeActivity($activity_id);
        }

        return response()->json(['successStatus' => 'Activity and post successfully deleted'], $this->successStatus);
    }
}
