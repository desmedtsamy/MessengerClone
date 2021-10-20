<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Chat;
use Auth;

 class routeController extends Controller {
    
    function index() {
        if (Auth::check()){

            $friends = Chat::getFriends(Auth::id());
            $friend = $friends[0];
            return view('home', ['current'=>$friend]);
        }else{

       return view('welcome') ;
        }
    }
    
}
