<?php
include_once("functions.php");
if(isset($_REQUEST['title']) && isset($_REQUEST['organizer'])){
    include_once("Event.php");
    $event = new NewEvent();
    $error = array();

    if($_REQUEST['id'] !== ""){
        $event->set_id(strip_tags($_REQUEST['id']));
    }
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
        if($event->update()){
            $msg = "Event successfully updated";
            echo $msg;
        }else{
            $msg = "Event couldn't be updated";
            echo $msg;
        }
        
    }else{
        foreach($error as $err){
            echo($err."\n");
        }
    }
}elseif(isset($_REQUEST['code']) && isset($_REQUEST['title'])){
    $errors = array();
    if(is_post("code")){
        $course_code = strip_tags($_REQUEST['code']);
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
    }
    if(is_post("trimester")){
        $trim = strip_tags($_REQUEST['trimester']);
    }
    $id = $_POST['id'];
    if(!$errors){
        $conn = get_connection_handle();
        $stmt = $conn->prepare("update courses set title = ?, course_code = ?, 
        lecturer = ?, department = ?, description = ?, status = ?, academic_year = ?, 
        level = ?, term = ? where id = ?");
        $stmt->bind_param("sssssssiss", $title, $course_code,$lecturer,
        $department, $description, $status, $year, $level, $trim, $id);
        $stmt->execute();
        if($conn->affected_rows == 1){
            echo "Course has been updated";
        }else{
            $msg =  "Course couldn't be updated";
            echo $msg;
        }
    }else{
        foreach($errors as $error){
            echo $error."\n";
        }
    }
}elseif(isset($_REQUEST['userID']) && isset($_REQUEST['username'])){
    $error = array();
    if($_REQUEST['userID'] !== ""){
        $id = $_REQUEST['userID'];
    }else{
        $error[] = "An error occured, try again";
    }
    if(is_post("username")){
        $username = strip_tags($_REQUEST['username']);
    }else{
        $error[] = "Please provide your username";
    }
    if(is_post("email")){
        $email = strip_tags($_REQUEST['email']);
    }else{
        $error[] = "Email is required";
    }
    if(is_post("phone")){
        $phone = strip_tags($_REQUEST['phone']);
    }else{
        $error[] = "Provide a phone number";
    }
    if(is_post("age")){
        $age = $_REQUEST['age'];
    }
    if(is_post("gender")){
        $gender = strip_tags($_REQUEST['gender']);
    }
    if(is_post("hostel")){
        $hostel = strip_tags($_REQUEST['hostel']);
    }
    if(is_post("country")){
        $country = strip_tags($_REQUEST['country']);
    }
    if(is_post("town")){
        $town = strip_tags($_REQUEST['town']);
    }
    if(is_post("region")){
        $region = strip_tags($_REQUEST['region']);
    }

    if(!$error){
        $conn = get_connection_handle();
        $stmt = $conn->prepare("update users set username = ?, email = ?, phone = ?,
        age = ?, gender = ?, hostel = ?, nationality = ?, town = ?, region = ? where id = ?");
        echo $conn->error;
        $stmt->bind_param("sssisssssi", $username,$email,$phone,$age, $gender,$hostel,$country,
        $town, $region, $id);
        $stmt->execute();
        if($conn->affected_rows == 1){
            echo "Update successful";
        }else{
            echo "Couldn't update your details";
        }
    }else{
        foreach($error as $err){
            echo $err.'<br>';
        }
    }
}