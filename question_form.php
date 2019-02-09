<div class="container question-form">
  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
      <label for="title" id="lbl-title"></label><br>
      <input type="text" class="inline" placeholder="Questiion" name="question" id="title">
      <br>
      <div id="question"></div>
      <label for="tags">Tags</label><br>
      <input type="text" name="tags" id="tags"><hr>
      <div class="hide" id="tags-cont" disabled></div>
      <input class="hide" name='question' id="question-content">
      <button name="submit" class="btn btn-info">
          Post Question
      </button>
  </form>
</div>
<script>
    $('#title').on('input', function(){
      if($(this).val().length > 0){
        $("#lbl-title").fadeIn().text("Question");
      }else{
        $("#lbl-title").text("");
      }

    })
    $("#question").on('input', function(){
        $("#question-content").val($("#question").html())
    })
    $("#tags").on('input', function(){
      if($(this).val().includes(",")){
        let lastChar = $(this).val().lastIndexOf(",");
        let tag = this.value.slice(0, lastChar);
        $("#tags-cont").removeClass("hide");
        tag.innerHTML += tag;
      }else{
        console.log("woow")
      }
    })
</script>
