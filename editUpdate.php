<?php
include("functions.php");
$conn = get_connection_handle();
if(isset($_REQUEST['venue']) && isset($_REQUEST['id'])){
    $error = array();
    if(is_post("venue")){
        $venue = strip_tags($_REQUEST['venue']);
    }else{
        $error[] = "Venue is required!<br>";
    }

    if(is_post("end")){
        $end = strip_tags($_REQUEST['end']);
    }else{
        $error[] = "Ending time is required!<br>";
    }

    if(is_post("start")){
        $start = strip_tags($_REQUEST['start']);
    }else{
        $error[] = "Starting time is required!<br>";
    }
    if(is_post("day")){
        $day = strip_tags($_REQUEST['day']);
    }else{
        $error[] = "Lesson day is required!<br>";
    }
    if(is_post("id")){
        $id = $_REQUEST['id'];
    }
    if(!$error){
        $stmt = $conn->prepare("update lessons set venue = ?, day = ?,
        start = ?, end = ? where id = ?");
        $stmt->bind_param("ssssi", $venue, $day, $start,$end, $id);
        $stmt->execute();
        if($conn->affected_rows == 1){
            echo "Update successful";
        }else{
            echo "Update not successful";
        }
    }else{
        foreach($error as $err){
            echo $err;
        }
    }
}elseif(isset($_REQUEST['name']) && isset($_REQUEST['hostel_id'])){
    $error = array();
    if(is_post("name")){
        $name = strip_tags($_REQUEST['name']);
    }else{
        $error[] = "Hostel name is required!<br>";
    }

    if(is_post("contact")){
        $contact = strip_tags($_REQUEST['contact']);
    }else{
        $error[] = "Owner contact is required!<br>";
    }

    if(is_post("campus")){
        $campus = strip_tags($_REQUEST['campus']);
    }else{
        $error[] = "Campus is required!<br>";
    }
    if(is_post("rate")){
        $rate = strip_tags($_REQUEST['rate']);
    }else{
        $error[] = "Hostel rate is required!<br>";
    }
    if(is_post("distance")){
        $distance = strip_tags($_REQUEST['distance']);
    }else{
        $error[] = "Distance to campus is required!<br>";
    }
    if(is_post("facilities")){
        $facilities = strip_tags($_REQUEST['facilities']);
    }else{
        $error[] = "Hostel facilities cannot be blank!<br>";
    }
    if(is_post("hostel_id")){
        $id = $_REQUEST['hostel_id'];
    }
    if(!$error){
        $stmt = $conn->prepare("update hostels set name = ?, rate = ?,
        campus = ?, contact = ?, distance = ?, facilities = ? where id = ?");
        $stmt->bind_param("ssssssi", $name, $rate, $campus,$contact, 
        $distance, $facilities, $id);
        $stmt->execute();
        if($conn->affected_rows == 1){
            echo "Update successful";
        }else{
            echo "Update not successful";
        }
    }else{
        foreach($error as $err){
            echo $err;
        }
    }
}