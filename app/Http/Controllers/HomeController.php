<?php

namespace App\Http\Controllers;

use App\Events\Message;
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
        return view('home');
    }

    public function post(Request $request)
    {
        $user = Auth::user()->name;
        broadcast(new Message($user, $request->message));

        return response()->json(["status" => "メッセージの送信に成功!"]);
    }
}
