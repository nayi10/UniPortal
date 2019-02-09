<?php
include_once("../../header.php");

$conn = get_connection_handle();
$query = $conn->query("select distinct tags from questions");
echo "<div class='container mt-5'>";
if($query && $query->num_rows > 0){
    while($row = $query->fetch_object()){
        $tags = explode(",", $row->tags);
        foreach($tags as $tag){
          echo "<a class='mx-2' href='$tag/'>
                <span class='tag'>$tag</span>
          </a>";
        }
    }
}else {
  echo "<h1 class='text-center'>No tags are available yet</h1>";
}
 ?>
</div>
