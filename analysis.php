<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="input-group mt-2 ml-3">
            <div class="custom-control custom-radio mr-3">
                <input type="radio" name="year" value="2019" id="2019" class="custom-control-input"/>
                <label class='custom-control-label' for="2019">This year</label>
            </div>
            <div class="custom-control custom-radio mr-3">
                <input type="radio" name="year" value="2018" id="2018" class="custom-control-input"/>
                <label class='custom-control-label' for="2018">Last year</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" name="year" value="all" id="all" class="custom-control-input"/>
                <label class='custom-control-label' for="all">All time</label>
            </div>
        </div><hr>
        <canvas id="usersChart" width="400" height="150"></canvas>
    </div>
</div><hr>
<div class="row mx-2">
    <div class="col-md-6">
        <canvas id="questionsChart" width="180" height="150"></canvas>
    </div>
    <div class="col-md-6">
        <canvas id="answersChart" width="180" height="150"></canvas>
    </div>
</div>
<hr>
<script src="js/Chart.js"></script>
<script>
function sendRequest(year){
    yr = year !== "" || year !== null ? year: "2019";
    $.ajax({
        url: "apis.php",
        type: "POST",
        data: {year: yr},
        success: function(response){
            json = JSON.parse(response);
            var ctx = document.getElementById("usersChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: json.labels,
                    datasets: [{
                        label: "Registered users for " + json.datasets.year,
                        data:  json.datasets.users,
                        backgroundColor: "rgba(0, 0, 230, 0.3)",
                        fillColor: "rgba(10, 20, 230, 0.6)",
                        strokeColor: "rgba(120, 201, 255, 0.4)",
                        pointColor: "#00f", 
                        pointStrokeColor: "#fff", 
                        pointHighlightFill: "#fff", 
                        pointHighlightStroke: "rgba(10,10,220, 0.4)",
                        borderColor: "rgba(25, 10, 255, 0.5)"
                    }]
                }
            });
            var cts = document.getElementById("questionsChart").getContext('2d');
            var lineChart = new Chart(cts, {
                type: "line",
                data: {
                    labels: json.labels,
                    datasets: [{
                        label: "All questions - " + json.datasets.year,
                        data:  json.datasets.questions,
                        fillColor: "rgba(10, 230, 20, 0.6)",
                        strokeColor: "rgba(120, 201, 255, 0.4)",
                        pointColor: "#00f", 
                        pointStrokeColor: "#fff", 
                        pointHighlightFill: "#fff", 
                        pointHighlightStroke: "rgba(10,10,220, 0.4)",
                        borderColor: "teal"
                    }]
                }
            });
            var chart = document.getElementById("answersChart").getContext('2d');
            var lineChart = new Chart(chart, {
                type: "line",
                data: {
                    labels: json.labels,
                    datasets: [{
                        label: "All answers - " + json.datasets.year,
                        data:  json.datasets.answers,
                        fillColor: "rgba(10, 230, 20, 0.6)",
                        strokeColor: "rgba(120, 201, 255, 0.4)",
                        pointColor: "#00f", 
                        pointStrokeColor: "#fff", 
                        pointHighlightFill: "#fff", 
                        pointHighlightStroke: "rgba(10,10,220, 0.4)",
                        borderColor: "orange"
                    }]
                }
            });
        }
    })
}
sendRequest("");
$("input:radio").each(function(){
    $(this).on("input", function(){
        var val = $(this).val();
        sendRequest(val)
    })
})
// var downvotesChart = new Chart(dvcharts, {
//     type: 'bar',
//     data: {
//         labels: ["Upvotes", "Downvotes"],
//         datasets: [{
//             label: 'Answer Statistics',
//             data: [upvotes2, downvotes2],
//             backgroundColor: [
//                 'red',
//                 '#ff5555'
//             ],
//             borderColor: [
//                 'red',
//                 '#ff5555'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero:true
//                 }
//             }]
//         }
//     }
// });
</script>