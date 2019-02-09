<?php
if(isset($_FILES['files'])){
    $yr = date("Y");
    $targe_path = "images/events/".$yr."/";
    $temp_file = $_FILES['files']['tmp_name'];
    if(!file_exists($targe_path)){
        mkdir($targe_path, 0777, true);
    }    
    $title = strtolower($_REQUEST['title']);
    if(exif_imagetype($_FILES['files']['tmp_name']) == IMAGETYPE_GIF){
        $filename = implode("-", explode(" ", $title)).".gif";
    }elseif(exif_imagetype($_FILES['files']['tmp_name']) == IMAGETYPE_PNG){
        $filename = implode("-", explode(" ", $title)).".png";
    }elseif(exif_imagetype($_FILES['files']['tmp_name']) == IMAGETYPE_JPEG){
        $filename = implode("-", explode(" ", $title)).".jpg";
    }
    
    $target_file = $targe_path.$filename;
    if(move_uploaded_file($temp_file, $target_file)){
        echo "File has been uploaded";
    }else{
        echo("File upload not successful");
    }
}elseif(isset($_FILES['file']) && isset($_REQUEST['hostel-name'])){
    $yr = date("Y");
    $targe_path = "images/hostels/".$yr."/";
    $temp_file = $_FILES['file']['tmp_name'];
    if(!file_exists($targe_path)){
        mkdir($targe_path, 0777, true);
    }    
    $title = strtolower($_REQUEST['hostel-name']);
    if(exif_imagetype($_FILES['file']['tmp_name']) == IMAGETYPE_GIF){
        $filename = md5($title).".gif";
    }elseif(exif_imagetype($_FILES['file']['tmp_name']) == IMAGETYPE_PNG){
        $filename = md5($title).".png";
    }elseif(exif_imagetype($_FILES['file']['tmp_name']) == IMAGETYPE_JPEG){
        $filename = md5($title).".jpg";
    }
    
    $target_file = $targe_path.$filename;
    if(move_uploaded_file($temp_file, $target_file)){
        echo "File has been uploaded";
    }else{
        echo("File upload not successful");
    }
}