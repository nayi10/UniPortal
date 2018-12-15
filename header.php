<?php
session_start();

$directory = basename(dirname($_SERVER['PHP_SELF']));

require_once('functions.php');
include_once("Student.php");

 if(is_session("student_id")){

    $student_id = $_SESSION['student_id'];

    $email = $_SESSION['email'];

    $user_id = $_SESSION['id'];

}elseif(is_session("tutor_id")){
    
    $tutor_id = $_SESSION['tutor_id'];
    $email = $_SESSION['email'];
    $user_id = $_SESSION['id'];
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title></title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="UniPortal">

<meta name="keywords" content="Ghana, questions, qa, QA, Q&A, school, university,
      courses, books, reading, education, educative,event,events, skills,academic,
      publish, educative content, lectures">

<?php require_once('styles.php');?>

</head>

<body>

<nav class="fixed-top navbar-expand-md navbar">

  <a class="navbar-brand mr-5" href="/UniPortal">UniPortal</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-toggle"
          aria-controls="navbar-toggle" aria-label="Toggle navigation">

    <span class="fa fa-bars text-white"></span>

  </button>

  <div class="collapse navbar-collapse" id="navbar-toggle">

    <ul class="navbar-nav" id="main-menu">
        <li class="nav-item with-select">
            <form class="form-inline hide-md">
                <select name="campus" title="Select Campus" class="overflowed" id="select_campus">
                    <option value="General">General</option>
                    <option value="Navrongo">Navrongo</option>
                    <option value="Nyankpala">Nyankpala</option>
                    <option value="Tamale">Tamale</option>
                    <option value="Wa">Wa</option>
                </select>
            </form>
        </li>
        <li class="nav-item">
            <input type="search" name="search" placeholder="Search content" class="nav-form-input mr-3">


        </li>

        <li class="nav-item">
            <a class="nav-link" href="questions.php">Questions</a>

        </li>

        <li class="nav-item">
            <a class="nav-link" href="hostels.php">Hostels</a>

        </li>

        <li class="nav-item">
            <a class="nav-link" href="lectures.php">Lectures</a>

        </li>

        <li class="nav-item dropdown">

        <?php

            if(isset($_SESSION['username']) && $_SESSION['username'] != ''){

                $username = $_SESSION['username'];

                $user_dir = "users/myaccount/images/".$username.".jpg";

                if(file_exists($user_dir)){

                    echo'<a class="nav-link dropdown-toggle" title="'.$username.'" href="#" id="dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="'.$user_dir.'" class="img-circle"></a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown">
                        <li>
                            <a class="dropdown-item" href="/UniPortal/dashboard.php#account">My Account</a>
                        </li>

                        <li>
                        <a class="dropdown-item" href="/UniPortal/dashboard.php">Dashboard</a>
                        </li>

                        <li><a class="dropdown-item" href="/UniPortal/logout.php">Logout</a>
                        </li>
                    </ul>';
                }else{
                echo '<a class="nav-link dropdown-toggle" title="'.$username.'" href="#" id="dropdown"
                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <i class="fa fa-user circle-trans"></i>
                '.ucfirst($username).'</a>

                    <ul class="dropdown-menu" aria-labelledby="dropdown">
                        <li>
                        <a class="dropdown-item" href="/UniPortal/dashboard.php#account">My Account</a></li>

                        <li>
                        <a class="dropdown-item" href="/UniPortal/dashboard.php">Dashboard</a></li>

                        <li><a class="dropdown-item" href="/UniPortal/logout.php">Logout</a></li>

                    </ul>';

                }

            } else {
                    echo '<a href="/UniPortal/login.php" class="nav-link">Login</a>';
                }
            ?>
        </li>

        </ul>
    </div>
</nav>
<div class="content-separator" id='con-sep'>
    <?php if(is_session("student_id")){
        $title = "Ask a question";
    }  else {
        $title = "Ask question as guest";
    } ?>

    <button class="btn btn-info-alt fixed" id="toggler" style="bottom:5;top: 90%;" title="<?php echo $title; ?>">
        <span class="fa fa-plus"></span>
    </button>

<?php include_once 'scripts.php'; ?>
