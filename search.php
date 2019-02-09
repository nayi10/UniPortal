<?php
include_once 'functions.php';

if(isset($_GET['search']) && isset($_GET['table'])){
    $con = new Connection();
    $conn = $con->connect();
    $table = strip_tags($_GET['table']);
    $search = htmlspecialchars(strip_tags($_GET['search']));

    if($table == "questions"){
        $query = "(SELECT * FROM questions WHERE question LIKE '%$search%' "
                . "OR added_on LIKE '%$search%' OR description LIKE '%$search%'
                LIMIT 25)";
    }elseif($table == "answers"){
        $query = "(SELECT * FROM answers WHERE question LIKE '%$search%'"
                . " OR added_on LIKE '%$search%' OR answer LIKE '%$search%'
                LIMIT 25)";
    }
    $result = $conn->query($query);
    if($result && $result->num_rows > 0){

        echo "<h6 class='text-center'>Results for '<b><i>$search</i></b>'
                (<small><i>total: $result->num_rows</i></small>)</h6>";

        while($row = $result->fetch_object()){

          $id = $row->id;

          $question = substr($row->question, 0, 250);

          $user = $table == 'questions' ? $row->asked_by : $row->answered_by;

          $content = $table == 'answers' ? $row->answer: $row->description;
          $denotation = $table == 'questions' ? 'Asked by': 'Answered by';
          echo "<div class='card py-2 px-3 rounded'>
                      <h4>$question</h4>
                      <p>$content...</p>
                      <span class='justify-content-end bg-raised p-2'>
                      <em>$denotation: ".ucfirst($user)."</em></span>
                      <a href='questions/?question=".urlencode($question)."' class='mr-1'>
                        Read more...
                      </a>
          </div><hr>";

        }

    }else{
        echo "<h1 class='text-center text-lg'>Nothing found</h1><br>
        <button class='button button-outline'>Ask a new question</button<hr>";
    }
}
