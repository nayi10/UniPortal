<?php
if(!session_id())
  session_start();
if(isset($_SESSION["username"]) && $_SESSION['user_type'] == "Normal"){
    include_once("header.php");
    $std_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $user = new User($username);
  }else{
    header("Location:/UniPortal/admin");
  }
  ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-2 col-md-2">
      <div class="sidebar">
        <h5 class="sidebar-header text-center hide-lg">
          <?php echo $user->get_fullname();?>
        </h5>
        <div class="sidebar-list">
            <a href=".">
              <i class="fa fa-home mr-2"></i> <span class="hide-lg">Home</span>
            </a>
            <a href="dashboard.php">
              <i class="fa fa-dashboard mr-2"></i> <span class="hide-lg">Dashboard</span>
            </a>
            <a href="dashboard.php?tab=myaccount" id="my_questions">
              <i class="fa fa-user mr-2"></i> <span class="hide-lg">My Account</span>
            </a>
            <a href="dashboard.php?tab=questions" id="my_questions">
              <i class="fa fa-question mr-2"></i> <span class="hide-lg">My Questions</span>
            </a>
            <a href="dashboard.php?tab=answers" id="my_answers">
              <i class="fa fa-pencil-square-o mr-2"></i> <span class="hide-lg">My Answers
            </a>
            <a href="dashboard.php?tab=notes" id="my_questions">
              <i class="fa fa-sticky-note-o mr-2"></i> <span class="hide-lg">My Notes</span
            </a>
            <?php if($user->get_usertype() == "student"){ ?>
            <a href="dashboard.php?tab=assignments" id="my_assignments">
              <i class="fa fa-refresh mr-2"></i> <span class="hide-lg">Assignments</span>
            </a>
            <a href="dashboard.php?tab=lectures" id="my_lectures">
              <i class="fa fa-list mr-2"></i> <span class="hide-lg">My Lectures</span>
            </a>
            <a href="dashboard.php?tab=chat">
              <i class="fa fa-comment mr-2"></i> <span class="hide-lg">Open Chat</span>
            </a>
            <?php }else{ ?>
            <a href="dashboard.php?tab=newassignment" id="new_assignment">
              <i class="fa fa-plus mr-2"></i> <span class="hide-lg">New Assignment</span>
            </a>
            <?php } ?>
            <a href="dashboard.php?tab=share" id="share">
              <i class="fa fa-share-alt mr-2"></i> <span class="hide-lg">Share material</span>
            </a>
        </div>
      </div>
</div>
<div class="col-10 col-sm-10"><br>

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
?>
