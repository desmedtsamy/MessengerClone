<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $channels = Chat::getAllChannels();
        $messages = Chat::getMessages($channels[0]["id"]);
        return view('welcome', ['channels' => $channels,"messages"=>$messages]);

    }
}
