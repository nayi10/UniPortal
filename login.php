<?php
include_once('header.php');
if(isset($_SESSION['user_id']) || isset($_SESSION['username'])){
    echo "<script>history.back();</script>";
}
?>
<h1 class="text-hide">Login to your account</h1>
<div class="container"><br>
    <div class="row">
        <div class="col-md-4 col-lg-4 col-xl-4 mb mx-auto">
            <div class="card-4">
            <div class='alert alert-danger hide'></div>
                <h4 class="text-center card-header">Login to your account</h4><br>
                <form id="formLogin">
                    <label for="user_id" id="label_user">Student ID</label><br>
                    <input type="text" name="user_id" maxlength="50" class="input-text" id="user_id"><br>
                    <label for="password">Password</label><br>
                    <input type="password" name="password" maxlength="50" class="input-text" id="password">
                    <hr>
                    <button class="btn btn-primary" id="login" type="submit">Login</button>
                </form>
                <br>
                <div>No account? <a href="signup.php" class="text-blue">Signup here.</a></div>

            </div>
        </div>
    </div>
</div>


<script>
$("#formLogin").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "process.php",
        type: "POST",
        dataType: "text",
        data: $(this).serialize(),
        success: function(res){
            if(res == "Login successful"){
                history.go(-1);
            }else{
                $(".alert").removeClass("hide").html(res)
            }
        }
    })
})
 </script>
 <?php
 include('footer.php');
 ?>
