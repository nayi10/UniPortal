<?php
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $id = $_SESSION['id'];
    $email = $_SESSION['email'];
}else{
    header("Location:/UniPortal");
}
include_once("User.php");
$user = new User($username);
$firstname = $user->get_firstname();
$lastname = $user->get_lastname();
$phone = $user->get_phone();
$password = $user->get_password();
$user_id = strtoupper($user_id);
$programme = $user->get_programme();
$department = $user->get_department();
$content = <<<T
    <div class="col-md-6">
        <div class="card px-4 py-2">
            <h1 class="card-title">Profile details</h1>
        <form method="post" action="update.php" id="update">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Username</span>
                </div>
                <input class="form-control" type="text" value="$username" name="username" id="username" 
                    class="form-control-plaintext" disabled>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Fullname </span>
                </div>
                <input class="form-control" type="text" value="$firstname" name="firstname" id="firstname" 
                    class="form-control-plaintext" disabled>
                <input class="form-control" type="text" value="$lastname" name="lastname" id="lastname" 
                    class="form-control-plaintext" disabled>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Phone Number </span>
                </div>
                <input class="form-control" type="text" value="$phone" name="phone" id="phone" 
                    class="form-control-plaintext" disabled>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Email </span>
                </div>
                <input class="form-control" type="text" value="$email" name="email" id="email" 
                    class="form-control-plaintext" disabled>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Student ID</span>
                </div>
                <input class="form-control" type="text" value="$user_id" name="student_id" id="student_id" 
                    class="form-control-plaintext" disabled>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Programme</span>
                </div>
                <input class="form-control" type="text" value="$programme" name="programme" id="programme" 
                    class="form-control-plaintext" disabled>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Department</span>
                </div>
                <input class="form-control" type="text" value="$department" name="department" id="department" 
                    class="form-control-plaintext" disabled>
            </div>
            <button class="btn btn-primary" name="btnUpdate" id="btnUpdate">Update</button>
        </form>
    </div>
</div>
T;
echo($content);