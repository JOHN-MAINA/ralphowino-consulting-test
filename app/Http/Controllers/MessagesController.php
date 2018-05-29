<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use App\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Cmgmyr\Messenger\Models\Thread;
use Zend\Diactoros\Response;

class MessagesController extends Controller
{
    public $successCode = 200;
    /**
     * List all threads by a user
     * @param $user_id
     * @return Response
     */
    public function index($user_id = false){
        Log::error(Config::get('stream.key'));
        Log::error(Config::get('stream.secret'));
        $threads = null;
        $threads_count = 10;
        if ($user_id){
            $threads = Thread::with('users')->forUser($user_id)->latest('updated_at')->paginate($threads_count);
        } else {
            $threads = Thread::with('users')->forUser(Auth::user()->id())->latest('updated_at')->paginate($threads_count);
        }

        foreach ($threads as $thread){
            $latest_message = Thread::find($thread->id)->getLatestMessageAttribute();
            $user = User::find($latest_message->user_id);

            $thread->latest_message = $latest_message;
            $thread->user = $user;
        }

        return response()->json($threads, $this->successCode);
    }

    /**
     * Create thread and add participants
     * @param $request
     * @return Response
     */
    public function create_thread(Request $request){
        //Log::error(print_r($request->all(), true));

        $thread = Thread::create([
            'subject' => $request['subject'],
        ]);

        // Create message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => $request['sender_id'],
            'body' => $request['message'],
        ]);

        // Add thread initiator
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => $request['sender_id'],
            'last_read' => new Carbon,
        ]);

        // Add Recipients
        foreach ($request->participants as $participant){
            $thread->addParticipant($participant);
        }

        $threads = Thread::with('users')->forUser($request['sender_id'])->latest('updated_at')->get();
        return response()->json($threads, $this->successCode);
    }

    /**
     * @param $thread_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch_messages($thread_id, $user_id){
        $messagesPerPage = 10;
        $messages = Message::with(['user'])->where('thread_id', $thread_id)->orderBy('created_at', 'desc')->paginate($messagesPerPage);

        $thread = Thread::find($thread_id);
        $thread->markAsRead($user_id);
        return response()->json($messages, $this->successCode);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save_message(Request $request){
        $message = new Message();
        $message->thread_id = $request->thread_id;
        $message->user_id = $request->user_id;
        $message->body = $request->message;

        $message->save();

        $user = User::find($message->user_id);
        $message->user = $user;
        return response()->json($message, $this->successCode);
    }

    /**
     * @param $thread_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_thread_participants($thread_id){
        $thread = Thread::find($thread_id);
        $participants = Participant::with(['user'])->where('thread_id', $thread_id)->get();

        return response()->json(['participants' => $participants, 'thread' => $thread], $this->successCode);
    }

    public function remove_participant($thread_id, $participant_id){
        $thread = Thread::find($thread_id);
        $thread->removeParticipant($participant_id);

        $participants = Participant::with(['user'])->where('thread_id', $thread_id)->get();

        // Archive thread if the last user has left
        if(count($participants) < 1){
            $thread->delete();
        }
        return response()->json($participants, $this->successCode);

    }
}
