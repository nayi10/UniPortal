<?php
include_once 'header.php';
if(is_session("user_id")){
    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['email'];
    $username = $_SESSION['username'];
    $id = $_SESSION['id'];
}else{
    echo "<script>location.href = '/UniPortal';</script>";
}

if(isset($_REQUEST['new'])){
?>
<div class="container-fluid bg-light"><br>
    <form id="noteForm">
        <div class="alert alert-dismissible hide fade show px-2 py-1">
        </div>
        <label for="title" id="lbl-title"></label>
        <input type="text" class="input-text" placeholder="Title" name="title" id="title">
        <input type="hidden" name="username" value="<?php echo $username;?>">
        <div id="message"></div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="status" value="public" name="status">
            <label class="custom-control-label" for="status">Shareable</label>
        </div>
        <input type="hidden" name='note' id="note-content">
        <button name="submit" type="submit" class="btn btn-info btn-sm align-end"  id="save"
        style="margin-left:85%; margin-top: -45px;">
            <i class="fa fa-save"></i>
            Save</button>
        </div>
    </form>
</div>
<?php }else{
    $user = new User($username);
    if($user->get_notes()){
        $tip = <<<K
        <div class="d-flex justify-content-end">
            <div class="btn-group" role="group" aria-label="Action buttons">
                <button type="button" class="btn btn-secondary" id="newButton">
                    <i class="fa fa-plus"></i>
                </button>
                <button type="button" class="btn btn-secondary" id="deleteButton">
                    <i class="fa fa-trash-o"></i>
                </button>
                <button type="button" id="editButton" class="btn btn-secondary" data-toggle="modal" data-target="#pop">
                    <i class="fa fa-edit"></i>
                </button>
            </div>
        </div>
        <div class="modal fade" id="pop" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal">Editing note</h5>
                        <div class="alert hide mt-3"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editForm">
                        <div class="modal-body">
                            <input type="text" name="note-title" id="note-title" class="form-control">
                            <div id="message"></div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="status" value="public" name="status">
                                <label class="custom-control-label" for="status">Shareable</label>
                                <input type="hidden" name='content' id="content">
                                <input type="hidden" name='note-id' id="note-id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnUpdate" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-responsive-md">
            <h1 class="text-md hide">A list of your notes</h1>
            <div class="alert hide mt-3"></div>
            <caption class="caption">A list of your notes</caption>
            <thead>
                <th>Title</th>
                <th>Accessiblity</th>
                <th colspan='3'>Resource Link</th>
                <th>Date Added</th>
                <th>Action</th>
            </thead>
            <form id='actionForm'>
K;
        echo($tip);
        $notes = $user->get_notes();
        while($note = $notes->fetch_object()){
            if($note->status == "public"){
                $status = "<i class='fa fa-unlock-alt fa-2x text-orange' title='Accessible to public'></i>";
            }else{
                $status = "<i class='fa fa-lock fa-2x text-green' title='Only accessible to you'></i>";
            }
            echo "<tr>
                <td>$note->title</td>
                <td>$status</td>
                <td colspan='3'>
                    <div class='input-group mb-2 mr-sm-2'>
                        <input id='link_$note->id' class='form-control text-sm' value='localhost/UniPortal/users/$username/notes.php?id=$note->link_id' readonly>
                        <div class='input-group-append'>
                            <button class='btnCopy input-group-text' id='$note->id'>
                                <i class='fa fa-copy'></i>
                            </button>
                        </div>
                    </div>
                </td>
                <td>$note->added_on</td>
                <td> 
                    <div class='custom-control custom-radio'>
                        <input type='radio' class='custom-control-input' id='edit_$note->id' name='item_id' value='$note->id'>
                        <label class='custom-control-label' for='edit_$note->id'>
                            <i class='fa fa-pencil'></i>
                        </label>
                    </div> 
                </td>
            </tr>";
        }
        echo "</form></table>";
    }
}
?>
<script>
    $("#toggler").hide();
    $("#message").on('input', function(){
        var txt = $("#message").html()
        $("input#note-content").val(txt)
    })

    $(".btnCopy").on("click", function(e){
        e.preventDefault();
        id = this.id;
        var link = $("#link_" + id);
        link.focus();
        link.select();
        document.execCommand("copy");
    })

    $("#noteForm").on("submit", function(e){
        $.ajax({
            url: "save.php",
            type: "POST",
            dataType: "text",
            data: $(this).serialize(),
            success: function(responseText){
                $(".alert").removeClass("hide").addClass("alert-success").append(responseText);
                document.getElementById("note-content").value = "";
                document.getElementById("message").innerHTML = "";
                document.getElementById("title").value = "";
            },
            fail: function(error){
                $(".alert").removeClass("hide").append(error.responseText)
            }
        })
        e.preventDefault();
    })

    $("#editForm").on("submit", function(e){
        $.ajax({
            url: "save.php",
            type: "POST",
            dataType: "text",
            data: $(this).serialize(),
            success: function(responseText){
                $(".alert").removeClass("hide").addClass("alert-success").append(responseText);
                document.getElementById("content").value = "";
                document.getElementById("message").innerHTML = "";
                document.getElementById("note-title").value = "";
            },
            fail: function(error){
                $(".alert").removeClass("hide").append(error.responseText)
            }
        })
        e.preventDefault();
    })

    $("#editButton").on("click", function(e){
        var id = $("input[type='radio']:checked").val();
        if(id){
            $.ajax({
                url: "fetch.php",
                type: "GET",
                dataType: "text",
                data: {id: id},
                success: function(responseText){
                    msg = JSON.parse(responseText);
                    $("#note-title").val(msg.title);
                    $("#content").val(msg.note);
                    $("#message").html(msg.note);
                    $("#note-id").val(msg.id);
                    if(msg.status == "public"){
                        $("#status").prop("checked", true);
                    }
                },
                fail: function(error){
                    $(".alert").removeClass("hide").append(error.responseText)
                }
            })
        }else{
            $(this).removeClass("modal")
            alert("Please select one of the notes to edit")
        }
        
        e.preventDefault();
    })
    
    $("#deleteButton").on("click", function(e){
        var id = $("input[type='radio']:checked").val();
        console.log(id)
        if(id){
            $.ajax({
                url: "save.php",
                type: "POST",
                dataType: "text",
                data: {item_id: id},
                success: function(responseText){
                    console.log(responseText)
                    $(".alert").removeClass("hide").addClass("alert-success").append(responseText)
                },
                fail: function(error){
                    console.log(error)
                    $(".alert").removeClass("hide").addClass("alert-danger").append(error)
                }
            })
        }else{
            alert("Please select one of the notes to delete")
        }
        
        e.preventDefault();
    })
    
    $("#editModal").on("hidden.bs.modal", function(e){
        $("#note-title").val("");
        $("#content").val("");
        $("#message").html("");
        $("#note-id").val("");
        $("#status").removeAttr("checked")
    })

    $("#newButton").click(function(e){
        e.preventDefault();
        location.replace("/UniPortal/dashboard.php?tab=notes&new");
    })
    function dismissAlert(){
        $(".alert").fadeOut("slow");
    }
    setInterval(dismissAlert, 7500)
</script>
