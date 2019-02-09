<?php
include_once 'Classes/Connection.php';

function is_okay($var){

    if(isset($var) && !empty($var) && $var !== ""){
        return TRUE;
    }

    return FALSE;
}

function are_null(...$items){
    foreach($items as $item){
        if(is_null($item) || is_empty($item)){
            return true;
        }
    }
    return false;
}

function are_not_null(...$items){
    foreach($items as $item){
        if(!is_null($item) || !is_empty($item)){
            $truthy[] = true;
        }
        if($truthy){
            return true;
        }
    }
    return false;
}

function is_first(...$items){
    if((!is_null($items[0]) || !empty($items[0])) && is_null($items[1])){
        return true;
    }
    return false;
}

function is_second(...$items){
    $first = $items[0];
    $second = $items[1];
    if((!is_null($second) || !empty($second)) && is_null($first)){
        return true;
    }
    return false;
}

function is_third(...$items){
    $first = $items[0];
    $second = $items[1];
    $third = $items[2];
    if((!is_null($third) || !empty($third)) && is_null($first) && is_null($second)){
        return true;
    }
    return false;
}

function create_comment_form($id, $type, $user){
  $form = <<<HEL
    <button class='btn btn-default btn-sm mb-1 mt-2 ml-3' id='comment-btn'>
      Add comment
    </button>
    <form>
      <div class='hide ml-3' id='comment-content'>
        <span class='error'></span>
        <textarea name='comment' id='comm' class='mb-1 form-control'></textarea>
        <input type='hidden' name='type' id='type' value='$type'>
        <input type='hidden' name='type_id' id='type_id' value='$id'>
        <input type='hidden' name='username' id='user' value='$user'>
        <button type='submit' id='sm-btn' class='btn btn-sm' disabled>
          Add
        </button>
      </div>
    </form id='comment-form'>
    <script>
      $('#comment-btn').on('click', function(){
        $(this).hide();
        $('#comment-content').removeClass('hide');
      });

      $('textarea').on('keyup', function(){
        if($(this).val().length > 0){
          $('#sm-btn').removeAttr('disabled');
          $('#sm-btn').addClass('btn-primary');
        }else{
          $('#sm-btn').attr('disabled','disabled');
          $('#sm-btn').removeClass('btn-primary');
        }
      });
      user = $('#user').val();
      typ = $('#type').val();
      id = $('#type_id').val();

      $('#sm-btn').on('click',function(e){
        com = $('#comm').val();
        e.preventDefault();
        if($("textarea").val() !== ''){
          $.ajax({
              method: "POST",
              url: "../process.php",
              data: { type: typ, type_id: id, comment: com, username: user }
            })
            .done(function(msg) {
                if(msg == "Comment has been added"){
                  document.location.reload()
                }
            })
            .fail(function(error){
                console.log("Error occured: " + error)
            });
        }else{
            $(".error").css("color", "red").text("Please enter your comment!");
        }

      })

    </script>
HEL;
return $form;
}

function is_post($var){
    if(isset($_POST[$var]) && !empty($_POST[$var])){
        return TRUE;
    }
    return FALSE;
}

function is_get($var){
    if(isset($_GET[$var]) && !empty($_GET[$var])){
        return strip_tags($_GET[$var]);
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

function add_answer($qtn, $content, $user, $time, $date){
    $conn = get_connection_handle();
    $stmt = $conn->prepare("insert into answers(question,answer,answered_by,
      added_on, added_at) values(?,?,?,?,?)");
    $stmt->bind_param("sssss", $qtn, $content, $user, $time, $date);
    $stmt->execute();
    if($conn->affected_rows == 1){
      return true;
    }
    return false;
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
