<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');


header('Content-Type: application/json');

// Get values from the AJAX request
$department = $_GET['department'];
$grade = $_GET['grade'];
$year = $_GET['year'];



//echo json_encode(['basic_salary' => '1000', 'gross_salary' => '1500', 'house_rent' => '200']);


	// Query the database for salary data
	 $sql = "SELECT basic_salary, gross_salary, house_rent 
       FROM salary_scale 
	   WHERE `group_name` = '$department' AND `grade` = '$grade' AND `year_number` = '$year'";
	   
		$result = db_query($sql);
		
		if ($result) {
			$row = mysqli_fetch_assoc($result);
			echo json_encode($row);
			
		} else {
			echo json_encode(['basic_salary' => 'N/A', 'gross_salary' => 'N/A', 'house_rent' => 'N/A']);
		}

	
		
		
		
?>
