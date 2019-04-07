<?php
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $id = $_SESSION['id'];
    $email = $_SESSION['email'];
}else{
    header("Location:.");
}
include_once("User.php");
$user = new User($username);
$firstname = $user->get_firstname();
$lastname = $user->get_lastname();
$user->set_username($username);
$phone = $user->get_phone();
$password = $user->get_password();
$user_id = strtoupper($user_id);
$programme = $user->get_programme();
$department = $user->get_department();
//Misc
$age = $user->get_age();
$gender = $user->get_gender();
$hostel = $user->get_hostel();
$country = $user->get_country();
$town = $user->get_town();
$region = $user->get_region();
$content = <<<T
<form id="updateForm">
<div class='hide' id='alert'></div>
<div class='row'>
    <div class="col-md-6">
        <div class="card px-4 py-2" id="detail">
            <h1 class="card-title pt-2">Profile details 
                <div class='hover-visible'>
                    <span class="mx-2" id='btnEdit'>
                    <i class="fa fa-edit"></i> Edit
                    </span>
                    <span class="mx-2 hide" id='btnCancel'>
                        <i class="fa fa-close"></i> Cancel
                    </span>
                </div>
            </h1>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Username</span>
                </div>
                <input class="form-control edit-able" type="text" value="$username" 
                name="username" id="username" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Fullname </span>
                </div>
                <input type="hidden" name='userID' value="$id">
                <input class="form-control" type="text" value="$firstname" name="firstname" id="firstname" readonly>
                <input class="form-control" type="text" value="$lastname" name="lastname" id="lastname" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Phone Number </span>
                </div>
                <input class="form-control edit-able" type="text" value="$phone" name="phone" id="phone" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Email </span>
                </div>
                <input class="form-control edit-able" type="text" value="$email" name="email" id="email" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">User ID</span>
                </div>
                <input class="form-control" type="text" value="$user_id" name="user_id" id="student_id" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Programme</span>
                </div>
                <input class="form-control" type="text" value="$programme" name="programme" id="programme" readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <span class="input-group-text">Department</span>
                </div>
                <input class="form-control" type="text" value="$department" name="department" id="department" readonly>
            </div>
        </div>
    </div>
    <div class="col-md-6">
T;
    $content .= '
    <div class="card p-3">';

    if($age !== "" && !is_null($age)){
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Age</span>
            </div>
            <input class="form-control edit-able" type="number" value="'.$age.'" name="age" id="age" readonly>
        </div>';
    }else{
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Age</span>
            </div>
            <input class="form-control" type="number" name="age" id="age">
        </div>';
    }
    if(!is_null($gender) && $gender !== ""){
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Gender</span>
            </div>
            <input class="form-control edit-able" type="text" value="'.$gender.'" name="gender" id="gender" readonly>
        </div>';
    }else{
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Gender</span>
            </div>
            <input class="form-control" type="text" name="gender" id="gender">
        </div>';
    }
    //Hostel
    if(!is_null($hostel) && $hostel !== ""){
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Hostel</span>
            </div>
            <input class="form-control edit-able" type="text" value="'.$hostel.'" name="hostel" id="hostel" readonly>
        </div>';
    }else{
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Hostel</span>
            </div>
            <input class="form-control" type="text" name="hostel" id="hostel">
        </div>';
    }
    if(!is_null($country) && $country !== ""){
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Country</span>
            </div>
            <input class="form-control edit-able" type="text" value="'.$country.'" name="country" id="country" readonly>
        </div>';
    }else{
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Country</span>
            </div>
            <input class="form-control" type="text" name="country" id="country">
        </div>';
    }
    if(!is_null($town) && $town !== ""){
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Town</span>
            </div>
            <input class="form-control edit-able" type="text" value="'.$town.'" name="town" id="town" readonly>
        </div>';
    }else{
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Town</span>
            </div>
            <input class="form-control" type="text" name="town" id="town">
        </div>';
    }
    if(!is_null($region) && $region !== ""){
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Region</span>
            </div>
            <input class="form-control" type="text" value="'.$region.'" name="region" id="region" readonly>
        </div>';
    }else{
        $content .= '<div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Region</span>
            </div>
            <input class="form-control" type="text" name="region" id="region">
        </div>';
    }
    echo $content."</div>
        <button class='btn btn-primary mt-3' name='btnUpdate' id='btnUpdate'>
            Finish updating profile
        </button>
        </div>
        </div>
    </form>";
    if(!$user->get_profile_image()){
        $content1 = "<h2 class='text-lg my-3'>Upload a Profile Photo</h2>
        <div class='alert hide'></div>
        <div class='dropzone' id='profile-photo'></div><hr>";
        echo $content1;
    }
?>
<script>
    $("#btnEdit").click(function(){
        $(this).hide(function(){
            $("#btnCancel").show();
        })
        $(".edit-able").each(function(){
            $(this).prop("readonly", false);
        });
    });
    $("#btnCancel").click(function(){
        $(this).hide(function(){
            $("#btnEdit").show();
        })
        $(".edit-able").each(function(){
            $(this).prop("readonly", true);
        });
    });
    $("#updateForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: "update.php",
            type: "POST",
            dataType: "text",
            data: $(this).serialize(),
            success: function(data){
                if(data == "Update successful"){
                    $("#alert").removeClass("hide").addClass("alert alert-success").html(data);
                }else{
                    $("#alert").removeClass("hide").addClass("alert alert-info").html(data);
                }
            },
            fail: function(error){
                console.log(error)
                $("#alert").removeClass("hide").addClass("alert alert-error").html(error);
            }
        })
    })
</script>