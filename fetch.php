<?php
include_once("functions.php");
if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
    $conn = get_connection_handle();
    $query = $conn->query("select * from notes where id = $id");
    if($query->num_rows > 0){
        $row = $query->fetch_object();
        $nArray = array("id" => $row->id, "title" => $row->title, 
                        "note" => $row->note, "status" => $row->status);
        echo json_encode($nArray);
    }
}