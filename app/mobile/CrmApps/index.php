<?php

ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

// Specify the target path
$targetPath = '/app/mobile/auth/crmApp/index.php';

// Redirect to the new path
header('Location: ' . $targetPath);
exit();
?>



<script>
        // var x=document.getElementById("demo");
        
        function getLocation(){
            
            if (navigator.geolocation)
            {
            navigator.geolocation.getCurrentPosition(showPosition);
            // }else{x.innerHTML="Geolocation is not supported by this browser.";
                
            }
        }
        
        
        function showPosition(position){
        // x.innerHTML="Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;  
        
        var latitude  = position.coords.latitude;
        var longitude  = position.coords.longitude;
        
        document.getElementById("latitude").value = latitude; 
        document.getElementById("longitude").value = longitude; 
            
        }
        document.body.onload = function(){
        getLocation();
        };
        

</script>
