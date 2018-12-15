<?php

$dir = pathinfo($_SERVER['PHP_SELF']);

$directory = $dir['dirname'];

if($directory == "/UniPortal"){
$styles = <<<MPW

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

<link href="css/font-awesome.css" rel="stylesheet">

<link href="css/main.css" rel="stylesheet">
<link href="trumbowyg/ui/trumbowyg.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
MPW;

}elseif($directory == '/UniPortal/questions'){

$styles = <<<MPW
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="./../css/font-awesome.css" rel="stylesheet">

    <link href="./../css/main.css" rel="stylesheet">

    <link href="./../css/style.css" rel="stylesheet">

    <link href="./../trumbowyg/ui/trumbowyg.css" rel="stylesheet">
MPW;

}elseif($directory == '/UniPortal/blog/tags'){

$styles = <<<MPW
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="../../css/font-awesome.css" rel="stylesheet">

    <link href="../../css/main.css" rel="stylesheet">

    <link href="../../css/style.css" rel="stylesheet">

    <link href="./../trumbowyg/ui/trumbowyg.css" rel="stylesheet">
MPW;

}else{

$styles = <<<MPW
<link href="./../../../bootstrap/css/bootstrap.min.css" rel="stylesheet">

<link href="./../../../css/font-awesome.css" rel="stylesheet">

<link href="./../../../css/main.css" rel="stylesheet">

<link href="./../../../trumbowyg/ui/trumbowyg.css" rel="stylesheet">
MPW;

}
echo $styles;
