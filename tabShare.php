<?php
if(!session_id()) session_start();
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['email'];
    $id = $_SESSION['id'];
}else{
    header("UniPortal/");
}
include_once("functions.php");
$user = new User($username);
$con = get_connection_handle();
$fullname = $user->get_fullname();
$depart = $user->get_department();
?>

<div class="container">
    <div class="alert hide"></div>
    <h1 class="text-center">Share to students</h1>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <form id="share">
                <div class="dropzone" id="shareDoc"></div>
                <hr><h3 class="text-md">Share with</h3>
                <div class="custom-control custom-control-inline">
                    <input type="radio" id="public" name="sharewith" class="custom-control-input" value="Public">
                    <label class="custom-control-label" for="public">Public</label>
                </div>
                <div class="custom-control custom-control-inline">
                    <input type="radio" id="department" name="sharewith" 
                    class="custom-control-input" value="<?php echo $depart; ?>">
                    <label class="custom-control-label" for="department"><?php echo $depart; ?> Department</label>
                </div>
                <div class="custom-control custom-control-inline">
                    <input type="radio" id="user" name="sharewith" 
                    class="custom-control-input" value="user">
                    <label class="custom-control-label" for="user">Another user</label>
                </div>
                <div class="container mt-3 hide" id="pickUser">
                    <input type="search" id="search" placeholder="Search user" class="form-control">
                    <div class="hide" id="result"></div>
                </div>
                <input id='omgUser' type='hidden'>
                <hr>
                <button class="btn btn-primary float-right mt-1" type="submit" id="btnShare">Share</button>
            </form>
        </div>
    </div>
</div>
<script>
    $("#user").on("input", function(){
        $("#pickUser").removeClass("hide").fadeIn();
    })
    
    Dropzone.options.shareDoc = {
        url: 'upload.php',
        paramName: "shareFile",
        acceptedFiles: ".png,.jpg,.pdf, .doc, .docx, .odg, .ods, .xlsx,.xls,.ppt, .pptx",
        autoProcessQueue: false,
        maxFiles: 1,
        message: "Drop file here to share",
        maxFilesize: 150,
        addRemoveLinks: true,
        init: function() {
            dzClosure = this;
            $("#btnShare").on("click", function(e){
                e.preventDefault();
                e.stopPropagation();
                dzClosure.processQueue();
            });
            this.on("sending", function(data, xhr, formData){
                if($("#public").is("input:checked")){
                    shareWith = "Public";
                }else if($("#user").is("input:checked")){
                    user = $("#omgUser").val();
                    if(user == "" || user == undefined){
                        shareWith = "Public";//Fallback to Public if user not available
                    }else{
                        shareWith = user;
                    }
                }else{
                    shareWith = $("#department").val();
                }
                formData.append("sharewith", shareWith);
            })
            .on("success", function(file, res) {
                
                if(res == "File has been shared with " + shareWith){
                    $(".alert").removeClass("hide").addClass("alert-success").html(
                        res.charAt(0).toUpperCase() + res.slice(1));
                }else{
                    this.removeFile(file);
                    $(".alert").removeClass("hide").addClass("alert-info").html(
                        res.charAt(0).toUpperCase() + res.slice(1));
                }
            })
            .on("maxfilesexceeded", function(file) { this.removeFile(file); })
            .on("fail",function(error){
                $(".alert").removeClass("hide").addClass("alert-danger").html(error)
            })      
        }
    }
    $("#search").on('input', function(e){
    e.preventDefault();
    if($(this).val() !== ""){
        search = $(this).val();
        $.ajax({
            method: "POST",
            url: "get-user.php",
            data: {name: search}
        })
        .done(function(data){
            $("#result").removeClass("hide").html(data);
        })
        .fail(function(error){
            $("#result").removeClass("hide").css("color", 'red').text("There is an error getting the user - " + error);
        })
    }
})
</script>