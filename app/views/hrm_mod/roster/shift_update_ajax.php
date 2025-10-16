<script src="sweetalerts/sweetalert2.min.js"></script>
<script src="sweetalerts/promise-polyfill.js"></script>
<link href="sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />



<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
     
	 $sdate = $_POST["sdate"];
	 $edate = $_POST["edate"];

	 $schedule_id = $_POST['schedule_check'];
	 $display = isset($_POST["check_list"]) ? $_POST["check_list"] : [];
 
	

		$fdate =  date('Y-m-d',strtotime($sdate));
		$tdate =  date('Y-m-d',strtotime($edate));
		
		
	 $successMessage = "Data successfully processed!";

		foreach ( $display as $key  ) {
		
		for($i=$fdate;$i<=$tdate;$i = date('Y-m-d', strtotime( $i . " +1 days"))){ 
		
       
		

		$del_sql = "delete from hrm_roster_allocation where PBI_ID='".$key."' and roster_date = '".$i."'";
		db_query($del_sql);


	    $insSql = 'INSERT INTO hrm_roster_allocation( PBI_ID, roster_date,  shedule_1, job_location,group_for, entry_by) 
		 VALUES ("'.$key.'", "'.$i.'",  "'.$schedule_id.'", "'.$_POST['job_location'].'", "'.$_POST['group_for'].'", "'.$entry_by.'")';
		$result =  db_query($insSql);
		
	

 
        } 
	
			}
			
			
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




		






        
        ?>