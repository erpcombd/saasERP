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

<div class="card card-style" style="margin-bottom: 0;">
    <div class="card-body leave p-0">
        <h5 class="card-title p-3 m-0">CURRENT LOCATION</h5>
        <hr class="m-0">
        <div id="map-container" style="width: 100%; position: relative;">
            <iframe id="map" width="100%" frameborder="0" style="border:0; background-color: white; " allowfullscreen></iframe>
        </div>
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
    
    // Function to make the map full page
    function setFullPageMap() {
        // Calculate available height (viewport height minus header)
        const headerHeight = document.querySelector('.card-title').offsetHeight + 1; // +1 for the hr
        const windowHeight = window.innerHeight;
        const availableHeight = windowHeight - headerHeight - 50; // Subtract some extra padding
        
        // Set the map container and iframe height
        document.getElementById("map-container").style.height = availableHeight + 'px';
        document.getElementById("map").style.height = '100%';
    }
    
    // Initialize location and map size when the page loads
    window.onload = function() {
        getLocation();
        setFullPageMap();
    }
    
    // Adjust map size when window is resized
    window.addEventListener('resize', setFullPageMap);
</script>

<?php require_once '../assets/template/inc.footer.php'; ?>