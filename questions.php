<?php
include_once("header.php");
?>

<div class="container"><br>
    <h1 class="text-adjust text-center">Viewing All Questions</h1>
    <div class="row">
        <div class="col-md-12">
            <?php
                $conn = get_connection_handle();
                $query = $conn->query("select * from questions order by date LIMIT 15");
                echo $conn->error;
                if($query->num_rows > 0){
                    echo "<ul class='ul' style='list-style:none;'>";
                    while($row = $query->fetch_object()){
                        $question = implode("-", explode(" ", $row->question));
                        echo "<li><a href='questions/?question=$question'>$row->question</a>"
                                . "<span class='text-dark'> - Asked on $row->date</span></li>";
                    }
                    echo '</ul>';
                }
            ?>
        </div>
    </div>
</div>
