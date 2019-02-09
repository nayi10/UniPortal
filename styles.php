<?php
if(!session_id())
    session_start();
$dir = pathinfo($_SERVER['PHP_SELF']);

$directory = $dir['dirname'];
$username = basename($directory);
if($directory == "/UniPortal"){
$styles = <<<MPW
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/dropzone.css" rel="stylesheet">
<link href="trumbowyg/ui/trumbowyg.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
MPW;
}elseif($directory == '/UniPortal/questions' || $directory == "/UniPortal/lessons" || $directory == "/UniPortal/users"){

$styles = <<<MPW
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./../css/font-awesome.css" rel="stylesheet">
    <link href="./../css/dropzone.css" rel="stylesheet">
    <link href="./../trumbowyg/ui/trumbowyg.css" rel="stylesheet">
    <link href="./../css/main.css" rel="stylesheet">
MPW;
}elseif($directory == '/UniPortal/questions/tags' || $directory == "/UniPortal/users/$username"){
$styles = <<<MPW
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/font-awesome.css" rel="stylesheet">
    <link href="../../css/dropzone.css" rel="stylesheet">
    <link href="../../trumbowyg/ui/trumbowyg.css" rel="stylesheet">
    <link href="../../css/main.css" rel="stylesheet">
MPW;
}else{
$styles = <<<MPW
<link href="./../../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="./../../../css/font-awesome.css" rel="stylesheet">
<link href="./../../css/dropzone.css" rel="stylesheet">
<link href="./../../../trumbowyg/ui/trumbowyg.css" rel="stylesheet">
<link href="./../../../css/main.css" rel="stylesheet">
MPW;
}
echo $styles;
