<?php
include_once("../../header.php");
include_once("../../User.php");
if(isset($_REQUEST['id'])){
    $note_id = $_REQUEST['id'];
    $username = basename(dirname(__FILE__));
    $user = new User($username);
    $note = $user->get_noteby_link($note_id);
    if($note){
        $desc = nl2br($note->note);
        $no = <<<NOTE
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-md-5 mx-auto">
                    <div class="card-4 mb-3" style="border-top:4px solid orange;">
                        <h1 class='text-teal text-md text-center'>$note->title</h1><hr>
                        <div class="px-3">$desc</div>
                        <div class="card-footer">
                            <small style="color: #999;">This note was added on $note->added_on</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
NOTE;
        echo $no;
    }else{
        include("../../404.html");
    }
}