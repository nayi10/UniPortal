<?php
require_once('functions.php');
if (isset($_POST['username']) && isset($_POST['email'])) {
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
    
    if (!isset($_POST['user_id']) || $_POST['user_id'] == '') {
        $errors[] = 'Please enter user\'s ID';
    } elseif (strlen($_POST['user_id']) < 11 && strlen($_POST['user_id']) > 15) {
        $errors[] = 'Invalid User ID';
    } else {
        $user_id = strip_tags(trim(htmlspecialchars($_POST['user_id'])));
    }
    
    if (!isset($_POST['department']) || $_POST['department'] == '') {
        $errors[] = 'Please provide department';
    }else {
        $department = strip_tags(trim(htmlspecialchars($_POST['department'])));
    }
    
    if(isset($_POST['userType']) && $_POST['userType'] == "Student"){
        $usertype = "student";
        $certificate = "";
        $programme = strip_tags(trim(htmlspecialchars($_POST['programme'])));
    }else{
        $certificate = strip_tags($_POST['certificate']);
        $programme = "";
        $usertype = "tutor";
    }
    
    $added = date('Y-m-d h:i:sa');
    if (!$errors) {
        $conn = get_connection_handle();
        $stmt = $conn->prepare("INSERT INTO users(user_id, username, firstname,
        middlename, lastname, email, phone, password, programme, department, type, 
        certificate, added_on) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssssssss', $user_id, $username, $firstname, $middlename, 
        $lastname, $email, $phone, $password, $programme, $department, $usertype, $certificate, $added);
        $stmt->execute();
        $row = $conn->affected_rows;
        if ($row == 1) {
            if(!file_exists("users/$username/")){
                if(mkdir("users/$username/", 0777, true)){
                    if(file_get_contents("default.php")){
                        $content = file_get_contents("default.php");
                        file_put_contents("users/$username/index.php", $content);
                        $note = file_get_contents("notes.php");
                        file_put_contents("users/$username/notes.php", $note);
                        $msg = "User has been created";
                        echo $msg;
                    }
                }
            }else{
                if(file_get_contents("default.php")){
                    $content = file_get_contents("default.php");
                    file_put_contents("users/$username/index.php", $content);
                    $note = file_get_contents("notes.php");
                    file_put_contents("users/$username/notes.php", $note);
                    $msg = "User has been created";
                    echo $msg;
                }
            }
        } else {
            echo "Cannot create user $username" . $conn->error;
        }

    } else {
        foreach($errors as $error){
            echo($error."<br>");
        }
    }
}
?>