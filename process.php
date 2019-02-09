<?php
include_once("functions.php");

if(isset($_REQUEST['comment']) && !empty($_REQUEST['comment'])){
    $errors = array();
    $comment = is_string($_REQUEST['comment'])?
    strip_tags($_REQUEST['comment']): $errors[] = "Comment is required";

    $type = isset($_REQUEST['type'])?
    strip_tags($_REQUEST['type']): $errors[] = "An error occured. Try again";

    $id = isset($_REQUEST['type_id'])? intval($_REQUEST['type_id']):
    $errors[] = "An error occured. Try again";

    $username = isset($_REQUEST['username'])? strval($_REQUEST['username']):
    $errors[] = "An error occured. Try again";

    if(!$errors){
        $conn = get_connection_handle();
        $today = date("Y-m-d");
        $now = date("H:i:sa");
        $stmt = $conn->prepare("insert into comments(type, type_id, comment,
        username, added_on, added_at) values(?,?,?,?,?,?)");
        $stmt->bind_param("sissss", $type, $id, $comment, $username, $today,$now);
        $stmt->execute();
        if($conn->affected_rows == 1){
            echo "Comment has been added";
        }else{
            echo "Something happened, try again.".$conn->error;
        }
    }else{
        foreach($errors as $error){
            echo $error;
        }
    }
}elseif(isset($_REQUEST['name']) && $_REQUEST['name'] !== ""){
    if(!session_id())
        session_start();
    
    $username = $_SESSION['username'];
    $name = strip_tags($_REQUEST['name']);
    include_once("functions.php");
    $conn = get_connection_handle();
    $result = $conn->query("select firstname,lastname,username from users where 
            username != '$username' and (username like '%$name%' or firstname like '%$name%' or 
            lastname like '%$name%' or user_id like '%$name%') and type = 'student' limit 10");

    if($result->num_rows > 0){
        while($row = $result->fetch_object()){
            $url = "http://localhost/UniPortal/dashboard.php?tab=chat";
            $real_name = $row->firstname." ".$row->lastname;
            $user = $row->username;
              // $_SESSION['chatwith-name'] = $real_name;
              // $_SESSION['chatwith'] = $user;
            echo "<a href='$url&chatwith=$user' class='chat-list'>$real_name ($user)</a>";
        }
    }else{
        echo "No matches were found";
    }
}elseif(isset($_REQUEST['message']) && !empty($_REQUEST['message'])){
    $msg = strip_tags($_REQUEST['message']);
    $sender = strip_tags($_REQUEST['sender']);
    $receiver = strip_tags($_REQUEST['receiver']);
    
    $today = date("Y-m-d");
    $now = date("H:i:sa");
    $status = "unviewed";
    $conn = get_connection_handle();
    $stmt = $conn->prepare("insert into chats(sender,receiver,message,status,
        added_on,added_at) values(?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $sender,$receiver,$msg,$status,$today,$now);
    $stmt->execute();
    if($conn->affected_rows == 1){
        echo "Chat has been added";
    }else{
      echo "Could not send message: ".$conn->error;
    }
}elseif(isset($_REQUEST['vote-type']) && $_REQUEST['type'] == "answer"){
    include_once("User.php");
    include_once("Answer.php");
    $vote = 1;
    $vote_type = strip_tags($_REQUEST['vote-type']);
    $question = strip_tags($_REQUEST['question']);
    $username = strip_tags($_REQUEST['username']);
    $id = strip_tags($_REQUEST['answer_id']);
    $user = new User($username);
    if(!$user->has_voted($id, "answer")){
        $ans = new Answer();
        $ans->set_id($id);
        if($vote_type == "upvote"){
          $ans->insert_votes($username, $vote);
        }else{
          $ans->insert_votes($username, null, $vote);
        }  
    }
    
}elseif(isset($_REQUEST['vote-type']) && $_REQUEST['type'] == "question"){
    include_once("User.php");
    include_once("Question.php");
    $vote = 1;
    $vote_type = strip_tags($_REQUEST['vote-type']);
    $question = strip_tags($_REQUEST['question']);
    $username = strip_tags($_REQUEST['username']);
    $id = strip_tags($_REQUEST['question_id']);
    $user = new User($username);
    if(!$user->has_voted($id, "question")){
        $qn = new Question($question);
        $qn->set_id($id);
        if($vote_type == "upvote"){
          $qn->insert_votes($username, $vote);
        }else{
          $qn->insert_votes($username, null, $vote);
        }
    }
}elseif(!empty($_FILES['file'])){
    $assign = strip_tags($_POST['assign_id']);
    $user = strip_tags($_POST['username']);
    $tutor = strip_tags($_POST['tutor']);
    $date_ = new DateTime();
    $today = $date_->format("Y-m-d H:i:s");
    $temp_file = $_FILES['file']['tmp_name'];
    $code = strip_tags($_POST['course-code']);
    $stat = "true";

    if(!empty($assign) && !empty($user)){
        $conn = get_connection_handle();
        $stmt = $conn->prepare("insert into submissions(assignment_id, 
        lecturer, username, date_submitted, is_submitted) values(?,?,?,?,?)");
        $stmt->bind_param("issss", $assign, $tutor, $user,$today,$stat);
        $stmt->execute();
        if($conn->affected_rows == 1){
            $yr = date("Y");
            $targe_path = "images/assignments/".$yr."/".$code."/";
            if(!file_exists($targe_path)){
                mkdir($targe_path, 0777, true);
            }

            $target_file = $targe_path.$user."-".$assign.".pdf";
            if(move_uploaded_file($temp_file, $target_file)){
              echo "File has been submitted";
            }else{
              echo "File could not be submitted";
            }
        }
    }
}elseif(isset($_POST['username']) && isset($_POST['email'])) {
    $errors = array();
    
    if (!isset($_POST['email']) || $_POST['email'] == '') {
        $errors[] = 'Email address is required';
    } else if (!((strpos($_POST['email'], ".") > 0) && (strpos($_POST['email'], "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $_POST['email'])) {
        $errors[] = 'Invalid email address';
    } else {
        $email = strip_tags(trim(htmlspecialchars($_POST['email'])));
    }
    
    if (!isset($_POST['username']) || $_POST['username'] == '') {
        $errors[] = 'Username is required';
    } elseif (strlen($_POST['username']) < 4) {
        $errors[] = 'Username must be six/more charaters';
    } else {
        $username = strip_tags(trim(htmlspecialchars($_POST['username'])));
    }
    
    if (!isset($_POST['firstname']) || $_POST['firstname'] == '') {

        $errors[] = 'Firstname cannot be blank';

    } elseif (!preg_match("/[a-zA-Z]/", $_POST['firstname'])) {

        $errors[] = 'Invalid characters for firstname';

    } else {
       $firstname = strip_tags(trim(htmlspecialchars($_POST['firstname'])));
    }

    if (!isset($_POST['lastname']) || $_POST['lastname'] == '') {
        $errors[] = 'Lastname cannot be left blank';
    } elseif (!preg_match("/[a-zA-Z]/", $_POST['lastname'])) {
        $errors[] = 'Invalid lastname';
    } else {
        $lastname = strip_tags(trim(htmlspecialchars($_POST['lastname'])));
    }

    if (isset($_POST['middlename']) && $_POST['middlename'] !== ""){
        if(!preg_match("/[a-zA-Z]/", $_POST['middlename'])) {
            $errors[] = 'Invalid middle name';
        }else{
            $middlename = strip_tags(trim(htmlspecialchars($_POST['middlename'])));
        }
    }else{
        $middlename = "";
    }

    if (!isset($_POST['password']) || $_POST['password'] == '') {
        $errors[] = 'Password is required';
    } elseif (strlen($_POST['password']) < 6) {
        $errors[] = 'Password must be six(6) or more characters';
    } else if (!preg_match("/[a-z]/", $_POST['password']) || !preg_match("/[A-Z]/", $_POST['password']) || !preg_match("/[0-9]/", $_POST['password'])) {
        $errors[] = "Password must contain uppercase, lowercase and number(s)";
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    if (!isset($_POST['phone']) || $_POST['phone'] == '') {
        $errors[] = 'Please provide a phone number';
    } elseif (strlen($_POST['phone']) < 10) {
        $errors[] = 'Invalid phone number';
    } else {
        $phone = strip_tags(trim(htmlspecialchars($_POST['phone'])));
    }

    $added = date('Y-m-d h:i:sa');
    if (!$errors) {
        $conn = get_connection_handle();
        $stmt = $conn->prepare("INSERT INTO admins(username, firstname,
        middlename, lastname, email, phone, password, added_on) VALUES(?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssss', $username, $firstname, $middlename, 
        $lastname, $email, $phone, $password, $added);
        $stmt->execute();
        echo $conn->error;
        $row = $conn->affected_rows;
        if ($row == 1) {
            if(!file_exists("admins/$username/")){
                mkdir("admins/$username/", 0777, true);
            }
            $msg = "User has been created";
            echo($msg);
        } else {
            echo "Cannot create user $username" . $conn->error;
        }

    } else {
        foreach($errors as $error){
            echo($error."<br>");
        }
    }
}
