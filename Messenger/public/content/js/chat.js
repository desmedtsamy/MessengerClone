

    var currentName =" {{$current['name']}}";
    var currentId= "{{$current['id']}}";
    var currentAvatar = "{{$current['avatar']}}";
$(document).ready(function(){
    showCurrent();
    showFriends();
    initMessages();
    var input = document.getElementById("message");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            prout();
        }
    });
});
function switchChat($id){
    $.get("/api/user/"+$id, function(newCurrent, status){
        currentName =newCurrent.name;
    currentId= newCurrent.id;
    currentAvatar = newCurrent.avatar;
console.log(currentName);
    });
    initMessages();
    showCurrent();
}
function prout(){
    $.post("/api/message",
    {
      id: "{{ Auth::id() }}",
      friend: currentId,
      content:$("#message").val()
    });
    addMessage($("#message").val());
    $("#message").val('');
}
function addMessage(content){
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
    $.get("/api/messages/{{Auth::id()}}/{{$current['id']}}", function(messages, status){
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
$.get("/api/friends", function(friends, status){
            friends.forEach(friend => $("#SmallChats").append(
                    
                "<button onClick= 'switchChat("+friend.id+")'>"+
                    "<div class= 'SmallChat'>"+
                        "<img class='image' src='"+friend.avatar+"'>"+
                        "<div class='title'>"+friend.name+"</div>"+
                        
                       " <div class='lastMessage'>demande en attente ⏳</div>"+
                        
                   " </div>"+
                "</button>"));
            
        })
}
function showCurrent(){

    $("#messages").empty();
    $("#current").append(
        "<img class='image' src='"+currentAvatar+"''>"+
            "<div class='title'>"+currentName+"</div>"+
            "<div class='lastMessage'>en ligne 🟢</div>"

            );
}