<?php
if(!session_id())
    session_start();

    include_once("functions.php");

    function getChat($sender, $receiver, $username, $msg, $time){
        if($sender == $username){
            $file = file_exists("images/$username.jpg")? $username.".jpg":"picture.png";
            $cont = <<<ML
                <div class="d-flex justify-content-end mb-4">
                    <div class="msg_cotainer_send">
                        $msg
                        <span class="msg_time">$time</span>
                    </div>
                    <div class="img_cont_msg">
                        <img src="images/$file" class="rounded-circle user_img_msg">
                    </div>
                </div>
ML;
            echo $cont;
        }else{
            $file = file_exists("images/$sender.jpg")? $sender.".jpg":"picture.png";
            $cont = <<<ML
                <div class="d-flex justify-content-start mb-4">
                    <div class="img_cont_msg">
                        <img src="images/$file" class="rounded-circle user_img_msg">
                    </div>
                    <div class="msg_cotainer">
                        $msg
                        <span class="msg_time">$time</span>
                    </div>
                </div>
ML;
            echo $cont;
        }
    }

    if(isset($_SESSION['username']) && isset($_REQUEST['chatwith'])){
        $username = strip_tags($_SESSION['username']);
        $receiver = strip_tags($_REQUEST['chatwith']);
        $conn = get_connection_handle();
        if(isset($_REQUEST['last_id'])){
            $id = strip_tags($_REQUEST['id']);
            $query = $conn->query("select * from chats where sender = '$username' and receiver = '$receiver' 
            or sender = '$receiver' and receiver = '$username' and id > $id");
        }else{
            $query = $conn->query("select * from chats where sender = '$username' and receiver = '$receiver' 
            or sender = '$receiver' and receiver = '$username'");
        }
        if($query->num_rows > 0){
            while($row = $query->fetch_object()){
                if(strtotime($row->added_on) == strtotime(date("d-m-Y"))){
                    $time_date = $row->added_at.", Today";
                }else{
                    $time_date = $row->added_at.", ".$row->added_on;
                }
                $chat = getChat($row->sender, $row->receiver,$username,$row->message,$time_date);
                echo $chat;
            }
        }else{
            if(!is_get('chatwith')){
                echo "<div class='empty-msg'><span class='fa fa-info'></span>
                    No conversation yet, choose a friend to chat with.
                </div>";
            }else{
                echo "<div class='empty-msg'><span class='fa fa-info'></span>
                    Start a conversation
                </div>";
            }
        }
    }
?>