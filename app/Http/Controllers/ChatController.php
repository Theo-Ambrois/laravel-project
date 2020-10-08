<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\ChatEvent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('chat.chat');
    }

    public function fetchAllMessages()
    {
        //return Chat::with('user')->get();
        if (isset($_GET['channel_id'])) {
            return Chat::with('user')->where('channel_id', '=', $_GET['channel_id'])->get();
        }
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $chat = $user->messages()->create([
            'message' => $request->input('message'),
            "channel_id" => $request->input('channel_id')
        ]);

    	broadcast(new ChatEvent($user, $chat))->toOthers();

    	return ['status' => 'Message envoyé !'];
    }

    public function fetchAllUsers()
    {
        return User::All();
    }
}