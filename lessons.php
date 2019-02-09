<?php
include_once("functions.php");
$conn = get_connection_handle();
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
}else{
    $limit = 25;
}
$query = $conn->query("select * from lessons LIMIT $limit");
if($query->num_rows > 0){
    echo '
    <div class="card p-4">
    <h1 class="card-title">All lessons</h1>
    <table class="table table-bordered table-responsive-md">
        <thead>
            <th>Subject</th>
            <th>Course code</th>
            <th>Lecturer</th>
            <th>Venue</th>
            <th>Day</th>
            <th>Starts</th>
            <th>Ends</th>
        </thead>
        <tbody>';
    while($row = $query->fetch_object()){
        $list = <<<LOVE
        <tr>
            <td>$row->subject</td>
            <td>$row->course_code</td>
            <td>$row->lecturer</td>
            <td>$row->venue</td>
            <td>$row->day</td>
            <td>$row->start</td>
            <td>$row->end</td>
        </tr>
LOVE;
        echo $list;
    }
    echo "</tbody></table></div>";
}