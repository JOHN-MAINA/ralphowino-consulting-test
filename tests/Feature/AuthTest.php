<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    /**
     * @test
     */
    public function  a_user_can_login_with_valid_credentials(){

        // Create a user and persist
        $user = $user = factory(User::class)->create();

        // Attempt user login with valid credentials
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        /*
         * Check whether the user was authenticated
         * You can also assert that the user was redirected to '/home'
         * though it would not be a valid test if after authentication a user is authenticated to a different url
         */
        //
        $this->assertAuthenticatedAs($user);

    }

    /**
     * @test
     */
    public function  a_user_cannot_login_with_invalid_credentials(){

        // Create a user and persist
        $user = $user = factory(User::class)->create();

        // Attempt login with invalid credentials
        $response = $this->post('/login', [
            'email' => 'myemail', //$user->email,
            'password' => 'invalid-pass',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * @test
     */
    public function  a_user_can_register_with_valid_credentials(){

        // Create a user and don't save to db
        $user = factory(User::class)->make();

        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        // Confirm that user was saved to the database
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email
        ]);

    }

    /**
     * @test
     */
    public function  a_user_cannot_register_with_existing_credentials(){

        // Fetch an existing user from the db
        $user = User::orderBy('created_at', 'desc')->first();

        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        // Confirm was redirected back with registration errors
        $response->assertSessionHasErrors();

    }

    /*
     * NB: For this test to succeed you must have configured your mail variable
     *  Laravel will attempt to send a password reset email to the user
     */

    /**
     * @test
     */
    public function  a_user_can_request_for_reset_password_code(){

        // Create a user and don't save to db
        $user = User::orderBy('created_at', 'desc')->first();

        $response = $this->post(url('/password/email'), [
            'email' => $user->email,
        ]);

        // Confirm was redirected password reset page to create a new password
        $response->assertStatus(302);

    }

    /**
     * @test
     */
    public function  a_user_can_reset_password_with_valid_code(){

        $user = factory(User::class)->create();

        //Generate password reset token for the created user
        $token = Password::createToken($user);

        $newPassword = 'password';

        $this->post('/password/reset', [
            'token' => $token,
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ]);

        // Compare the new password with hash value of newly created password
        if (Hash::check($newPassword, $user->fresh()->password)) {
            $this->assertTrue(true, 'Password matched');
        } else {
            $this->assertTrue(false, 'Password did not matched');
        }


    }
}
