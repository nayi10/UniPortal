<?php

$dir = pathinfo($_SERVER['PHP_SELF']);
$directory = $dir['dirname'];

if($directory == "/UniPortal"){

$scripts = <<<MPW

<script src="js/jquery.js"></script>

<script src="js/jquery.form.js"></script>

<script src="bootstrap/js/bootstrap.bundle.js"></script>

<script type="text/javascript" src="trumbowyg/trumbowyg.min.js"></script>
<script src="trumbowyg/trumbowyg.js"></script>

<script src="js/main.js"></script>

MPW;

} elseif($directory == '/UniPortal/blog'){

$scripts = <<<MPW

<script src="./../js/jquery.js"></script>

<script src="./../js/jquery.form.js"></script>

<script src="./../bootstrap/js/bootstrap.js"></script>

<script src="./../bootstrap/js/bootstrap.js"></script>

<script src="./../js/jquery.form.js"></script>
<script type="text/javascript" src="./../trumbowyg/trumbowyg.min.js"></script>
<script src="./../trumbowyg/trumbowyg.js"></script>

<script src="./../js/main.js"></script>


MPW;

}else{

$scripts = <<<MPW

<script src="./../../../js/jquery.js"></script>

<script src="./../../../bootstrap/js/bootstrap.js"></script>

<script src="./../../../bootstrap/js/bootstrap.js"></script>

<script src="./../../js/jquery.form.js"></script>

<script src="./../../../js/jquery.form.js"></script>
<script type="text/javascript" src="./../../../trumbowyg/trumbowyg.min.js"></script>
<script type="text/javascript" src="./../../../trumbowyg/trumbowyg.js"></script>

<script src="./../../../js/main.js"></script>

MPW;

}

echo $scripts;
?>
