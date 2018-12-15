<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
include_once 'User.php';
include_once 'header.php';
?>
    <?php
        if(!is_session("student_id")){ ?>
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
            <?php } ?>

    <div class="container-fluid homepage"><br><br>
        <div id="loader" class="card hide"></div>
        <div class="row">
            <div class="col-lg-3 hide-md card">
                <h2 class="text-md mt-2 text-dark-grey text-center border-bottom pb-2">
                    Featured Hostels
                </h2>
                <div class='carousel slide carousel-fade' id="carousel-slides" data-ride='carousel'>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="carousel-img" src="images/computer.jpg">
                            <div class="carousel-caption">
                                <p>The comfort of being a student</p>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img class="carousel-img img-round" src="images/bedroom.jpg">
                            <div class="carousel-caption d-block">
                                <p>Exclusive Interactive Events</p>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img class="carousel-img img-round" src="images/bedroom-interior-design.jpg">
                            <div class="carousel-caption d-block">
                                <p>Relevant Tutorials To Discover</p>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img class="carousel-img img-round" src="images/apple.jpg">
                            <div class="carousel-caption">
                                <p>More On The Way To Come</p>

                            </div>
                        </div>
                    </div>
                        <a class="carousel-control-prev" href="#carousel-slides" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="carousel-control-next" href="#carousel-slides" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                          </a>
                    </div>
            </div>
            <div class="col-md-8 col-lg-6">
                <div class="search-container">
                  <form class="search-form">
                      <input name='search' type="search" oninput="sendData(this.value, $('#table').val())" placeholder='Search questions' class='inline'>
                      <select name='table' class='inline' id="table">
                            <option value="questions">Questions</option>
                            <option value="hostels">Hostels</option>
                            <option value="lectures">Lectures</option>
                            <option value="answers">Answers</option>
                      </select>
                  </form>
                </div><hr>
                  <div id="results">

                  </div>
            <h1 class="text-center">Upcoming Events & Seminars</h1>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card round-top">
                    <h1 class="card-title text-center text-md mb-0">
                        Recent Questions
                        <i class="fa fa-angle-double-right text-md text-gray"></i></h1>
                    <a href="questions.php">
                        <li class="preformatted" style="margin-top: 0">How do pay my fees online</li></a>
                    <a href="#">
                        <li class="preformatted">How are we going to demonstrate?</li>
                    </a>
                    <a href="questions.php">
                        <li class="preformatted" style="margin-top: 0">How do pay my fees online</li></a>
                    <a href="#">
                        <li class="preformatted">How are we going to demonstrate?</li>
                    </a>
                    <a href="questions.php" class="text-center text-sm p-2 text-blue">
                        More Questions <i class="fa fa-angle-double-right"></i>
                    </a>
                </div>
                <div class="card-1 mt-2">
                    <h1 class="card-title text-center text-md mb-0 pb-2 border-bottom">
                        Ongoing Classes
                        <i class="fa fa-circle-o text-md text-green"></i>

                    </h1>
                    <li class="preformatted">
                        <span>Linear Algebra</span> - 10:00am - 1:05pm
                    </li>
                    <li class="preformatted">
                        <span>Computer Graphics</span> - 1:00pm - 3:05pm
                    </li>
                    <li class="preformatted">
                        <span>Programming in Java</span> - 7:00am - 9:05am
                    </li>
                </div>
            </div>
        </div>
    </div>
</body>
    <script>
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
                console.log(table)
            }
        };

        xhttp.open('GET', "search.php?search=" + str + "&table=" + table, true);
        xhttp.send();
    }

    </script>
</html>
