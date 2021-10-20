<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;
use App\User;

 use App\Models\Chat;

 class RestChatController extends Controller {
    function friends($id) {
        $result = Chat::getFriends($id);
        return response()->json($result);
    }
    function addfriend(Request $request) {
        $userid = $request->input('id');
        $friend = $request->input('friend');
        Chat::addFriend($friend,$userid);

    }
    function accept(Request $request) {
        $userid = $request->input('id');
        $friend = $request->input('friend');
        Chat::accept($friend,$userid);

    }
    function denided(Request $request) {
        $userid = $request->input('id');
        $friend = $request->input('friend');
        Chat::denided($friend,$userid);

    }
    function messages($id,$friend) {
            $result = Chat::getMessages($id,$friend);
            foreach ($result as &$message) {
                
               $message["content"] = Crypt::decryptString($message["content"]);
            }
        return response()->json($result);
    }
    function getUser($id) {
        $friend = Chat::getUser($id);
        return response()->json($friend);
    }
 
    function addMessage(Request $request) {
        $userid = $request->input('id');
        $content = Crypt::encryptString($request->input('content'));
        $friend = $request->input('friend');
        Chat::addMessage($friend,$userid,$content);

    }
    
}
