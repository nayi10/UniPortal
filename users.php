<?php
include_once("functions.php");
$conn = get_connection_handle();
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
}else{
    $limit = 25;
}
$query = $conn->query("select * from users LIMIT $limit");
if($query->num_rows > 0){
    echo '
    <div class="card p-4">
    <h1 class="card-title">Registered users</h1>
    <table class="table table-bordered table-responsive-md">
        <thead>
            <th>User ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Programme</th>
            <th>Department</th>
            <th>Type</th>
        </thead>
        <tbody>';
    while($row = $query->fetch_object()){
        $list = <<<LOVE
        <tr>
            <td>$row->user_id</td>
            <td>$row->firstname $row->middlename $row->lastname</td>
            <td>$row->username</td>
            <td>$row->phone</td>
            <td>$row->email</td>
            <td>$row->programme</td>
            <td>$row->department</td>
            <td>$row->type</td>
        </tr>
LOVE;
        echo $list;
    }
    echo "</tbody></table></div>";
}