<?php
require_once("../../header.php");
include_once("../../functions.php");
include_once("../../User.php");
$conn = get_connection_handle();
$username = basename(dirname(__FILE__));
$user = new User($username);
$stmt = $conn->query("SELECT * FROM users WHERE username = '$username'");
if($stmt && $stmt->num_rows > 0){
    $num_questions = $user->get_question_count();
    $aupvotes = $conn->query("select sum(votes) as total from votes where type = 'answer' 
    and vote_type = 'upvote' and username = '$username'");
    $arows = $aupvotes->fetch_object();
    $num_answers = $user->get_answer_count();
    $questions = $conn->query("select question from questions where asked_by = '$username'");
    $qupvotes = $conn->query("select sum(votes) as total from votes where type = 'question' 
    and vote_type = 'upvote' and username = '$username'");
    $qrows = $qupvotes->fetch_object();
    $answers = $conn->query("select question from answers where answered_by = '$username'");
    while($row = $stmt->fetch_object()){
        $details = <<<_EFL
    <div class="row">
        <div class="col-md-6 mx-auto">
            <ul class="nav nav-tabs" id="myTab">
                <li class="nav-item">
                    <a class="nav-link active" id="account-tab" data-toggle="tab" 
                    href="#account" role="tab" aria-controls="account">
                        <i class="fa fa-user"></i> Account
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contrib-tab" data-toggle="tab" 
                    href="#contribute" role="tab" aria-controls="contribution">
                        <i class="fa fa-bar-chart"></i> Contribution
                    </a>
                </li>
            </ul>
            <div class="tab-content card p-2" id="myTabContent">
                <div class="tab-pane fade show active" role="tabpanel" id="account">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h1 class="text-center">About $row->firstname $row->lastname</h1>
                        </li>
                        <li class="list-group-item">
                            <strong>Username:</strong> <span class="float-right text-md">$row->username</span>
                        </li>
                        <li class="list-group-item">
                            <strong>First name:</strong> <span class="float-right text-md">$row->firstname</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Last name:</strong> <span class="float-right text-md">$row->lastname</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Lastname:</strong> <span class="float-right text-md">$row->firstname</span>
                        </li>
                        <li class="list-group-item">
                            <strong>User ID:</strong> <span class="float-right text-md">$row->user_id</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Programme:</strong> <span class="float-right text-md">$row->programme</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Department:</strong> <span class="float-right text-md">$row->department</span>
                        </li>
                    </ul>
                </div>
_EFL;
    echo $details;
    }
    echo '
    <div class="tab-pane fade show" role="tabpanel" id="contribute" aria-labelledby="contrib-tab">
        <div class="d-flex list-group pl-3">
            <h3 class="text-md mt-2">Questions</h3>';
    if($questions->num_rows > 0){
        while($rows = $questions->fetch_object()){
            $url = urlencode($rows->question);
            echo '<div class="list-group-item">
                <a href="/UniPortal/questions/?question='.$url.'">'.$rows->question.'</a>
                </div>';
        }
        echo '<div class="list-group-item">
                <span>Question upvotes </span><span class="float-right">'.$qrows->total.'</span>
            </div>';
    }else{
        echo "<p>No questions asked yet</p>";
    }

    echo '</div><hr><div class="d-flex list-group pl-3">
        <h3 class="text-md mt-2">Answers</h3>';
    if($answers->num_rows > 0){
        while($rws = $answers->fetch_object()){
            $url = urlencode($rws->question);
            echo '<div class="list-group-item">
                <a href="/UniPortal/questions/?question='.$url.'">'.$rws->question.'</a>
            </div>';
        }
    
        echo '<div class="list-group-item">
                <span>Answer upvotes  </span><span class="float-right">'.$arows->total.'</span>
            </div>';
    }else{
        echo "<p>User has not answered any questions yet</p>";
    }
    echo "</div>
        </div>
    </div>
</div>";
}else{
    // include_once("../../404.php");
}