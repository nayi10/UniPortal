<?php
include("functions.php");
$conn = get_connection_handle();
$months = array("January", "February", "March", "April", "May", "June", "July", 
    "August", "September", "November", "December");
$months_so_far = array();
$sums = array();
$sum = array();
$total = array();
$today = date("Y-m-d");
$unix_last_year = strtotime("$today -1 year");
$last_year = date("Y", $unix_last_year);

if(isset($_REQUEST['year'])){
    if(strftime(date("Y")) == $_REQUEST['year']){
        $date = new DateTime();
        $yr = $date->format("Y");
        $this_month = date("F");
        $index = array_search($this_month, $months);
        for($i = 0; $i < count($months); $i++){
            if($i <= $index){
                $months_so_far[] = $months[$i];
            }
        }
        foreach($months_so_far as $month){
            $query = $conn->query("select count(id) as total from users where 
            DATE_FORMAT(added_on, '%M') = '$month' and DATE_FORMAT(added_on, '%Y') = '$yr'");
            if($query->num_rows > 0){
                $row = $query->fetch_object();
                $sums[] = $row->total;
            }
            $qry = $conn->query("select count(id) as total from questions where 
            DATE_FORMAT(added_on, '%M') = '$month' and DATE_FORMAT(added_on, '%Y') = '$yr'");
            if($qry->num_rows > 0){
                $row = $qry->fetch_object();
                $sum[] = $row->total;
            }
            $q = $conn->query("select count(id) as total from answers where 
            DATE_FORMAT(added_on, '%M') = '$month' and DATE_FORMAT(added_on, '%Y') = '$yr'");
            if($q->num_rows > 0){
                $row = $q->fetch_object();
                $total[] = $row->total;
            }
        }
    }elseif($_REQUEST['year'] == $last_year){
        $yr = $_REQUEST['year'];
        $months_so_far = $months;
        foreach($months_so_far as $month){
            $query = $conn->query("select count(id) as total from users where 
            DATE_FORMAT(added_on, '%M') = '$month' and DATE_FORMAT(added_on, '%Y') = '$yr'");
            if($query->num_rows > 0){
                $row = $query->fetch_object();
                $sums[] = $row->total;
            }

            $qry = $conn->query("select count(id) as total from questions where 
            DATE_FORMAT(added_on, '%M') = '$month' and DATE_FORMAT(added_on, '%Y') = '$yr'");
            if($qry->num_rows > 0){
                $row = $qry->fetch_object();
                $sum[] = $row->total;
            }
            $q = $conn->query("select count(id) as total from answers where 
            DATE_FORMAT(added_on, '%M') = '$month' and DATE_FORMAT(added_on, '%Y') = '$yr'");
            if($q->num_rows > 0){
                $row = $q->fetch_object();
                $total[] = $row->total;
            }
        }
    }else{
        $yr = "all time";
        $query = $conn->query("select distinct DATE_FORMAT(added_on, '%Y') as year from users 
        order by added_on asc");
        $qry = $conn->query("select distinct DATE_FORMAT(added_on, '%Y') as year from  
        questions order by added_on asc");
        if($query->num_rows >= 0 && $qry->num_rows >= 0){
            while($row = $query->fetch_object()){
                $years[] = $row->year;
            }
            $months = $years;
            foreach($years as $year){
                $query = $conn->query("select count(id) as total from users where 
                DATE_FORMAT(added_on, '%Y') = '$year'");
                if($query->num_rows > 0){
                    $row = $query->fetch_object();
                    $sums[] = $row->total;
                }
                $qry = $conn->query("select count(id) as total from questions where 
                DATE_FORMAT(added_on, '%Y') = '$year'");
                if($qry->num_rows > 0){
                    $row = $qry->fetch_object();
                    $sum[] = $row->total;
                }
                $q = $conn->query("select count(id) as total from answers where 
                DATE_FORMAT(added_on, '%Y') = '$year'");
                if($q->num_rows > 0){
                    $row = $q->fetch_object();
                    $total[] = $row->total;
                }
            }
        }
    }
}
$dataset = array('year' => $yr, 'users' => $sums, 'questions' => $sum, 'answers' => $total);
$data = array('labels' => $months, 'datasets' => $dataset);
$json = json_encode($data);
echo $json;