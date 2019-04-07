<?php

if(isset($_REQUEST['submit-date']) && isset($_REQUEST['course'])){
    $yr = date("Y");
    $targe_path = "assignments/course/".$yr."/";
    if($_FILES){
        $temp_file = $_FILES['assignment']['tmp_name'];
    }else{
        $temp_file = "";
    }
    
    if(!file_exists($targe_path)){
        mkdir($targe_path, 0777, true);
    }
    $date = date("dmYH");
    $title = strtolower($_REQUEST['course'])."-$date";
    $error = array();
    if(isset($_REQUEST['submit-date']) && $_REQUEST['submit-date'] !== ""){
        $submit_day = strip_tags($_REQUEST['submit-date']);
    }else{
        $error[] = "Specify submission date";
    }
    if(isset($_REQUEST['question']) && $_REQUEST['question'] !== ""){
        $q = strip_tags($_REQUEST['question']);
    }elseif((!isset($_FILES['assignment']) || empty($_FILES['assignment'])) && empty($_REQUEST['question'])){
        $error[] = "Please add/upload question(s)";
    }else{
        $q = "Find question(s) in attached file";
    }

    if(isset($_REQUEST['submit-time']) && $_REQUEST['submit-time'] !== ""){
        $submit_time = strip_tags($_REQUEST['submit-time']);
    }else{
        $submit_time = "";
    }
    if(isset($_REQUEST['course']) && $_REQUEST['course'] !== ""){
        $course = strip_tags($_REQUEST['course']);
    }else{
        $error[] = "Course is required";
    }

    if(isset($_REQUEST['format']) && $_REQUEST['format'] !== ""){
        $format = strip_tags($_REQUEST['format']);
    }else{
        $format = "Any";
    }

    if(isset($_REQUEST['submit-method']) && $_REQUEST['submit-method'] !== ""){
        $submit_method = strip_tags($_REQUEST['submit-method']);
    }else{
        $submit_method = "Other";
    }
    if(isset($_REQUEST['lecturer']) && $_REQUEST['lecturer'] !== ""){
        $lecturer = strip_tags($_REQUEST['lecturer']);
    }else{
        $error[] = "An error occured, try again";
    }
    if(!$error){
        include("Assignment.php");

        if($_REQUEST['question'] == "" && !empty($_FILES)){
            if(exif_imagetype($_FILES['assignment']['tmp_name']) == IMAGETYPE_PNG){
                $filename = $title.".png";
            }elseif(exif_imagetype($_FILES['assignment']['tmp_name']) == IMAGETYPE_JPEG){
                $filename = $title.".jpg";
            }else{
                $filename = $title.".pdf";
            }
            
            $target_file = $targe_path.$filename;
            move_uploaded_file($temp_file, $target_file);
        }else{
            echo "Please add all question details before submitting<br>";
        }
       
        $assign = new Assignment();
        $assign->set_course($course);
        $assign->set_question($q);
        $assign->set_submission_format($format);
        $assign->set_submission_method($submit_method);
        $assign->set_lecturer($lecturer);
        $assign->set_submit_date($submit_day);
        $assign->set_submit_time($submit_time);

        if($assign->insert()){
            echo("Assignment has been added");
        }else{
            echo "Assignment not added";
        }
    }else{
        foreach($error as $err){
            echo $err."<br>";
        }
    }
}