<?php
require_once('header.php');
?>
<div class='container'>
    <div id='meta-info' class='hide'>Enroll in upcoming educational events and grow your academic horizons
    </div>
    <br><br>
    <div class='row d'>
        <div class='col-md-10 mx-auto'>
            <div class="card-4 p-3">

            <div class="row">
<?php
$conn = get_connection_handle();
if(isset($_GET['utm_id']) && !empty($_GET['utm_id'])){
    $id = clean_data("utm_id");
    $stmt = $conn->query("select * from events where id = $id");
    $rows = $stmt->num_rows;

    if($rows == 1){

        while($row = $stmt->fetch_object()){

            $filehandle = "files_x64/events/images/".md5($row->title);

            if(file_exists($filehandle.".png")){

                $image = $filehandle.".png";

            }elseif(file_exists($filehandle.".jpg")){

                $image = $filehandle.".jpg";

            }elseif(file_exists($filehandle.".gif")){

                $image = $filehandle.".gif";

            }else{
                $image = "images/default.jpg";
            }

            $content = strip_tags($row->description);
            $title = strip_tags($row->title);

            echo "<div class='col-md-5'>
                    <img src='$image' class='img-round event-img'>
                </div>
            <div class='col-md-7'>
                <h1 class='card-title'>$title</h1>
            <p>$content</p>
        </div>
        <p class='p-2 ml-2'>
            <span class='ml-md-0 mr-sm-2'>
                <i class='fa fa-address-book text-green'></i>
                $row->organizer
            </span>
            <span class='ml-md-5'>
                <i class='fa fa-map-marker text-green'></i>
                $row->location
            </span>
            <span class='ml-md-5 hide-sm'>
                <i class='fa fa-graduation-cap text-green'></i> $row->type
            </span>
            <span class='text-sm ml-5 ml-sm-3'>
            <i class='fa fa-calendar text-brown'></i> $row->start_date
            </span> |

            <span class='text-sm ml-md-4 ml-sm-3'>
                <i class='fa fa-calendar-o text-green'></i> $row->end_date
            </span> |

            <span class='text-sm ml-md-4 ml-sm-2'>
                <i class='fa fa-clock-o text-brown'></i> $row->time
            </span>
        </p><br>";
        }
    }else{
        echo '<h1 class="text-center text-md">We couldn\'t understand your '
        . 'request, please try again</h1>';
    }
    echo "</div></div>";
}else{
    $stmt = $conn->query("select * from events order by id desc limit 15");

    $rows = $stmt->num_rows;

    if($rows > 0){

        while($row = $stmt->fetch_object()){

            $id = strip_tags($row->id);

            $title = urlencode($row->title);

            $point = strpos($row->description, ".");

            if(str_word_count(substr($row->description, 0, $point)) <= 25){
                $content = substr($row->description, 0, $point);
            }elseif(str_word_count(substr($row->description, 0, $point)) <= 35){
                $content = substr($row->description, 0, $point - 100);
            }else{
                $content = trim(substr($row->description,0, 200));
            }

            echo "<div class='row'>
            <div class='col-md-4'>";

            $filehandle = "files_x64/events/images/".md5($row->title);

            if(file_exists($filehandle.".png")){

                $image = $filehandle.".png";

            }elseif(file_exists($filehandle.".jpg")){

                $image = $filehandle.".jpg";

            }elseif(file_exists($filehandle.".gif")){

                $image = $filehandle.".gif";

            }else{
                $image = "images/default.jpg";
            }

            echo "<a href='events.php?utm_id=$id'>
                    <img src='$image' max-height='200px' class='img-round event-img'>
                    </a>
                </div>
                <div class='col-md-8'>
                <p>
                    <span class='ml-md-0 mr-sm-2'>
                        <i class='fa fa-address-book text-green'></i>
                        $row->organizer
                    </span>
                    <span class='ml-md-5'>
                        <i class='fa fa-map-marker text-green'></i>
                        $row->location
                    </span>
                    <span class='ml-md-5 hide-sm'>
                        <i class='fa fa-graduation-cap text-green'></i> $row->type
                    </span>
                </p><hr>
                <div>$content... <a href='events.php?utm_id=$id' class='text-blue text-sm'>More
                    <i class='fa fa-angle-double-right'></i></a>
                </div><hr>
                <p><span class='text-sm ml-0'>
                    <i class='fa fa-calendar text-brown'></i> $row->start_date
                    </span> |

                    <span class='text-sm ml-md-4 ml-sm-3'>
                        <i class='fa fa-calendar-o text-green'></i> $row->end_date
                    </span> |

                    <span class='text-sm ml-md-4 ml-sm-2'>
                        <i class='fa fa-clock-o text-brown'></i> $row->time
                    </span>
                </p>
            </div>
          </div><hr>
        </div>
            <br>";
        }
        echo "</div></div></div>";
    }else{
        echo "<h3 class='text-center'>No events available at the moment.</h3>";

    }
}

echo "</div></div>";

require_once('footer.php');
?>
<script>
     $(window).scroll(function () {
        if ($(window).scrollTop() >= 152) {

            $('.sidebar').addClass('fixed');
            $('.sidebar').css('transition-duration', '0.3s');
            $('.sidebar').css('place-content','end left');

        } else {
            $('.sidebar').removeClass('fixed');

        }

        if((window).scrollTop() >= 250){
            $('.sidebar').removeClass('border-right');
        }else{
            $('.sidebar').addClass('border-right');
        }
    });
</script>
