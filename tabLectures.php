<?php
if(!session_id()) session_start();
if(isset($_SESSION['username'])){
    include_once("Lesson.php");
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $id = $_SESSION['id'];

}else{
    header("UniPortal/");
}
$lesson = new Lessons();
$res = $lesson->get_all_lessons();

if($res && $res->num_rows > 0){
    echo "<h5 class='card-title mx-2'>Today's lectures</h5>
        <table class='table table-striped table-hover table-responsive-sm bg-white'>
        <thead>
            <th>Subject</th>
            <th>Course code</th>
            <th>Venue</th>
            <th>Time</th>
        </thead>
        <tbody>";

    while($row = $res->fetch_object()){

        echo "
        <tr>
            <td>$row->subject</td>
            <td>$row->course_code</td>
            <td>$row->venue</td>
            <td>$row->start to $row->end</td>";       
    }
    echo("</tr></tbody></table>");
}else{
    echo "<h1>No lectures for today</h1>";
}