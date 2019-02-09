<?php
include_once("functions.php");
$conn = get_connection_handle();
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
}else{
    $limit = 25;
}
$query = $conn->query("select * from hostels order by id desc LIMIT $limit");
if($query->num_rows > 0){
    echo '
    <div class="card p-4">
    <h1 class="card-title">All hostels</h1>
    <table class="table table-bordered table-responsive-md">
        <thead>
            <th>Name</th>
            <th>Campus</th>
            <th>Contact</th>
            <th>Distance</th>
            <th>Facilities</th>
            <th>Rate</th>
        </thead>
        <tbody>';
    while($row = $query->fetch_object()){
        $list = <<<LOVE
        <tr>
            <td>$row->name</td>
            <td>$row->campus</td>
            <td>$row->contact</td>
            <td>$row->distance</td>
            <td>$row->facilities</td>
            <td>GHC$row->rate</td>
        </tr>
LOVE;
        echo $list;
    }
    echo "</tbody></table></div>";
}