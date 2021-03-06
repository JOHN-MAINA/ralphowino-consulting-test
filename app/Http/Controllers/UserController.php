<?php

namespace App\Http\Controllers;

use App\User;
use GetStream\Stream\Client;
use GetStream\StreamLaravel\Eloquent\ActivityTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('Ralphowino')->accessToken;
            $success['name'] =  $user->name;
            $success['email'] = $user->email;
            $success['id'] = $user->id;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // Instantiate a feed object
        $client = new Client(Config::get('stream.key'), Config::get('stream.secret'));
        // Instantiate a feed object
        $client->feed('user', $user->id);


        $success['token'] =  $user->createToken('Ralphowino')->accessToken;
        $success['name'] =  $user->name;
        $success['email'] = $user->email;
        $success['id'] = $user->id;
        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function fetch_user($id){
        $user = User::find($id);
        return response()->json($user, $this->successStatus);
    }
}
