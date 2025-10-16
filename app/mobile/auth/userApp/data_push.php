<?php
session_start();
date_default_timezone_set('Asia/Dhaka');
// Database connection
$mysqli = new mysqli("localhost", "ezzyerp_clouduser23", "cloudpass224423", "ezzyerp_saas_masterdb");

if ($mysqli->connect_errno) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to connect to MySQL: ' . $mysqli->connect_error
    ]);
    exit();
}

// Haversine formula to calculate distance between two coordinates
function haversineDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo) {
    $earthRadius = 6371000; // Radius of the earth in meters

    // Convert degrees to radians
    $latFrom = deg2rad((float) $latitudeFrom);
    $lonFrom = deg2rad((float) $longitudeFrom);
    $latTo = deg2rad((float) $latitudeTo);
    $lonTo = deg2rad((float) $longitudeTo);

    // Differences in coordinates
    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    // Haversine formula
    $a = pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2);
    $c = 2 * asin(sqrt($a));

    // Return the distance in meters
    return $earthRadius * $c;
}

$pdata = file_get_contents("php://input");
file_put_contents('debug_log.txt', $pdata); // Save the exact input for inspection
$result = json_decode($pdata);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo ' | JSON Decode Error: ' . json_last_error_msg();
}


    // Retrieve data from POST request
    $EMP_CODE = $result[0]->EMP_CODE;
    $latitude = $result[0]->latitude; // From the user
    $longitude = $result[0]->longitude; // From the user

    // Get current date and time values
    $xtime = date('Y-m-d H:i:s');  // Current datetime
    $xdate = date('Y-m-d');         // Current date
    $time = date('H:i:s');          // Current time
    $ztime = date('Y-m-d H:i:s');  // Current datetime
    $xlocationid = 1;  // Example value; modify as needed
    $xmechineid = 1;   // Example value; modify as needed

    // Query to get the predefined locations with their latitude, longitude, and radius from the hrm_att_location table
    $sql = "SELECT id, name, lattitude, longitude, radius FROM hrm_att_location LIMIT 1";
    $locationResult = $mysqli->query($sql);

    // Initialize response
    $response = [
        'status' => 'error',
        'message' => 'No matching locations found in the database.',
        'data' => []
    ];

    // Flag to track if the user is within any location's radius
    $foundLocation = false;
    $distance=0;
    if ($locationResult->num_rows > 0) {
        while ($row = $locationResult->fetch_assoc()) {
            // Retrieve the latitude, longitude, and radius from the table
            $storedLatitude = $row['lattitude'];
            $storedLongitude = $row['longitude'];
            $storedRadius = $row['radius'];

            // Calculate the distance between the user's location and the stored location
            $distance = haversineDistance($latitude, $longitude, $storedLatitude, $storedLongitude);

            // Check if the user is within the radius
            // if ($distance <= $storedRadius) {
            //     $foundLocation = true;
            // }
        }
    }

    // If user location is found and within range, proceed
    // if ($foundLocation) {
        // Step 1: Check how many 'in_punch' and 'out_punch' entries exist for the same EMP_CODE and xdate
      echo   $checkSql = "SELECT att_type, COUNT(*) AS count FROM hrm_attdump WHERE EMP_CODE = '$EMP_CODE' AND xdate = '$xdate' GROUP BY att_type";
        $checkResult = $mysqli->query($checkSql);

        $inPunchCount = 0;
        $outPunchCount = 0;

        while ($row = $checkResult->fetch_assoc()) {
            if ($row['att_type'] === 'in_punch') {
                $inPunchCount = $row['count'];
            } elseif ($row['att_type'] === 'out_punch') {
                $outPunchCount = $row['count'];
            }
        }

        // Step 2: Determine the turn for in_punch or out_punch based on counts
       echo  $turnForInPunch = ($inPunchCount - $outPunchCount) === 0; // If in_punch count == out_punch count, it's in_punch time
       echo  $turnForOutPunch = ($inPunchCount - $outPunchCount) === 1; // If in_punch count > out_punch count, it's out_punch time

        // Step 3: Perform actions based on the current turn
        if ($turnForInPunch) {
            // It's time for in_punch, insert if user is within range
            if($distance <= $storedRadius){
         echo   $sqlInsert = 'INSERT INTO hrm_attdump(bizid, xenrollid, xlocationid, xmechineid, xdate, xtime, time, EMP_CODE, att_type)  
                          VALUES ("'.$EMP_CODE.'", "'.$EMP_CODE.'", "'.$xlocationid.'", "'.$xmechineid.'", "'.$xdate.'", "'.$xtime.'", "'.$time.'", "'.$EMP_CODE.'", "in_punch")';
            $insertResult = $mysqli->query($sqlInsert);
            if ($insertResult) {
                $response['status'] = 'success';
                $response['message'] = 'Successfully inserted in_punch data';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error inserting in_punch: ' . $mysqli->error;
            }
            }
        } elseif ($turnForOutPunch) {
            // It's time for out_punch, check if user is out of range
            if ($distance > $storedRadius) {
                $sqlInsert = 'INSERT INTO hrm_attdump(bizid, xenrollid, xlocationid, xmechineid, xdate, xtime, time, EMP_CODE,att_type)  
                              VALUES ("'.$EMP_CODE.'", "'.$EMP_CODE.'", "'.$xlocationid.'", "'.$xmechineid.'", "'.$xdate.'", "'.$xtime.'", "'.$time.'", "'.$EMP_CODE.'", "out_punch")';
                $insertResult = $mysqli->query($sqlInsert);
                if ($insertResult) {
                    $response['status'] = 'success';
                    $response['message'] = 'Successfully inserted out_punch data';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error inserting out_punch: ' . $mysqli->error;
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'User is still within range, cannot insert out_punch.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid punch sequence, cannot proceed.';
        }
    // } else {
    //     $response['status'] = 'error';
    //     $response['message'] = 'Your location is not within the range of any predefined locations.';
    // }

    // Return JSON response
    echo json_encode($response);

?>
