<?php
include_once("Question.php");
include_once("Answer.php");
if(!session_id()) session_start();
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $id = $_SESSION['id'];
}else{
    header("UniPortal/");
}

$user = new User($username);
$ans = $user->get_answers();
if($ans && $ans->num_rows > 0){
    echo "<h1 class='card-title'>$ans->num_rows Answer(s)</h1>
        <ul class='list-group'>";

    while($rows = $ans->fetch_object()){
        $url = urlencode($rows->question);
        $answer = new Answer($rows->question);
        $answer->set_id($rows->id);
        $upvotes = $answer->get_upvotes() > 0 ? $answer->get_upvotes(): 0;
        $downvotes = $answer->get_downvotes() > 0 ? $answer->get_upvotes(): 0;
        echo "<li class='list-group-item'>
                <a href='questions/?question=$url#$rows->id'>
                    $rows->question
                </a>
                <span class='float-right'>
                    <span class='badge badge-success p-2 text-md text-white' title='$upvotes upvotes'>
                        $upvotes <i class='fa fa-thumbs-up'></i>
                    </span>
                    <span class='badge badge-danger p-2 text-md text-white' title='$downvotes downvotes'>
                        $downvotes <i class='fa fa-thumbs-down'></i>
                    </span>
                </span>
                
            </li>";
    }
    echo "</ul>";
}else{
    echo "<h1 class='card-title'>You have not answered any questions.</h1>";
}