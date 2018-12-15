<?php
include_once 'header.php';

if(isset($_POST["submit"])){
    $con = new Connection();
    $conn = $con->connect();

    $errors = array();

     if(is_post("title")){
        $title = clean_data($_POST['title']);
    }else{
        $errors[] = "Please enter title";
    }

    if(is_post("note")){
        $note = $_POST['note'];
    }  else {
        $errors[] = "Please note cannot be blank";
    }


    if(is_post("status")){
        $status = $_POST['status'];
    }

    $save_day = date(DATE_RSS);

    if(is_session("student_id")){
        $owner_id = $_SESSION['student_id'];
    }

    $result = $conn->query("SELECT id from notes order by id DESC");

    $id = fetch_item($result);

    if($id){
        $link = "http://localhost/UniPortal/$owner_id/notes.php?id=$id";
    }else{
        $id = 1;
        $link = "http://localhost/UniPortal/$owner_id/notes.php?id=$id";
    }

    if(!$errors){
        $stmt = $conn->prepare("insert into notes(title,note,owner_id,"
                . "created_on,status,link) values(?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $title,$note,$owner_id,$save_day,$status,$link);
        $stmt->execute();
        if($conn->affected_rows == 1){
            $msg = "Saved successfully";
            if(!session_id())
                session_start ();
            $_SESSION['msg'] = $msg;
        }else {
            $error = "Could not save data";
            if(!session_id())
            session_start ();
        $_SESSION['error'] = $error;
        }

    }else {

        if(!session_id())
            session_start ();
        $_SESSION['errors'] = $errors;

    }
}

?>

<div class="container-fluid">
    <div class="row">
        <div id="hel"></div>
        <div class="col-md-6 mx-auto">
            <div class="card-0 mt-4">
                <?php if(is_session("errors")){
                    echo "<div class='alert alert-danger alert-dismissible'>";
                    foreach($_SESSION['errors'] as $error){
                        echo "<span>$error</span><br>";
                    }
                    echo '<a class="close fa fa-remove" data-dismiss="alert"></a></div>';
                }
                ?>
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                    <label for="title" id="lbl-title"></label>
                    <input type="text" class="b-down inline" placeholder="Title" name="title" id="title">
                    <br><br>
                    <div id="message"></div>
                    <label for="status">
                        <input type="checkbox" value="Shareable" name="status" id="status">
                        Shareable
                    </label>
                    <input class="hide" name='note' id="note-content">
                    <button name="submit" class="btn btn-info"  id="save"style="margin-left:85%;margin-top:0;">
                        <i class="fa fa-save"></i>
                        Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#toggler").hide();
    $("#message").on('input', function(){
        $("#note-content").val($("#message").html())
    })

</script>
