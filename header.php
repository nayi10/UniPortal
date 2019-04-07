<?php
//Checks whether there exists a user session
if(!session_id())
  session_start();//If no session, start one

  //Folder in which this file resides. Donno why
$directory = basename(dirname($_SERVER['PHP_SELF']));

require_once('functions.php');
include_once("User.php");

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

<nav class="navbar fixed-top navbar-expand-sm">

  <a class="navbar-brand mr-5" href="/UniPortal">UniPortal</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-toggle"
          aria-controls="navbar-toggle" aria-label="Toggle navigation">

    <span class="fa fa-bars text-white"></span>

  </button>

  <div class="collapse navbar-collapse flex-grow-0" id="navbar-toggle">

    <ul class="navbar-nav ml-auto" id="main-menu">
        <!-- <li class="nav-item">
            <input type="search" name="search" placeholder="Search content" class="nav-form-input">
        </li> -->
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
            if(isset($_SESSION['username'])){
                $username = $_SESSION['username'];
                $user = new User($username);//New user object
                if($user->get_profile_image()){
                    //Has profile image? Display it beside their name on the navbar
                    $img = $user->get_profile_image();
                    $link = "<a class='nav-link dropdown-toggle' href='#' id='dropdown' data-toggle='dropdown'>
                        <img src='$img' class='img-circle'/>
                    </a>";
                }else{
                    $link = '<a class="nav-link dropdown-toggle" href="#" id="dropdown" data-toggle="dropdown">
                        <i class="fa fa-user"></i> '.$username.'
                    </a>';
                }
                //User type[admin, normal], shows dropdown items depending on this
                $usrType = $_SESSION['user_type'] == "Normal"? 
                '<li>
                    <a class="dropdown-item" href="/UniPortal/dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a class="dropdown-item" href="/UniPortal/dashboard.php?tab=myaccount">My Account</a>
                </li>':
                '<li>
                    <a class="dropdown-item" href="/UniPortal/admin.php">Dashboard</a>
                </li>';

                $tofl = <<<TOFL
                $link
                <ul class="dropdown-menu dropdown-menu-right">
                    $usrType
                    <li>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </li>
                </ul>
TOFL;
                echo $tofl;
            } else {
                    $username = "";
                    echo '<a href="/UniPortal/login.php" class="nav-link">Login</a>';
                }
            ?>
        </li>

        </ul>
    </div>
</nav>
<!-- Question form in the form of a modal window-->
<div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="newModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="newModal">Ask a new question</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="alert hide mt-3"></div>
              <form id="questionForm">
                  <div class="modal-body">
                      <label for="question">Question</label>
                      <input type="text" name="question" id="question-input" class="form-control">
                      <div id="matched-list" class="hide"></div>
                      <div id="description"></div>
                      <!--input type="hidden" name="desc" id="desc" -->
                      <label for="tags" class="mr-2 mt-1">Tags</label>
                      <input type="text" class="form-control" id="tags">
                      <input type="hidden" name='tags' id="tag-cont">
                      <input type="hidden" name='username' id="username" value="<?php echo $username;?>">
                      <div class="mt-2" id="tag-container"></div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" id="btnAdd" class="btn btn-primary">Ask question</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
    <!-- Floating action button - used to ask questions -->
    <button class="btn-circle" id="btn-circle" data-toggle="modal" data-target="#popup">
        <i class="fa fa-question"></i>
    </button>
<?php include_once 'scripts.php'; ?>