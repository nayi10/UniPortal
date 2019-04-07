<?php
include("functions.php");
$conn = get_connection_handle();
if(isset($_REQUEST['question'])){
    $question = strip_tags($_REQUEST['question']);
    $qry = $conn->query("select question from questions where question like '%$question%' limit 7");
    if($qry && $qry->num_rows > 0){
        echo "<hr><b class='mt-3'>Similar questions that may answer your question</b><br>
            <ul class='list-group'>";
        while ($rows = $qry->fetch_object()) {
            $url = urlencode($rows->question);
            echo "<li class='list-group-item'>
                <a href='/UniPortal/questions/?question=$url' class='list-group-action'>
                $rows->question</a>
            </li>";
        }
        echo "</ul>";
    }
}