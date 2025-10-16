<?php
// Example usage
$host = "localhost";
$username = "root";
$password = "";
$database = "erp";


// Establish a connection to the database
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}







//_________________________ INSERT FUNCTION ____________________
function insertData($conn, $table, $data)
{
    // Escape the data to prevent SQL injection
    $escapedData = array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $data);

    // Build the parameterized INSERT query
    $columns = implode(', ', array_keys($escapedData));
    $placeholders = implode(', ', array_fill(0, count($escapedData), '?'));
    $values = array_values($escapedData);
   echo $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Error: " . mysqli_error($conn));
    }

    // Bind the values to the statement parameters
    $types = str_repeat('s', count($values)); // Assuming all values are strings
    mysqli_stmt_bind_param($stmt, $types, ...$values);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Data inserted successfully.";
    } else {
        //echo "Error: " . mysqli_stmt_error($stmt);
		echo "Error: " . $sql . "<br>" . mysqli_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

//_________________________ END INSERT FUNCTION ____________________

//_________________________ DELETE  FUNCTION START  ________________

function deleteData($conn,$table, $condition) {
   
    // Check connection
 /*   if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }*/

    // Construct the delete query
   echo $sql = "DELETE FROM $table WHERE $condition";

    // Execute the delete query
    if ($conn->query($sql) === TRUE) {
        echo "Data deleted successfully from $table.";
    } else {
        echo "Error deleting data: " . $conn->error;
    }
	
    // Close the database connection
    $conn->close();
}
//_________________________ DELETE  FUNCTION END  ____________________



/**
 * Function to validate and sanitize user input
 */
function validateInput($input)
{
    // Trim whitespace
    $input = trim($input);
    // Remove HTML tags
    $input = strip_tags($input);
    // Escape special characters
    $input = htmlspecialchars($input);

    return $input;
}



	

//_____________________ ----  IMAGE UPLOAD FUNCTION START --------_________________
function uploadImage($file_input_name, $target_dir, $allowed_types = array('image/jpeg', 'image/png', 'image/gif'), $max_file_size = 1024 * 1024) {
    if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] == UPLOAD_ERR_OK) {
        // Get file information
        $file_name = $_FILES[$file_input_name]['name'];
        $file_tmp_name = $_FILES[$file_input_name]['tmp_name'];
        $file_type = $_FILES[$file_input_name]['type'];
        $file_size = $_FILES[$file_input_name]['size'];

        // Validate file type and size
        if (!in_array($file_type, $allowed_types)) {
            return "Invalid file type. Only JPEG, PNG, and GIF files are allowed.";
        }
        if ($file_size > $max_file_size) {
            return "File size exceeds limit. Maximum file size is 1 MB.";
        }

        // Move file to target directory
        $target_file = $target_dir . basename($file_name);
        if (!move_uploaded_file($file_tmp_name, $target_file)) {
            return "Error uploading file.";
        }

        // Return the path to the uploaded file
        return $target_file;
    } else {
        return "No file uploaded.";
    }
}
//_____________________ ----  IMAGE UPLOAD FUNCTION END  --------_________________





//_______________ Dropdown Query _____
function foreign_relation1($table,$id,$show,$value,$condition=''){
$link = mysqli_connect("localhost", "root", "", "erp"); 
if($condition=='')
$sql="select $id,$show from $table";
else
$sql="select $id,$show from $table where $condition";
echo $sql;
$res=mysqli_query($link,$sql);
while($data=mysqli_fetch_row($res))
{
if($value==$data[0])
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
else
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}
}


//_____________ UNIQUE PRODUCT CODE _________
function generateUniqueProductCode() {
    do {
        $code = str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        $sql = "SELECT COUNT(*) AS count FROM products WHERE code = '$code'";
        $db = mysqli_connect("localhost", "root", "", "erp"); 
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        mysqli_close($db); 

    } while ($count > 0);

    return $code;
}






//___________ FIND A FIELD ___
/*function find_a_field($table,$field,$condition)
	{
	$sql="select $field from $table where $condition limit 1";
	$res=@mysqli_query($conn,$sql);
	$count=@mysqli_num_rows($res);
	if($count>0)
	{
	$data=@mysqli_fetch_row($res);
	return $data[0];
	}
	else
	return NULL;
	}
		function find_a_field_sql($sql)
	{
	
	$res=@mysqli_query($conn,$sql);
	$count=@mysqli_num_rows($res);
	if($count>0)
	{
	$data=@mysqli_fetch_row($res);
	return $data[0];
	}
	else
	return NULL;
	}
	
		function find_all_field_sql($sql)
	{
	$res=@mysqli_query($conn,$sql);
	$count=@mysqli_num_rows($res);
	
	if($count>0)
		{
		$data=@mysqli_fetch_object($res);
		return $data;
		}
	else
		return NULL;
	}
	
	function find_all_field($table,$field,$condition)
	{
	$sql="select * from $table where $condition limit 1";
	$res=@mysqli_query($conn,$sql);
	$count=@mysqli_num_rows($res);
	
	if($count>0)
		{
		$data=@mysqli_fetch_object($res);
		return $data;
		}
	else
		return NULL;
	}*/

?>






