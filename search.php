<?php
include_once 'functions.php';

if(is_okay($_GET['search']) && is_okay($_GET['table'])){
    $con = new Connection();
    $conn = $con->connect();
    $table = strip_tags($_GET['table']);
    $search = htmlspecialchars(strip_tags($_GET['search']));

    if($table == "questions"){
        $query = "(SELECT * FROM questions WHERE question LIKE '%$search%' "
                . "OR added_on LIKE '%$search%')";
    }elseif($table == "answers"){
        $query = "(SELECT * FROM answers WHERE question LIKE '%$search%'"
                . " OR added_on LIKE '%$search%' OR answer LIKE '%$search%')";
    }elseif($table == "hostels"){
        $query = "(SELECT * FROM hostels WHERE name LIKE '%$search%'"
                . " OR description LIKE '%$search%' OR campus LIKE '%$search%')";
    }elseif($table == "lectures"){
        $query = "(SELECT * FROM lessons WHERE subject LIKE '%$search%'"
                . " OR abbreviation LIKE '%$search%' OR venue LIKE '%$search%'"
                . " OR day LIKE '%$search%')";
    }

    $result = $conn->query($query);
    echo $conn->error;
    $rows = $result->num_rows;

    if($rows > 0){

        echo "<h3><small>Results for your searched item '<b><i>$search</i></b>'
                (<small>Total: $rows</small>)</small></h3>
               <div class='col-md-12'>";

        while($row = $result->fetch_object()){

        $id = $row->id;

        $content = substr($row->question, 0, 250);

        $title = urlencode($row->course);


        echo "<div class='card-0 hover-light-grey'>
                    <h4>$row->lecturer</h4>
                    <p>$content...</p>
                    <span class='justify-content-end bg-raised p-2'><b class='text-md'>Lecturer: </b>
                    <em>".ucfirst($row->lecturer)."</em></span>
                    <a href='view.php?category=$row->lecturer&id=$id&utm_title=$row->course' class='btn btn-info-alt'>
                    View</a></p>
                </div><hr>";

        }

    echo "</div>";

    }else{
        echo "<h1 class='text-center text-lg'>Nothing found</h1><hr>";
    }
}
