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
}elseif(isset($_FILES['photo']) && isset($_REQUEST['username'])){
    $username = $_REQUEST['username'];
    $targe_path = "users/$username/";
    $temp_file = $_FILES['photo']['tmp_name'];
    if(!file_exists($targe_path)){
        mkdir($targe_path, 0777, true);
    }
    if(exif_imagetype($_FILES['photo']['tmp_name']) == IMAGETYPE_GIF){
        $filename = $username.".gif";
    }elseif(exif_imagetype($_FILES['photo']['tmp_name']) == IMAGETYPE_PNG){
        $filename = $username.".png";
    }elseif(exif_imagetype($_FILES['photo']['tmp_name']) == IMAGETYPE_JPEG){
        $filename = $username.".jpg";
    }
    $target_file = $targe_path.$filename;
    if(move_uploaded_file($temp_file, $target_file)){
        echo "File has been uploaded";
    }else{
        echo("File upload not successful");
    }
}elseif(isset($_FILES['shareFile']) && isset($_REQUEST['sharewith'])){
    $yr = date("Y");
    $share = $_REQUEST['sharewith'];
    $targe_path = "share/$share/$yr/";
    $temp_file = $_FILES['shareFile']['tmp_name'];
    if(!file_exists($targe_path)){
        mkdir($targe_path, 0777, true);
    }
    $timestamp = new DateTime();
    ".png,.jpg,.pdf, .doc, .docx, .odg, .ods, .xlsx,.xls,.ppt, .pptx";
    $time = $timestamp->getTimestamp();
    switch($_FILES['shareFile']['type']){

        case 'image/jpeg': $ext = 'jpg'; break;
        case 'application/ods': $ext = 'ods'; break;
        case 'application/odg': $ext = 'odg'; break;
        case 'application/pdf': $ext = 'pdf'; break;
        case 'application/doc': $ext = 'doc'; break;
        case 'application/docx': $ext = 'docx'; break;
        case 'application/ppt': $ext = 'ppt'; break;
        case 'application/ppptx': $ext = 'pptx'; break;
        case 'application/xlsx': $ext = 'xlsx'; break;
        case 'application/xls': $ext = 'xls'; break;
        case 'image/png': $ext = 'png'; break;
        default: $ext = '';
        break;

    }
    $target_file = $targe_path.$time.".$ext";
    if(move_uploaded_file($temp_file, $target_file)){
        echo "File has been shared to $share";
    }else{
        echo("File was not successfully shared");
    }
}