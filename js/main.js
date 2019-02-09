jQuery(document).ready(function(){
        jQuery("#rating").on("change", function(){
            jQuery("#rate-div").removeClass("hide");
        })
    $("#sort-btn").on("click", function(){
        $("#post_title").sort();
    })
    
    $("#slides > div:gt(0)").hide();

        setInterval(function() { 
            $('#slides > div:first')
              .fadeOut(1000)
              .next()
              .delay(1000)
              .fadeIn(1000)
              .end()
              .appendTo('#slides');
        },  5000);
              
        $("#user_toggle").on('click', function(){

        var id = document.getElementById("lecturer_id");
        //If the selected element contains a class named hide
        if(id.classList.contains("hide")){
            $("#label_tutor").removeClass("hide")
            $("#label_user").addClass("hide");
            $("#lecturer_id").removeClass("hide");
            $("#student_id").addClass("hide");
        }else{
            $("#label_user").removeClass("hide");
            $("#label_tutor").addClass("hide");
            $("#lecturer_id").addClass("hide");
            $("#student_id").removeClass("hide");
        }
    })
    $(function (){
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'focus hover click',
            html: true,
            selector: 'id'
        })
    })

    $('.tooltip-dismiss').tooltip({
        trigger: 'focus'
    })

    var heading = $("h1:first").text();
    var title = $('title');
    var meta = $('#meta-info').text();
    
    title.text(heading)
    if(meta !== ""){
       meta_tag =  $("<meta name='description' content='" + meta + "'>");
       meta_tag.appendTo("head");
    }

    $("#select_campus").on("change", function(){
        document.location.reload();
    })

    $(function () {
        $('[data-toggle="popover"]').popover({
            html:true,
            trigger: 'click'
        })
    })

    $("#chat").on("click", function(){
        $("#dashboard-container").load("chat.ui.php", function(){
            console.log("Loaded successful")
        })
    })
    $(window).scroll(function(){
        if($(window).scrollTop() >= 45){
            $(".navbar").css("background-color", "rgba(0, 0, 0, 0.98)")
        }else{
            $(".navbar").css("background-color", "rgba(0, 0, 0, 0.9)")
        }
    })
    $('#answer-form').on('input', function(){
        $('#answer-content').val($('#answer-form').html())
    })
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            html:true,
            trigger: 'hover focus click'
        })
    })


    $('#message').trumbowyg();
    $('#question').trumbowyg();
    $('#answer-form').trumbowyg();

    $("#btn-sort").on('click',function(){
        sort = document.getElementById("toggle-sort");
        if(sort.classList.contains("hide")){
            $("#toggle-sort").removeClass("hide")
        }else{
            $("#toggle-sort").addClass("hide")
        }
    });
    $("#toggler").on('click', function(){
        var loader = document.getElementById("loader");
        if(loader.classList.contains("hide")){
            $("#loader").load("note.php").removeClass("hide");
            $("#message").trumbowyg();
        }else{
            $("#loader").addClass("hide");
        }
    });
    
})

var page = window.scrollBy(0, window.innerHeight);

function scrollToTop() {

    var device = window.innerHeight;

    if(window.scrollTop() > device){
        $(window).scrollTo(0, 0);
    }
}
  
Dropzone.options.assignUpload = {
    url: 'process.php',
    paramName: "file",
    // forceFallback: true,
    acceptedFiles: "application/pdf, .docx, .doc, .odt",
    autoProcessQueue: true,
    maxFiles: 1,
    maxFilesize: 10,
    addRemoveLinks: true,
    init: function() {
        dzClosure = this;
        $("#submit-all").on("click", function(e){
            e.preventDefault();
            e.stopPropagation();
            dzClosure.processQueue();
        });
        this.on("sending", function(data, xhr, formData){
            formData.append("assign_id", $("#assign_id").val());
            formData.append("username", $("#username").val());
            formData.append("course-code", $("#code").val());
            formData.append("tutor", $("#tutor").val());
        })
        .on("success", function(file, responseText) {
            $("#msg").removeClass("hide").text(responseText);
            $(".replaceable").text("You have submitted your solution");
            $(".dropzone").hide();
        })
        .on("maxfilesexceeded", function(file) { this.removeFile(file); })
        .on("fail",function(error){
            $("#error").removeClass("hide").text(error)
        })      
    }
  }

  Dropzone.options.uploadEvent = {
    url: 'upload.php',
    paramName: "files",
    acceptedFiles: ".png,.jpg,.gif",
    autoProcessQueue: false,
    maxFiles: 1,
    maxFilesize: 5,
    addRemoveLinks: true,
    init: function() {
        dzClosure = this;
        $("#submitPhoto").on("click", function(e){
            e.preventDefault();
            e.stopPropagation();
            dzClosure.processQueue();
        });
        this.on("sending", function(data, xhr, formData){
            formData.append("title", $("#event-title").val());
        })
        .on("success", function(file, responseText) {
            if(responseText == "File has been uploaded"){
                $("#eventForm").find("input").each(function(){
                    $(this).val("");
                })
                $("#alert").removeClass("hide").addClass("alert-success").html(responseText);
            }else{
                $("#alert").removeClass("hide").addClass("alert-danger").html(responseText);
            }
        })
        .on("maxfilesexceeded", function(file) { this.removeFile(file); })
        .on("fail",function(error){
            $(".alert").removeClass("hide").addClass("alert-danger").html(error)
        })      
    }
  }

  Dropzone.options.hostelPic = {
    url: 'upload.php',
    paramName: "file",
    acceptedFiles: ".png,.jpg,.gif",
    autoProcessQueue: false,
    maxFiles: 1,
    maxFilesize: 5,
    addRemoveLinks: true,
    init: function() {
        dzClosure = this;
        $("#submitPic").on("click", function(e){
            e.preventDefault();
            e.stopPropagation();
            dzClosure.processQueue();
        });
        this.on("sending", function(data, xhr, formData){
            formData.append("hostel-name", $("#name").val());
        })
        .on("success", function(file, responseText) {
            if(responseText == "File has been uploaded"){
                this.removeFile(file);
                $(".alert").removeClass("hide").addClass("alert-success").html(responseText);
                setInterval(location.reload(true), 7500)
            }else{
                $(".alert").removeClass("hide").addClass("alert-danger").html(responseText);
            }
        })
        .on("maxfilesexceeded", function(file) { this.removeFile(file); })
        .on("fail",function(error){
            $(".alert").removeClass("hide").addClass("alert-danger").html(error)
        })      
    }
}

 function destroySession(){
    $("#logout").on('click', function(){
        $.ajax({
            url: "../logout.php",
            type: "POST"
        })
        .done(function(data){
            if(data == "Logged out successfully"){
                $(".container").html("You have successfully logged out");
                location.href = "/UniPortal/";
            }
        })
        .fail(function(error){
            console.log(error.responseText);
        })
    })
}
function dismissAlert(){
    $(".alert").addClass("hide");
}
setInterval(dismissAlert, 7500)

 function sendData(str){
    if(str == ""){
        document.getElementById("results").innerHTML = "";
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            document.getElementById("results").innerHTML = this.responseText;
        }
    };

    xhttp.open('GET', "search.php?search=" + str, true);
    xhttp.send();
  }

  function sendPostData(data, el){
     if(str == ""){
         document.getElementById(el).innerHTML = "";
     }

     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function(){
         if(this.readyState == 4 && this.status == 200){
             document.getElementById(el).innerHTML = this.responseText;
         }
     };

     xhttp.open('POST', true);
     xhttp.send(data);
   }
