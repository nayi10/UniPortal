<?php
include_once("functions.php");
include_once("Answer.php");
$conn = get_connection_handle();
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
}else{
    $limit = 25;
}
$query = $conn->query("select * from answers order by id DESC LIMIT $limit");
if($query->num_rows > 0){
    echo '
    <div class="card p-4">
    <h1 class="card-title">All answers</h1>
    <table class="table table-bordered table-responsive">
        <thead>
            <th>Question</th>
            <th>Answer</th>
            <th>Answered by</th>
            <th>Upvotes</th>
            <th>Downvotes</th>
        </thead>
        <tbody>';
    while($row = $query->fetch_object()){
        $answer = new Answer(null, $row->answer);
        $answer->set_id($row->id);
        $upvotes = $answer->get_upvotes() > 0 ? $answer->get_upvotes(): "0";
        $downvotes = $answer->get_downvotes() > 0? $answer->get_downvotes(): "0";
        $ans = substr($row->answer, 0, 250);
        $list = <<<LOVE
        <tr>
            <td>$row->question</td>
            <td>$ans</td>
            <td>$row->answered_by</td>
            <td>$upvotes</td>
            <td>$downvotes</td>
        </tr>
LOVE;
        echo $list;
    }
    echo "</tbody></table></div>";
}else{
    echo "<h1 class='text-center mt-5'>No answers to display at the moment</h1>";
}