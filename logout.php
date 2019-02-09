<?php
    session_start();
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
       $session_params = session_get_cookie_params();
       setcookie(session_name(), '', time() - 42000,
        $session_params["path"], $session_params["domain"],
        $session_params["secure"], $session_params["httponly"]
       );
    }
    session_destroy();
    echo 'Logged out successfully';
?>