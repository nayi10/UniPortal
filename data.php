<?php
include("functions.php");
$conn = get_connection_handle();
if(isset($_POST["item"])){
    $item = strip_tags($_POST['item']);
    $table = strtolower($item);
    $search = strip_tags($_POST['search']);
    if($item == "Events"){
        if($search !== ""){
            $query = $conn->query("select * from $table where title like '%$search%' 
            or organizer like '%$search%' or type like '%$search%' or location like 
            '%$search%'");
        }else{
            $query = $conn->query("select * from $table limit 100");
        }
        if($query->num_rows > 0){
            $tbl = <<<TBL
            <div class="alert hide"></div>
            <table class="table table-hover table-bordered table-responsive-md">
                <thead class="thead-light">
                    <th>Title</th>
                    <th>Organizer</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Time</th>
                    <th>Misc.</th>
                    <th>Edit</th>
                </thead>
TBL;
            echo($tbl);
            while($rows = $query->fetch_object()){
                echo "
                <tbody>
                    <tr id='row_$rows->id'>
                        <td>$rows->title</td>
                        <td>$rows->organizer</td>
                        <td>$rows->contact</td>
                        <td>$rows->location</td>
                        <td>$rows->type</td>
                        <td>$rows->start_date</td>
                        <td>$rows->end_date</td>
                        <td>$rows->time</td>
                        <td>$rows->misc</td>
                        <td>
                            <button id='default_$rows->id' class='btn btnDefault'>
                                <i class='fa fa-edit'></i>
                            </button>
                        </td>
                    </tr>
                    <tr class='hide' id='rowEvent$rows->id'>
                    <td colspan='10'>
                    <form id='form_$rows->id'>
                        <div class='form-row'>
                            <div class='col'>
                                <label for='title$rows->id'>Title</label>
                                <input name='title' id='title$rows->id' class='form-control' value='$rows->title'><br>
                                <label for='orga$rows->id'>Organizer</label>
                                <input name='organizer' id='orga$rows->id' class='form-control' value='$rows->organizer'><br>
                                <label for='tel$rows->id'>Phone</label>
                                <input name='phone' class='form-control' id='tel$rows->id' value='$rows->contact'><br>
                                <label for='loc$rows->id'>Location</label>
                                <input name='location' class='form-control' id='loc$rows->id' value='$rows->location'><br>
                                <label for='tp$rows->id'>Event type</label>
                                <input name='type' class='form-control' id='tp$rows->id' value='$rows->type'><br>
                                <label for='std$rows->id'>Start date</label>
                                <input name='start_date' class='form-control' id='std$rows->id' value='$rows->start_date'><br>
                            </div>
                            <div class='col'>
                                <label for='desc$rows->id'>Description</label>
                                <textarea name='description' rows='10' class='form-control' 
                                id='desc$rows->id'>$rows->description</textarea>
                                <label for='edd$rows->id'>End date</label>
                                <input name='end_date' class='form-control' id='edd$rows->id' value='$rows->end_date'>
                                <label for='tm$rows->id'>Time</label>
                                <input name='time' class='form-control' id='tm$rows->id' value='$rows->time'>
                                <label for='msc$rows->id'>Miscelaneous</label>
                                <input name='misc' class='form-control' id='msc$rows->id' value='$rows->misc'>
                            </div>
                        </div>
                        <input type='hidden' name='id' value='$rows->id'>
                        <button id='$rows->id' class='btn btn-success btnSave'>
                            <i class='fa fa-save'></i> Save
                        </button>
                    </form>
                    </td>
                </tr>
                </tbody>";
            }
            echo "</table></div>";
        }
    }elseif($item == "Courses"){
         if($search !== ""){
            $query = $conn->query("select title from $table where title like '%$search%' 
            or lecturer like '%$search%' or department like '%$search%' or term like 
            '%$search%'");
        }else{
            $query = $conn->query("select title from $table limit 100");
        }
        if($query->num_rows > 0){
           echo "<div class='container mb-3'>        
            <form id='selectCourse'>
            <div class='input-group my-3'>
                <label for='item' class='input-group-prepend'>
                    Select a course</span>
                </label>
                <select class='custom-select' name='course_title' id='course_title'>";
            while($rows = $query->fetch_object()){
                echo "<option value='$rows->title'>$rows->title</option>";
            }
            echo '</select>
                <button id="submitGo" class="input-group-append">
                    <span class="input-group-text">Go</span>
                </button>
                </div>
            </form>';
        }
    }elseif($item == "Hostels"){
        if($search !== ""){
            $query = $conn->query("select * from hostels where name like '%$search%' 
            or contact like '%$search%' or campus like '%$search%' or facilities like 
            '%$search%'");
        }else{
            $query = $conn->query("select * from hostels limit 100");
        }
        if($query->num_rows > 0){
            $tbl = <<<TBL
            <div class="alert hide"></div>
            <table class="table table-hover table-bordered table-responsive-md">
            <thead class="thead-light">
                <th>Name</th>
                <th>Contact</th>
                <th>Campus</th>
                <th>Distance</th>
                <th>Facilities</th>
                <th>Rate</th>
                <th>Edit</th>
            </thead>
TBL;
            echo($tbl);
            while($rows = $query->fetch_object()){
                echo "
                <tbody>
                    <tr>
                        <td>$rows->name</td>
                        <td>$rows->contact</td>
                        <td>$rows->campus</td>
                        <td>$rows->distance</td>
                        <td>$rows->facilities</td>
                        <td>$rows->rate</td>
                        <td>
                            <button id='Hostel_$rows->id' class='btn btn-info btnEdit2'>
                                <i class='fa fa-edit'></i>
                            </button>
                        </td>
                    </tr>
                    <tr class='hide' id='editHostel$rows->id'>
                        <td colspan='7'>
                            <form id='hostelForm$rows->id'>
                                <div class='form-row'>
                                    <div class='col'>
                                        <label for='namee$rows->id'>
                                            Hostel Name
                                        </label>
                                        <input name='name' class='form-control' id='name$rows->id' value='$rows->name'>
                                    </div>
                                    <div class='col'>
                                        <label for='cont$rows->id'>
                                            Contact
                                        </label>
                                        <input name='contact' id='cont$rows->id' class='form-control' value='$rows->contact'>
                                    </div>
                                    <div class='col'>
                                        <label for='camp$rows->id'>
                                            Campus
                                        </label>
                                        <input name='campus' id='camp$rows->id' class='form-control' value='$rows->campus'>
                                    </div>
                                </div>
                                <div class='form-row my-2'>
                                    <div class='col'>
                                        <label for='rate$rows->id'>
                                            Rate
                                        </label>
                                        <input name='rate' id='rate$rows->id' class='form-control' value='$rows->rate'>
                                    </div>
                                    <div class='col'>
                                        <label for='dist$rows->id'>
                                            Distance
                                        </label>
                                        <input name='distance' id='dist$rows->id' class='form-control' value='$rows->distance'>
                                    </div>
                                    <div class='col'>
                                        <label for='fac$rows->id'>
                                            Facilities
                                        </label>
                                        <input name='facilities' id='fac$rows->id' class='form-control mb-3' value='$rows->facilities'>
                                        <input type='hidden' name='hostel_id' value='$rows->id'>
                                    </div>
                                </div>
                                <button id='btnAdd_$rows->id' class='btn btn-primary btnUpdateHostel'>
                                    Save
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
                ";
            }
            echo "</table>";
        }
    }elseif($item == "Lessons"){
        if($search !== ""){
            $query = $conn->query("select * from $table where subject like '%$search%' 
            or course_code like '%$search%' or lecturer like '%$search%' or day like 
            '%$search%'");
        }else{
            $query = $conn->query("select * from $table limit 100");
        }
        if($query->num_rows > 0){
            $tbl = <<<TBL
            <div class="alert hide"></div>
            <table class="table table-hover table-bordered table-responsive-md">
            <thead class="thead-light">
                <th>Course</th>
                <th>Venue</th>
                <th>Day</th>
                <th>Start</th>
                <th>End</th>
                <th>Edit</th>
            </thead>
TBL;
            echo($tbl);
            while($rows = $query->fetch_object()){
                echo "
                <tbody>
                    <tr>
                        <td>$rows->subject</td>
                        <td>$rows->venue</td>
                        <td>$rows->day</td>
                        <td>$rows->start</td>
                        <td>$rows->end</td>
                        <td>
                            <button id='Edit$rows->id' class='btn btn-primary btnEdit'>
                                <i class='fa fa-edit'></i>
                            </button>
                        </td>
                    </tr>
                    <tr class='hide' id='rowEdit$rows->id'>
                        <td colspan='6'>
                            <form id='formEdit$rows->id'>
                                <div class='form-row'>
                                    <div class='col'>
                                        <label for='title$rows->id'>
                                            Course title
                                        </label>
                                        <input name='title' class='form-control' id='title$rows->id' value='$rows->subject' disabled>
                                    </div>
                                    <div class='col'>
                                        <label for='ven$rows->id'>
                                            Organizer
                                        </label>
                                        <input name='venue' id='ven$rows->id' class='form-control mb-3' value='$rows->venue'>
                                    </div>
                                </div>
                                <div class='form-row my-2'>
                                    <div class='col'>
                                        <label for='day$rows->id'>
                                            Day
                                        </label>
                                        <input name='day' id='day$rows->id' class='form-control mb-3' value='$rows->day'>
                                    </div>
                                    <div class='col'>
                                        <label for='start$rows->id'>
                                            Start
                                        </label>
                                        <input name='start' id='start$rows->id' class='form-control mb-3' value='$rows->start'>
                                    </div>
                                    <div class='col'>
                                        <label for='end$rows->id'>
                                            End
                                        </label>
                                        <input name='end' id='end$rows->id' class='form-control mb-3' value='$rows->end'>
                                        <input type='hidden' name='id' value='$rows->id'>
                                    </div>
                                </div>
                                <button id='btn_$rows->id' class='btn btn-primary btnUpdate'>
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
                ";
            }
            echo "</table>";
        }
    }else{
        echo "Unknown itme $item. Try again";
    }
}elseif (isset($_REQUEST['course_title'])) {
    $title = isset($_REQUEST['course_title']) ? $_REQUEST['course_title']: "";
    $qry = $conn->query("select * from courses where title = '$title'");
    if($qry->num_rows > 0){
        $row = $qry->fetch_object();
        if($row->status == "core"){
            $option = "Core";
            $other = "Elective";
        }else{
            $option = "Elective";
            $other = "Core";
        }
        
        $form = <<<Love
        <div class="alert hide"></div>
        <form id="editCourse" class="mb-4">        
            <div class="row">
                <div class="col-md-6 my-2">
                    <label for="title">Title</label>
                    <input name="title" id="title" class="input-text" value="$row->title"><br>
                    <label for="code">Course code</label>
                    <input name="code" id="code" class="form-control" value="$row->course_code">
                    <label for="lecturer">Lecturer</label>
                    <input name="lecturer" id="lecturer" class="form-control" value="$row->lecturer"><br>
                    <label for="department">Department</label>
                    <input name="department" id="department" class="form-control" value="$row->department"><br>
                    <label for="academic_year">Academic year</label>
                    <input name="academic_year" id="academic_year" class="form-control" value="$row->academic_year"><br>
                    <label for="trim">Trimester</label>
                    <input name="trimester" id="trimester" class="form-control" value="$row->term"><br>
                </div>
                <div class="col-md-6 my-2">
                    <input type="hidden" name="id" value="$row->id">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="10">$row->description</textarea><br>
                    <label for="status">Course type</label>
                    <select name="status" id="status" class="form-control">
                        <option value="$option">$option</option>
                        <option value="$other">$other</option>
                    </select>
                    <label for="academic_year">Level</label>
                    <input type="number" step="100" min="100" max="700" name="level" id="level" class="form-control" value="$row->level"><br>
                </div>
            </div>
                    <button type="submit" id="btnEdit" class="btn btn-secondary" style="position:absolute;right:20px;bottom:8px;">
                        Update
                    </button>
        </form>
Love;
        echo $form;
    }
}
?>
<script>
$(".btnDefault").click(function(e){
    e.preventDefault();
    id = this.id.split("_")[1];
    console.log(id)
    $("#rowEvent" + id).removeClass("hide");
    $(this).prop("disabled", true)
})
   
$(".btnSave").click(function(e){
    e.preventDefault();
    id = this.id;
    form = $("#form_" + id);
    $.ajax({
        url: "update.php",
        type: "POST",
        dataType: "text",
        data: form.serialize(),
        success: function(response){
            $(".alert").removeClass("hide").addClass("alert-success").html(response);
            $("input." + id).each(function(){
                $(this).addClass("hide");
                $("textarea." + id).prop("disabled", true)
            })
            $(".btnSave").prop("disabled", false)
        }
    });
});

$("#course_title").on('change', function(){
    if($("#course_title").val() !== ""){
        $.ajax({
            url: "data.php",
            type: "POST",
            dataType: "text",
            data: {course_title: $("#course_title").val()},
            success: function(response){
                if(response !== ""){
                    $("#holder").html(response);
                }
            }
        });
    }
});
$("#submitGo").on('click', function(e){
    e.preventDefault();
    if($("#course_title").val() !== ""){
        $.ajax({
            url: "data.php",
            type: "POST",
            dataType: "text",
            data: {course_title: $("#course_title").val()},
            success: function(response){
                if(response !== ""){
                    $("#holder").html(response);
                }
            }
        });
    }
});

$("#editCourse").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "update.php",
        type: "POST",
        dataType: "text",
        data: $(this).serialize(),
        success: function(response){
            if(response !== ""){
                $(".alert").removeClass("hide").addClass("alert-info").html(response);
            }
        },
        fail: function(error){
            $(".alert").removeClass("hide").addClass("alert-info").html(error);
        }
    });
});
$(".btnEdit").on("click", function(){
    id = this.id;
    if(id){
        $(this).prop("disabled", true)
        $("#row" + id).removeClass("hide")
    }
})
$(".btnEdit2").on("click", function(){
    id = this.id.split("_")[1];
    if(id){
        $(this).prop("disabled", true)
        $("#editHostel" + id).removeClass("hide")
    }
})
$(".btnUpdate").click(function(e){
    e.preventDefault();
    btnid = this.id;
    id = btnid.split("_")[1];
    $.ajax({
        url: "editUpdate.php",
        type: "POST",
        dataType: "text",
        data: $("#formEdit" + id).serialize(),
        success: function(responseText){
            $("#row" + id).addClass("hide")
            $(".btnEdit").prop("disabled", false)
            if(responseText == "Update successful"){
                $(".alert").addClass("alert-success").removeClass("hide").text(responseText);
            }else{
                $(".alert").addClass("alert-info").removeClass("hide").text(responseText);
            }
        },
        fail: function(error){
            $(".alert").addClass("alert-danger").removeClass("hide").html(error);
        }
    })
})
$(".btnUpdateHostel").click(function(e){
    e.preventDefault();
    btnid = this.id;
    id = btnid.split("_")[1];
    $.ajax({
        url: "editUpdate.php",
        type: "POST",
        dataType: "text",
        data: $("#hostelForm" + id).serialize(),
        success: function(responseText){
            $("#editHostel" + id).addClass("hide")
            $(".btnEdit2").prop("disabled", false)
            if(responseText == "Update successful"){
                $(".alert").addClass("alert-success").removeClass("hide").text(responseText);
            }else{
                $(".alert").addClass("alert-info").removeClass("hide").text(responseText);
            }
        },
        fail: function(error){
            $(".alert").addClass("alert-danger").removeClass("hide").html(error);
        }
    })
})
</script>