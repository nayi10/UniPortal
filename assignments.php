<?php
include_once("functions.php");
$conn = get_connection_handle();
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
}else{
    $limit = 25;
}
$query = $conn->query("select * from assignments LIMIT $limit");
if($query->num_rows > 0){
    echo '
    <div class="card p-4">
    <h1 class="card-title">Assignments</h1>
    <table class="table table-bordered table-responsive">
        <thead>
            <th>Question</th>
            <th>Course</th>
            <th>Date added</th>
            <th>Date to submit</th>
            <th>Submission time</th>
            <th>Lecturer</th>
            <th>Submission method</th>
            <th>Submission format</th>
        </thead>
        <tbody>';
    while($row = $query->fetch_object()){
        $list = <<<LOVE
        <tr>
            <td>$row->question</td>
            <td>$row->course</td>
            <td>$row->given_date</td>
            <td>$row->submit_date</td>
            <td>$row->submit_time</td>
            <td>$row->lecturer</td>
            <td>$row->submission_method</td>
            <td>$row->submission_format</td>
        </tr>
LOVE;
        echo $list;
    }
    echo "</tbody></table></div>";
}