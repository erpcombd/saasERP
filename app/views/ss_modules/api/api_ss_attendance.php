<?php
include("../config/db.php");
include("../config/function.php");

// Get the request data
$pdata = file_get_contents("php://input");
$data = json_decode($pdata, true); // true to decode as associative array
$user_id = $data['user_id'];

// Check if user_id exists in the table for the current date
$current_date = date("Y-m-d");
$query = "SELECT * FROM ssn_location_log WHERE user_id = '$user_id' AND access_date = '$current_date'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) {
    // This is the first request of the day for this user_id
    $attendance_type = "In Time";
} else {
    // This is not the first request of the day for this user_id
    $attendance_type = "Out Time";
}

// Insert the data into the table
$query = "INSERT INTO ssn_location_log (user_id, do_no, attendance_type, access_date, access_time, ip, latitude, longitude, milage) 
          VALUES ('$user_id', '{$data['do_no']}', '$attendance_type', '$current_date', NOW(), '{$data['ip']}', '{$data['latitude']}', '{$data['longitude']}', '{$data['milage']}')";
if(mysqli_query($conn, $query)) {
    // Data inserted successfully, now save the image
    if(isset($_FILES['image'])) {
        $image = $_FILES['image']['tmp_name'];
        
        // Check if image data is available
        if(!empty($image)) {
            // Define the image directory and name
            $image_name = "image_" . time() . ".jpg"; // You can change the image name as per your requirement
            $image_path = "./" . $image_name; // Update this with the directory path where you want to save the images
            
            // Move the uploaded image to the desired directory
            if(move_uploaded_file($image, $image_path)) {
                // Image saved successfully
                $response = array("status" => "success", "message" => "Data and image saved successfully.");
            } else {
                // Error saving image
                $response = array("status" => "error", "message" => "Error saving image.");
            }
        } else {
            // No image uploaded
            $response = array("status" => "error", "message" => "No image uploaded.");
        }
    } else {
        // Image file not received
        $response = array("status" => "error", "message" => "Image file not received.");
    }
} else {
    $response = array("status" => "error", "message" => "Error inserting data: " . mysqli_error($conn));
}

// Encode and output the response
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>
