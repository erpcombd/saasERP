<script src="sweetalerts/sweetalert2.min.js"></script>
<script src="sweetalerts/promise-polyfill.js"></script>
<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />



<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
     $update_in = $_POST['in_time'];
     $update_out = $_POST['out_time'];
     $emp_id = $_POST["id_no"];
     $xdate = $_POST["date"];
	
    	//$fdate =  date('Y-m-d',strtotime($sdate));
		//$tdate =  date('Y-m-d',strtotime($edate));
		
		
	 $successMessage = "Data successfully processed!";
   if($update_in>0 || $update_out>0){
		   // Update query
    $update_query = "UPDATE hrm_att_summary SET in_time = '$update_in', out_time = '$update_out' 
                     WHERE emp_id = '$emp_id' AND att_date = '$xdate'";

    $result = db_query($update_query);
			
			
			if ($result) {
				// Include SweetAlert script to display a success message
				echo "<script>
					$(document).ready(function() {
						swal({
							title: 'Shift Successfully Changed.',
							text: 'You Follow The Right Step!',
							type: 'success',
							padding: '2em'
						});
					});
				</script>";
			}
		
			
		
		}


 
}




		






        
        ?>