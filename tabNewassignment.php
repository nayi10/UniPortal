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
$qry = $con->query("select course_code from courses where lecturer = '$fullname' 
and department = '$depart'");
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="alert hide"></div>
            <h1 class="text-md">Select delivery method</h1>
            <select class="custom-select" id="method">
                <option value="written">Online Written</option>
                <option value="upload">Uploaded File</option>
            </select>
            <hr>
            <form id="assignmentNew">
                <ol id="placeholder" class="hide"></ol>
                <div class="form-row">
                    <div class="col">
                        <div id="method-1">
                            <label for="question">Question</label>
                            <input type="hidden" name="question" id="questionlist">
                            <input type="hidden" name="lecturer" id="lecturer" value="<?php echo $fullname;?>">
                            <textarea rows="4" id="question" class="form-control"></textarea>
                            <button class="btn btn-sm btn-success mt-1" id="btnAddAss">
                                <i class="fa fa-plus"></i> Add question
                            </button>
                        </div>
                        <div class="hide" id="method-2">
                            <div class="dropzone" id="ass-upload"></div>
                        </div>
                    </div>
                    <div class="col">
                        <label for="course">Course</label>
                        <select class="custom-select mb-3" id="course" name="course">
                            <?php if($qry->num_rows > 0){
                                while($rows = $qry->fetch_object()){
                                    echo "<option value='$rows->course_code'>$rows->course_code</option>";
                                }
                            }
                            ?>
                        </select>
                        <label for="submit-date">Submission date</label>
                        <input type="date" id="submit-date" name="submit-date" class="form-control">
                        <button class="btn-default float-right" id="reveal">
                            <span class="fa fa-plus-circle"></span> More fields
                        </button>
                    </div>
                </div>
                <hr>
                <div class="form-row hide" id="other-fields">
                    <div class="col">
                        <label for="submit-time">Submission time</label>
                        <input type="time" name="submit-time" rows="4" id="submit-time" class="form-control mb-3">
                        <label for="submit-method">Submission method</label>
                        <select class="custom-select" id="submit-method" name="submit-method">
                            <option value='Portal'>Portal</option>
                            <option value="Personal Submission">Personal Submission</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col mt-2 ml-4">
                        <h3 class="text-md">Submission format</h3>
                        <div class="custom-control custom-control-inline">
                            <input type="radio" id="printed" name="format" class="custom-control-input" value="Printed">
                            <label class="custom-control-label" for="printed">Printed</label>
                        </div>
                        <div class="custom-control custom-control-inline">
                            <input type="radio" id="handwritten" name="format" 
                            class="custom-control-input" value="Hand Written">
                            <label class="custom-control-label" for="handwritten">Hand Written</label>
                        </div>
                        <div class="custom-control custom-control-inline">
                            <input type="radio" id="any" name="format" 
                            class="custom-control-input" value="Any">
                            <label class="custom-control-label" for="any">Any</label>
                        </div>
                        <hr>
                    </div>
                </div>
                <button class="btn btn-primary float-right mt-1" type="submit" id="submitAss">Submit</button>
            </form>
        </div>
    </div>
</div>
<script>
    $("#reveal").click(function(e){
        e.preventDefault();
        $("#other-fields").removeClass("hide").fadeIn();
    })

    $("#btnAddAss").click(function(e){
        e.preventDefault();
        question = document.getElementById("question").value;
        if(question !== "" && !question.startsWith(" ", 0)){
            $("#placeholder").removeClass("hide").append("<li class='question'>" + question + "</li>");
            $("#question").val("");
            if($("#questionlist").val() == ""){
                $("#questionlist").val(question);
            }else{
                var already = $("#questionlist").val();
                $("#questionlist").val(already + ",nb " + question);
            }
        }
    })

    $("#method").on("input", function(){
        toggleMethods();
    })
    function toggleMethods(){
        if($("#method").val() == "upload"){
            $("#method-2").removeClass("hide").fadeIn();
            $("#method-1").addClass("hide");
            $("#placeholder").hide();
        }else{
            $("#method-1").removeClass("hide").fadeIn();
            $("#method-2").addClass("hide");
            $("#placeholder").show();
        }
    }
submitForm()
function submitForm() {
    if($("#method").val() !== "upload"){
        Dropzone.options.assUpload = {
            url: 'add-assignment.php',
            paramName: "assignment",
            acceptedFiles: ".png,.jpg,.pdf",
            autoProcessQueue: false,
            maxFiles: 1,
            maxFilesize: 25,
            addRemoveLinks: true,
            init: function() {
                dzClosure = this;
                $("#submitAss").on("click", function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    dzClosure.processQueue();
                });
                this.on("sending", function(data, xhr, formData){
                    if($("#printed").is("input:checked")){
                        format = "Printed";
                    }else if($("#handwritten").is("input:checked")){
                        format = "Hand Written";
                    }else{
                        format = "Any";
                    }
                    formData.append("course", $("#course").val());
                    formData.append("submit-date", $("#submit-date").val());
                    formData.append("submit-time", $("#submit-time").val());
                    formData.append("submit-method", $("#submit-method").val());
                    formData.append("question", $("#questionlist").val());
                    formData.append("lecturer", $("#lecturer").val());
                    formData.append("format", format);
                })
                .on("success", function(file, responseText) {
                    console.log(responseText)
                    if(responseText == "Assignment has been added"){
                        $("#assignmentNew").find("input").each(function(){
                            $(this).val("");
                        })
                        $(".alert").removeClass("hide").addClass("alert-success").html(responseText);
                    }else{
                        $(".alert").removeClass("hide").addClass("alert-info").html(responseText);
                    }
                })
                .on("maxfilesexceeded", function(file) { this.removeFile(file); })
                .on("fail",function(error){
                    $(".alert").removeClass("hide").addClass("alert-danger").html(error)
                })      
            }
        }
    }else{
        $.post({
            url: "add-assignment.php",
            dataType: "text",
            data: $("#assignmentNew").serialize(),
            success: function(msg){
                $(".alert").removeClass("hide").addClass("alert-info").text(msg);
            },
            fail: function(error){
                $(".alert").removeClass("hide").addClass("alert-danger").text(error);
            }
        });
    }
}

$("#assignmentNew").on('submit',function(e){
    e.preventDefault();
    submitForm()
});
</script>