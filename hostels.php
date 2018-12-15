<?php
include_once 'Hostel.php';
include_once 'header.php';
?>
<div class="container">
    <h1 class="text-lg text-center pt-3">Browse campus hostels</h1>
    <div class="row">
        <div class="col-md-10">
            <div class="card-4">
                <button class="btn" id="btn-sort" data-toggle="tooltip"
                        title="<a href='?sort=price'>Price</a><br><a href='?sort=distance'>Distance</a><br>
                         <a href='?sort=rating'>Rating</a><br><a href='?sort=name'>Name</a><br>
                         <a href='?sort=location'>Location</a><br>">
                    <i class="fa fa-sort"></i> Sort</button><br>
                <!--div class="popover" id="popover" role="tooltip">
                    <div class="arrow"></div>
                    <h3 class="popover-header">Sort by</h3>
                    <div class="popover-body">
                         <a href="?sort=price" id="byPrice">Price</a><br><a href="?sort=distance" id="byDistance">Distance</a><br>
                         <a href="?sort=rating" id="byRating">Rating</a><br>
                         <a href="?sort=name" id="byName">Name</a><br>
                         <a href="?sort=location" id="byLocation">Location</a><br>
                    </div>
                </div-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-hover p-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="images/b.jpg" height="200px" class="img-round">
                                </div>
                                <div class="col-md-8 pr-4">
                                    <p style="text-align:justify;">The secretariat by this memo wishes to officially inform all students that the institution is not participating in this year's  NUGS National Delegates Congress(es).
                                    Any participating person or group of persons does so at an individual jurisdiction.
                                    All are thus strictly cautioned not to represent, parade or propagate the name of UDS Navrongo Campus at any such event(s).
                                    Thank you.
                                    </p><hr>
                                    <?php $words = "The secretariat by this memo wishes to officially inform all students that the institution is not participating in this year's  NUGS National Delegates Congress(es).
                                    Any participating person or group of persons does so at an individual jurisdiction.
                                    All are thus strictly cautioned not to represent, parade or propagate the name of UDS Navrongo Campus at any such event(s).
                                    Thank you.";
                                    echo strlen($words);
                                    ?>
                                     <span class="text-dark-grey mx-4"><i class="fa fa-eye"></i> 1204</span>
                                     <?php include_once 'rating.php'; ?>
                                     <button class="btn btn-info">View</button>
                                </div>
                            </div>
                        </div><hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
