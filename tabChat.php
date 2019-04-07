<?php 
if(!session_id()) session_start();
	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		$id = $_SESSION['id'];
	}else{
		header("UniPortal/");
    }
?>
<link rel="stylesheet" href="css/chat.css">
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <h1 class="hide">Chat room</h1>
        <div class="col-md-4 col-xl-3 chat">
            <div class="card contacts_card">
            <div class="card-header">
                <form>
                    <div class="input-group">
                        <input type="search" placeholder="Search..." name="" class="form-control search">
                        <div class="input-group-prepend">
                            <span class="input-group-text search_btn"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                    <div class="card-4 hide" id="result"></div>
                </form>
            </div>
            <div class="card-body contacts_body">
                <ui class="contacts">
                <?php
                    include_once("functions.php");
                    if(isset($_GET['chatwith'])){
                
                        // $name = $_SESSION['chatwith-name'];
                        $chat_user = $_GET['chatwith'];
                        $status = $chat_user." is online";
                        if(isset($_GET['status']) && $_GET['status'] == true){
                            $conn = get_connection_handle();
                            $conn->query("update chats set status = 'viewed' 
                            where sender = '$chat_user' and receiver = '$username'");
                        }
                        $det = <<<LT
                            <li class="active" style="border-bottom:1px solid rgba(100,100,100,0.5);">
                                <div class="d-flex bd-highlight">
                                    <div class="img_cont">
                                        <img src="images/picture.png" class="rounded-circle user_img">
                                        <span class="online_icon"></span>
                                    </div>
                                    <div class="user_info">';
                                        <a href='dashboard.php?tab=chat&chatwith=$chat_user'>
                                            <span>$chat_user</span>
                                        </a>
                                        <p>$status</p>
                                    </div>
                                </div>
                            </li>
LT;
                        echo $det;
                    }
                    $conn = get_connection_handle();
                    $res = $conn->query("select distinct receiver from chats 
                    where sender = '$username' order by id desc limit 25");

                    if($res && $res->num_rows > 0){
                        
                        while($row = $res->fetch_object()){
                            if(file_exists("images/$row->receiver.jpg")){
                                $file = "images/$row->receiver.jpg";
                            }else{
                                $file = "images/picture.png";
                            }
                            $result = $conn->query("select added_on from chats where 
                                    sender = receiver = '$row->receiver' 
                                    order by id desc limit 1");
                            $r = $result->fetch_object();
                            $d_ = new DateTime($r->added_on);
                            $date_ = $d_->format("d-m-Y");
                            $time = $d_->format("H:ia");
                            $tl = <<<REM
                            <li id="last">
                                <div class='d-flex bd-highlight'>
                                    <div class='img_cont'>
                                        <a href='dashboard.php?tab=chat&chatwith=$row->receiver'>
                                            <img src='$file' class='rounded-circle user_img other'>
                                        </a>
                                    </div>
                                    <div class='user_info'>
                                        <a href='dashboard.php?tab=chat&chatwith=$row->receiver'>
                                            <span>$row->receiver</span>
                                        </a>
                                        <p>$date_, $time</p>
                                    </div>
                                </div>
                            </li>
REM;
                            echo $tl;
                        }
                    }
                ?>
                </ui>
            </div>
            <div class="card-footer"></div>
        </div></div>
        <div class="col-md-8 col-xl-6 chat">
            <div class="card">
                <div class="card-header msg_head">
                    <div class="d-flex bd-highlight">
                    <?php if(isset($_GET['chatwith'])){
                        $uname = ucfirst(strip_tags($_GET['chatwith']));
                        $dir = "images/$uname.jpg" || "images/$uname.png";
                        $f = file_exists($dir)? $dir: "images/picture.png";
                        $img = "<img src='$f' class='rounded-img user_img'>";
                    }else{
                        $uname = "";
                        $img = "";
                    }
                    ?>
                        <div class="img_cont">
                            <?php echo $img; ?>
                        </div>
                        <div class="user_info">
                            <span><?php echo $uname == ""? "Choose someone to chat": $uname;;?></span>
                            <span class="online_status"></span>
                        </div>
                    </div>
                    <span id="action_menu_btn"><i class="fa fa-ellipsis-v"></i></span>
                    <div class="action_menu">
                        <ul>
                            <li><i class="fa fa-user-circle"></i> 
                            <a href="users/<?php echo strtolower($uname);?>/" class="text-white">
                                View profile
                            </a>
                            </li>
                            <li><i class="fa fa-ban"></i> Block</li>
                        </ul>
                    </div>
                </div>
                <input id='omgUser' type='hidden' value="<?php echo $uname; ?>">
                <div class="card-body msg_card_body">
                    <?php include_once("chat-server.php");?>
                </div>
                <div class="card-footer">
                    <form id="chat-form" method="post" action="process.php">
                        <div class="input-group">
                            <input type="hidden" id="receiver" value="<?php echo strtolower($uname);?>">
                            <input type="hidden" id="sender" value="<?php echo $username;?>">
                            <div class="input-group-append">
                                <span class="input-group-text attach_btn"><i class="fa fa-paperclip"></i></span>
                            </div>
                            <textarea name="message" id="chat-msg" class="form-control type_msg" placeholder="Type your message..."></textarea>
                            <div class="input-group-append">
                                <button class="input-group-text send_btn">
                                    <i class="fa fa-location-arrow"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/dropzone.js"></script>
<script>
    $(".attach_btn").click(function(){
       $(".msg_card_body").removeClass("msg_card_body").addClass("dropzone").prop("id", "shareTo")
    })
    Dropzone.options.shareTo = {
        url: 'upload.php',
        paramName: "shareFile",
        acceptedFiles: ".png,.jpg,.pdf, .doc, .docx, .odg, .ods, .xlsx,.xls,.ppt, .pptx",
        autoProcessQueue: true,
        maxFiles: 1,
        maxFilesize: 150,
        addRemoveLinks: true,
        init: function() {
            dzClosure = this;
            this.on("sending", function(data, xhr, formData){
                shareWith = $("#omgUser").val();
                formData.append("sharewith", shareWith.toLowerCase());
            })
            .on("success", function(file, res) {
                if(res == "File has been shared with " + shareWith){
                    $(".alert").removeClass("hide").addClass("alert-success").html(res.toUpperCase());
                }else{
                    $(".alert").removeClass("hide").addClass("alert-info").html(res.toCase());
                }
            })
            .on("maxfilesexceeded", function(file) { this.removeFile(file); })
            .on("fail",function(error){
                $(".alert").removeClass("hide").addClass("alert-danger").html(error)
            })      
        }
    }
$(document).ready(function(){
    $('#action_menu_btn').click(function(){
        $('.action_menu').toggle();
    });
});
$(".search").on('input', function(e){
    e.preventDefault();
    if($(this).val() !== ""){
        search = $(this).val();
        $.ajax({
            method: "POST",
            url: "process.php",
            data: {name: search}
        })
        .done(function(data){
            $("#result").removeClass("hide").html(data);
        })
        .fail(function(error){
            $("#result").removeClass("hide").css("color", 'red').text("There is an error getting the results - " + error);
        })
    }
})
setInterval(function(){
    locat = location.href;
    chatString = locat.slice(locat.search("chatwith"), locat.length);//Locate chat query string
    usernamePart = chatString.substring(chatString.indexOf("=") + 1, chatString.length);
    index = usernamePart.indexOf("&") >= 0 ? usernamePart.indexOf("&") : usernamePart.length;
    username = usernamePart.slice(0, index)
    $.ajax({
        method: "GET",
        url: "chat-server.php",
        data: {chatwith: username}
    })
    .done(function(data){
        $(".msg_card_body").html(data);
    })
    .fail(function(error){
        $(".msg_card_body").html(error);
    })
}, 3000);

$("#chat-msg").keypress(function (e) {
    if(e.which == 13 && !e.shiftKey) {
        let val = $(this).val();
        let sender = $("#sender").val();
        let receiver = $("#receiver").val();
        if($("#chat-msg").val() !== '' && sender !== '' && receiver !== ''){
            $.ajax({
                method: "POST",
                url: "process.php",
                data: {message: val, sender: sender, receiver: receiver}
                })
                .done(function(data){
                    if(data == "Chat has been added"){
                        $(".msg_card_body").scrollTop($(".msg_card_body")[0].scrollHeight)
                    }
                })
                .fail(function(error){
                    console.log("Error occured: " + error)
                });
        }
        $(this).val("");
        e.preventDefault();
    }
});
$("#chat-form").submit(function (e) {
    let val = $("#chat-msg").val();
    let sender = $("#sender").val();
    let receiver = $("#receiver").val();
    if($("#chat-msg").val() !== ''){
        $.ajax({
            method: "POST",
            url: "process.php",
            data: {message: val, sender: sender, receiver: receiver}
            })
            .success(function(response){
                if(response == "Chat has been added"){
                    $(".msg_card_body").scrollTop($(".msg_card_body")[0].scrollHeight)
                }
            })
            .fail(function(error){
                console.log("Error occured: " + error)
            });
    }
    $("#chat-msg").val("");
    e.preventDefault();
});
</script>