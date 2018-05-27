<?php

namespace App\Listeners;

use App\Events\UserCreated;
use GetStream\Stream\Client;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        $client = new Client('fjc6zh99wy5p', 'zpb2j5yqrmcuuy8rc93u8du8vjw9wces3ncuvvknvmgtxn4uxvv5jnbqw6ejsbet');

        // Instantiate a feed object
        $userFeed = $client->feed('user', 68);

        Log::error(print_r($userFeed, true));
    }
}
