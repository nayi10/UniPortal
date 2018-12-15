<?php
include_once 'Classes/Connection.php';

function is_okay($var){

    if(isset($var) && !empty($var) && $var !== ""){
        return TRUE;
    }

    return FALSE;
}

function is_post($var){
    if(isset($_POST[$var]) && !empty($_POST[$var])){
        return TRUE;
    }
    return FALSE;
}

function is_array_okay(...$vars){
    foreach ($vars as $var) {
        if(isset($var) && !empty($var) && $var !== ""){
            return TRUE;
        }

        return FALSE;
    }
}

function is_empty($var){
    if(isset($var) && empty($var)){
        return TRUE;
    }

    return FALSE;
}

function execute_query($query){

    $connection = new Connection();
    $conn = $connection->connect();
    $result = $conn->query($query);

    if(!$result){

        return FALSE;

    }

    return $result;

}

function fetch_item($result){

    return $result->fetch_object();

}

function show_num_rows($result_query){

    $rows = mysqli_num_rows($result_query);

    return $rows;
}

function show_affected_rows($conn){

    $connection = new Connection();
    $conn = $connection->connect();
    $affected = $conn->affected_rows;

    if($affected == 1){
        return $affected;
    }

    return FALSE;

}

function delete_item($tbl_name, $id){
    $connection = new Connection();
    $conn = $connection->connect();
    $sql = execute_query("DELETE * FROM $tbl_name WHERE id = $id");

    if(show_affected_rows($sql)){
        return $sql->id;
    }else{
        $error = $conn->error;
        return $error;
    }

}

function is_session($session_var){

    if(isset($_SESSION[$session_var]) && !empty($_SESSION[$session_var])){

        return TRUE;
    }

    return FALSE;

}

function session_destruct(){

    $_SESSION = array();

    if (session_id() != "" || isset($_COOKIE[session_name()])){

        setcookie(session_name(), '', time()-2592000, 'sessions');

        session_destroy();
    }

}

function clean_data($req_var){

    $data = isset($_REQUEST[$req_var]) ? $_REQUEST[$req_var] : '';

    return strip_tags(htmlspecialchars($data));
}

function delete($cat, $id){
    $connection = new Connection();
    $conn = $connection->connect();
    $query = "DELETE from $cat where id = $id";

    if($conn->query($query)){
    $affected = $conn->affected_rows;
    return $affected;
    }
    return FALSE;

}

function select_all($tbl_name, $order_by=null,$limit=null,$offset=NULL){
    $connection = new Connection();
    $conn = $connection->connect();
    $query = "SELECT * FROM $tbl_name";
    if(!is_null($order_by)){
        $query .= "  ORDER BY $order_by";
    }

    if(!is_null($limit)){
        $query .= " LIMIT $limit";
    }

    if(!is_null($offset)){
        $query .= " OFFSET $offset";
    }
    $result = $conn->query($query);

    if(($result->num_rows) > 0){

        $res = $conn->get_result();

        return $res;

    }

}

function select_by_id($tbl_name,$id, $order=null){
    $connection = new Connection();
    $conn = $connection->connect();

    if(!is_null($order)){
        $order_by = $order;
    }  else {
        $order_by = '';
    }
    $result = $conn->query("SELECT * FROM $tbl_name WHERE id = $id "
            . "order by id $order_by");

    if(($result->num_rows) > 0){

        $res = $conn->get_result();

        return $res;

    }

}

function get_connection_handle(){
    $con = new Connection();
    $conn = $con->connect();
    if($conn){
        return $conn;
    }
}

function select_field($tbl_name,$item,$order=null){
    $connection = new Connection();
    $conn = $connection->connect();
    if(!is_null($order)){
        $order_by = $order;
    }  else {
        $order_by = '';
    }

    $result = $conn->query("SELECT $item from $tbl_name order by id $order_by");
    echo $conn->error;
    if(($result->num_rows) > 0){

        return $result;

    }
    return FALSE;

}


function grow_by_two($el) {
    $c = "<span style='font-size:2em;'>$el</span>";
    return $el;
}

function grow_by_one_half($el) {
    $c = "<span style='font-size:1.5em;'>$el</span>";
    return $el;
}

function mk_link_from_tags($str){

    if(str_word_count($str) > 1){

        $new_str = implode("-",explode(" ",  trim($str)));
        return $new_str;
    }else{
        return trim($str);
    }
}

function stringify($str){

    if(str_word_count($str) > 1){

        $new_str = implode("-",explode(" ",  trim($str)));
        return $new_str;
    }else{
        return trim($str);
    }
}
