<?php

$dir = pathinfo($_SERVER['PHP_SELF']);
$directory = $dir['dirname'];

if($directory == "/UniPortal"){

$scripts = <<<MPW

<script src="js/jquery.js"></script>

<script src="js/dropzone.js"></script>

<script src="bootstrap/js/bootstrap.bundle.js"></script>

<script type="text/javascript" src="trumbowyg/trumbowyg.min.js"></script>

<script src="js/main.js"></script>

MPW;

} elseif($directory == '/UniPortal/questions' || $directory == "/UniPortal/lessons" || $directory == "/UniPortal/users"){

$scripts = <<<MPW

<script src="./../js/jquery.js"></script>

<script src="./../js/dropzone.js"></script>

<script src="./../bootstrap/js/bootstrap.js"></script>

<script src="./../bootstrap/js/bootstrap.js"></script>

<script src="./../js/dropzone.js"></script>
<script type="text/javascript" src="./../trumbowyg/trumbowyg.min.js"></script>

<script src="./../js/main.js"></script>
MPW;

}elseif($directory == '/UniPortal/questions/tags' || $directory == "/UniPortal/users/$username"){

$scripts = <<<MPW

<script src="../../js/jquery.js"></script>

<script src="../../bootstrap/js/bootstrap.js"></script>

<script src="../../bootstrap/js/bootstrap.js"></script>

<script src="../../js/dropzone.js"></script>

<script src="../../js/dropzone.js"></script>
<script type="text/javascript" src="../../trumbowyg/trumbowyg.min.js"></script>

<script src="../../js/main.js"></script>

MPW;

}else{
    $scripts = <<<MPW

<script src="./../../js/jquery.js"></script>

<script src="./../../bootstrap/js/bootstrap.js"></script>

<script src="./../../bootstrap/js/bootstrap.js"></script>

<script src="./../../js/dropzone.js"></script>

<script src="./../../js/dropzone.js"></script>
<script type="text/javascript" src="./../../trumbowyg/trumbowyg.min.js"></script>

<script src="./../../js/main.js"></script>

MPW;
}

echo $scripts;
?>
