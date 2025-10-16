<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');


header('Content-Type: application/json');

// Get values from the AJAX request
$salary_schedule = $_GET['salary_schedule'];
$grade = $_GET['grade'];
$designation = $_GET['designation'];



//echo json_encode(['basic_salary' => '1000', 'gross_salary' => '1500', 'house_rent' => '200']);


	// Query the database for salary data
	  $sql = "SELECT  gross , basic ,house, medical ,conveyance ,food
       FROM grade_settings 
	   WHERE `salary_schedule` = '$salary_schedule' AND `grade` = '$grade' AND `designation` = '$designation'";
	   
		$result = db_query($sql);
		
		if ($result) {
			$row = mysqli_fetch_assoc($result);
			echo json_encode($row);
			
		} else {
			echo json_encode(['basic_salary' => 'N/A', 'gross_salary' => 'N/A', 'house_rent' => 'N/A']);
		}

	
		
		
		
?>
