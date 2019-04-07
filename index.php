<!DOCTYPE html>
<?php
include_once 'User.php';
include_once 'header.php';
include_once("Event.php");
include_once("Hostel.php");
?>
    <?php
        if(!is_session("username")){ ?>
    <div id="image-header" class="mb-2">
            <p class="text-center"><br><br>
                You're missing a lot because you have not logged in. You can only
                browse questions, view answers and hostel information if you
                don't login.<br>

                Login to be able to View Ongoing Lectures, browse and save your favorite books,
                save your notes for future reference, view assignments, <br>ask and get your questions answered,
                and much more.
            <div class="text-center">
                <a href="login.php" class="btn btn-info">Click to login</a>
            </div>
            </p><br>
        </div>
            <?php } 
            $hostels = new Hostel();
            $query = $hostels->get_random_hostels();
            ?>

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-lg-3">
            <?php if($query->num_rows > 0){ ?>
            <h2 class="text-md mt-2 text-dark-grey text-center border-bottom pb-2">
                    Featured Hostels</h2>
            <div id="slides" class="card">
                <?php while($row = $query->fetch_object()){ 
                    $hostels->set_name($row->name);
                    $desc = substr($row->description, 0, 120);
                    $url = urlencode($row->name);
                ?>
                <div class="card">
                    <div class="card-img">
                        <img  src="<?php echo $hostels->get_image();?>" height="200">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row->name;?></h5>
                        <p class="card-text">
                            <?php echo $desc;?>
                        </p>
                        <a href="hostels?name=<?php echo $url;?>" class="btn btn-primary">View Hostel Info</a>
                    </div>
                </div>
            <?php } ?>
            </div>
                <?php } ?>
        </div>
        <div class="col-md-8 col-lg-6">
            <form class="search-form">
                <div class="input-group">
                    <input name='search' type="search" class="form-control" 
                    oninput="sendData(this.value, $('#table').val())" placeholder='Search'>
                    <div class="input-group-append">
                        <select name='table' class='custom-select' id="table">
                            <option value="questions">Questions</option>
                            <option value="answers">Answers</option>
                        </select>
                    </div>
                </div>
            </form>
                <hr>
                <div id="results"></div>
            <?php 
                $events = new NewEvent();
                $res = $events->get_events(7);
                if($res && $res->num_rows > 0){
            ?>
            <h1 class="text-center">Upcoming Events</h1>
                <?php while($row = $res->fetch_object()){
                        $img = $events->get_image($row->title);
                        $desc = substr($row->description, 0, 100);
                        $url = urlencode($row->title);
                        $result = <<<ML
                        <div class="card mb-4">
                            <div class="row">
                                <div class='col-md-4'>
                                <img src="$img" class="img-round">
                                </div>
                                <div class="col-md-8 px-4">
                                    <h4 class="card-title mt-2">$row->title</h4>
                                    <p class="card-text home">$desc... 
                                        <a class="card-link text-sm" href="events.php?title=$url">
                                        More details...
                                        </a>
                                    </p>
                                    <span class="text-special text-green">
                                        <span class="fa fa-map-marker"> $row->location</span>
                                        <span class="fa fa-calendar mx-2"> $row->start_date</span>
                                        <span class="fa fa-clock-o"> $row->time</span>
                                    </span>
                                </div>
                            </div>
                        </div>
ML;
                        echo $result;
                    }
                }
                include_once("Question.php");
                include_once("Lesson.php");
                $lessons = new Lessons();
                $results = $lessons->get_todays_lessons(5);
                $questions = new Question();
                $res = $questions->get_questions(5);
                if($res && $res->num_rows > 0){
            ?>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card round-top">
                    <h1 class="card-header">
                        Recent Questions
                        <i class="fa fa-angle-double-right text-md text-gray"></i>
                    </h1>
                    <ul class="list-group list-group-flush">
                        <?php while($rows = $res->fetch_object()){
                            $url = urlencode($rows->question);
                            echo "<li class='list-group-item'>
                                <a href='questions/?question=$url' class='list-group-link text-sm'>$rows->question</a>
                            </li>";
                        }
                    } ?>
                        <li class="list-group-item">
                            <a href="questions/" class="text-center text-sm p-2 text-blue">
                                More Questions <i class="fa fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card round-top mt-2">
                    <h1 class="card-header">
                        Todays Classes
                    </h1>
                    <?php if($results && $results->num_rows > 0){?>
                    <ul class="list-group list-group-flush">
                        <?php while($rw = $results->fetch_object()){
                            echo "<li class='list-group-item'>
                                <span class='px-1'>$rw->subject</span>
                            </li>";
                        }
                    }else{
                        echo "<li class='list-group-item'>No lessons available today</li>";
                    } ?>  
                        <li class="list-group-item">
                            <a href="lessons/">View more...</a>
                        </li>
                    </ul>
                </div>
                <div class="card round-top mt-2">
                    <h1 class="card-header">
                        Frequently Asked Questions
                    </h1>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Cras justo odio</li>
                        <li class="list-group-item">
                            <span>How do I register for the trim?</span>
                        </li>
                        <li class="list-group-item">
                            <span>Does campus chill?</span>
                        </li>
                        <li class="list-group-item">
                            <span>Do you usually enjoy your lectures?</span>
                        </li>
                        <li class="list-group-item">
                            <span>Do you think UDS is the best?</span>
                        </li>
                        <li class="list-group-item">
                            <span>How many games has UDS won?</span>
                        </li>
                        <li class="list-group-item">
                            <span>Do you usually enjoy your school?</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
    <script>
    //Sends the form data to the server using Ajax GET
        function sendData(str, table){
            if(table == ""){
                table = "questions";
            }

            if(str == ""){
                document.getElementById("results").innerHTML = "";
            }
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("results").innerHTML = this.responseText;
            }
        };

        xhttp.open('GET', "search.php?search=" + str + "&table=" + table, true);
        xhttp.send();
    }

    </script>
</html>
