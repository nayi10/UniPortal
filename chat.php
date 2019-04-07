<?php if(!session_id()) session_start();
	if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		$id = $_SESSION['id'];
	}else{
		header("UniPortal/");
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Chat</title>
        <?php include_once("styles.php"); ?>
        <link rel="stylesheet" href="css/chat.css">
        <script src="js/jquery.js"></script>
    </head>
	<body>
		<div class="container-fluid h-100">
			<div class="row justify-content-center h-100">
				<div class="col-md-4 col-xl-3 chat">
					<div class="card mb-sm-3 mb-md-0 contacts_card">
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
								$det = <<<LT
									<li class="active" style="border-bottom:1px solid rgba(100,100,100,0.5);">
										<div class="d-flex bd-highlight">
											<div class="img_cont">
												<img src="images/picture.png" class="rounded-circle user_img">
												<span class="online_icon"></span>
											</div>
											<div class="user_info">';
												<a href='chat.php?chatwith=$chat_user'>
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

									$result = $conn->query("select added_on, added_at from chats where 
											receiver = '$row->receiver' 
											order by id desc limit 1");
									$r = $result->fetch_object();
									$tl = <<<REM
									<li id="last">
										<div class='d-flex bd-highlight'>
											<div class='img_cont'>
												<a href='chat.php?chatwith=$row->receiver'>
													<img src='$file' class='rounded-circle user_img other'>
												</a>
											</div>
											<div class='user_info'>
												<a href='chat.php?chatwith=$row->receiver'>
													<span>$row->receiver</span>
												</a>
												<p>$r->added_on, $r->added_at</p>
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
                                    <span><?php echo $uname == ""? "Choose someone to chat": $uname;?></span>
                                    <span class="online_status"></span>
								</div>
							</div>
							<span id="action_menu_btn"><i class="fa fa-ellipsis-v"></i></span>
							<div class="action_menu">
								<ul>
									<li><i class="fa fa-user-circle"></i> 
									<a href="user/<?php echo $uname;?>/" class="text-white">
										View profile
									</a>
									</li>
									<li><i class="fa fa-ban"></i> Block</li>
								</ul>
							</div>
						</div>
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
                                        <button class="input-group-text send_btn"><i class="fa fa-location-arrow"></i></button>
                                    </div>
                                </div>
                            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
    </body>
    <script>
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
					console.log("Data: " + data)
                    $("#result").removeClass("hide").html(data);
                })
                .fail(function(error){
                    $("#result").removeClass("hide").css("color", 'red').text("There is an error getting the results - " + error);
                })
				console.log("Value: " + search)
            }
        })
        setInterval(function(){
			locat = location.href;
			chatString = locat.slice(locat.search("chatwith"), locat.length);//Locate chat query string
			username = chatString.substring(chatString.indexOf("=") + 1, chatString.length);
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
				if($("#chat-msg").val() !== ''){
					$.ajax({
						method: "POST",
						url: "process.php",
						data: {message: val, sender: sender, receiver: receiver}
						})
						.done(function(data){
							console.log("Message: " + data + "\nData: " + data);
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
					.fail(function(error){
						console.log("Error occured: " + error)
					});
			}
			$("#chat-msg").val("");
			e.preventDefault();
		});
    </script>
</html>
