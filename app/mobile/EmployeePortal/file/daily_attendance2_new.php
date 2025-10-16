<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

// Configuration Constants
define('MAX_ATTENDANCE_DISTANCE', 500);
define('OFFICE_LATITUDE', 23.840419931321687);
define('OFFICE_LONGITUDE', 90.3656383041611);
define('GOOGLE_MAPS_API_KEY', 'AIzaSyAKYGY2-qCVcd9EdlPJCcSvawTOReYGJew&latlng');

$title = "Daily Attendance";
$page = "daily_attendance2.php";

require_once '../assets/template/inc.header.php';

date_default_timezone_set('Asia/Dhaka');
$current_datetime = date("Y-m-d H:i:s");

$u_id = $_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management', 'PBI_ID', 'user_id='.$u_id);

$msg = '';
$msg2 = '';

if(isset($_POST['submitit'])){
    if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){
        $distance = haversineDistance(
            $_POST['latitude'], 
            $_POST['longitude'], 
            OFFICE_LATITUDE, 
            OFFICE_LONGITUDE
        );

        if($distance <= MAX_ATTENDANCE_DISTANCE){
            $current_time = date('H:i:s');
            $query = 'INSERT INTO hrm_attdump (
                `ztime`, `bizid`, `EMP_CODE`, `xenrollid`, `time`, `xtime`, 
                `xdate`, `xlocationid`, `latitude`, `longitude`, 
                `schedule_notes`, `sch_latitude_point`, `sch_longitude_point`
            ) VALUES (
                "'.$current_datetime.'", 
                "'.$PBI_ID.'", 
                "'.$PBI_ID.'", 
                "'.$PBI_ID.'", 
                "'.$current_time.'", 
                "'.$current_datetime.'", 
                "'.date('Y-m-d').'", 
                "999", 
                "'.$_POST['latitude'].'", 
                "'.$_POST['longitude'].'", 
                "'.$_POST['schedule_notes'].'", 
                "'.$_POST['sch_latitude_point'].'", 
                "'.$_POST['sch_longitude_point'].'"
            )';
            
            try {
                $insert = $conn->query($query);
                if($insert){
                    $msg = 'Attendance Successfully Recorded!';
                } else {
                    $msg2 = 'Failed to record attendance. Please try again.';
                }
            } catch (Exception $e) {
                $msg2 = 'Database error: ' . $e->getMessage();
            }
        } else {
            $msg2 = "You are outside the allowed attendance range. Distance: " . round($distance, 2) . " meters.";
        }
    } else {
        $msg2 = 'Location data is missing. Please ensure location services are enabled.';
    }
}

$roster = find_all_field('hrm_roster_allocation','','PBI_ID="'.$PBI_ID.'" and roster_date="'.date("Y-m-d").'"');
$roster_point = null;
if($roster && isset($roster->point_1)) { 
    $roster_point = find_all_field('hrm_roster_point', '', 'id="' . $roster->point_1 . '"');
}
?>


    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .attendance-container {
            max-width: 480px;
            margin: 20px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header-section {
            padding: 20px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
        }
        .profile-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .profile-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
        }
        .time-display {
				text-align: center;
				padding: 30px 0;
				background: #11f9ff1f;
        }
        .current-time {
            font-size: 3rem;
            font-weight: bold;
            margin: 0;
            color: #333;
        }
        .current-date {
            color: #666;
            margin-top: 5px;
            font-size: 1.1rem;
        }
        .check-in-button {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: none;
            background: #337e55;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 30px auto;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }
        .check-in-button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
        }
        .check-in-button i {
            font-size: 50px;
            color: white;
        }
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding: 20px;
        }
        .action-btn {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .action-btn:hover {
            background: #f8fafc;
            transform: translateY(-2px);
        }
        .action-btn i {
            font-size: 24px;
            color: #22c55e;
        }
        .action-btn span {
            font-size: 14px;
            color: #4b5563;
            font-weight: 500;
        }
        .disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        #locationInfo {
            padding: 15px;
            background: #f0fdf4;
            border-radius: 10px;
            margin: 20px;
            font-size: 0.9rem;
            color: #166534;
        }
        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 10px;
            margin: 20px;
            text-align: center;
            font-weight: 500;
            display: none;
        }
        #map {
            height: 200px;
            margin: 20px;
			border-radius: 10px;
			border: 6px solid #0069b5;
			box-shadow: 0 4px 20px rgb(3 104 178 / 73%);
        }
    </style>

    <div class="w-100 p-3 pb-0">
	<div class="attendance-container mt-5">
    <!--    <div class="header-section"></div>-->

        <div class="time-display pb-1">
            <h1 class="current-time" id="currentTime"></h1>
            <p class="current-date mb-2" id="currentDate"></p>
        </div>

        <form action="" method="post" id="attendanceForm">
            <input type="hidden" name="xtime" value="<?php echo $current_datetime; ?>">
            <input type="hidden" name="xdate" value="<?php echo date("Y-m-d"); ?>">
            <input type="hidden" name="latitude" id="latitude" required readonly>
            <input type="hidden" name="longitude" id="longitude" required readonly>
            <input type="hidden" name="error_detection" id="error_detection" value="0">
            <input type="hidden" name="adresssss" id="adresssss">
            <input type="hidden" name="sch_latitude_point" id="sch_latitude_point" 
                   value="<?php echo $roster_point ? $roster_point->latitude_point : ''; ?>" readonly>
            <input type="hidden" name="sch_longitude_point" id="sch_longitude_point" 
                   value="<?php echo $roster_point ? $roster_point->longitude_point : ''; ?>" readonly>
            
            <textarea id="schedule_notes" name="schedule_notes" style="display: none;">
                <?php echo $roster_point ? $roster_point->point_short_name : ''; ?>
            </textarea>
            
            <button type="submit" name="submitit" id="submitit" class="check-in-button">
                <i class="fas fa-fingerprint"></i>
            </button>

            <div id="successMessage" class="success-message">
            Attendance Successfully Recorded!
        </div>

        <?php if(!empty($msg)): ?>
        <div class="alert alert-success m-3" role="alert">
            <?php echo $msg; ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($msg2)): ?>
        <div class="alert alert-danger m-3" role="alert">
            <?php echo $msg2; ?>
        </div>
        <?php endif; ?>
		</form>
		</div>
    </div>
	

            <div id="map"></div>
           


       

   <!-- Add Google Maps API with explicit libraries and error handling -->
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBesXXt7OdJx2wz7Q3REhPvqgLLKCWYSWI&libraries=places,geometry&callback=initMap" async defer onerror="handleMapLoadError()"></script>
    
   
    
    <script>
    // Global error handler for map loading
    function handleMapLoadError() {
        console.error('Google Maps API failed to load');
        document.getElementById('map').innerHTML = `
            <div class="alert alert-warning">
                <strong>Map Unavailable</strong>
                <p>Location services are currently unavailable.</p>
            </div>
        `;
    }

    let map, marker;
    const OFFICE_LATITUDE = 23.840419931321687;
    const OFFICE_LONGITUDE = 90.3656383041611;

    function updateDateTime() {
        const now = new Date();
        document.getElementById('currentTime').textContent = now.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit'
        });
        document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', { 
            month: 'short', 
            day: '2-digit', 
            year: 'numeric'
        });
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);

    const GEOLOCATION_TIMEOUT = 30000;
    const GEOLOCATION_MAX_AGE = 300000;

    const geolocationOptions = {
        enableHighAccuracy: true,
        timeout: GEOLOCATION_TIMEOUT, 
        maximumAge: GEOLOCATION_MAX_AGE
    };

    function initMap() {
        try {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: OFFICE_LATITUDE, lng: OFFICE_LONGITUDE },
                zoom: 15,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false
            });

            retrieveLocation();
        } catch (error) {
            console.error('Map initialization error:', error);
            handleMapLoadError();
        }
    }

    function retrieveLocation() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                showPosition, 
                handleLocationError, 
                geolocationOptions
            );
        } else {
            fetchIPLocation();
        }
    }

    function showPosition(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        document.getElementById("latitude").value = latitude;
        document.getElementById("longitude").value = longitude;

        const latLng = new google.maps.LatLng(latitude, longitude);
        map.setCenter(latLng);
        
        if (marker) {
            marker.setPosition(latLng);
        } else {
            marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: "Your Location",
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                }
            });
        }

        document.getElementById("submitit").disabled = false;
        fetchLocationDetails(latitude, longitude);
    }

    function fetchIPLocation() {
        fetch('https://ipapi.co/json/')
        .then(response => response.json())
        .then(data => {
            const latitude = data.latitude;
            const longitude = data.longitude;

            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;
            
            const latLng = new google.maps.LatLng(latitude, longitude);
            map.setCenter(latLng);
            
            if (marker) {
                marker.setPosition(latLng);
            } else {
                marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: "Approximate Location"
                });
            }

            document.getElementById("submitit").disabled = false;
        })
        .catch(error => {
            handleLocationError({ 
                code: 'IP_LOCATION_FAILED', 
                message: 'Could not retrieve location' 
            });
        });
    }

    function handleLocationError(error) {
        console.error('Location Error:', error);

        document.getElementById("latitude").value = OFFICE_LATITUDE;
        document.getElementById("longitude").value = OFFICE_LONGITUDE;

        const officeLatLng = new google.maps.LatLng(OFFICE_LATITUDE, OFFICE_LONGITUDE);
        map.setCenter(officeLatLng);
        
        if (marker) {
            marker.setPosition(officeLatLng);
        } else {
            marker = new google.maps.Marker({
                position: officeLatLng,
                map: map,
                title: "Office Location",
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                }
            });
        }
    }

    function fetchLocationDetails(latitude, longitude) {
        const geocoder = new google.maps.Geocoder();
        const latlng = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
        
        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === google.maps.GeocoderStatus.OK && results[0]) {
                const address = results[0].formatted_address;
                document.getElementById("adresssss").value = address;
            } else {
                console.warn('Geocoding failed:', status);
            }
        });
    }

    window.initMap = initMap;
    </script>


<?php 
require_once '../assets/template/inc.footer.php';
?>