<?php
include_once 'Hostel.php';
include_once 'header.php';

if(isset($_GET['name']) && $_GET['name'] !== ""){
    $name = strip_tags($_GET['name']);
    $hostel = new Hostel($name);
    $rate = $hostel->get_rate();
    $image = $hostel->get_image();
    $campus = $hostel->get_campus();
    $contact = $hostel->get_contact();
    $distance = $hostel->get_distance();
    $added_on  = new DateTime($hostel->get_date_added());
    $facilities = $hostel->get_facilities();
    $desc = nl2br($hostel->get_description());
    $date = $added_on->format("dS M Y, H:i:sa");
    $text = <<<LT
    <img src='$image' style='margin-top:-5px;width:100%;height:340px;'>
    <h1 class='overlay img-text'>All About $name That you need to know</h1>
    <div class="container mt-3">
        <ul class="nav nav-tabs" id="navTab">
            <li class="nav-item">
                <a class="nav-link active" id="desc-tab" data-toggle="tab" 
                href="#desc" role="tab" aria-controls="description">Description</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="more-tab" data-toggle="tab" 
                href="#more" role="tab" aria-controls="more">More</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" 
                href="#contact" role="tab" aria-controls="contact">Contact</a>
            </li>
        </ul>
        <div class="tab-content card p-5" id="navTabContent">
            <div class="tab-pane fade show active" id="desc" 
            role="tabpanel" aria-labelledby="desc-tab">
                $desc
            </div>
            <div class="tab-pane fade show card p-2 border-0" id="more" 
            role="tabpanel" aria-labelledby="more-tab">
                <h2 class="card-title">$name</h2>
                <p class="mx-3"><i class="fa fa-map-marker text-green p-2"></i> 
                    Campus: $campus
                </p>
                <p class="mx-3"><i class="fa fa-road text-orange p-1 pr-2"></i> 
                    Distance from campus: About <small>$distance meters</small>
                </p>
                <p class="mx-3"><i class="fa fa-trophy text-blue p-2"></i> 
                    Facilities available: <small>$facilities</small>
                </p>
                <p class="mx-3"><i class="fa fa-clock-o text-green p-2"></i> 
                    This hostel was added on <small>$date</small>
                </p>
            </div>
            <div class="tab-pane fade show" id="contact" 
            role="tabpanel" aria-labelledby="contact-tab">
                <span>
                    <i class="fa fa-phone-square p-2 text-lg text-green"></i> 
                    Call <a href="tel:$contact">$contact</a> for more information
                </span>
            </div>
        </div>
    </div>
LT;
    echo $text;
}else{
    $hostels = new Hostel();
    $query = $hostels->get_hostels_name_campus();
    ?>
    <div class="container-fluid">
        <h1 class="text-lg text-center my-2">Browse campus hostels</h1>
        <?php
        if($query && $query->num_rows > 0){
        ?>
        <div class="row">
            <?php while($rows = $query->fetch_object()){ 
                $hostels->set_name($rows->name);
                $hostels->set_date_added($rows->added_on);  
                $url = urlencode($rows->name);  
            ?>
            <div class="col-md-3">
                <div class="card rounded p-2">
                    <img src="<?php echo $hostels->get_image(); ?>" height="300" class="event img">
                    <h2 class="header overlay text-center"><?php echo $rows->name;?></h2>
                    <p class="center overlay text-center">
                        <a href="hostels?name=<?php echo $url;?>" class="btn btn-translucent">
                        <i class="fa fa-ellipsis-v icon-circle"></i> More details</a>
                    </p>
                    <div class="img-overlay text-center">
                        <span class="mx-2">
                            <i class="fa fa-map-marker text-green"></i> <?php echo $rows->campus;?>
                        </span>
                        <span class="mx-2 float-right">
                            <i class="fa fa-eye text-orange"></i> Views
                        </span>
                    </div>
                </div>
            </div>
            <?php 
            }
        }else{ ?>
        <h1 class="text-center my-5">No hostels available at the moment</h1>
        </div>
    </div>
    <?php }} ?>