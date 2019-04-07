<?php
if (session_id())
    session_start();
include_once("header.php");
include_once("User.php");

$user = new User($username);
$fullname = $user->get_fullname();
$depart = $user->get_department();
?>

<div class="container">
        <div class="dropzone" id="shareTo"></div>
        <input id='omgUser' type='hidden'>
    </div>
</div>
<script>
  
    Dropzone.options.shareTo = {
        url: 'upload.php',
        paramName: "shareFile",
        acceptedFiles: ".png,.jpg,.pdf, .doc, .docx, .odg, .ods, .xlsx,.xls,.ppt, .pptx",
        autoProcessQueue: false,
        maxFiles: 1,
        maxFilesize: 150,
        addRemoveLinks: true,
        init: function() {
            dzClosure = this;
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
                    $(".alert").removeClass("hide").addClass("alert-success").html(res.toUpperCase());
                }else{
                    $(".alert").removeClass("hide").addClass("alert-info").html(res.toCase());
                }
            })
            .on("maxfilesexceeded", function(file) { this.removeFile(file); })
            .on("fail",function(error){
                $(".alert").removeClass("hide").addClass("alert-danger").html(error)
            })      
        }
    }