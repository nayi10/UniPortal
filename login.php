<?php
include_once('header.php');

if(isset($_SESSION['user_id'])){

    echo "<script>history.back();</script>";

}

?>

<h1 class="text-hide">Login to your account</h1>

<div class="container"><br>

    <div class="row">

        <div class="col-md-4 col-lg-4 col-xl-4 mb mx-auto">

            <div class="card-4">
                <?php

                    if(isset($_POST['login'])){

                        $student = new Student();

                    if($student->login($_POST['student_id'], $_POST['password'])){
                            echo "<div class='alert alert-info alert-dismissible'>"
                            . "Login successful, redirecting...<span class='close' "
                            ."data-dismiss='alert'>&times;</span></div>";
                        }  else {
                            if(session_id()){
                                $errors = $_SESSION['errors'];
                                 echo "<div class='alert alert-info alert-dismissible'>";

                                foreach($errors as $error){
                                   echo $error."<br>";
                                }
                                echo "<span class='close' data-dismiss='alert'>&times;</span></div>";
                            }
                        }

                    }
                ?>
                <h4 class="text-center card-header">Login to your account</h4><br>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"id="login">

                    <label for="user_id" id="label_user">Student ID</label><br>
                    <input type="text" name="student_id" maxlength="50" class="input-text" id="student_id"><br>

                    <label for="password">Password</label><br>
                    <input type="password" name="password" maxlength="50" class="input-text" id="password">
                    <hr>
                    <button name="login" class="btn btn-primary btn-block" id="login" onclick="loginRequest()" type="submit">Login</button>

                </form>
                <br>
                <div>No account? <a href="signup.php" class="text-blue">Signup here.</a></div>

            </div>
        </div>
    </div>
</div>


<script>
    var xhttp = new XMLHttpRequest();
    function loginRequest(){
        id = $("#student_id").val();
        password = $("#password").val();

        document.getElementById("results").innerHTML = "";
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("results").innerHTML = this.responseText;
            }
        };
        url = "../Student.php";
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhttp.send(id,password);
        console.log("Pass: " + password + "\nUsername: " + id)
    }
 </script>
 <?php
 include('footer.php');
 ?>
