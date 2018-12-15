<?php

$result = $db_connect->query("SELECT COUNT(id) AS rows, AVG(rating_val) as rating FROM item_rating
                WHERE item_id = $item_id");

$r = $result->num_rows;

$rows = $result->fetch_assoc();

$rate = round($rows['rating']);

$n_rows = $rows['rows'];

if($n_rows == 1){
    $reviews = $n_rows." review";
}else{
     $reviews = $n_rows." reviews";
}

switch($rate){

    case 1: echo "<span class='text-sm' title='1 Star($reviews)'>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star-o'></i>
                <i class='fa fa-star-o'></i>
                <i class='fa fa-star-o'></i>
                <i class='fa fa-star-o'></i>
                <i class='pl-1'>($n_rows)</i>"
            . "</span>";
    break;

    case 2: echo "<span class='text-sm' title='2 Stars($reviews)'>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star-o'></i>
                <i class='fa fa-star-o'></i>
                <i class='fa fa-star-o'></i>
                 <i class='pl-1'>($n_rows)</i>
                </span>";
    break;

    case 3: echo "<span class='text-sm' title='3 Stars($reviews)'>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star-o'></i>
                <i class='fa fa-star-o'></i>
                 <i class='pl-1'>($n_rows)</i>
                </span>";
    break;

    case 4: echo "<span class='text-sm' title='4 Stars($reviews)'>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star-o'></i>
                 <i class='pl-1'>($n_rows)</i>
                </span>";
    break;

    case 5: echo "<span class='text-sm' title='5 Stars($reviews)'>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star text-orange'></i>
                <i class='fa fa-star text-orange'></i>
                 <i class='pl-1'>($n_rows)</i>
                </span>";
    break;

    default: echo "<span class='text-sm' title='Not rated'>
                <i class='fa fa-star-o'></i>
                <i class='fa fa-star-o'></i>
                <i class='fa fa-star-o'></i>
                <i class='fa fa-star-o'></i>
                <i class='fa fa-star-o'></i>
                </span>";

}
