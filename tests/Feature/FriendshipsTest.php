<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;

class FriendshipsTest extends TestCase
{
    /**
     * @test
     */
    public function a_user_can_send_a_friend_request()
    {
        $sender    = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $sender->befriend($recipient);

        $this->assertCount(1, $recipient->getFriendRequests());
    }
}
