<?php
include_once('db-connect.php');

if(isset($_POST['submit_rating']) && $_POST['rating'] != '' && !empty($_POST['rator_name'])){

      $page = $_POST['page'];

      $rating = $_POST['rating'];
      $rator_email = stripslashes(strip_tags($_POST['rator_email']));
      $rator_name = strip_tags($_POST['rator_name']);
      $rate_comment = strip_tags(htmlspecialchars($_POST['rating_comment']));
      $rator_id = intval(strip_tags($_POST['rator_id']));
      $item_id = intval(strip_tags($_POST['item_id']));
      $category = $_POST['category'];
      $title = $_POST['utm_item'];
      $pid_std = $item_id;

      $res = $db_connect->query("SELECT * FROM item_rating WHERE rator_id =
      $rator_id AND item_id = $item_id AND item_category = $category");

      if($res && $res->num_rows > 0){

        $err = urlencode("Sorry! You have rated this item already");

        header("Location:$page?category=$category&utm_item=$title&id=$pid_std&error=$err");

      } else{
            $res = $db_connect->query("SELECT * FROM rating_meta WHERE item_id = $item_id ");
            if($res && $res->num_rows == 0){
                  $total_points = 1;
                  $stmt = $db_connect->prepare("INSERT INTO rating_meta(item_id, total_points) VALUES(?,?)");
                  $stmt->bind_param("ii", $item_id, $total_points);
                  $stmt->execute();
                  $r = $stmt->get_result();
            } else{
                  $result = $res->fetch_assoc();
                  $total_points = $result['total_points'] + 1;
                  $r = $db_connect->query("UPDATE rating_meta SET total_points = $total_points");
            }

      $stmt = $db_connect->prepare("INSERT INTO item_rating(item_id,
                  rating_val, rating_comment, rator_id, rator_name, rator_email) VALUES(?,?,?,?,?,?)");

      $stmt->bind_param('idsiss', $item_id,$rating,$rate_comment,$rator_id,$rator_name, $rator_email);
      $stmt->execute();
      $result = $stmt->get_result();
      $rows = $db_connect->affected_rows;

      if($rows == 1){
            $resp = urlencode("Rating done successfully");
            header("Location:$page?category=$category&utm_item=$title&id=$pid_std&msg=$resp");
      }
    }
}
