<?php

namespace App\Listeners;

use App\Events\UserCreated;
use GetStream\Stream\Client;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class UserCreatedListener
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
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        // Instantiate a new client, find your API keys in the dashboard.
        $client = new Client(Config::get('stream.key'), Config::get('stream.secret'));

        // Instantiate a feed object
        $client->feed('user', $event->user->id);

    }
}
