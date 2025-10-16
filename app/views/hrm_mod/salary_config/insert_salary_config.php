<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');


// Get employee name from the form
$salary_schedule = $_POST['salary_schedule'];
$grade = $_POST['grade'];
$gross = $_POST['gross'];
$basic = $_POST['basic'];
$house = $_POST['house'];
$medical = $_POST['medical'];
$conveyance = $_POST['conveyance'];
$food = $_POST['food'];


// Get designations from the form and split them into an array
//$designations = explode(",", $_POST['designation']);

// Get designations from the form and ensure it's an array
$designations = isset($_POST['designation']) ? $_POST['designation'] : array();



// Insert designations into the designations table
foreach ($designations as $designation) {
    $designation = trim($designation);
   echo $insertDesignationQuery = "INSERT INTO grade_settings 
	(salary_schedule,grade ,designation,gross,basic,house,medical,conveyance,food) 
	VALUES ('$salary_schedule', '$grade' , '$designation' , '$gross' , '$basic', '$house', '$medical','$conveyance','$food')";
    $query=db_query($insertDesignationQuery);
}



// Redirect back to the form
header("Location: worker_salary_configuration.php");
exit();
		
		
		
?>
