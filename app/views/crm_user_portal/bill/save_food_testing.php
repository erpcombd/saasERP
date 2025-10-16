<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ____________________ INSERT DATA _______________________//

$u_id=$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);


$emp_code   = json_decode($_POST["E_code"]);
//$pbi_code = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE='.json_decode($_POST["E_code"]));

$con_no   = json_decode($_POST["Conve_no"]);
$con_date = json_decode($_POST["Con_date"]);
$means_of = json_decode($_POST["Means"]);
$remarks    = json_decode($_POST["Remarks"]);
$bill_type   = json_decode($_POST["Bill_Type"]);
$f_address = json_decode($_POST["F_address"]);

$amount    = json_decode($_POST["Amount"]);

echo $Image_Files = json_decode($_POST["ImgDoc"]);


$folder = 'hrm_emp_pic'; 
$field  = $Image_Files;  //'PBI_PICTURE_ATT_PATH';
$file_name = $folder.'-'.$con_no;

$file_path =  upload_file($folder,$field,$file_name);





for ($i = 0; $i < count($emp_code); $i++) {
if(($emp_code[$i] != "")){   /* not allowing empty values and the row which has been removed. */
    
		// Check if the conveyance_no number is already associated with a different user ID
		$sqlq = "SELECT * FROM bills WHERE conveyance_no = '$con_no[$i]' AND emp_code != '$emp_code[$i]'";
		$result = db_query($sqlq);
		
		if ($result->num_rows > 0) {
			// Display an error message to the user
			echo "Bill number already used by another user.";
		} else {

	
		 $sql="INSERT INTO bills (emp_code,conveyance_no,conveyance_type, food_no_of_person,amount,remarks,conveyance_date,
		 	status,entry_by,means,document) 
		 VALUES ('$emp_code[$i]', '$con_no[$i]' , '$bill_type[$i]', '$f_address[$i]','$amount[$i]', '$remarks[$i]', 
		 	'$con_date[$i]', 'Pending', '$PBI_ID[$i]','$means_of[$i]','$file_path[$i]')";
		$query=db_query($sql);
	
	   }

	
   }
}


Print  "Data added Successfully !";



?>