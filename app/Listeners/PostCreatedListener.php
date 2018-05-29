<?php

namespace App\Listeners;

use App\Events\PostCreated;
use GetStream\Stream\Client;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

class PostCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        // Add post to user feed as an activity
        // Instantiate a feed object
        $client = new Client(Config::get('stream.key'), Config::get('stream.secret'));

// Add an activity to the feed
        $data = [
            "actor"=>"User:" . $event->post->user_id,
            "verb"=>"post",
            "object"=>"Post:" . $event->post->id,
        ];


        // Instantiate a feed object
        $userFeed = $client->feed('user', $event->post->user_id);

        $userFeed->addActivity($data);
    }
}
