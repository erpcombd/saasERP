<script src="sweetalerts/sweetalert2.min.js"></script>
<script src="sweetalerts/promise-polyfill.js"></script>
<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />



<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


if( $_GET['att_date']>0 ){
  
		  $user_id=$_SESSION['user']['id'];
		   $emp_id =  $_GET['emp_code']; 

		 
          $attendance_date = $_GET['att_date'];
				   
      
				   
		         $sql = "UPDATE hrm_att_summary SET in_time = '0000-00-00 00:00:00', out_time = '0000-00-00 00:00:00' ,
				 force_absent = 1, present = 0
				  WHERE  emp_id = '$emp_id' AND att_date = '$attendance_date'";
				 $update_result =  db_query($sql);
				  
				  $sql = "UPDATE hrm_attdump SET type=2 ,entry_by = '$user_id'
				  WHERE  EMP_CODE = '$emp_id' AND xdate = '$attendance_date'";
				 $update_result =  db_query($sql);
		
		


			
			if ($update_result) {
		
				//header("Location: time_card_report.php");  // Replace 'other_page.php' and 'some_value' with appropriate values
                //exit(); 
				
		 $_POST['PBI_IDD'] = $emp_id;

        // Redirect with parameter
        $redirect_url = "time_card_report.php?PBI_IDD=" . urlencode($_POST['PBI_IDD']);
        header("Location: $redirect_url");
        exit();
				
			}
			
			
	}




		






        
        ?>