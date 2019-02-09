<?php
include("functions.php");
if(isset($_POST["item-to-delete"])){
    $conn = get_connection_handle();
    $item = strip_tags($_POST['item-to-delete']);
    $table = strtolower($item);
    $search = strip_tags($_POST['lookup']);
    if($item == "Events"){
        if($search !== ""){
            $query = $conn->query("select id, title, organizer from $table where title like '%$search%' 
            or organizer like '%$search%' or type like '%$search%' or location like 
            '%$search%'");
        }else{
            $query = $conn->query("select id, title, organizer from $table limit 100");
        }
        if($query->num_rows > 0){
            $tbl = <<<TBL
            <div class="table-responsive">
                <div class="alert hide"></div>
                <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <th>Title</th>
                    <th>Organizer</th>
                    <th>Action</th>
                </thead>
TBL;
            echo($tbl);
            while($rows = $query->fetch_object()){
                echo "
                <form id='form_$rows->id'>
                    <tbody>
                        <tr id='row_$rows->id'>
                            <td>$rows->title
                            </td>
                            <td>$rows->organizer
                            </td>
                            <td><input type='hidden' name='id' form='form_$rows->id' value='$rows->id'>
                            <input type='hidden' name='table' form='form_$rows->id' value='events'>
                                <button id='$rows->id' form='form_$rows->id' class='btn btnDelete'>
                                    <i class='fa fa-trash'></i> Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </form>
                ";
            }
            echo "</table></div>";
        }
    }elseif($item == "Courses"){
        if($search !== ""){
            $query = $conn->query("select id, title, course_code from $table where title like '%$search%' 
            or course_code like '%$search%' or status like '%$search%' or department like 
            '%$search%'");
        }else{
            $query = $conn->query("select id, title, course_code from $table limit 100");
        }
        if($query->num_rows > 0){
            $tbl = <<<TBL
            <div class="table-responsive">
                <div class="alert hide"></div>
                <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <th>Title</th>
                    <th>Course code</th>
                    <th>Action</th>
                </thead>
TBL;
            echo($tbl);
            while($rows = $query->fetch_object()){
                echo "
                <form id='form_$rows->id'>
                    <tbody>
                        <tr id='row_$rows->id'>
                            <td>
                                $rows->title
                            </td>
                            <td>$rows->course_code
                            </td>
                            <td><input type='hidden' name='id' form='form_$rows->id' value='$rows->id'>
                            <input type='hidden' name='table' form='form_$rows->id' value='courses'>
                                <button id='$rows->id' form='form_$rows->id' class='btn btnDelete'>
                                    <i class='fa fa-trash'></i> Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </form>
                ";
            }
            echo "</table></div>";
        }
    }elseif($item == "Hostels"){
        if($search !== ""){
            $query = $conn->query("select id, name, campus from $table where name like '%$search%' 
            or campus like '%$search%' or facilities like '%$search%' or contact like 
            '%$search%'");
        }else{
            $query = $conn->query("select id, name, campus from $table limit 100");
        }
        if($query->num_rows > 0){
            $tbl = <<<TBL
            <div class="table-responsive">
            <div class="alert hide"></div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <th>Hostel name</th>
                    <th>Campus</th>
                    <th>Action</th>
                </thead>
TBL;
            echo($tbl);
            while($rows = $query->fetch_object()){
                echo "
                <form id='form_$rows->id'>
                    <tbody>
                        <tr>
                            <td>
                                $rows->name
                            </td>
                            <td>$rows->campus
                            </td>
                            <td><input type='hidden' name='id' form='form_$rows->id' value='$rows->id'>
                            <input type='hidden' name='table' form='form_$rows->id' value='hostels'>
                                <button id='$rows->id' form='form_$rows->id' class='btn btnDelete'>
                                    <i class='fa fa-trash'></i> Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </form>
                ";
            }
            echo "</table></div>";
        }
    }elseif($item == "Lessons"){
        if($search !== ""){
            $query = $conn->query("select id, subject, course_code, day from lessons where day like '%$search%' 
            or course_code like '%$search%' or subject like '%$search%' or venue like '%$search%'");
        }else{
            $query = $conn->query("select id, subject, course_code, day from lessons limit 100");
        }
        if($query->num_rows > 0){
            $tbl = <<<TBL
            <div class="table-responsive">
            <div class="alert hide"></div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <th>Course title</th>
                    <th>Course code</th>
                    <th>Day</th>
                    <th>Action</th>
                </thead>
TBL;
            echo($tbl);
            while($rows = $query->fetch_object()){
                echo "
                <form id='form_$rows->id'>
                    <tbody>
                        <tr id='row_$rows->id'>
                            <td>
                                $rows->subject
                            </td>
                            <td>
                                $rows->course_code
                            </td>
                            <td>
                                $rows->day
                            </td>
                            <td><input type='hidden' name='id' form='form_$rows->id' value='$rows->id'>
                            <input type='hidden' name='table' form='form_$rows->id' value='lessons'>
                                <button id='$rows->id' form='form_$rows->id' class='btn btnDelete'>
                                    <i class='fa fa-trash'></i> Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </form>
                ";
            }
            echo "</table></div>";
        }
    }elseif($item == "Users"){
        if($search !== ""){
            $query = $conn->query("select id, username, firstname, lastname from users where 
            username like '%$search%' or firstname like '%$search%' or lastname 
            like '%$search%' or email like '%$search%' or user_id like '%$search%'");
        }else{
            $query = $conn->query("select id, username, firstname, lastname from users limit 100");
        }
        if($query->num_rows > 0){
            $tbl = <<<TBL
            <div class="table-responsive">
            <div class="alert hide"></div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <th>Name</th>
                    <th>Username</th>
                    <th>Action</th>
                </thead>
TBL;
            echo($tbl);
            while($rows = $query->fetch_object()){
                echo "
                <form id='form_$rows->id'>
                    <tbody>
                        <tr>
                            <td>
                                $rows->firstname $rows->lastname
                            </td>
                            <td>$rows->username
                            </td>
                            <td><input type='hidden' name='id' form='form_$rows->id' value='$rows->id'>
                                <input type='hidden' name='table' form='form_$rows->id' value='users'>
                                <button id='$rows->id' form='form_$rows->id' class='btn btnDelete'>
                                    <i class='fa fa-trash'></i> Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </form>
                ";
            }
            echo "</table></div>";
        }
    }else{
        echo "Unknown table $item. Try again";
    }
}elseif(isset($_REQUEST['id']) && isset($_REQUEST['table'])){
    $id = $_REQUEST['id'];
    $table = $_REQUEST['table'];
    $conn = get_connection_handle();
    if($table == "users"){
        $query = $conn->query("delete from users where id = $id");
    }elseif($table == "courses"){
        $query = $conn->query("delete from courses where id = $id");
    }elseif($table == "hostels"){
        $query = $conn->query("delete from hostels where id = $id");
    }elseif($table == "lessons"){
        $query = $conn->query("delete from lessons where id = $id");
    }elseif($table == "events"){
        $query = $conn->query("delete from events where id = $id");
    }
    if($conn->affected_rows == 1){
        echo("Item has been deleted successfully");
    }else{
        echo "Item couldn't be deleted";
    }
}
?>
<script>
$(".btnDelete").click(function(e){
    e.preventDefault();
    id = this.id;
    form = $("#form_" + id);
    $.ajax({
        url: "delete.php",
        type: "POST",
        dataType: "text",
        data: form.serialize(),
        success: function(response){
            $(".alert").removeClass("hide").addClass("alert-success").html(response);
        },
        fail: function(error){
            $(".alert").removeClass("hide").addClass("alert-info").html(error);
        }
    })
})
</script>