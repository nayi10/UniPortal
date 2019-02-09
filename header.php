<?php
if(!session_id())
  session_start();

$directory = basename(dirname($_SERVER['PHP_SELF']));

require_once('functions.php');
include_once("Student.php");

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
        <li class="nav-item">
            <input type="search" name="search" placeholder="Search content" class="nav-form-input">
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/UniPortal/questions/">Questions</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/UniPortal/hostels.php">Hostels</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/UniPortal/events.php">Events</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/UniPortal/lectures.php">Lectures</a>
        </li>

        <li class="nav-item dropdown">
        <?php
            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){

                $user_id = strtoupper($_SESSION['user_id']);

                $user_dir = "users/myaccount/images/".$user_id.".jpg";

                if(file_exists($user_dir)){

                    echo'<a class="nav-link dropdown-toggle" title="'.$user_id.'" href="#" id="dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="'.$user_dir.'" class="img-circle"></a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown">
                        <li>
                            <a class="dropdown-item" href="/UniPortal/dashboard.php#account">My Account</a>
                        </li>

                        <li>
                        <a class="dropdown-item" href="/UniPortal/dashboard.php">Dashboard</a>
                        </li>

                        <li><a class="dropdown-item" href="/UniPortal/#" id="logout" onclick="destroySession()">Logout</a>
                        </li>
                    </ul>';
                }else{
                echo '<a class="nav-link dropdown-toggle" title="'.$user_id.'" href="#" id="dropdown"
                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <i class="fa fa-user"></i> Profile</a>

                    <ul class="dropdown-menu" aria-labelledby="dropdown">
                        <li class="dropdown-item">
                          <a href="/UniPortal/myaccount.php">'.$user_id.'</a>
                        </li>
                        <li class="dropdown-item">
                          <a href="/UniPortal/dashboard.php">Dashboard</a>
                        </li>
                        <li class="dropdown-item">
                          <a href="/UniPortal/#" id="logout" onclick="destroySession()">Logout</a>
                        </li>
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

<?php include_once 'scripts.php'; ?>
