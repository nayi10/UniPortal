<?php
include_once("functions.php");
$conn = get_connection_handle();
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
}else{
    $limit = 25;
}
$query = $conn->query("select comment, username, added_on from 
comments order by id DESC LIMIT $limit");
if($query->num_rows > 0){
    echo '
    <div class="card p-4">
    <h1 class="card-title">Recent comments</h1>
    <table class="table table-bordered table-responsive-md">
        <thead>
            <th>Comment</th>
            <th>User</th>
            <th>Date</th>
        </thead>
        <tbody>';
    while($row = $query->fetch_object()){
        $list = <<<LOVE
        <tr>
            <td>$row->comment</td>
            <td>$row->username</td>
            <td>$row->added_on</td>
        </tr>
LOVE;
        echo $list;
    }
    echo "</tbody></table></div>";
}