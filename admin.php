<?php
include_once("header.php");
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $userid = $_SESSION['user_id'];
    $email = $_SESSION['email'];
    $id = $_SESSION['id'];
}else{
    header("Location:/UniPortal");
}
?>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group ml-md-3">
                <li class="list-group-item active hover-none p-2">
                    View...
                </li>
                <a href="admin.php" class="list-group-item list-group-item-actio active-one">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
                <a class="list-group-item list-group-item-action" href="" id="answers">
                        Answers <i class="fa fa-code float-right"></i>
                </a> 
                <a class="list-group-item list-group-item-action" href="">
                        Assignments <i class="fa fa-tasks float-right"></i>
                </a>
                <a class="list-group-item list-group-item-action" href="">
                        Comments <i class="fa fa-comment float-right"></i>
                </a>
                <a class="list-group-item list-group-item-action" href="">
                        Courses <i class="fa fa-graduation-cap float-right"></i>
                </a>
                <a class="list-group-item list-group-item-action" href="">
                        All Events <i class="fa fa-calendar float-right"></i>
                </a>
                <a class="list-group-item list-group-item-action" href="">
                        All Hostels <i class="fa fa-home float-right"></i>
                </a>           
                <a class="list-group-item list-group-item-action" href="">
                        Lessons <i class="fa fa-pencil float-right"></i>
                </a>
                <a class="list-group-item list-group-item-action" href="">
                        Questions <i class="fa fa-question float-right"></i>
                </a>
                <a class="list-group-item list-group-item-action" href="">
                    Registered Courses <i class="fa fa-check float-right"></i>
                </a>
                <a class="list-group-item list-group-item-action" id="users" href="">
                        Users <i class="fa fa-users float-right"></i>
                </a>
            </div>
        </div>
        <div class="col" id="container">
            <ul class="nav nav-tabs" id="navTab">
                <li class="nav-item">
                    <a class="nav-link active" id="desc-tab" data-toggle="tab" 
                    href="#stats" role="tab" aria-controls="description">
                        <i class="fa fa-bar-chart"></i> Analytics
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-plus"></i> New
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-toggle="tab" href="#newEvent" role="tab" 
                        aria-controls="newEvent">Event</a>
                        <a class="dropdown-item" data-toggle="tab" href="#newCourse" role="tab" 
                        aria-controls="newEvent">Course</a>
                        <a class="dropdown-item" data-toggle="tab" href="#newHostel" role="tab" 
                        aria-controls="newEvent">Hostel</a>
                        <a class="dropdown-item" data-toggle="tab" href="#lessons" role="tab" 
                        aria-controls="lessons">Lesson</a>
                        <a class="dropdown-item" data-toggle="tab" href="#newUser" role="tab" 
                        aria-controls="newEvent">User</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="edit-tab" data-toggle="tab" 
                    href="#edit" role="tab" aria-controls="edit">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#delete" role="button" 
                    aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </li>
            </ul>
            <div class="tab-content card" id="navTabContent">
                <div class="tab-pane fade show active" id="stats" 
                role="tabpanel" aria-labelledby="stats-tab">
                    <?php include_once("analysis.php"); ?>
                </div>
                <div class="tab-pane fade show" id="edit" 
                role="tabpanel" aria-labelledby="edit-tab">
                    <?php include_once("edit.html"); ?>
                </div>
                <div class="tab-pane fade show mt-2" id="newEvent" 
                role="tabpanel" aria-labelledby="newEvent-tab">
                    <?php include_once("new-event.html"); ?>
                </div>
                <div class="tab-pane fade show mt-2" id="newUser" role="tabpanel" 
                        aria-labelledby="newUser-tab">
                    <?php include_once("new-user.html"); ?>
                </div>
                <div class="tab-pane fade show mt-2" id="lessons" role="tabpanel" 
                        aria-labelledby="lessons-tab">
                    <?php include_once("new-lesson.html"); ?>
                </div>
                <div class="tab-pane fade show mt-2" id="delete" role="tabpanel" 
                        aria-labelledby="delete-tab">
                    <?php include_once("delete.html"); ?>
                </div>
                <div class="tab-pane fade show mt-2" id="newCourse" 
                role="tabpanel" aria-labelledby="newCourse-tab">
                    <?php include_once("new-course.html"); ?>
                </div>
                <div class="tab-pane fade show mt-2" id="newHostel" 
                role="tabpanel" aria-labelledby="newHostel-tab">
                    <?php include_once("new-hostel.html"); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var elems = $(".list-group-item-action");
    elems.each(function(){
        $(this).click(function(e){
            e.preventDefault();
            if($(this).text().includes("Registered Courses") || $(this).text().includes("All")){
                page = $(this).text().toString().toLowerCase().trim().split(" ").join("-");
            }else{
                page = $(this).text().toString().toLowerCase().trim();
            }
            $("#container").load(page + ".php");
            $(".active-one").removeClass("active-one")
            $(this).addClass("active-one");
        })
    })
</script>