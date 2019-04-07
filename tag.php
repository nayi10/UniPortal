<?php
include_once("../../../header.php");
include_once("../../../Question.php");
$tag =  basename(dirname(__FILE__));
?>
<h1 class="text-adjust text-center mt-5">Questions Related to <?php echo ucwords($tag); ?></h1>
<div class="row">
    <div class="col-md-10 mx-auto">
<?php
    $question = new Question();
    if(isset($_GET['limit'])){
      $query = $question->get_all_by_tag($tag, intval($_GET['limit']));
    }else{
      $query = $question->get_all_by_tag($tag);
    }
    
    if($query && $query->num_rows > 0){
      echo "<ul class='list-group'>";
      while($rows = $query->fetch_object()){
          $url = urlencode($rows->question);
          $question->set_question($rows->question);
          $count = $question->get_num_answers() > 0 ? $question->get_num_answers(): "0";
          $upvote = $question->get_upvotes() > 0 ? $question->get_upvotes(): "0";
          $downvote = $question->get_downvotes() > 0 ? $question->get_downvotes(): "0";
        
          echo "<li class='list-group-item'>
                  <a href='/UniPortal/questions/?question=$url'>
                      $rows->question
                  </a>
                  <span class='float-right'>
                      <span class='badge badge-dark p-2 text-md text-white' title='$count answers'>
                      $count answers
                      </span>
                      <span class='badge badge-success p-2 text-md text-white' title='$upvote upvotes'>
                          $upvote upvotes
                      </span>
                      <span class='badge badge-danger p-2 text-md text-white' title='$downvote downvotes'>
                          $downvote downvotes
                      </span>
                  </span>
                  
              </li>";
      }
      echo "</ul>";
    }
?>
    </div>
</div>