<?php
if(!session_id())
    session_start();
if(isset($_SESSION['username']) && $_SESSION['username'] !== ""){
    include_once("header.php");
    $std_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $user = new User($username);
}else{
    header("Location:/UniPortal/");
}

$my_shared_files = "share/munta1/".date("Y");
$my_files = array_diff(scandir($my_shared_files), array('..', '.'));
if(file_exists($my_shared_files)){
    $date = new DateTime();
    echo "<div class='card p-3'>
    <h1 class='text-center'>Files shared with you</h1>
    <table class='table table-bordered'>
        <thead>
            <th>File</th>
            <th>Date</th>
            <th>File type</th>
            <th>Action</th>
        </thead>";
    foreach($my_files as $file){
        $name = explode(".", $file)[0];
        $type = strtoupper(explode(".", $file)[1]);
        $d = $date->setTimestamp($name);
        $shared = $d->format("Y-m-d H:sa");
        echo "<tr>
            <td>$name</td>
            <td>$shared</td>
            <td>$type</td>
            <td><a href='$my_shared_files/$file' download class='btn btn-sm btn-primary'>Download</a></td>
        </tr>";
    }
    echo "</table></div>";
}