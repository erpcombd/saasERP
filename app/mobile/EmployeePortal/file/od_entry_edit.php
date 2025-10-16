<?php 
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/emp_apps_function.php';

$title = "OD Edit Form";
$page = "od_entry_edit.php";

 $od_id = $_GET['id'];

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


$leave_status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);
    $sql ="SELECT group_od_id 
FROM hrm_od_info 
ORDER BY group_od_id DESC limit 1";
    $query_group_od_id = db_query($sql);
    $row_group_od_id = mysqli_fetch_assoc($query_group_od_id);
    $last_group_id=$row_group_od_id['group_od_id'];



if (isset($_POST['send'])) {
    // Get the values from the form
    $od_id = $_GET['id'];  // Assuming the od_id is passed in the URL
    $new_conveyance_type = $_POST['type'];  // New value for conveyance_type
    $new_amount = $_POST['amount'];  // New value for amount

    // Fetch existing conveyance_type and amount from the database
    $sql = "SELECT conveyance_type, amount FROM bills WHERE od_id = '$od_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Split the existing values into arrays
        $conveyance_types = explode(',', $row['conveyance_type']);
        $amounts = explode(',', $row['amount']);

        // Check if the new conveyance type already exists
        $index = array_search($new_conveyance_type, $conveyance_types);

        if ($index !== false) {
            // Update existing conveyance type and amount
            $amounts[$index] = $new_amount; // Update the corresponding amount
        } else {
            // Add new conveyance type and amount
            $conveyance_types[] = $new_conveyance_type; // Add new type
            $amounts[] = $new_amount; // Add new amount
        }

        // Recreate the comma-separated strings
        $updated_conveyance_types = implode(',', $conveyance_types);
        $updated_amounts = implode(',', $amounts);

        // Update the database with the new values
        $update_sql = "UPDATE bills 
                       SET conveyance_type = '$updated_conveyance_types', amount = '$updated_amounts' 
                       WHERE od_id = '$od_id'";

        if ($conn->query($update_sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "No record found for the given od_id.";
    }
}






?>

    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
   
   


		
		
		

<div class="card card-style">
  <form action="od_entry_edit.php?id=<?= $od_id ?>" method="post">
  <input name="PBI_ID" type="hidden" class="form-control validate-text" value="<?= $PBI_ID ?>" readonly required/>
<div class="row m-0">
				
        <div class="col-md-12">
            <p style="text-align: center;color: green; font-size: 23px; margin:0px; font-weight: 700;"><?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "' . $PBI_ID . '"') ?> (<?= $PBI_ID ?>)</p>
        </div>
    </div>

    <div class="row m-0">
			<div class="col-12 p-0">
					<label for="type">Conveyance Type</label>
							<select name="type" id="type" class="form-control" required>
								<option value="">Select Type</option>
								<option value="Food">Food</option>
								<option value="Transport">Transport</option>
								<option value="Other">Other</option>
							</select>
			</div>


        <div class="col-12 p-0">
                <label for="amount">Amount</label>
                <input type="text" name="amount" id="amount" class="form-control" placeholder="Enter amount" required>
        </div>

			<div class="d-flex justify-content-center row pt-3 m-0 p-0">
                <div class="col-8">
                     <input type="submit" name="send" class="btn btn-3d btn-m btn-full mb-0 b-n rounded-xs font-900 shadow-s btn-primary w-100" value="Add/Update TA/TD">
                </div>
            </div>
			
        <!--<div class="col-md-2 d-flex align-items-end">
            <div class="input-style has-borders no-icon mb-4 input-style-active">
                <input type="submit" name="send" class="btn btn-3d btn-m btn-full mb-0 b-n rounded-xs font-900 shadow-s btn-primary w-100" value="Add/Update TA/TD">
            </div>
        </div>-->
		
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
</style>
			
<div class="card card-style">
<!-- Table to display added rows -->

<table id="table2" name="table2" class="table table-borderless text-center table-scroll table_new_border" style=" font-size: 11px !important; zoom: 80% !important;">
    <thead>
        <tr class="bg-night-light1">
            <th>SL</th>
            <th>Lacation</th>
            <th>Date Time</th>
            <th>Convince bill</th>
             <th>Total Amount</th>
     
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
 $sql_t = "SELECT * FROM hrm_od_info a WHERE PBI_ID='" . $PBI_ID . "' and id ='" . $od_id . "'";
$query2 = db_query($sql_t);

$sl= 0;
while ($data2 = mysqli_fetch_object($query2)) {
    // Get location name using latitude and longitude
    $locationName = getLocationName($data2->latitude, $data2->longitude);
    $sl++
?>
    <tr class="table-row">
        <td class="serial-number"><?=$sl ?></td> <!-- Replace SL with a dynamic number -->
        <td class="costs"><p>Latitude :<?= $data2->latitude  ?></p> <p>Longitude: <?= $data2->longitude ?></p>
       
        
        </td> <!-- Display the location name -->
        <td class="date-time">
            <p class="date">Date: <span><?= $data2->s_date ?></span></p>
            <p class="start-time">Start Time: <span><?= $data2->s_time ?></span></p>
            <p class="end-time">End Time: <span><?= $data2->e_time ?></span></p>
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
 

    </tr>
<?php
}
?>

    </thead>
    <tbody></tbody>
</table>

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