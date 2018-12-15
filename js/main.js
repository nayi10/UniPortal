jQuery(document).ready(function(){

        jQuery("#rating").on("change", function(){

            jQuery("#rate-div").removeClass("hide");

        })

    $("#sort-btn").on("click", function(){

        $("#post_title").sort();

    })

    $("#user_toggle").on('click', function(){
        
        var id = document.getElementById("lecturer_id");
        
        if(id.classList.contains("hide")){
            $("#label_tutor").removeClass("hide")
            $("#label_user").addClass("hide");
            $("#lecturer_id").removeClass("hide");
            $("#student_id").addClass("hide");
        }else{
            $("#label_user").removeClass("hide");
            $("#label_tutor").addClass("hide");
            $("#lecturer_id").addClass("hide");
            $("#student_id").removeClass("hide");
        }
        
    })
    $(function (){
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'focus hover click',
            html: true,
            selector: 'id'
        })
    })

    $('.tooltip-dismiss').tooltip({
        trigger: 'focus'
    })

    var heading = $("h1:first").text();

    var title = $('title');

    var meta = $('#meta-info').text();

    title.text(heading)

    if(meta !== ""){
       meta_tag =  $("<meta name='description' content='" + meta + "'>");

       meta_tag.appendTo("head");
    }

    $("#select_campus").on("change", function(){
        document.location.reload();
    })
    
    $(function () {
        $('[data-toggle="popover"]').popover({
            html:true,
            trigger: 'click'
        })
    })

    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            html:true,
            trigger: 'hover focus click'
        })
    })

    $('#message').trumbowyg();
    
    $("#btn-sort").on('click',function(){
        sort = document.getElementById("toggle-sort");
        if(sort.classList.contains("hide")){
            
            $("#toggle-sort").removeClass("hide")
        }else{
            $("#toggle-sort").addClass("hide")
        }
    });
    
    $("#toggler").on('click', function(){
        var loader = document.getElementById("loader");
        if(loader.classList.contains("hide")){
            $("#loader").load("note.php").removeClass("hide");
            
            $("#message").trumbowyg();
            
        }else{
            $("#loader").addClass("hide");
        }
    });
    
    jQuery("#addto_cart").on("change input", function(){

        var val = jQuery(this).val();

        var price = jQuery('#price').val();

        if(val >= 1){

            var total_price = price * val;

            jQuery('#total').removeClass('hide')

            jQuery('#total').text("Total: GHS" + total_price);

        } else{

            jQuery(this).addClass('error');

            jQuery("#total").html("<small class='text-red'>NOTE: Price must be a number and greater than 0</small>");
        }

         jQuery(this).removeClass("error");
    })


    jQuery('#register-for-account').on('click', function(){

            jQuery('.checkout-user-details').slideToggle();


    })

    
    $('#confirm-delete').on('change click', function(){

        $('#hide').removeClass('hide');
    })

    $('delete-account').ajaxForm();

    $('delete-account').submit(function(){

        $(this).ajaxSubmit();

        return false;
    });

})
/*
var page = window.scrollBy(0, window.innerHeight);

function scrollToTop() {

    var device = window.innerHeight;

    if(window.scrollTop() > device){
        window.scrollTo(0, 0);
    }
  }
  */
 
 function sendData(str){
    if(str == ""){
        document.getElementById("results").innerHTML = "";
    }
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            document.getElementById("results").innerHTML = this.responseText;
        }
    };

    xhttp.open('GET', "search.php?search=" + str, true);
    xhttp.send();
    }