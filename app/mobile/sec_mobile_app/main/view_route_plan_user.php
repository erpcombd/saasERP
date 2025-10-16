<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';
$title = "View Visit Schedule";
$today = date('Y-m-d');
$dayName = date('l');
$company_id = $_SESSION['user']['company_id'];
$menu = 'Visit';
$sub_menu = 'view_visit_schedule';


$google_api = find1("select map_api from ss_config where id=1");

if (isset($_SESSION['user']['username'])) {
     $sql = 'select * from ss_schedule where PBI_ID="' . $_SESSION['user']['username'] . '" and date="' . $today  . '"  and day_name="' . $dayName . '"';
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_object($query);

    $sql2 = 'select * from ss_shop where route_id="' . $row->route_id . '"';
    $query2 = mysqli_query($conn, $sql2);

    $locations = array();
    $shop_name = array();
    while ($row = mysqli_fetch_object($query2)) {
        $latitude = $row->latitude;
        $longitude = $row->longitude;
        $shopName = $row->shop_name;
        $locations[] = "{lat: $latitude, lng: $longitude}";
        $shop_name[] = $shopName;
    }
}

require_once '../assets/template/inc.header.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <style>
                #map {
                    height: 100vh;
                    width: 100%;
                }
            </style>

            <div id="map"></div>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlikB8yJL0j_2j_ofL0xIHR6WkmAWYBN8&callback=initMap" async defer></script>

            <script>
                <?php if (isset($_SESSION['user']['username'])): ?>
                function initMap() {
                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 7,
                        center: <?php echo $locations[0]; ?> // Center the map somewhere
                    });

                    var image = {
                        url: 'shop.png',
                        scaledSize: new google.maps.Size(40, 40),
                        labelOrigin: new google.maps.Point(20, -10) // Size of the icon
                    };

                    var imageuser = {
                        url: 'usericon.png',
                        scaledSize: new google.maps.Size(40, 40),
                        labelOrigin: new google.maps.Point(20, -10) // Size of the icon
                    };

                    // Add markers for each location
                    <?php foreach ($locations as $index => $location): ?>
                    new google.maps.Marker({
                        position: <?php echo $location; ?>,
                        map: map,
                        icon: image,
                        label: {
                            fontSize: "8pt",
                            text: '<?php echo $shop_name[$index]; ?>',
                        }
                    });
                    <?php endforeach; ?>

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function (position) {
                            const pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };

                            // Add a marker for the current position
                            new google.maps.Marker({
                                position: pos,
                                map: map,
                                icon: imageuser,
                                title: "Your Location"
                            });

                            map.setCenter(pos);
                        }, function () {
                            handleLocationError(true, map.getCenter());
                        });
                    } else {
                        // Browser doesn't support Geolocation
                        handleLocationError(false, map.getCenter());
                    }

                    // Create a DirectionsService object
                    const directionsService = new google.maps.DirectionsService();

                    // Create a DirectionsRenderer object
                    const directionsRenderer = new google.maps.DirectionsRenderer({
                        map: map,
                        polylineOptions: {
                            strokeColor: 'green', // Set the color of the polyline to green
                        },
                        suppressMarkers: true
                    });

                    // Create a waypoints array for the directions
                    let waypoints = [];
                    <?php foreach ($locations as $location): ?>
                    waypoints.push({
                        location: <?php echo $location; ?>,
                        stopover: true
                    });
                    <?php endforeach; ?>

                    // Request directions from Google Maps Directions Service
                    directionsService.route({
                        origin: waypoints[0].location,
                        destination: waypoints[waypoints.length - 1].location,
                        waypoints: waypoints.slice(1, waypoints.length - 1),
                        travelMode: google.maps.TravelMode.DRIVING,
                    }, function (response, status) {
                        if (status === 'OK') {
                            directionsRenderer.setDirections(response);
                        } else {
                            window.alert('Directions request failed due to ' + status);
                        }
                    });
                }

                function handleLocationError(browserHasGeolocation, pos) {
                    window.alert(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
                }
                <?php endif; ?>
            </script>
        </div>
    </section>
</div>

<? require_once '../assets/template/inc.footer.php'; ?>