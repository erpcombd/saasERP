//create a geocoder object to use the geocode

var data;

//Ajax Call for the assign product up form 
//Once the form is submitted
$("#signupform").submit(function(event){
    //hide message
    $("#signupmessage").hide();
    //show spinner
    $("#spinner").css("display", "block");
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to signup.php using AJAX
    $.ajax({
        url: "asset_manage.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#signupmessage").html(data);
                //hide spinner
                $("#spinner").css("display", "none");
                //show message
                $("#signupmessage").slideDown();
            }
        },
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            //hide spinner
            $("#spinner").css("display", "none");
            //show message
            $("#signupmessage").slideDown();
            
        }
    
    });

});



//Ajax Call for the Recevied product up form 
//Once the form is submitted
$("#receivedform").submit(function(event){
    //hide message
    $("#signupmessage").hide();
    //show spinner
    $("#spinner").css("display", "block");
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to signup.php using AJAX
    $.ajax({
        url: "asset_received.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#signupmessage").html(data);
                //hide spinner
                $("#spinner").css("display", "none");
                //show message
                $("#signupmessage").slideDown();
            }
        },
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            //hide spinner
            $("#spinner").css("display", "none");
            //show message
            $("#signupmessage").slideDown();
            
        }
    
    });

});



//Ajax Call for the Recevied product up form 
//Once the form is submitted
$("#purchase").submit(function(event){
    //hide message
    $("#signupmessage").hide();
    //show spinner
    $("#spinner").css("display", "block");
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
//    console.log(datatopost);
    //send them to signup.php using AJAX
    $.ajax({
        url: "local_purchase_input.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data){
                $("#signupmessage").html(data);
                //hide spinner
                $("#spinner").css("display", "none");
                //show message
                $("#signupmessage").slideDown();
            }
        },
        error: function(){
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            //hide spinner
            $("#spinner").css("display", "none");
            //show message
            $("#signupmessage").slideDown();
            
        }
    
    });

});

