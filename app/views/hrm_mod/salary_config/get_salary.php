<?php

header('Content-Type: application/json');

// Database connection
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "erp";

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}



// Get values from the AJAX request
$department = $_GET['department'];
$grade = $_GET['grade'];
$year = $_GET['year'];



//echo json_encode(['basic_salary' => '1000', 'gross_salary' => '1500', 'house_rent' => '200']);


	// Query the database for salary data
	 $sql = "SELECT basic_salary, gross_salary, house_rent 
       FROM salary_scale 
	   WHERE `group_name` = '$department' AND `grade` = '$grade' AND `year_number` = '$year'";
	   
		$result = db_query($connection, $sql);
		
		if ($result) {
			$row = mysqli_fetch_assoc($result);
			echo json_encode($row);
			
		} else {
			echo json_encode(['basic_salary' => 'N/A', 'gross_salary' => 'N/A', 'house_rent' => 'N/A']);
		}

		mysqli_close($connection);
		
		
		
?>
