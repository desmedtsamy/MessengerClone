<?php
    namespace App\Models;
    use \Illuminate\Support\Facades\DB;
    use PDO;
    use Auth;
    use \Cache;
    class Chat{
        
        public static function getMessages($id,$friendId) {
            $pdo = DB::getPdo();
            $channels = $pdo->query("select messages.id,added_on,content,users.name,users.avatar from messages join users ON users.id = messages.author_id 
            WHERE messages.author_id = $id AND messages.receptor_id = $friendId
            OR messages.receptor_id = $id AND messages.author_id = $friendId")
                         ->fetchAll();
            return $channels;
        }
        public static function getID($email) {
            $pdo = DB::getPdo();
            $id = $pdo->query("select id from users WHERE email ='$email'")
                         ->fetch();
            return $id['id'];
        }
        public static function getUser($id) {
            $pdo = DB::getPdo();
            $result = $pdo->query("select id , name,avatar from users where id = $id  ")
                         ->fetch();
                        $status =(Cache::has('user-is-online-'.$result['id']));
                        array_push($result,$status);
                        $result['status'] = $result[3];
                        unset($result[3]);

            return $result;
        }
        public static function getFriends($id) {
            $pdo = DB::getPdo();
           
            $request1 = $pdo->query("select users.id AS id, users.name AS name,users.avatar AS avatar, accepted from friends join users ON users.id = id_user_2 where id_user_1 = $id  ")
                         ->fetchAll();
            $request2 = $pdo->query("select users.id, users.name AS name,users.avatar AS avatar, accepted from friends join users ON users.id = id_user_1 where id_user_2 = $id  ")
                         ->fetchAll();
            $result = array_merge($request1,$request2);
            for ($i = 0; $i < count($result); $i++) {
                $status =(Cache::has('user-is-online-'.$result[$i]['id']));
                        array_push($result[$i],$status);
                        $result[$i]['status'] = $result[$i][4];
                        unset($result[$i][4]);
            }
            return $result;
        }
        public static function accept($friend,$userId) {
           DB::insert("UPDATE friends SET accepted = 0 where id_user_1='$friend' AND id_user_2='$userId'");
        }
        public static function denided($friend,$userId) {
            
           DB::insert("DELETE FROM friends where id_user_1='$friend' AND id_user_2='$userId'");
         }
        public static function addFriend($friend,$userId) {
            $pdo = DB::getPdo();
            $friendId = $pdo->query("select id from users where  name= '$friend'  ")
                         ->fetch();
           DB::insert("INSERT INTO friends (id_user_1,id_user_2,accepted) VALUES (?,?,?)",[$userId,$friendId['id'],$friendId['id']]);
        }
        public static function addMessage($friend,$userId,$content) {
           
            DB::insert("INSERT INTO messages (content,author_id,receptor_id) VALUES (?,?,?)",[$content,$userId,$friend]);
        }
       
        public static function getAllUser() {
            $pdo = DB::getPdo();
            $channels = $pdo->query("select name,id from users ")
                         ->fetchAll();
            return $channels;
        }
    }
?>
