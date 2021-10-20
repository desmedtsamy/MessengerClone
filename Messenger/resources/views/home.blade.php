@extends('layouts.app')

<link rel="stylesheet" type="text/css" href="/content/chat.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@section('content')

<div id = "list">

        <h2>Discussions</h2>
        <div id ="SmallChats">      
                
        </div>
    </div>
    <div id = "chat">
    <div class= "SmallChat" id="current">
            
    </div>
        <div id="messages">
        </div>
        <div id="message">
            <input type="text" id="messageInput" name="content" placeholder="Aa" autocomplete="off">
            <button id="messageImage" onClick= 'addMessage()'><img class="image" id="messageImage" src="/content/img/send.svg"></button>
        </div>

    </div>

<div class="hover_bkgr_fricc">
    <span class="helper"></span>
    <div>
        <div class="popupCloseButton">&times;</div>
        <div id="popup"></div>
    </div>
</div>
<script>


let currentName =" {{$current['name']}}";
    let currentId= "{{$current['id']}}";
    let currentAvatar = "{{$current['avatar']}}";
    let currentStatus = "{{$current['status']}}";

$(document).ready(function(){
    $('.popupCloseButton').click(function(){
        $('.hover_bkgr_fricc').hide();
    });

    showCurrent();
    showFriends();
    initMessages();
    var input = document.getElementById("message");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            addMessage();
        }
    });
    
});
function switchChat($id){
    $.get("/api/user/"+$id, function(newCurrent, status){
        currentName = newCurrent.name;
        currentId= newCurrent.id;
        currentAvatar = newCurrent.avatar;
        currentStatus = newCurrent.status;
    initMessages();
    showCurrent();
    });
    
    
}
function addMessage(){
    if($("#messageInput").val() !="" && $("#messageInput").val() !=" " ){
        $.post("/api/message",
        {
        id: "{{ Auth::id() }}",
        friend: currentId,
        content:$("#messageInput").val()
        });

        showMessage($("#messageInput").val());
        $("#messageInput").val('');
    }
}
function addFriend(){
    $.post("/api/addfriend",
    {
      id: "{{ Auth::id() }}",
      friend: $("#name").val()
    });
    showFriends();
    $('.hover_bkgr_fricc').hide();
    $("#name").val('');

}
function showMessage(content){
    $("#messages").append(
                    "<p class='author'>{{Auth::user()->name}}</p><br>"+
                    "<img class='smallImage' src='{{Auth::user()->avatar}}'>"+
                    "<div class='container'>"+
                    "<p>"+content+"</p>"+
                    "</div>"+
                    "<br><br><br>"

            );
}
function initMessages(){
    $("#messages").empty();
    $.get("/api/messages/{{Auth::id()}}/"+currentId, function(messages, status){
            for( message of messages){
            if(message.name == "{{Auth::user()->name}}"){
            $("#messages").append(
                    "<p class='author'>"+message.name+"</p><br>"+
                    "<img class='smallImage' src='"+message.avatar+"'>"+
                    "<div class='container'>"+
                    "<p>"+message.content+"</p>"+
                    "</div>"+
                    "<br><br><br>"

            );
            }
            else{
                $("#messages").append(
                    "<p class='author left'>"+message.name+"</p><br>"+
                    "<img class='smallImage left' src='"+message.avatar+"'>"+
                    "<div class='container darker'>"+
                    "<p>"+message.content+"</p>"+
                    "</div>"+
                    "<br><br><br>"

            );
            }
            }
            
        });
}
function showFriends(){

    $("#SmallChats").empty();
    $.get("/api/friends/"+{{Auth::id()}}, function(friends, status){
        let user="";
            for(friend of friends){

            if(friend.accepted == 0){
                user+=(  
                    "<button onClick= 'switchChat("+friend.id+")'>"+
                    "<div class= 'SmallChat'>"+
                        "<img class='image' src='"+friend.avatar+"'>"+
                        "<div class='title'>"+friend.name+"</div>");
                    if(friend.status){

                        user+="<div class='lastMessage'>en ligne 🟢</div>";
                    }else{
                        user+="<div class='lastMessage'>hors ligne 🔴</div>";
                    }  
                }else{
                    
                    if(friend.accepted == {{Auth::id()}}){
                         user+=(  
                         "<button onClick= 'invit("+friend.id+")'>"+
                        "<div class= 'SmallChat'>"+
                        "<img class='image' src='"+friend.avatar+"'>"+
                        "<div class='title'>"+friend.name+"</div>"+" <div class='lastMessage'>demande reçu ✅ ❌</div>");
                    }else{
                        user+=(  
                         "<button>"+
                        "<div class= 'SmallChat'>"+
                        "<img class='image' src='"+friend.avatar+"'>"+
                        "<div class='title'>"+friend.name+"</div>"+
                        " <div class='lastMessage'>demande en attente ⏳</div>");
                       
                    }
    
                }
                user+=(" </div></button>");
            }
            user +=("<button onClick='show()'>"+
                "<div class= 'SmallChat'>"+
                    "<img class='image' src='/content/img/plus.svg'>"+
                    "<div class='title'>Ajouter</div>"+
                    "<div class='lastMessage'>Ajouter un contact</div>"+
                "</div></button>");
            $("#SmallChats").append(user);
        })
}
async function show(){

    $("#popup").empty();
    $("#popup").append("<h1>Ajouter un contact</h1>"+
    "nom du contact : <input type='text' id='name' placeholder='Aa' autocomplete='off'>");
    $('.hover_bkgr_fricc').show();

    var input = document.getElementById("name");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            addFriend();
        }
    });
}
function showCurrent(){
    let txt = "";
    $("#current").empty();
   txt+=(
        "<img class='image' src='"+currentAvatar+"''>"+
            "<div class='title'>"+currentName+"</div>" );
    if(currentStatus == 1){

        txt+="<div class='lastMessage'>en ligne 🟢</div>";
    }else{
        txt+="<div class='lastMessage'>hors ligne 🔴</div>";
    }
    $("#current").append(txt);
}
function invit(id){

    $("#popup").empty();
    $('.hover_bkgr_fricc').show();
    $("#popup").append("<h1>Accepter ?</h1>"+
    "<button onClick= 'accept("+id+")'>✅</button><button onClick= 'deny("+id+")'>❌</button>");
}
function accept(id){
    $.post("/api/accept",
    {
      id: "{{ Auth::id() }}",
      friend: id
    });
    showFriends();
    $('.hover_bkgr_fricc').hide();
    $("#name").val('');

}
function deny(id){
    $.post("/api/denided",
    {
      id: "{{ Auth::id() }}",
      friend: id
    });
    showFriends();
    $('.hover_bkgr_fricc').hide();
    $("#name").val('');

}
</script>
@endsection