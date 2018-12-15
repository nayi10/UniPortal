<?php
if(session_id() == ''){
    session_start();
}

if(isset($_SESSION['username']) && $_SESSION['username'] != ''){

    echo '<div class="card p-3 mt-5">

        <form action="rate.php" method="post">

            <label for="rating">Rate <i>'.$item_title.'</i></label><br>

            <fieldset class="rating" id="rating">

                <input type="radio" id="star5" name="rating" value="5" />
                <label class = "full" for="star5" title="Awesome"></label>

                <input type="radio" id="star4" name="rating" value="4" />
                <label class = "full" for="star4" title="Very Nice"></label>

                <input type="radio" id="star3" name="rating" value="3" />
                <label class = "full" for="star3" title="Nice"></label>

                <input type="radio" id="star2" name="rating" value="2" />
                <label class = "full" for="star2" title="Not Nice"></label>

                <input type="radio" id="star1" name="rating" value="1" />
                <label class = "full" for="star1" title="Poor"></label>

            </fieldset>
            <div class="hide mt-1" id="rate-div">
                <input type="text" placeholder="Username" value="'.$username.'" class="my-xs-2 input-text" name="rator_name" id="name" required>

                <input type="email" placeholder="Email" value="'.$email.'" class="my-xs-2 input-text" name="rator_email" id="email" required><br>

                <textarea type="text" placeholder="Comment" class="input-text" name="rating_comment" required></textarea>

                <input type="hidden" value="'.isset($user_id).'" name="rator_id">

                <input type="hidden" value="'.$row->id.'" name="item_id">

                <input type="hidden" value="'.$title.'" name="utm_item">

                <input type="hidden" value="'.$page.'" name="page">

                <input type="hidden" value="'.$category.'" name="category">

                <button type="submit" class="btn btn-success" id="rating-btn" name="submit_rating">Submit</button>
            </div>

            <div id="error-rating">
            </div>
        </form></div>';

}
