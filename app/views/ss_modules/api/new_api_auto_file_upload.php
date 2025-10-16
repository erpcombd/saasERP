<?php
include("../config/db.php");
include("../config/function.php");

// Get the request data
$pdata = file_get_contents("php://input");
$data = json_decode($pdata, true); 

$master_id=$_POST['master_id'];
$tr_from=$_POST['tr_from'];
$entry_by=$_POST['entry_by'];

if(isset($_FILES['image'])) {
    // Extract original image name and extension
    $original_image_name = $_FILES['image']['name'];
    $image_extension = pathinfo($original_image_name, PATHINFO_EXTENSION);
    $image = $_FILES['image']['tmp_name'];
    
    // Check if image data is available
    if(!empty($image)) {
      
        $random_image_name = uniqid() . '.' . $image_extension;
        $image_path = "../../../../uploaded_documents/" . $random_image_name;
        
        // Move the uploaded image to the desired directory with random name
        if(move_uploaded_file($image, $image_path)) {
            // Insert original image name into database with current timestamp
            $query = "INSERT INTO documents_information (master_id,tr_from,path,original_name,new_name,entry_by,entry_at) VALUES ('$master_id','$tr_from','../../../../uploaded_documents/','$original_image_name','$random_image_name','$entry_by', NOW())";
            $result = mysqli_query($conn, $query);
            
            if($result) {
               
                
                // Image and data saved successfully
                $response = array(
                    "status" => "success", 
                    "message" => "Data and image saved successfully.", 
                    "original_name" => $original_image_name,
                    "new_name" => $random_image_name,
                    "image_id" => $image_id
                );
            } else {
                // Error inserting original image name into database
                $response = array("status" => "error", "message" => "Error inserting original image name into database.");
            }
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

// Encode and output the response
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>