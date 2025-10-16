<?php 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$title = "Current Location";
$page = "location.php";

require_once '../assets/template/inc.header.php';
?>

<div class="card card-style">
    <div class="card-body leave">
        <h5 class="card-title">CURRENT LOCATION</h5>
        <hr>
        <body onLoad="getLocation()">
            <iframe id="map" width="100%" height="200" frameborder="0" style="border:0; background-color: white;" allowfullscreen></iframe>
        </body>
    </div>
</div>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
            alert("Geolocation is not supported by this browser.");
        }
    }
    
    function showPosition(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        var mapSrc = "https://maps.google.com/maps?q=" + lat + "," + lon + "&z=17&output=embed";
        document.getElementById("map").src = mapSrc;
    }
</script>

<?php require_once '../assets/template/inc.footer.php'; ?>

