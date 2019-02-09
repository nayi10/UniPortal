<?php
if(!session_id())
  session_start();

if(isset($_SESSION['username'])){
  $username = $_SESSION['username'];
  $user_id = $_SESSION['user_id'];
}
include_once("../header.php");
include_once("../Question.php");
include_once("../Answer.php");

echo '<div class="container-fluid"><br>';

if(isset($_GET['question']) && !empty($_GET['question'])){
  if(!isset($_SESSION['username'])){
    $status = "disabled title='Login to upvote/downvote'";
  }else{
    $status = "";
  }
    $question = new Question();//New question object
    $question->set_question($_GET['question']);
    $query = $question->get_answers();
    ?>
      <div class="row">
        <div class="col-md-5" style="background-color: #f1f1f1;">
          <h1 class="text-center">
            <?php $qtn = $question->get_question()? $question->get_question():
            "Question does not exist"; echo $qtn ?>
          </h1>
          <p>
            <?php if( $question->get_description()){ echo $question->get_description();
            $qupvotes = $question->get_upvotes();
            $qdownvotes = $question->get_downvotes();
            $qid = $question->get_id();
            if(isset($_SESSION['username'])){
              echo "<div class='btn-group mt-2'>
                  <form id='form-qu'>
                      <input type='hidden' name='question' value='$qtn'>
                      <input type='hidden' name='vote-type' value='upvote'>
                      <input type='hidden' name='question_id' value='$qid'>
                      <input type='hidden' name='type' value='question'>
                      <input type='hidden' id='quvote' value='$qupvotes'>
                      <input type='hidden' name='username' value='$username'>
                      <button type='submit' class='btn text-green mr-3' $status 
                      title='This question is useful' id='qBtnUp'>
                        $qupvotes <i class='fa fa-thumbs-up'></i>
                      </button>
                  </form>
                  <form id='form-qd'>
                      <input type='hidden' name='question' value='$qtn'>
                      <input type='hidden' name='vote-type' value='downvote'>
                      <input type='hidden' name='type' value='question'>
                      <input type='hidden' name='question_id' value='$qid'>
                      <input type='hidden' id='qdvote' value='$qdownvotes'>
                      <input type='hidden' name='username' value='$username'>
                      <button class='btn btn-default text-red' $status 
                      title='This question is not useful' id='qBtnDown'>
                        $qdownvotes <i class='fa fa-thumbs-down'></i>
                      </button>                  
                  </form>
              </div>";
            }
          }
            ?>
          </p><hr>
          <div class="container-fluid">
            <?php if($question->get_tags()){
                foreach($tags = $question->get_tags() as $tag){
                    $tag = trim($tag);
                    echo "<a href='tags/$tag/'>
                          <span class='tag'>$tag</span>
                    </a>";
                }
              } ?>
          </div>
        </div>

<?php
    if($query){
        $rows = $query->num_rows;
        echo "<div class='col-md-6 mx-auto'><br><br><br>
          <h2 class='text-center'>Answers ($rows)</h2>";
        
        while($row = $query->fetch_object()){
          $id = $row->id;
          $conn = get_connection_handle();
          $q = $conn->query("select sum(votes) as total from votes where type_id = $id 
          and type = 'answer' and vote_type = 'upvote'");
          if($q->num_rows > 0){
              $rw = $q->fetch_object();
              $upvotes = $rw->total;
          }else{
              $upvotes = 0;
          }
          $qery = $conn->query("select sum(votes) as total from votes where type_id = $id 
          and type = 'answer' and vote_type = 'downvote'");
          if($qery->num_rows > 0){
              $rw = $qery->fetch_object();
              $downvotes = $rw->total;
          }else{
              $downvotes = 0;
          }
          $ans = new Answer($row->question);
          $res = $ans->get_comments();

          $form = isset($_SESSION['username'])?
          create_comment_form($id,'answer', $_SESSION['username']): '';
          echo "<div class='answer-dom'>
              <p class='mb-2'>$row->answer</p>";
              if(isset($_SESSION['username'])){
                $f = <<<LD
                <div class='btn-group mt-2'>
                    <form id='form1'>
                        <input type='hidden' name='question' value='$qtn'>
                        <input type='hidden' name='vote-type' value='upvote'>
                        <input type='hidden' name='answer_id' value='$row->id'>
                        <input type='hidden' name='type' value='answer'>
                        <input type='hidden' id='uvote' value='$upvotes'>
                        <input type='hidden' name='username' value='$username'>
                        <button type='submit' class='btn text-green mr-3' $status 
                        title='This answer is useful' id='btnUp'>
                          $upvotes <i class='fa fa-thumbs-up'></i>
                        </button>
                    </form>
                  <form id='form2'>
                      <input type='hidden' name='question' value='$qtn'>
                      <input type='hidden' name='vote-type' value='downvote'>
                      <input type='hidden' name='type' value='answer'>
                      <input type='hidden' name='answer_id' value='$row->id'>
                      <input type='hidden' id='dvote' value='$downvotes'>
                      <input type='hidden' name='username' value='$username'>
                      <button class='btn btn-default text-red' $status 
                      title='This answer is not useful' id='btnDown'>
                        $downvotes <i class='fa fa-thumbs-down'></i>
                      </button>
                </div>
              </form>
LD;
              echo $f;
              }
            echo "<small class='float-right'>
              <span class='pr-2'>answered by $row->answered_by<span> at
              $row->added_on</small><hr>";
              if($res){
                  while($row = $res->fetch_object()){
                    $da = new DateTime($row->added_on);
                    $added = $da->format("d-m-Y");
                    echo "<div class='text-md ml-3'>
                          <small>$row->comment -
                            <span class='mx-2'>
                              <b>$row->username</b>
                            </span>:
                              $added, $row->added_at
                          </small>
                        </div><hr>";
                  }
              }
          if(isset($_SESSION['username'])){
            $d = new DateTime();
            $date_ = $d->format("Y-m-d H:i:s");
            echo "$form</div>
            <p>Know an alternative answer to this question? Please help provide a
            good answers by adding your own.</p>
            <div class='container answer-form'>
                  <div class='alert hide'></div>
                      <form id='answerForm'>
                          <div id='answer-form'></div>
                          <textarea class='hide' name='answer' id='answer'></textarea>
                          <input type='hidden' name='username' value='$username'>
                          <input type='hidden' name='question' value='$qtn'>
                          <input type='hidden' name='date' value='$date_'>
                          <button name='submit' class='btn btn-info'>
                              Post Answer
                          </button>
                      </form>
                  </div>
              </div>";
          }else{
            echo "<a href='../login.php'>Login</a> to add an answer.";
          }
        }
    }else{

      $d = new DateTime();
      $date_ = $d->format("Y-m-d H:i:s");
      
      if($question->get_question() && isset($_SESSION['username'])){
        $username = session_id() ? $_SESSION['username']: "";
        echo "<div class='col-md-6 mx-auto'>
              <h2 class='text-center text-adjust' id='hi'>No answer yet</h2>
              <p>Please there are no answers to the question yet.
                <a href='#' onclick='showForm()'>Provide your answer</a>
              </p>
              <div id='form' class='hide'>
                  <div class='container answer-form'>
                      <div class='alert hide'></div>
                      <form id='answerForm'>
                          <div id='answer-form'></div>
                          <textarea class='hide' name='answer' id='answer'></textarea>
                          <input type='hidden' name='username' value='$username'>
                          <input type='hidden' name='question' value='$qtn'>
                          <input type='hidden' name='date' value='$date_'>
                          <button name='submit' class='btn btn-info'>
                              Post Answer
                          </button>
                      </form>
                    </div>
                </div>
            </div>";
      }
    }

}else{ ?>
  <h1 class="text-adjust text-center">Recent Questions</h1>
  <div class="row">
      <div class="col-md-11 mx-auto">
      <?php
          $conn = get_connection_handle();
          $question = new Question();
          if(isset($_GET['limit'])){
            $query = $question->get_all(intval($_GET['limit']));
          }else{
            $query = $question->get_all();
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
                        <a href='?question=$url'>
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
      }
?>
</body>
<script>
//Sends the form data to the server using Ajax GET
  function getValue(val){
    window.alert(val);
  }
(function($){
    function sendData(e){
      id = this.id;
      $.ajax({
        url: "../process.php",
        dataType: 'text',
        type: "post",
        contentType: 'application/x-www-form-urlencoded',
        data: $(this).serialize(),
        success: function( data, textStatus, jQxhr ){
            
          console.log(data)
            if(data == 1){
              if(id == 'form1'){
                vot = $("#uvote").val() !== ""? $("#uvote").val(): 0;
                vote = vot + parseInt(data);
                $("#btnUp").html(vote + " <i class='fa fa-thumbs-up'></i>")
              }else if(id == 'form2'){
                vot = $("#dvote").val() !== ""? $("#dvote").val(): 0;
                vote = vot - parseInt(data);
                $("#btnDown").html(vote + " <i class='fa fa-thumbs-down'></i>")
              }else if(id == 'form-qu'){
                vot = $("#quvote").val() !== ""? $("#qupvote").val(): 0;
                vote = vot + parseInt(data);
                $("#qBtnUp").html(vote + " <i class='fa fa-thumbs-up'></i>")
              }else{
                vot = $("#qdvote").val() !== ""? $("#qdvote").val(): 0;
                vote = vot - parseInt(data);
                $("#qBtnDown").html(vote + " <i class='fa fa-thumbs-down'></i>")
              }
                
            }
        },
        error: function( jqXhr, textStatus, errorThrown ){
            console.log( errorThrown );
        }
      });
      e.preventDefault();
  }
  
  $('#form1').submit( sendData );
  $('#form2').submit( sendData );
  $('#form-qu').submit( sendData );
  $('#form-qd').submit( sendData );
})(jQuery);

$("#answerForm").submit(function(e){
  e.preventDefault();
  $.ajax({
    url: "../save.php",
    type: "POST",
    dataType: "text",
    data: $(this).serialize(),
    success: function(responseText){
      $("#answer").text("");
      console.log(responseText)
      $("#answer-form").text("");
      $(".alert").removeClass("hide").addClass("alert-success").text(responseText);
    },
    fail: function(error){
      $(".alert").removeClass("hide").addClass("alert-danger").text(error);
    }
  })
})

$("#answer-form").on("input", function(){
  answer = $(this).html();
  $("#answer").text(answer);
})
  function showForm(){
    $("#hi").hide('fast', function(){
      $("#form").fadeIn();
      $("#title").focus();
    })
  }
</script>
