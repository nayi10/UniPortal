<?php
include_once("Question.php");
if(!session_id()) session_start();
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $id = $_SESSION['id'];
}else{
    header("UniPortal/");
}

$user = new User($username);
$qtn = $user->get_questions();
if($qtn && $qtn->num_rows > 0){
    echo "<h1 class='card-title'>Questions ($qtn->num_rows)</h1>
        <ul class='list-group'>";

    while($rows = $qtn->fetch_object()){
        $url = urlencode($rows->question);
        $question = new Question($rows->question);
        $count = $question->get_num_answers() > 0 ? $question->get_num_answers(): 0;
        $upvotes = $question->get_upvotes() > 0 ? $question->get_upvotes(): 0;
        $downvotes = $question->get_downvotes() > 0 ? $question->get_downvotes(): 0;
        echo "<li class='list-group-item'>
                <a href='questions/?question=$url'>
                    $rows->question
                </a>
                <span class='float-right'>
                    <span class='badge badge-info p-2 text-md text-white' title='$count answers'>
                    $count <i class='fa fa-reply'></i>
                    </span>
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
    echo "<h1 class='card-title'>You have not asked any questions yet.</h1>";
}