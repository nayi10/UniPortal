<?php
include_once("functions.php");
$conn = get_connection_handle();
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
}else{
    $limit = 25;
}
$query = $conn->query("select * from questions order by id DESC LIMIT $limit");
if($query->num_rows > 0){
    echo '
    <div class="card p-4">
    <h1 class="card-title">All questions</h1>
    <table class="table table-bordered table-responsive-md">
        <thead>
            <th>Question</th>
            <th>Asked by</th>
            <th>Tags</th>
            <th>Date</th>
        </thead>
        <tbody>';
    while($row = $query->fetch_object()){
        $list = <<<LOVE
        <tr>
            <td>$row->question</td>
            <td>$row->asked_by</td>
            <td>$row->tags</td>
            <td>$row->added_on</td>
        </tr>
LOVE;
        echo $list;
    }
    echo "</tbody></table></div>";
}