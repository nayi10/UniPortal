<?php
if(!session_id())
    session_start();

    if(isset($_REQUEST['chatwith'])){
        $_SESSION['chatwith'] = strip_tags($_REQUEST['chatwith']);
    }