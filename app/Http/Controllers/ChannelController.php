<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Chat;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $channels = Channel::all();
        return view('home', ['channels' => $channels]);
    }

    public function getName()
    {
        $id = $_GET['channel_id'];
        return Channel::where('id', '=', $id)->pluck('name');
    }

    public function create(Request $request)
    {
        $channel = new Channel();
        $channel->name = $request->channelName;
        $channel->save();

        return redirect('/');
    }

    public function delete($id)
    {
        $channel = Channel::find($id);
        $channel->delete();

        return redirect('/');
    }
}
