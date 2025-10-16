<?php 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$title = "OD Entry Form";
$page = "od_entry.php";

require_once '../assets/template/inc.header.php';
$u_id= $_SESSION['user']['id']; //$_SESSION['user_id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$user_id	= $PBI_ID; //$_SESSION['user_id'];





$root='leave';
$table='hrm_leave_info';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='type';				// For a New or Edit Data a must have data field
$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');
do_calander('#leave_apply_date');

$unique_name = md5(uniqid(rand(), true));
$_SESSION['employee_selected'] = $PBI_ID;

$essentialInfo = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);
$leave_status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);
$incharge_status = find_a_field('hrm_leave_info','incharge_status','id='.$_REQUEST['id']);

$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);
$incharge = $PBI->incharge_id;
$leave_status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);
    $sql ="SELECT group_od_id 
FROM hrm_od_info 
ORDER BY group_od_id DESC limit 1";
    $query_group_od_id = db_query($sql);
    $row_group_od_id = mysqli_fetch_assoc($query_group_od_id);
    $last_group_id=$row_group_od_id['group_od_id'];

if (isset($_POST['save_leave'])) {

    // Fetch form data
    $person_ids = $_POST['person_ids'];  // Array of person IDs (assigned persons)
    $latitude = $_POST['latitude']; 
    $longitude = $_POST['longitude'];
    $project_id = $_POST['project_id'];
    $entry_at = date('Y-m-d H:i:s');
    $entry_by = $PBI->PBI_ID;  // Ensure $PBI_ID is correctly defined
    $start_date = $_POST['s_date'];
    $s_time = $_POST['start_time'];
    $e_time = $_POST['end_time'];
	
	    
    $new_group_id = isset($last_group_id) ? $last_group_id + 1 : 1; // Default to 1 if not set



    // Iterate over each person_id in the array
    foreach ($person_ids as $PBI_ID) {
        // Construct SQL insert query for each PBI_ID
        $sql_master = "INSERT INTO hrm_od_info (s_time, e_time, s_date, latitude, longitude, entry_by, entry_at, PBI_ID, project_id, group_od_id , od_att_status) 
        VALUES ('$s_time', '$e_time', '$start_date', '$latitude', '$longitude', '$entry_by', '$entry_at', '$PBI_ID', '$project_id', '$new_group_id', 'STARTED')";

        // Execute the insert query
        if ($conn->query($sql_master)) {
            // Get the last inserted ID for hrm_od_info
            $od_id = $conn->insert_id;

            // Insert into crm_lead_activity table
            $sql_crm_lead_activity = "INSERT INTO crm_lead_activity (activity_type, entry_by, entry_at, od_id, assign_person, project_id, mode, subject,time,date) 
            VALUES ('Meeting', '$entry_by', '$entry_at', '$od_id', '$PBI_ID', '$project_id', 'postsale', 'OD Meeting','$s_time','$start_date' )";
            $conn->query($sql_crm_lead_activity);

            // Get bill types and amounts
            $types = $_POST['bill_types'];  // Get bill types from the form
            $amounts = $_POST['bill_amounts'];  // Get amounts from the form

            // Ensure both arrays have the same length before processing
            if (count($types) === count($amounts)) {
                foreach ($types as $index => $type) {
                    $amount = $amounts[$index];  // Get the corresponding amount for each type

                    // Construct the SQL insert query for bills
                    $sql_master_bill = "INSERT INTO bills (conveyance_type, amount, od_id, entry_by, entry_at,group_od_id) 
                    VALUES ('$type', '$amount', '$od_id', '$entry_by', '$entry_at', '$new_group_id')";
                    
                    // Execute the insert query
                    if (!$conn->query($sql_master_bill)) {
                        // If the query fails, output the error
                        echo "Error inserting bill: " . $conn->error;
                    }
                }
            } else {
                echo "Error: Types and amounts arrays are not the same length.";
            }

        } else {
            // If the query for hrm_od_info fails, output the error
            echo "Error inserting hrm_od_info for PBI_ID $PBI_ID: " . $conn->error;
        }
    }

    // After completing all operations, redirect or continue
     echo '<script type="text/javascript">window.location.href = "od_entry.php";</script>';

} else {
    //echo "Error: save_leave not set.";
}






// Fetch data from the database
$sql_t = "SELECT * FROM hrm_od_info a WHERE PBI_ID = '" . $PBI_ID . "' ORDER BY id DESC LIMIT 1";
$query2 = db_query($sql_t);


$sl= 0;
while ($data2 = mysqli_fetch_object($query2)) {

//$schedule_LATITUDE = mysqli_fetch_assoc(mysqli_query($conn, "SELECT latitude FROM crm_project_org WHERE id='" . $data2->project_id . "'"))['latitude'];
//$schedule_LONGITUDE = mysqli_fetch_assoc(mysqli_query($conn, "SELECT longitude FROM crm_project_org WHERE id='" . $data2->project_id . "'"))['longitude'];
//$punch_LATITUDE  = $_POST['latitude_od_'.$data2->id];
//$punch_LONGITUDE = $_POST['longitude_od_'.$data2->id];

if (isset($_POST['punch_in_'.$data2->id]) || isset($_POST['punch_out_'.$data2->id])) {
   $att_punch_in_id = $_POST['od_id_'.$data2->id]; 
   $PBI_ID = $PBI->PBI_ID; // this $PBI_ID for att sql emp id
   $time = date('H:i:s'); // this code for att sql time 

    // Determine whether it's a punch in or punch out
    $status = isset($_POST['punch_in_'.$data2->id]) ? 'PROCESSING' : 'COMPLETED';

   /* $sql_att = 'INSERT INTO hrm_attdump (`ztime`, `bizid`, `EMP_CODE`, `xenrollid`, `time`, `xtime`, `xdate`, `xlocationid`, 
        `latitude`, `longitude`, `schedule_notes`, `sch_latitude_point`, `sch_longitude_point`) 
        VALUES ("'.date('Y-m-d H:i:s').'", "'.$PBI_ID.'", "'.$PBI_ID.'", "'.$PBI_ID.'", "'.$time.'", 
        "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d').'", "999", "'.$_POST['latitude_od_'.$data2->id].'", 
        "'.$_POST['longitude_od_'.$data2->id].'", "'.$_POST['schedule_notes_'.$data2->id].'", "'.$_POST['latitude_od_'.$data2->id].'", 
        "'.$_POST['longitude_od_'.$data2->id].'")';*/
		
		
    $sql_att = 'INSERT INTO hrm_attdump_apps (`ztime`, `bizid`, `EMP_CODE`, `xenrollid`, `time`, `xtime`, `xdate`, `xlocationid`, 
        `latitude`, `longitude`, `schedule_notes`, `sch_latitude_point`, `sch_longitude_point`,`incharge_id`) 
        VALUES ("'.date('Y-m-d H:i:s').'", "'.$PBI_ID.'", "'.$PBI_ID.'", "'.$PBI_ID.'", "'.$time.'", 
        "'.date('Y-m-d H:i:s').'", "'.date('Y-m-d').'", "999", "'.$_POST['latitude_od_'.$data2->id].'", 
        "'.$_POST['longitude_od_'.$data2->id].'", "'.$_POST['schedule_notes_'.$data2->id].'", "'.$_POST['latitude_od_'.$data2->id].'", 
        "'.$_POST['longitude_od_'.$data2->id].'" , "'.$incharge.'")';		
    
    // Execute the insert query
   	$conn->query($sql_att);

    // Update query to set the status for the given punch_id
    $sql_in = "UPDATE `hrm_od_info` SET `od_att_status` = '".$status."' WHERE id = '".$att_punch_in_id."'";
    $conn->query($sql_in);
}

}



// if (isset($_POST['save_leave'])) {
    
// //     $sql ="SELECT group_od_id FROM hrm_od_info order by desc limit 1";
// //     $query_group_od_id = db_query($sql);
// //     $row_group_od_id = mysqli_fetch_assoc($query_group_od_id);
// //     $last_group_id=$row_group_od_id['group_od_id'];
// //     $new_group_id = $last_group_id+1;
// //   $now = time();
// //     $projectId = array(2, 3, 4, 5);
// //     $incharge = $PBI->incharge_id;

// //     if (in_array($essentialInfo->ESSENTIAL_PROJECT, $projectId)) {
// //         $_REQUEST['PBI_DEPT_HEAD'] = 111659;
// //     }

// //     $start_date = $_POST['s_date'];
// //       //$start_date = date('Y-m-d');
// //     $entry_at = date('Y-m-d H:i:s');
// //     $entry_by = $PBI->PBI_ID;
  
// //     $start = strtotime($_POST['s_date']);
// //     $e_time = $_POST['end_time'];
// //     $s_time = $_POST['start_time'];
// //     $latitude = $_POST['latitude'];
// //     $longitude = $_POST['longitude'];
// //     $project_id = $_POST['project_id'];

// //     // Insert into hrm_od_info
// //     $sql_master = "INSERT INTO hrm_od_info (s_time, e_time, s_date, latitude, longitude, entry_by, entry_at, PBI_ID,project_id,group_od_id) 
// //     VALUES ('" . $s_time . "', '" . $e_time . "', '" . $start_date . "', '" . $latitude . "', '" . $longitude . "', 
// //     '" . $entry_by . "', '" . $entry_at . "', '" . $PBI_ID . "', '" . $project_id . "', '" . $new_group_id . "')";
// $person_ids = $_POST['person_ids'];  // Array of person IDs (e.g., assigned persons)
// $latitude = $_POST['latitude']; 
// $longitude = $_POST['longitude'];
// $project_id = $_POST['project_id'];
// $entry_at = date('Y-m-d H:i:s');
// $entry_by = $PBI->PBI_ID;
// $start_date = $_POST['s_date'];
// $s_time = $_POST['start_time'];
// $e_time = $_POST['end_time'];
// $new_group_id = $last_group_id + 1; // Assuming this is calculated earlier

// // Iterate over each person_id in the array
// foreach ($person_ids as $PBI_ID) {
//     // Construct SQL insert query for each PBI_ID
//     $sql_master = "INSERT INTO hrm_od_info (s_time, e_time, s_date, latitude, longitude, entry_by, entry_at, PBI_ID, project_id, group_od_id) 
//     VALUES ('$s_time', '$e_time', '$start_date', '$latitude', '$longitude', '$entry_by', '$entry_at', '$PBI_ID', '$project_id', '$new_group_id')";

//     if ($conn->query($sql_master)) {
//         $od_id = $conn->insert_id; // Get the last inserted ID for hrm_od_info
  
  
//         $sql_crm_lead_activity = "INSERT INTO crm_lead_activity (activity_type, entry_by, entry_at, od_id,assign_person,project_id,mode) 
//         VALUES ('" . 'Meeting' . "', '" . $entry_by . "', '" . $entry_at . "', '" . $od_id . "', '" . $PBI_ID . "', '" . $project_id . "', '" . 'postsale' . "')";
//         $conn->query($sql_crm_lead_activity);
  
        
// $types = $_POST['bill_types'];  // Get the types (assuming sent from form)
// $amounts = $_POST['bill_amounts'];  // Get the amounts (assuming sent from form)




// // Ensure both arrays are the same length
// if (count($types) === count($amounts)) {
//     foreach ($types as $index => $type) {
//         $amount = $amounts[$index];  // Get the corresponding amount for the current type
        
//         // Construct the SQL insert query
//         $sql_master_bill = "INSERT INTO bills (conveyance_type, amount, od_id, entry_by, entry_at) 
//         VALUES ('" . $type . "', '" . $amount . "', '" . $od_id . "', '" . $entry_by . "', '" . $entry_at . "')";
//         $conn->query($sql_master_bill);
//     }
// } else {
//     echo "Error: Types and amounts arrays are not the same length.";
// }


//       //  echo '<script type="text/javascript">window.location.href = "od_entry.php";<script>';
//     } else {
//         echo "Error: " . $conn->error;
//     }
// }
// }

?>

<style>
.select2-container--default .select2-search--inline .select2-search__field {
    background: transparent;
    border: none !important;
    outline: 0;
    box-shadow: none;
    -webkit-appearance: textfield;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
<div class="card card-style">
    <form action="od_entry.php" method="post">
        <div class="content m-0">
             <div class="row">
                <div class="col-12">
					   <label for="form2" >Employee Code</label>
					   <input name="PBI_ID" type="hidden" class="form-control validate-text" value="<?=$PBI_ID?>" placeholder="Employee Code" readonly required/>
                       <input  type="text" class="form-control validate-text" value="<?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "' . $PBI_ID . '"') ?>" readonly/>
				</div>
				
				 <div class="col-12">
					   <label for="form2" >Assign Person Name</label>
					   <select class="form-control req" name="person_ids[]" id="emp_id1" multiple>
                      <option selected value="<?=$PBI_ID?>"><?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "' . $PBI_ID . '"') ?></option>
        				<?php foreign_relation('personnel_basic_info', 'PBI_ID', 'concat(PBI_ID," - ",PBI_NAME)', $assign_person, '1'); ?>
                    </select>
				</div>
				
				 <div class="col-6">
					   <label for="form2" >Select Project</label>
					  <select class="form-control req" name="project_id" id="project_id" required>
					  <option value="">Select Project Name</option>
					  <? foreign_relation('crm_project_org','id','name',$project_id,'1'); ?>
					</select>
				</div>
				
				 <div class="col-6">
					   <label for="form2" >Date</label>
					   <input type="Date" name="s_date" class="form-control validate-text" id="end_time" placeholder="End Time" required>
				</div>
				
				 <div class="col-6">
				 <input type="hidden" name="latitude" id="latitude" class="form-control" required value="<?=$_POST['latitude']?>" readonly/>
        				<input type="hidden" name="longitude" id="longitude" class="form-control" required value="<?=$_POST['longitude']?>"  readonly/>   
						<input type="hidden" name="schedule_notes" id="schedule_notes" class="form-control" required value="OUT OF OFFICE"  readonly/> 
					   <label for="form2" >Start Time</label>
					    <input type="time" name="start_time" class="form-control validate-text" id="start_time" placeholder="Start Time" required>
				</div>
				
				 <div class="col-6">
					   <label for="form2" >End Time</label>
					    <input type="time" name="end_time" class="form-control validate-text" id="end_time" placeholder="End Time" required>
				</div>
				
				
            </div>
            
            
<?php /*?><div class="row">
    <div class="col-md-5">
        <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="type" class="color-highlight">TADA Type</label>
            <select name="type" id="type" class="form-control">
                <option></option>
                <option>Food</option>
                <option>Transport</option>
                <option>Other</option>
            </select>
        </div>
    </div>

    <div class="col-md-5">
        <div class="input-style has-borders no-icon mb-4 input-style-active">
            <label for="amount" class="color-highlight">Amount</label>
            <input type="text" name="amount" id="amount" class="form-control" placeholder="Enter amount">
        </div>
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <div class="input-style has-borders no-icon mb-4 input-style-active">
            <!--<button type="button" name="send" class="btn btn-primary w-100" id="butsend">Add New</button>-->
             <input type="button" name="send" class="btn btn-primary" value="Add TADA" id="butsend">
        </div>
    </div>
</div>


<!-- Table to display added rows OF TADA -->
<table id="table1" name="table1" class="table table-bordered table-sm mt-4">
    <thead>
        <tr class="table-success">
            <th>SL</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<?php */?>

            <div class="d-flex justify-content-center row">
                <div class="col-6">
                    <input type="submit" name="save_leave" class="btn btn-3d btn-m btn-full mb-0 b-n rounded-xs font-900 shadow-s btn-success w-100">
                </div>
            </div>
        </div>
    </form>
</div>
<style>
    .date-time p,
.costs p {
    margin: 2px 0; /* Reduce margin to 2px */
}
.location {
  
    vertical-align: middle; /* Center text vertically */
    height: 100px; /* Set a height if necessary for vertical centering */
}
.costs {
  
    vertical-align: middle; /* Center text vertically */
    height: 100px; /* Set a height if necessary for vertical centering */
}
.serial-number {
  
    vertical-align: middle; /* Center text vertically */
    height: 100px; /* Set a height if necessary for vertical centering */
}
.btn-sm {
    padding: 5px 5px !important;
}

</style>
			
<div class="card card-style">
<form action="od_entry.php" method="post">
<!-- Table to display added rows -->
<table id="table2" name="table2" class="table table-borderless text-center table-scroll table_new_border" style=" font-size: 11px !important; zoom: 80% !important;"> 
    <thead>
        <tr class="bg-night-light1" style="text-wrap: nowrap;">
            <th>SL</th>
            <!--<th>Lacation</th>-->
			<th>Punch</th>
            <th>Date Time</th>
            <th>Conveyance bill</th>
             <th>Total Amount</th>
              <th>Add TADA</th>
        </tr>
<?php
// Function to get location name from latitude and longitude
function getLocationName($latitude, $longitude) {
    $apiKey = "AIzaSyBesXXt7OdJx2wz7Q3REhPvqgLLKCWYSWI"; // Replace with your actual Google API Key
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=$apiKey";
    
    // Get the response from Google API
    $response = file_get_contents($url);
    
    // Check if the response was received
    if ($response === FALSE) {
        return "Error: Unable to connect to Google API";
    }

    $json = json_decode($response, true);
    
    // Debug the response if needed
    // echo '<pre>'; print_r($json); echo '</pre>';

    // Check if the request was successful
    if (isset($json['status']) && $json['status'] == 'OK') {
        // Return the formatted address from the response
        return $json['results'][0]['formatted_address'];
    } else {
        // Return a detailed error message
        $errorMessage = isset($json['error_message']) ? $json['error_message'] : "Unknown error occurred";
        return "Location not found. Error: " . $errorMessage;
    }
}


// Fetch data from the database
$sql_t = "SELECT * FROM hrm_od_info a WHERE PBI_ID='" . $PBI_ID . "' ORDER BY id DESC";
$query2 = db_query($sql_t);

$sl= 0;
while ($data2 = mysqli_fetch_object($query2)) {
    // Get location name using latitude and longitude
    $locationName = getLocationName($data2->latitude, $data2->longitude);
    $sl++
?>
    <tr><td colspan = "6" align="center"><stong style=" font-weight: bold; "><?= find_a_field('crm_project_org','name','id="'.$data2->project_id.'"');?></stong></td></tr>
    <tr class="table-row">
        <td class="serial-number"><?=$sl ?></td> <!-- Replace SL with a dynamic number -->
        <!--<td class="costs"><p>Latitude :<?= $data2->latitude  ?></p> <p>Longitude: <?= $data2->longitude ?></p></td> --><!-- Display the location name -->
		<td>

			<input type="hidden" name="od_id_<?=$data2->id;?>" id="od_id_<?=$data2->id;?>" class="form-control" required value="<?=$data2->id;?>"  readonly/>
		    <input type="hidden" name="latitude_od_<?=$data2->id;?>" id="latitude_od_<?=$data2->id;?>" class="form-control" required value="<?=$_POST['latitude_od_'.$data2->id]?>" readonly/>
        	<input type="hidden" name="longitude_od_<?=$data2->id;?>" id="longitude_od_<?=$data2->id;?>" class="form-control" required 
			value="<?=$_POST['latitude_od_'.$data2->id]?>"  readonly/>   
			<input type="hidden" name="schedule_notes_<?=$data2->id;?>" id="schedule_notes_<?=$data2->id;?>" class="form-control" required value="OUT OF OFFICE"  readonly/>
		<? if ($data2->od_att_status == 'STARTED'){?>
		      <input type="submit" name="punch_in_<?=$data2->id;?>" class="btn btn-sm bg-mint-dark" value="In Punch">
		<? } elseif($data2->od_att_status == 'PROCESSING'){?> 
			 <input type="submit" name="punch_out_<?=$data2->id;?>" class="btn btn-sm btn-danger" value="Out Punch">
		<? } elseif($data2->od_att_status == 'COMPLETED'){?> 
				<span style="color:#00CC33"> <strong>Meeting Completed</strong></span> 
		<? } else{ echo 'Something was wrong'; } ?>

		</td>
        <td class="date-time">
            <p class="date" align="center" style="  margin-top: -15%; "><span><?= $data2->s_date ?></span> (<strong><?= $data2->s_time ?></strong> To <strong><?= $data2->e_time ?></strong>)</p>
<!--            <p class="start-time">Start Time: <span></span></p>
            <p class="end-time">End Time: <span></span></p>-->
        </td>
<td class="costs">
    <?php
    // SQL query to get the row from the bills table
     $sql_bill = "SELECT * FROM bills WHERE od_id ='" . $data2->id . "'";
    $query3 = db_query($sql_bill);

    // Fetch the row containing conveyance types and amounts
    $row = mysqli_fetch_assoc($query3);

    // Split conveyance_type and amount if they are comma-separated
    $conveyance_types = explode(',', $row['conveyance_type']);  // Split by comma
    $amounts = explode(',', $row['amount']);  // Split by comma

    // Loop through each conveyance type and display with corresponding amount
    // foreach ($conveyance_types as $index => $type) {
    //     $amount = isset($amounts[$index]) ? $amounts[$index] : 0;  // Get corresponding amount or default to 0
    //     echo '<p class="'.strtolower($type).'">'.ucfirst($type).': <span>'.$amount.'</span></p>';
    // }
    
    $total_amount = 0;

    // Loop through each conveyance type and display with corresponding amount
    foreach ($conveyance_types as $index => $type) {
        $amount = isset($amounts[$index]) ? $amounts[$index] : 0;  // Get corresponding amount or default to 0
        echo '<p class="'.strtolower($type).'">'.ucfirst($type).': <span>'.$amount.'</span></p>';
        
        // Add amount to total
        $total_amount += (float)$amount;  // Convert to float in case it's a string
    }
    
    
    
    ?>
</td>
 <td class="serial-number"><?=$total_amount ?></td>
 
 <td class="serial-number">
		<? if ($data2->od_att_status == 'STARTED'){?>
		      <span style="color:#d0781a;"> <strong>Please IN Punch For TADA</strong></span>
		<? } elseif($data2->od_att_status == 'COMPLETED'){?> 
			 <a href='od_entry_edit.php?id=<?= $data2->id ?>' class='btn btn-sm btn-warning'><i class="fa-solid fa-plus"></i> TADA </a>
		<? } else{?> <span style="color:#ea0034"> <strong>Please OUT Punch For TADA</strong></span>  <? } ?>
 
</td>
    </tr>
	
	

<?php
}
?>

    </thead>
    <tbody></tbody>
</table>
		</form>
    </div>	

<script>
// $(document).ready(function() {
//     var id = 1;  // Starting ID for rows

//     // Event for Add New button
//     $("#butsend").on('click', function() {
//         console.log("Button clicked");  // For debugging

//         // Check if the type and amount inputs are properly detected
//         var typeField = $("#type");
//         var amountField = $("#amount");

//         // Debugging the field elements
//         console.log(typeField); // Should print jQuery object for #type
//         console.log(amountField); // Should print jQuery object for #amount

//         // Get values
//         var typeVal = typeField.val();
//         var amountVal = amountField.val();

//         // Logging the values
//         console.log("Type:", typeVal); 
//         console.log("Amount:", amountVal); 

//         // Check if the fields have values
//         if(typeVal && amountVal) {
//             // Append new row to the table
//             $("#table1 tbody").append('<tr id="'+id+'">\n\
//                 <td>' + id + '</td>\n\
//                 <td class="type'+id+'">' + typeVal + '</td>\n\
//                 <td class="amount'+id+'">' + amountVal + '</td>\n\
//                 <td><a href="#" class="remCF btn btn-danger">X</a></td>\n\
//             </tr>');
//             id++;  // Increment row ID
//         } else {
//             alert("Please fill both Type and Amount fields.");
//         }
//     });

//     // Remove row from table
//     // $("#table1").on('click', '.remCF', function() {
//     //     $(this).closest('tr').remove();
//     // });
    
//     $("#table1").on('click', '.remCF', function() {
//     console.log("Remove button clicked"); // Debugging message
//     $(this).closest('tr').remove(); // This should remove the closest table row
// });
// });

$(document).ready(function() {
    var id = 1;

    // Add New button event
    $("#butsend").on('click', function() {
        var typeVal = $("#type").val();
        var amountVal = $("#amount").val();

        if (typeVal && amountVal) {
            // Append new row
            $("#table1 tbody").append('<tr id="'+id+'">\n\
                <td>' + id + '</td>\n\
                <td class="type'+id+'">' + typeVal + '</td>\n\
                <td class="amount'+id+'">' + amountVal + '</td>\n\
                <td><a href="#" class="remCF btn btn-danger">X</a></td>\n\
            </tr>');
            id++;
        } else {
            alert("Please fill both Type and Amount fields.");
        }
    });

    // Remove row
    $("#table1").on('click', '.remCF', function() {
        $(this).closest('tr').remove();
    });

    // Form submit event to collect table data
    $("form").on('submit', function(e) {
        var billTypes = [];
        var billAmounts = [];

        $("#table1 tbody tr").each(function() {
            var type = $(this).find("td:nth-child(2)").text();
            var amount = $(this).find("td:nth-child(3)").text();

            billTypes.push(type);
            billAmounts.push(amount);
        });

        // Append hidden inputs to the form
        $("<input>").attr({
            type: "text",
            name: "bill_types[]",
            value: billTypes
        }).appendTo("form");

        $("<input>").attr({
            type: "text",
            name: "bill_amounts[]",
            value: billAmounts
        }).appendTo("form");
    });
});


</script>
	
			
			
			
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

<script>
window.onload = function() {
    // Check if Geolocation is supported
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    document.getElementById("latitude").value = latitude;
    document.getElementById("longitude").value = longitude;
	
    // Set the values for the secondary location (longitude_od and latitude_od)
	<?php
	$sql_t = "SELECT * FROM hrm_od_info a WHERE PBI_ID='" . $PBI_ID . "' ORDER BY id DESC";
	$query2 = db_query($sql_t);
	$sl= 0;
	while ($data2 = mysqli_fetch_object($query2)) {?>
		document.getElementById("latitude_od_<?=$data2->id;?>").value = latitude;
		document.getElementById("longitude_od_<?=$data2->id;?>").value = longitude;  
	<? } ?>
	
    var latlng = latitude + "," + longitude;
    var apiKey = "AIzaSyAKYGY2-qCVcd9EdlPJCcSvawTOReYGJew"; // Replace with your own API key
    var url = "https://maps.googleapis.com/maps/api/geocode/json?key=" + apiKey + "&latlng=" + latlng + "&sensor=true";

    $.getJSON(url, function(data) {
        console.log(data); // Print the full response for debugging

        if (data.status === "OK" && data.results.length > 0) {
            document.getElementById("adresssss").value = data.results[0].formatted_address;
        } else {
            console.error("Geocoding failed: " + data.status);
          //  alert("Failed to retrieve address. Please try again. Status: " + data.status);
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error fetching geocoding data:", textStatus, errorThrown);
        alert("Error fetching geocoding data.");
    });
}


function showError(error) {
    // Handle geolocation errors
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}

</script>


	
						

			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
        </div>
    <!-- End of Page Content--> 
    
    











<?php 
 require_once '../assets/template/inc.footer.php';
  selected_two('#emp_id1');
 selected_two('#project_id');
 
 
 ?>