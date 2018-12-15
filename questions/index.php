<?php
include_once("../header.php");
include_once("../Question.php");

if(isset($_POST["question"])){
    $question = new Question(clean_data($_POST['question']));
    $query = $question->get_answers();
    if($query->num_rows > 0){
        while($row = $query->fetch_object()){

        }
    }else{
        echo "<h1 class='text-md text-center'>Nothing to show</h1>";
    }
}