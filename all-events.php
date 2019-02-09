<?php
include_once("functions.php");
$conn = get_connection_handle();
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
}else{
    $limit = 25;
}
$query = $conn->query("select * from events order by id desc LIMIT $limit");
if($query->num_rows > 0){
    echo '
    <div class="card p-4">
    <h1 class="card-title">All events</h1>
    <table class="table table-bordered table-responsive-md">
        <thead>
            <th>Title</th>
            <th>Organizer</th>
            <th>Contact</th>
            <th>Location</th>
            <th>Event type</th>
            <th>Starts</th>
            <th>Ends</th>
            <th>Time</th>
        </thead>
        <tbody>';
    while($row = $query->fetch_object()){
        $list = <<<LOVE
        <tr>
            <td>$row->title</td>
            <td>$row->organizer</td>
            <td>$row->contact</td>
            <td>$row->location</td>
            <td>$row->type</td>
            <td>$row->start_date</td>
            <td>$row->end_date</td>
            <td>$row->time</td>
        </tr>
LOVE;
        echo $list;
    }
    echo "</tbody></table></div>";
}