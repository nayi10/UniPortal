<?php
include_once '../header.php';
include_once '../Lesson.php';
if(is_session("user_id")){
    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $id = $_SESSION['id'];
}else{
    header("login");
}
echo "<div class='container mt-3'>";
if(isset($_REQUEST['lesson'])){
    $lesson = strip_tags($_REQUEST['lesson']);
    
}else{
    $lesson = new Lessons();
    $day = date("l");
    $res = $lesson->get_all_lessons(null, $day);

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
            // //date_default_timezone_set("Africa/Accra");
            // $end_time = DateTime::createFromFormat("H:i a", $lesson->get_end());
            // $start_time = DateTime::createFromFormat("H:i a", $lesson->get_start());
            // $d = date("Y-m-d H:i:s");
            // $now = DateTime::createFromFormat("H:i a", $d);
            // if($now > $start_time && $now < $end_time){
            //     $status = "<div class='fa-3x'><i class='fas fa-spinner fa-spin'></i></div>";
            // }elseif($now < $start_time){
            //     $status = "<i class='fa fa-close'></i>";
            // }else{
            //     $status = "<i class='fa fa-spinner fa-2x fa-spin'></i>";
            // }
                      
            echo "
            <tr>
                <td>$row->subject</td>
                <td>$row->course_code</td>
                <td>$row->venue</td>
                <td>$row->start to $row->end</td>";       
        }
        echo("</tr></tbody></table>");
    }else{
        echo "<h1>No lectures for today $day</h1>";
    }
}
?>
</div>