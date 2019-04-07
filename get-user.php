<?php
if(isset($_REQUEST['name']) && $_REQUEST['name'] !== ""){
    if(!session_id())
        session_start();
    
    $username = $_SESSION['username'];
    $name = strip_tags($_REQUEST['name']);
    include_once("functions.php");
    $conn = get_connection_handle();
    $result = $conn->query("select firstname,lastname,username from users where 
            username <> '$username' and username like '%$name%' or firstname like '%$name%' or 
            lastname like '%$name%' or user_id like '%$name%' limit 10");

    if($result->num_rows > 0){
        echo "<ul class='list-group'>";
        while($row = $result->fetch_object()){
            $real_name = $row->firstname." ".$row->lastname;
            $user = $row->username;
            $usr = <<<USER
            <li class="list-group-item">
                <div class="custom-control custom-radio mr-3">
                    <input type="radio" id="$user" name="user" value="$user" class="custom-control-input user"/>
                    <label class='custom-control-label' for="$user">$real_name</label>
                </div>
            </li>
USER;
            echo $usr;
        }
        echo "</ul>";
    }else{
        echo "No matches were found";
    }
}else{
    header("Location:.");
}
?>
<script>
    $(".user").on("input", function(){
       var val = $(this).val();
       $("#omgUser").val(val)
    });
</script>