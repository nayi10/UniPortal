<?php
include_once("header.php");

if(is_session("username")){
    $std_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $user = new User($username);
  ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 hide-sm">
      <div class="sidebar">
        <h5 class="sidebar-header text-center">
          <?php echo $user->get_fullname();?>
        </h5>
        <div class="sidebar-list">
            <a href=".">
              <i class="fa fa-home mr-2"></i> Home
            </a>
            <a href="dashboard.php">
              <i class="fa fa-dashboard mr-2"></i> Dashboard
            </a>
            <a href="dashboard.php?tab=myaccount" id="my_questions">
              <i class="fa fa-user mr-2"></i> My Account
            </a>
            <a href="dashboard.php?tab=questions" id="my_questions">
              <i class="fa fa-question mr-2"></i> My Questions
            </a>
            <a href="dashboard.php?tab=answers" id="my_answers">
              <i class="fa fa-pencil-square-o mr-2"></i> My Answers
            </a>
            <a href="dashboard.php?tab=assignments" id="my_assignments">
              <i class="fa fa-refresh mr-2"></i> Assignments
            </a>
            <a href="dashboard.php?tab=notes" id="my_questions">
              <i class="fa fa-sticky-note-o mr-2"></i> My Notes
            </a>
            <a href="dashboard.php?tab=lectures" id="my_lectures">
              <i class="fa fa-list mr-2"></i> My Lectures
            </a>
            <a href="dashboard.php?tab=chat">
              <i class="fa fa-comment mr-2"></i> Open Chat
            </a>
        </div>
      </div>
</div>
<div class="col-md-10"><br>

<?php 
    if($tab = is_get("tab")){
      // $tab = is_get("tab");
      $page = "tab".ucfirst($tab).".php";
      if(file_exists($page)){
        include_once($page);
      }else{
        include_once("404.html");
      }
    }else{
      include_once("dash.php");
    }
  }else{
    header(".");
  }
?>
