<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

// Configuration Constants
define('MAX_ATTENDANCE_DISTANCE', 1000);
define('OFFICE_LATITUDE', 23.840419931321687);
define('OFFICE_LONGITUDE', 90.3656383041611);
define('GOOGLE_MAPS_API_KEY', 'AIzaSyBesXXt7OdJx2wz7Q3REhPvqgLLKCWYSWI');

$title = "Daily Attendance";
$page = "daily_attendance2.php";

date_default_timezone_set('Asia/Dhaka');
$current_datetime = date("Y-m-d H:i:s");

$u_id = $_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management', 'PBI_ID', 'user_id='.$u_id);

if(isset($_POST['submitit'])){
    header('Content-Type: application/json');
    
    // Prevent any output before JSON response
    ob_clean();
    
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
                    echo json_encode(['success' => true, 'message' => 'Attendance Successfully Recorded!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to record attendance. Please try again.']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => "You are outside the allowed attendance range. Distance: " . round($distance, 2) . " meters."]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Location data is missing. Please ensure location services are enabled.']);
    }
    exit;
}

// Move these includes here, after the AJAX response
require_once '../assets/template/inc.header.php';

$roster = find_all_field('hrm_roster_allocation','','PBI_ID="'.$PBI_ID.'" and roster_date="'.date("Y-m-d").'"');
$roster_point = null;
if($roster && isset($roster->point_1)) { 
    $roster_point = find_all_field('hrm_roster_point', '', 'id="' . $roster->point_1 . '"');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .attendance-container {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header-section {
            padding: 20px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
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
            padding: 20px 0;
            background: #f8fafc;
        }
        .current-time {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
            color: #333;
        }
        .current-date {
            color: #666;
            margin-top: 5px;
            font-size: 1rem;
        }
        .check-in-button {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: none;
            background: #4CAF50;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px auto;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }
        .check-in-button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        }
        .check-in-button:disabled {
            background: #cccccc;
            cursor: not-allowed;
        }
        .check-in-button i {
            font-size: 40px;
            color: white;
        }
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            padding: 15px;
        }
        .action-btn {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .action-btn:hover {
            background: #f8fafc;
            transform: translateY(-2px);
        }
        .action-btn i {
            font-size: 20px;
            color: #4CAF50;
        }
        .action-btn span {
            font-size: 12px;
            color: #4b5563;
            font-weight: 500;
        }
        #locationInfo {
            padding: 10px;
            background: #e8f5e9;
            border-radius: 10px;
            margin: 15px;
            font-size: 0.9rem;
            color: #2e7d32;
        }
        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 15px;
            border-radius: 10px;
            margin: 15px;
            text-align: center;
            font-weight: 500;
            display: none;
        }
        #map {
            height: 200px;
            margin: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="attendance-container">
        <div class="header-section">
            <div class="profile-section">
                <div>
                    <h2 class="h4 mb-1">Hey <?php echo $_SESSION['user']['name']; ?>!</h2>
                    <p class="mb-0">Ready to start your day?</p>
                </div>
                <img src="https://via.placeholder.com/60" alt="Profile" class="profile-image">
            </div>
        </div>

        <div class="time-display">
            <h1 class="current-time" id="currentTime"></h1>
            <p class="current-date" id="currentDate"></p>
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
            
            <button type="submit" name="submitit" id="submitit" class="check-in-button" disabled>
                <i class="fas fa-fingerprint"></i>
            </button>

            <div id="locationInfo">Fetching your location...</div>

            <div id="map"></div>

            <div class="action-buttons">
                <div class="action-btn">
                    <i class="far fa-clock"></i>
                    <span>Check In</span>
                </div>
                <div class="action-btn">
                    <i class="far fa-clock"></i>
                    <span>Check Out</span>
                </div>
                <div class="action-btn">
                    <i class="far fa-hourglass"></i>
                    <span>Total Hrs</span>
                </div>
            </div>
        </form>

        <div id="successMessage" class="success-message">
            Attendance Successfully Recorded!
        </div>
    </div>

    <script>
    window.gm_authFailure = function() {
        document.getElementById('map').innerHTML = 'Failed to load Google Maps. Please check your API key.';
    };
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBesXXt7OdJx2wz7Q3REhPvqgLLKCWYSWI&libraries=places&callback=initMap" 
        async 
        defer
        onerror="document.getElementById('map').innerHTML = 'Failed to load Google Maps';">
    </script>
    <script>
    let map, marker;
    let locationObtained = false;

    function updateDateTime() {
        const now = new Date();
        document.getElementById('currentTime').textContent = now.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit'
        });
        document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', { 
            month: 'short', 
            day: '2-digit', 
            year: 'numeric',
            weekday: 'long'
        });
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 23.840419931321687, lng: 90.3656383041611 },
            zoom: 15,
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                showPosition,
                (error) => handleLocationError(error),
                { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
            );
        } else {
            handleLocationError({ code: 'UNSUPPORTED' });
        }
    }

    function handleLocationError(error) {
        let errorMessage = "Unable to retrieve your location. ";
        switch(error.code) {
            case error.PERMISSION_DENIED:
                errorMessage += "Please enable location services in your browser settings.";
                break;
            case error.POSITION_UNAVAILABLE:
                errorMessage += "Location information is unavailable.";
                break;
            case error.TIMEOUT:
                errorMessage += "The request to get user location timed out.";
                break;
            case error.UNSUPPORTED:
                errorMessage += "Your browser doesn't support geolocation.";
                break;
            default:
                errorMessage += "An unknown error occurred.";
                break;
        }
        document.getElementById("locationInfo").textContent = errorMessage;
        document.getElementById("submitit").disabled = true;
    }

    function showPosition(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        setLocationValues(latitude, longitude);

        const latLng = new google.maps.LatLng(latitude, longitude);
        map.setCenter(latLng);
        
        if (marker) {
            marker.setPosition(latLng);
        } else {
            marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: "Your Location"
            });
        }

        locationObtained = true;
        document.getElementById("submitit").disabled = false;
        fetchLocationDetails(latitude, longitude);
    }

    function setLocationValues(latitude, longitude) {
        document.getElementById("latitude").value = latitude;
        document.getElementById("longitude").value = longitude;
    }

    function fetchLocationDetails(latitude, longitude) {
        const geocoder = new google.maps.Geocoder();
        const latlng = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
        
        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === "OK" && results[0]) {
                const address = results[0].formatted_address;
                document.getElementById("adresssss").value = address;
                document.getElementById("locationInfo").textContent = `Your location: ${address}`;
            } else {
                document.getElementById("locationInfo").textContent = "Unable to retrieve address details.";
            }
        });
    }

    document.getElementById('attendanceForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const submitButton = document.getElementById('submitit');
        
        if (!locationObtained) {
            alert("Please wait for your location to be obtained before submitting.");
            return;
        }
        
        submitButton.disabled = true;
        submitButton.innerHTML = '<div class="loading"></div>Submitting...';

        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => response.text())
        .then(text => {
            let data;
            try {
                data = JSON.parse(text);
                if (data.success) {
                    document.getElementById('successMessage').style.display = 'block';
                    setTimeout(() => {
                        document.getElementById('successMessage').style.display = 'none';
                    }, 3000);
                } else {
                    throw new Error(data.message || 'Unknown error occurred');
                }
            } catch (e) {
                console.error('Response:', text);
                throw new Error('Invalid server response: ' + e.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting attendance: ' + error.message);
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-fingerprint"></i>';
        });
    });

    window.onload = initMap;
    </script>
</body>
</html>

<?php 
require_once '../assets/template/inc.footer.php';
?>

