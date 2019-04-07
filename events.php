<?php
require_once('header.php');
require_once('Event.php');
?>
<div class='container-fluid'>
<?php
$conn = get_connection_handle();
if(isset($_GET['title']) && !empty($_GET['title'])){
    $title = strip_tags($_GET["title"]);
    $event = new NewEvent($title);
    if($event->get_id() > 0){
        $organizer = $event->get_organizer();
        $location = $event->get_location();
        $contact = $event->get_contact();
        $desc = nl2br($event->get_description());
        $event_type = $event->get_type();
        $start_date = $event->get_start_date();
        $end_date = $event->get_end_date();
        $time = $event->get_time();
        $misc = $event->get_misc();
        $added = new DateTime($event->get_added_on());
        $added_on = $added->format("M dS, Y h:i:sa");
        $img = $event->get_image($event->get_title());

        $el = <<<KL
        <h1 class="text-center mb-2">Viewing event - $title</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="card p-2">
                    <img src="$img" height="300" class="card-img rounded">
                    <h2 class="card-title text-center pt-2">$title</h2>
                </div><br>
                <ul class="list-group  mb-md-2">
                    <li class="list-group-item active hover-none">
                        More Details
                    </li>
                    <li class="list-group-item" title="Organizer">
                        <i class="fa fa-institution text-green pr-3"></i> $organizer
                    </li>
                    <li class="list-group-item" title="Event location">
                        <i class="fa fa-map-marker text-green pr-3 pl-1"></i> $location
                    </li>
                    <li class="list-group-item" title="Event type">
                        <i class="fa fa-briefcase text-green pr-3"></i> $event_type
                    </li>
                    <li class="list-group-item" title="Event organizer's contact">
                        <i class="fa fa-phone-square text-green pr-3"></i> $contact
                    </li>
                    <li class="list-group-item" title="Event interval">
                        <i class="fa fa-calendar-o text-green pr-3"></i> $start_date to $end_date
                    </li>
                    <li class="list-group-item" title="Event time">
                        <i class="fa fa-clock-o text-green pr-3"></i> $time
                    </li>
                </ul>
            </div><br>
            <div class="col-md-7">
                <div class="card p-2">
                    <h3 class="card-title pl-4 pt-2" style="font-size:1.4rem;">Event Description</h3>
                    <div class="card-body">
                        <p>$desc</p><hr>
                        <p>
                            <span class="bd-highlight">Posted by $organizer on $added_on</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
KL;
        echo $el;
    }else{
        include_once("404.html");
    }
}else{
    $events = new NewEvent();
    $res = $events->get_events(7);
    if($res && $res->num_rows > 0){
    ?>
    <h1 class="text-center">All Upcoming Events</h1>
    <div class="row">
    <?php while($row = $res->fetch_object()){
    $img = $events->get_image($row->title);
    $desc = substr($row->description, 0, 140);
    $url = urlencode($row->title);
    $result = <<<ML
    <div class="col-md-6 mb-4">
        <div class="card card-hover">
            <div class="row">
                <div class='col-md-4 mb-md-2'>
                    <img src="$img" class="img-round" height="160">
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
    </div>
ML;
    echo $result;
        }
        echo "</div>";
    }
}

echo "</div></div>";

?>
