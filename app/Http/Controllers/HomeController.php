<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $chats = Chat::orderBy("created_at","asc")->get();
        return view('home', compact("chats"));
    }

    public function post(Request $request)
    {
        $user = Auth::user()->name;

        $chat = new Chat();
        $chat->user = $user;
        $chat->message = $request->message;
        $chat->save();

        broadcast(new Message($chat->id, $chat->user, $chat->message, $chat->created_at, $chat->updated_at));

        return response()->json($chat);
    }
}
