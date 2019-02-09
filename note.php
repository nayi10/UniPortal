<?php
include_once 'header.php';
if(is_session("user_id")){
    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $id = $_SESSION['id'];
}else{
    header("/UniPortal");
}

if(isset($_POST["submit"])){
    $conn = get_connection_handle();
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

    if(is_session("username")){
        $owner_id = $_SESSION['username'];
    }
    $link = md5($title);

    if(!$errors){
        $stmt = $conn->prepare("insert into notes(title,note,owner_id,"
                . "created_on,status,link_id) values(?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $title,$note,$owner_id,$save_day,$status,$link);
        $stmt->execute();
        if($conn->affected_rows == 1){
            $msg = "Saved successfully";
            echo $msg;
        }else {
            $error = "Could not save data";
            echo $error;
        }

    }else {
        foreach($errors as $error){
            echo $error."<br>";
        }
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <div id="hel"></div>
        <div class="col-md-6 mx-auto">
            <div class="mt-4">
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
                    <input type="text" class="input-text" placeholder="Title" name="title" id="title">
                    <div id="message"></div>
                    <label for="status">
                        <input type="checkbox" value="Shareable" name="status" id="status"> Shareable
                    </label>
                    <input class="hide" name='note' id="note-content">
                    <button name="submit" class="btn btn-info btn-sm"  id="save"
                    style="margin-left:85%;">
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
