<?php
include_once("functions.php");

if(isset($_POST['note'])){
    $conn = get_connection_handle();
    $errors = array();
     if(is_post("title")){
        $title = strip_tags($_POST['title']);
    }else{
        $errors[] = "Please enter title";
    }
  
    if(is_post("note")){
        $note = $_POST['note'];
    }  else {
        $errors[] = "Please note cannot be blank";
    }
  
    if(is_post("status")){
        $status = $_POST['status'];
    }else{
        $status = "private";
    }
    if(is_post("username")){
      $username = $_POST['username'];
    }

    if(isset($_POST['title']) && isset($_POST['username'])){
        $id = md5($_POST['title']);
        $link = "http://localhost/UniPortal/$username/notes.php?id=$id";
    }
    $day = new DateTime();
    $save_day = $day->format("Y-m-d h:i:sa");
    if(!$errors){
        $stmt = $conn->prepare("insert into notes(title,note,owner, added_on,
        status,link) values(?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $title,$note,$username,$save_day,$status,$link);
        $stmt->execute();
        if($conn->affected_rows == 1){
            echo "Note has been saved successfully";
        }else{
           echo "Could not save data".$conn->error;
        }
  
    }else {
        foreach($errors as $error){
          echo($error."<br>");
        }
    }
}elseif(isset($_POST['note-title']) && isset($_POST['note-id'])){
    $title = strip_tags($_POST['note-title']);
    $id = $_POST['note-id'];
    $note = $_POST['content'];
    $status = $_POST['status'];
    if($id !== "" && $note !== "" && $title !== ""){
        $conn = get_connection_handle();
        $stmt = $conn->prepare("update notes set title = ?, note = ?, status = ? where id = ?");
        $stmt->bind_param("sssi", $title,$note,$status,$id);
        $stmt->execute();
        if($conn->affected_rows == 1){
            echo("Note has been updated");
        }else{
            echo("Note couldn't be updated".$conn->error);
        }
    }
}elseif(isset($_REQUEST['item_id'])){
    $id = $_REQUEST['item_id'];
    $conn = get_connection_handle();
    $stmt = $conn->query("delete from notes where id = $id");
    if($conn->affected_rows == 1){
        echo("Note has been deleted");
    }else{
        echo("Note couldn't be deleted".$conn->error);
    }
}elseif(isset($_REQUEST['answer']) && isset($_REQUEST['question'])){
    include("Answer.php");
    $answer = $_REQUEST['answer'];
    $question = strip_tags($_REQUEST['question']);
    $daye = $_REQUEST['date'];
    
    if($daye == ""){
        $daye = date("Y-m-d h:i:sa");
    }
    $username = strip_tags($_REQUEST['username']);
    $ans = new Answer($question, $answer);
    $ans->set_question($question);
    $ans->set_answer($answer);
    if($answer == ""){
        echo "Answer cannot be blank";
    }else{
        if($ans->add_answer($username, $daye)){
            echo "Your answer has been submitted";
        }else{
            echo("Your answer could not be added. Try again");
        }
    }
    
}elseif(isset($_REQUEST['title']) && isset($_REQUEST['organizer'])){
    include_once("Event.php");
    $event = new NewEvent();
    $error = array();

    if($_REQUEST['title'] !== ""){
        $event->set_title(strip_tags($_REQUEST['title']));
    }else{
        $error[] = "Event title is required<br>";
    }

    if($_REQUEST['organizer'] !== ""){
        $event->set_organizer(strip_tags($_REQUEST['organizer']));
    }else{
        $error[] = "Event organizer is required<br>";
    }
    if($_REQUEST['location'] !== ""){
        $event->set_location(strip_tags($_REQUEST['location']));
    }else{
        $error[] = "Event location is required<br>";
    }
    if($_REQUEST['phone'] !== ""){
        $event->set_contact(strip_tags($_REQUEST['phone']));
    }else{
        $error[] = "Organizer contact is required<br>";
    }
    if($_REQUEST['description'] !== ""){
        $event->set_description(strip_tags($_REQUEST['description']));
    }else{
        $error[] = "Please describe the event<br>";
    }
    if($_REQUEST['type'] !== ""){
        $event->set_type(strip_tags($_REQUEST['type']));
    }else{
        $error[] = "Event type is required<br>";
    }
    if($_REQUEST['start_date'] !== ""){
        $s = new DateTime(strip_tags($_REQUEST['start_date']));
        $start = $s->format("Y-m-d");
        $event->set_start_date($start);
    }else{
        $error[] = "Please start date is required<br>";
    }
    if($_REQUEST['end_date'] !== ""){
        $d = new DateTime(strip_tags($_REQUEST['end_date']));
        $end = $d->format("Y-m-d");
        $event->set_end_date($end);
    }else{
        $error[] = "Event end date is required<br>";
    }
    if($_REQUEST['time'] !== ""){
        $event->set_time(strip_tags($_REQUEST['time']));
    }else{
        $error[] = "Event time is required<br>";
    }
    $misc = strip_tags($_REQUEST['misc']);
    $event->set_misc($misc);
    $today = new DateTime();
    $added = $today->format("Y-m-d H:i:s");
    $event->set_added_on($added);

    if(!$error){
        if($event->add()){
            $msg = "Event successfully added";
            $data = array("message" => $msg,"title" => $_REQUEST['title']);
            echo json_encode($data);
        }else{
            $msg = "Event couldn't be added";
            $data = array("message" => $msg, "title" => $_REQUEST['title']);
            echo json_encode($data);
        }
        
    }else{
        foreach($error as $err){
            echo($err."\n");
        }
    }
}elseif(isset($_REQUEST['course_code']) && isset($_REQUEST['title'])){
    $errors = array();
    if(is_post("course_code")){
        $course_code = strip_tags($_REQUEST['course_code']);
    }else{
        $errors[] = "Course code is required<br>";
    }
    if(is_post("title")){
        $title = strip_tags($_REQUEST['title']);
    }else{
        $errors[] = "Title is required<br>";
    }
    if(is_post("lecturer")){
        $lecturer = strip_tags($_REQUEST['lecturer']);
    }else{
        $errors[] = "Please enter name of lecturer<br>";
    }
    if(is_post("department")){
        $department = strip_tags($_REQUEST['department']);
    }else{
        $errors[] = "Course department is required<br>";
    }
    if(is_post("description")){
        $description = strip_tags($_REQUEST['description']);
    }else{
        $errors[] = "Provide course description<br>";
    }
    if(is_post("status")){
        $status = strip_tags($_REQUEST['status']);
    }else{
        $errors[] = "Please indicate course status<br>";
    }

    if(is_post("academic_year")){
        $year = strip_tags($_REQUEST['academic_year']);
    }else{
        $errors[] = "Add academic year<br>";
    }
    if(is_post("level")){
        $level = strip_tags($_REQUEST['level']);
    }else{
        $errors[] = "Please select level";
    }
    if(is_post("trimester")){
        $trim = strip_tags($_REQUEST['trimester']);
    }
    if(!$errors){
        $conn = get_connection_handle();
        $d = date("Y-m-d h:i:sa");
        $stmt = $conn->prepare("insert into courses(title,course_code,lecturer,
        department,description,status,academic_year,level,term,added_on) 
        values(?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssssiss", $title, $course_code,$lecturer,
        $department, $description, $status, $year, $level, $trim, $d);
        $stmt->execute();
        if($conn->affected_rows == 1){
            echo "Course has been added.";
        }else{
            $msg =  "Course couldn't be added";
            echo $msg;
        }
    }else{
        foreach($errors as $error){
            echo $error."\n";
        }
    }
}elseif(isset($_REQUEST['hostel-name'])){
    include("Hostel.php");
    $hostel = new Hostel();
    $errors = array();
    if(is_post("hostel-name")){
        $name = strip_tags($_REQUEST['hostel-name']);
        $hostel->set_name($name);
    }else{
        $errors[] = "Hostel name is required<br>";
    }
    if(is_post("campus")){
        $campus = strip_tags($_REQUEST['campus']);
        $hostel->set_campus($campus);
    }else{
        $errors[] = "Campus is required<br>";
    }
    if(is_post("phone")){
        $phone = strip_tags($_REQUEST['phone']);
        $hostel->set_contact($phone);
    }else{
        $errors[] = "Please enter phone number<br>";
    }
    if(is_post("distance")){
        $distance = strip_tags($_REQUEST['distance']);
        $hostel->set_distance($distance);
    }else{
        $errors[] = "Hostel distance from campus is required<br>";
    }
    if(is_post("description")){
        $description = strip_tags($_REQUEST['description']);
        $hostel->set_description($description);
    }else{
        $errors[] = "Provide a description<br>";
    }
    if(is_post("rate")){
        $rate = strip_tags($_REQUEST['rate']);
        $hostel->set_rate($rate);
    }else{
        $errors[] = "Please provide rent price<br>";
    }
    $facilities = array();
    if(is_post("fa-toilet")){
        $facilities[] = strip_tags($_REQUEST['fa-toilet']);
    }
    if(is_post("fa-electricity")){
        $facilities[] = strip_tags($_REQUEST['fa-electricity']);
    }
    if(is_post("fa-washroom")){
        $facilities[] = strip_tags($_REQUEST['fa-washroom']);
    }
    if(is_post("fa-JCR")){
        $facilities[] = strip_tags($_REQUEST['fa-JCR']);
    }
    if(is_post("fa-tv")){
        $facilities[] = strip_tags($_REQUEST['fa-tv']);
    }

    $facility = implode(",", $facilities);
    $hostel->set_facilities($facility);
    $hostel->set_date_added(date("Y-m-d h:i:sa"));
    if(!$errors){
        if($hostel->save()){
            $msg =  array("message" => "Hostel has been added", "name" => $name);
            echo json_encode($msg);;
        }else{
            $msg =  array("message" => "Hostel couldn't be added", "name" => $name);
            echo json_encode($msg);
        }
    }else{
        foreach($errors as $error){
            echo $error."\n";
        }
    }
}elseif(isset($_REQUEST['lesson-title'])){
    $errors = array();
    if(is_post("course_code")){
        $course_code = strip_tags($_REQUEST['course_code']);
    }else{
        $errors[] = "Course code is required<br>";
    }
    if(is_post("lesson-title")){
        $title = strip_tags($_REQUEST['lesson-title']);
    }else{
        $errors[] = "Title is required<br>";
    }
    if(is_post("lecturer")){
        $lecturer = strip_tags($_REQUEST['lecturer']);
    }else{
        $errors[] = "Please enter name of lecturer<br>";
    }
    if(is_post("venue")){
        $venue = strip_tags($_REQUEST['venue']);
    }else{
        $errors[] = "Venue is required<br>";
    }

    if(is_post("day")){
        $day = strip_tags($_REQUEST['day']);
    }else{
        $errors[] = "Please indicate day for lesson<br>";
    }

    if(is_post("start")){
        $start = strip_tags($_REQUEST['start']);
    }else{
        $errors[] = "Please enter a start time<br>";
    }
    if(is_post("end")){
        $end = strip_tags($_REQUEST['end']);
    }else{
        $errors[] = "Please enter closing time";
    }

    if(!$errors){
        $conn = get_connection_handle();
        $stmt = $conn->prepare("insert into lessons(subject,course_code,lecturer,
        venue,day,start,end) values(?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssss", $title, $course_code,$lecturer,
        $venue, $day, $start, $end);
        $stmt->execute();
        if($conn->affected_rows == 1){
            echo "Lesson has been added";
        }else{
            $msg =  "Lesson couldn't be added";
            echo $msg;
        }
    }else{
        foreach($errors as $error){
            echo $error."\n";
        }
    }
}