<script src="js/Chart.js"></script>
<?php
    include_once("User.php");
    include_once("Question.php");
    $user = new User($username);
    $answers = $user->get_answer_count();
    $assign = $user->get_assignment_count();
    $questions = $user->get_question_count();
    $notes = $user->get_note_count();
    $qns_upvotes = $user->get_question_upvotes();
    $ans_upvotes = $user->get_answer_upvotes();
    $qn_downvotes = $user->get_question_downvotes();
    $ans_downvotes = $user->get_answer_downvotes();
?>
<div class="row">
    <input type="hidden" id="val1" value="<?php echo $questions; ?>">
    <input type="hidden" id="val2" value="<?php echo $answers; ?>">
    <input type="hidden" id="val3" value="<?php echo $assign; ?>">
    <input type="hidden" id="val4" value="<?php echo $notes; ?>">
    <div class="col-md-6">
        <canvas id="activityChart" width="400" height="300"></canvas>
    </div>
    <div class="col-md-3">
        <input type="hidden" id="questionsUpvotes" value="<?php echo $qns_upvotes; ?>">
        <input type="hidden" id="answersUpvotes" value="<?php echo $ans_upvotes; ?>">
        <canvas id="upvotesChart" width="180" height="300"></canvas>
    </div>
    <div class="col-md-3">
        <input type="hidden" id="qtnDownvotes" value="<?php echo $qn_downvotes; ?>">
        <input type="hidden" id="ansDownvotes" value="<?php echo $ans_downvotes; ?>">
        <canvas id="downvotesChart" width="180" height="300"></canvas>
    </div>
</div>
<hr><br>
<div class="row">
    <?php
    $res = $user->get_unviewed_chats();
    if($res && $res->num_rows > 0){
        echo "<div class='col-lg col-md-4'>
        <h5 class='card-title mx-2'>Unread conversations</h5>
        <ul class='list-group'>";

        while($rows = $res->fetch_object()){
            $num = $user->get_num_chats($rows->sender);
            $sender = ucwords($rows->sender);
            echo "<li class='list-group-item'>
                <a href='?tab=chat&chatwith=$sender&status=true'>$sender</a>
            <sup class='badge badge-info'>$num</sup></li>";
        }
        echo("</ul></div><hr>");
    }

    $qry = $user->get_assignments();
    if($qry && $qry->num_rows > 0 && $_SESSION['user_type'] == "Normal"){
        echo "<div class='col-lg col-md-4'>
        <h5 class='card-title mx-2'>Assignments to do</h5>
        <ul class='list-group'>";
        while($row = $qry->fetch_object()){
            $d = new DateTime($row->submit_date);
            $date_ = $d->format("d-m-Y");
            $q = ucfirst(substr($row->question, 0, 50));
            echo "<li class='list-group-item d-flex'>
                <span class='mr-5'>$q</span>
                <span class=''>$row->course</span>
                <span class='float-right'>
                    <span class='mx-4'>$date_</span>
                    <a href='?tab=assignments'>View</a>
                </span>
                </li>";
        }
        echo("</ul></div><hr>");
    }
    ?>
</div>

<div class="row mt-5">
    <?php include_once("footer.php");?>
</div>
<script>
var ctx = document.getElementById("activityChart").getContext('2d');
let val1 = document.getElementById("val1").value;
let val2 = document.getElementById("val2").value;
let val3 = document.getElementById("val3").value;
let val4 = document.getElementById("val4").value;
var vcharts = document.getElementById("upvotesChart").getContext('2d');
var dvcharts = document.getElementById("downvotesChart").getContext('2d');
let upvotes1 = document.getElementById("questionsUpvotes").value;
let upvotes2 = document.getElementById("answersUpvotes").value;
let downvotes1 = document.getElementById("qtnDownvotes").value;
let downvotes2 = document.getElementById("ansDownvotes").value;
console.log("Q Upv: " + upvotes1 + " Ans: " + upvotes2)
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Questions", "Answers", "Notes", "Assignments"],
        datasets: [{
            label: 'Your usage activities',
            data: [val1, val2, val4, val3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var upvotesChart = new Chart(vcharts, {
    type: 'bar',
    data: {
        labels: ["Upvotes", "Downvotes"],
        datasets: [{
            label: 'Questions Statistics',
            data: [upvotes1, downvotes1],
            backgroundColor: [
                'teal',
                'green'
            ],
            borderColor: [
                'teal',
                'green'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var downvotesChart = new Chart(dvcharts, {
    type: 'bar',
    data: {
        labels: ["Upvotes", "Downvotes"],
        datasets: [{
            label: 'Answer Statistics',
            data: [upvotes2, downvotes2],
            backgroundColor: [
                'red',
                '#ff5555'
            ],
            borderColor: [
                'red',
                '#ff5555'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>