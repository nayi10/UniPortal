<?php
include_once("functions.php");
$conn = get_connection_handle();
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
}else{
    $limit = 25;
}
$query = $conn->query("select * from courses LIMIT $limit");
if($query->num_rows > 0){
    echo '
    <div class="card p-4">
    <h1 class="card-title">All courses</h1>
    <table class="table table-bordered table-responsive">
        <thead>
            <th>Course code</th>
            <th>Course title</th>
            <th>Lecturer</th>
            <th>Level</th>
            <th>Status/Type</th>
            <th>Academic year</th>
            <th>Department</th>
            <th>Term</th>
        </thead>
        <tbody>';
    while($row = $query->fetch_object()){
        $list = <<<LOVE
        <tr>
            <td>$row->course_code</td>
            <td>$row->title</td>
            <td>$row->lecturer</td>
            <td>$row->level</td>
            <td>$row->status</td>
            <td>$row->academic_year</td>
            <td>$row->department</td>
            <td>$row->term</td>
        </tr>
LOVE;
        echo $list;
    }
    echo "</tbody></table></div>";
}else{
    echo "<h1 class='text-center mt-5'>No registered courses to display</h1>";
}