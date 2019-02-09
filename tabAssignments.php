<?php
if(!session_id()) session_start();
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['email'];
    $id = $_SESSION['id'];
}else{
    header("UniPortal/");
}

$user = new User($username);
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = strip_tags($_GET['id']);
    $rows = $user->get_assignment($id);
    if($rows){
        $assign = <<<LT
        <div class="container">
            <div class='row'>
                <div class='col-md-8 mx-auto'>
                    <ul class="list-group list-group-flush text-sm">
                        <li class="list-group-item">
                            <b>Question</b> - $rows->question
                        </li>
                        <li class="list-group-item">
                        <b>Lecturer</b> - <span class="mx-3">$rows->lecturer</span>
                        </li>
                        <li class="list-group-item">
                            <b>Date Interval</b> - 
                            <span class="mx-3 bd-highlight">
                                $rows->given_date - $rows->submit_date
                            </span>
                        </li>
                        <li class="list-group-item">
                            <b>Submission Method</b> - 
                            <span class="mx-3">
                                $rows->submission_method
                            </span>
                        </li>
                        <li class="list-group-item">
                            <b>Submission Format</b> - 
                            <span class="mx-3">
                                $rows->submission_format
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8 mx-auto my-4">
LT;
        if(!$user->has_submitted($id)){
            $assign .= <<<TL
                    <h2 class="text-center replaceable">Upload your solution below</h2>
                    <div id="msg" class="alert alert-success hide"></div>
                    <div id="error" class="alert alert-danger hide"></div>
                    <form action="process.php" id="assign-upload" class="dropzone">
                        <input type="hidden" name="username" value="$username" id="username">
                        <input type="hidden" name="tutor" value="$rows->lecturer" id="tutor">
                        <input id='submit-status' type="hidden">
                        <input type="hidden" name="course-code" value="$rows->course" id="code">
                        <input type="hidden" name="assign_id" value="$rows->id" id="assign_id">
                    </form> 
TL;
        }else{
            $assign .= <<<K
            <h5 class="text-center">You have submitted your solution</h5>
K;
        }
            
    $assign.= <<<LG
                </div>
            </div>
        </div>    
LG;
        echo $assign;
    }

}else{
    $assignments = $user->get_assignments();
    if($assignments && $assignments->num_rows > 0){
        echo "<h1 class='card-title'>Total assignments - $assignments->num_rows</h1>
            <ul class='list-group'>";

        while($rows = $assignments->fetch_object()){
            $url = urlencode($rows->question);
            $today = new DateTime();
            $today->format("Y-m-d");
            $submit_day = new DateTime($rows->submit_date);
            $submit_day->format("Y-m-d");
            $days = $today->diff($submit_day);
            if($submit_day > $today){
                $interval = $days->format('In %a days');
                $attr = "success";
            }elseif($submit_day == $today){
                $interval = "Today";
                $attr = "primary";
            }else{
                $interval = "Passed";
                $attr = "dark";
            }
            $question = substr($rows->question, 0, 70);
            $q = urlencode($rows->question);
            $code = urlencode($rows->course);
            $items = <<<LK
                <li class='list-group-item'>
                    <span class='mr-3 border-right pr-3'>$question...</span>
                    <span class="float-right">
                        <span class='mr-3 border-right pr-3'>$rows->course</span>
                        <span class="badge badge-$attr text-md text-white p-1">$interval</span>
                        <a class='mx-3' href="dashboard.php?tab=assignments&id=$rows->id"> Details 
                        <i class='fa fa-angle-double-right'></i>
                        </a>
                    </span>           
                </li>
LK;
            echo $items;
        }
        echo "</ul>";
    }else{
        echo "<h1 class='card-title'>You have no pending assignments.</h1>";
    }
}