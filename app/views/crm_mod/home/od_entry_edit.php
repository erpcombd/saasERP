<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";

// Check if this is an AJAX request
$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Only include layout.top.php if not an AJAX request
if (!$is_ajax) {
    require_once SERVER_CORE."routing/layout.top.php";
}
 
$title = "OD Edit Form";
$page = "od_entry_edit.php";

// Validate and sanitize input
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid OD ID");
}
$od_id = (int)$_GET['id'];

$u_id = $_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$user_id = $PBI_ID;

$root = 'leave';
$table = 'hrm_leave_info';
$unique = 'id';
$shown = 'type';
$g_s_date = date('Y-01-01');
$g_e_date = date('Y-12-31');
do_calander('#leave_apply_date');
$unique_name = md5(uniqid(rand(), true));
$_SESSION['employee_selected'] = $PBI_ID;
$essentialInfo = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);
$leave_status = find_a_field('hrm_leave_info','leave_status','id='.$od_id);
$incharge_status = find_a_field('hrm_leave_info','incharge_status','id='.$od_id);
$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);

$od_s_date = find_a_field('hrm_od_info','s_date','id='.$od_id);

$sql = "SELECT group_od_id FROM hrm_od_info ORDER BY group_od_id DESC LIMIT 1";
$query_group_od_id = db_query($sql);
$row_group_od_id = mysqli_fetch_assoc($query_group_od_id);
$last_group_id = $row_group_od_id['group_od_id'] ?? 0;

// Initialize message variables
$message = '';
$message_type = '';

if (isset($_POST['send'])) {
    // Validate and sanitize form inputs
    $from_address = trim($_POST['from'] ?? '');
    $to_address = trim($_POST['to'] ?? '');
    $new_conveyance_type = trim($_POST['type'] ?? '');
    $new_transport_type = trim($_POST['transport_type'] ?? '');
    $new_amount = floatval($_POST['amount'] ?? 0);

    // Basic validation
    if (empty($new_conveyance_type)) {
        $message = "Conveyance type is required";
        $message_type = "error";
    } elseif ($new_amount <= 0) {
        $message = "Amount must be greater than 0";
        $message_type = "error";
    } elseif ($new_conveyance_type === 'Transport' && (empty($from_address) || empty($to_address) || empty($new_transport_type))) {
        $message = "For transport type, from address, to address, and transport type are required";
        $message_type = "error";
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT conveyance_type, transport_type, amount, from_address, to_address FROM bills WHERE od_id = ?");
        $stmt->bind_param("i", $od_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Handle empty or null values
            $conveyance_types = !empty($row['conveyance_type']) ? explode(',', $row['conveyance_type']) : [];
            $transport_types = !empty($row['transport_type']) ? explode(',', $row['transport_type']) : [];
            $amounts = !empty($row['amount']) ? explode(',', $row['amount']) : [];

            // Check if the new conveyance type already exists
            $conveyance_index = array_search($new_conveyance_type, $conveyance_types);
            $transport_index = array_search($new_transport_type, $transport_types);

            if ($conveyance_index !== false && $transport_index !== false && $conveyance_index == $transport_index) {
                // Update existing entry (same index for both conveyance and transport)
                $amounts[$conveyance_index] = $new_amount;
            } else {
                // Add new entry
                $conveyance_types[] = $new_conveyance_type;
                $transport_types[] = $new_transport_type;
                $amounts[] = $new_amount;
            }

            // Recreate comma-separated strings
            $updated_conveyance_types = implode(',', $conveyance_types);
            $updated_transport_types = implode(',', $transport_types);
            $updated_amounts = implode(',', $amounts);
            
            if($from_address == ''  || $to_address == ''){
                if($from_address == ''){
                    $from_address = find_a_field('bills','from_address','od_id = "'.$od_id.'" ');
                }
                if($to_address == ''){
                    $to_address = find_a_field('bills','to_address','od_id = "'.$od_id.'" ');
                }
            }
            
            $bills_details_id = find_a_field('bills_details','bills_id','od_id = "'.$od_id.'" and conveyance_type = "'.$new_conveyance_type.'"');

            // Update database using prepared statement
            $status = 'UNCHECKED';
            $update_stmt = $conn->prepare("UPDATE bills SET conveyance_type = ?, transport_type = ?, amount = ?, from_address = ?, to_address = ?, status = ? WHERE od_id = ?");
            $update_stmt->bind_param("ssssssi", $updated_conveyance_types, $updated_transport_types, $updated_amounts, $from_address, $to_address, $status, $od_id);
            
            $od_id2 = find_a_field('bills', 'bills_id', 'od_id = "'.$od_id.'"');
            $emp_code2 = find_a_field('bills', 'emp_code', 'od_id = "'.$od_id.'"');
            
            // ta_da details updatte here 
            
        if($bills_details_id > 0){
               $update__details_stmt = $conn->prepare("UPDATE bills_details SET conveyance_type = ?, amount = ? , transport_type = ?, from_address = ?, to_address = ?, status = ? WHERE od_id = ? and bills_id = ?"  );
               
                $update__details_stmt->bind_param("sissssii", $new_conveyance_type,$new_amount,  $new_transport_type,$from_address, $to_address, $status, $od_id, $bills_details_id );
                
                
                $update__details_stmt->execute();
        }else{
                $insert__details_stmt = $conn->prepare("INSERT INTO bills_details (od_id, conveyance_no, conveyance_type, from_address, to_address, transport_type, amount, status, entry_by, emp_code, conveyance_date) VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?)");
                $insert__details_stmt->bind_param("iissssdsiis", $od_id,$od_id2, $new_conveyance_type, $from_address, $to_address, $new_transport_type, $new_amount, $status, $user_id, $emp_code2, $od_s_date);
                $insert__details_stmt->execute();
                
    
}

            // Update database using prepared statement
//             $status = 'UNCHECKED';
//             $update_stmt = $conn->prepare("UPDATE bills SET conveyance_type = ?, transport_type = ?, amount = ?, from_address = ?, to_address = ?, status = ? WHERE od_id = ?");
//             $update_stmt->bind_param("ssssssi", $updated_conveyance_types, $updated_transport_types, $updated_amounts, $from_address, $to_address, $status, $od_id);
            
//           $insert__details_stmt = $conn->prepare("INSERT INTO bills_details (od_id, conveyance_type, from_address, to_address, transport_type, amount, status, entry_by, emp_code,conveyance_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
// $insert__details_stmt->bind_param("issssdssis", $od_id, $new_conveyance_type, $from_address, $to_address, $new_transport_type, $new_amount, $status, $user_id, $PBI_ID, $conveyance_date);
// $insert__details_stmt->execute();
            
            if ($update_stmt->execute()) {
                $message = "Record updated successfully";
                $message_type = "success";
            } else {
                $message = "Error updating record: " . $conn->error;
                $message_type = "error";
            }
            $update_stmt->close();
        } else {
            $status = 'UNCHECKED';

            // No existing record, create new one
            $insert_stmt = $conn->prepare("INSERT INTO bills (od_id, conveyance_type, from_address, to_address, transport_type, amount, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("issssds", $od_id, $new_conveyance_type, $from_address, $to_address, $new_transport_type, $new_amount, $status);
            
            $insert__details_stmt = $conn->prepare("INSERT INTO bills_details (od_id, conveyance_type, from_address, to_address, transport_type, amount, status, entry_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $insert__details_stmt->bind_param("issssdsi", $od_id, $new_conveyance_type, $from_address, $to_address, $new_transport_type, $new_amount, $status, $user_id);
            $insert__details_stmt->execute();
            
            // echo 'Insert bills =INSERT INTO bills (od_id, conveyance_type, from_address, to_address, transport_type, amount, status) VALUES ("'.$od_id.'", "'.$new_conveyance_type.'", "'.$from_address.'", "'.$to_address.'", "'.$new_transport_type.'", "'.$new_amount.'", "'.$status.'")';
            // exit;
            if ($insert_stmt->execute()) {
                $message = "New record created successfully";
                $message_type = "success";
            } else {
                $message = "Error creating record: " . $conn->error; 
                $message_type = "error";
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
}
?>
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- start of Page Content-->  
<div class="page-content header-clear-medium">

    <!-- Success/Error Messages -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $message_type == 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($message); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card card-style p-2">
        <form action="od_entry_edit.php?id=<?= $od_id ?>" method="post" id="tadaForm">
            <input name="PBI_ID" type="hidden" class="form-control validate-text" value="<?= htmlspecialchars($PBI_ID) ?>" readonly required/>
            
            <div class="row m-0">
                <div class="col-md-12">
                    <p style="text-align: center;color: green; font-size: 20px; margin:0px; font-weight: 700;">
                        <?= htmlspecialchars(find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "' . $PBI_ID . '"')) ?> (<?= htmlspecialchars($PBI_ID) ?>)
                    </p>
                </div>
            </div>

            <div class="row m-0 mt-3">
                <div class="col-12 mb-3">
                    <label for="type">Conveyance Type <span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="">Select Type</option>
                        <option value="Food">Food</option>
                        <option value="Transport">Transport</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="col-12" id="from_to" style="display: none;">
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <label for="from">From <span class="text-danger">*</span></label>
                            <input type="text" name="from" class="form-control validate-text" id="from" placeholder="From Address">
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label for="to">To <span class="text-danger">*</span></label>
                            <input type="text" name="to" class="form-control validate-text" id="to" placeholder="To Address">
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-3" id="transport_type_container" style="display: none;">
                    <label for="transport_type">Transport Type <span class="text-danger">*</span></label>
                    <select name="transport_type" id="transport_type" class="form-control">
                        <option value="">Select Type</option>
                        <option value="Bus">Bus</option>
                        <option value="CNG">CNG</option>
                        <option value="Bike">Bike</option>
                        <option value="Rickshaw">Rickshaw</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label for="amount">Amount <span class="text-danger">*</span></label>
                    <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" step="0.01" min="0.01" required>
                </div>

                <div class="col-12 text-center mt-2">
                    <button type="submit" name="send" class="btn btn-primary">Add/Update</button>
                </div>
            </div>
        </form>
    </div>

    <style>
        .date-time p,
        .costs p {
            margin: 2px 0;
        }
        .location {
            vertical-align: middle;
            height: 100px;
        }
        .costs {
            vertical-align: middle;
            height: 100px;
        }
        .serial-number {
            vertical-align: middle;
            height: 100px;
        }
        .alert {
            margin-bottom: 20px;
        }
        .text-danger {
            color: #dc3545 !important;
        }
        
        /* Form styling improvements */
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 0.375rem 0.75rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }
        
        .row {
            margin-left: 0;
            margin-right: 0;
        }
        
        #from_to .row {
            margin: 0;
        }
        
        #from_to .col-md-6 {
            padding-left: 0;
            padding-right: 15px;
        }
        
        #from_to .col-md-6:last-child {
            padding-right: 0;
        }
        
        @media (max-width: 768px) {
            #from_to .col-md-6 {
                padding-right: 0;
                padding-left: 0;
            }
        }
    </style>
                
    <div class="card card-style">
        <!-- Table to display added rows -->
        <table id="table2" name="table2" class="table table-borderless text-center table-scroll table_new_border" style=" font-size: 11px !important; zoom: 80% !important;">
            <thead>
                <tr class="bg-night-light1">
                    <th>SL</th>
                    <th>Location</th>
                    <th>Date Time</th>
                    <th>From/To</th>
                    <th>Conveyance Type</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Function to get location name from latitude and longitude
                function getLocationName($latitude, $longitude) {
                    $apiKey = "AIzaSyBesXXt7OdJx2wz7Q3REhPvqgLLKCWYSWI";
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=$apiKey";
                    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec($ch);
                    
                    if (curl_error($ch)) {
                        $error = curl_error($ch);
                        curl_close($ch);
                        return "Error: " . $error;
                    }
                    curl_close($ch);

                    if ($response === FALSE) {
                        return "Error: Unable to connect to Google API";
                    }

                    $json = json_decode($response, true);

                    if (isset($json['status']) && $json['status'] == 'OK' && !empty($json['results'])) {
                        return $json['results'][0]['formatted_address'];
                    } else {
                        $errorMessage = isset($json['error_message']) ? $json['error_message'] : "Unknown error occurred";
                        return "Location not found. Error: " . $errorMessage;
                    }
                }
    
    $od_info = find_all_field('hrm_od_entry','','id = "'.$od_id.'"');
    
                // Fetch data from the database using prepared statement
                $stmt = $conn->prepare("SELECT * FROM bills_details WHERE od_id = ?");
                $stmt->bind_param("i", $od_id);
                $stmt->execute();
                $result = $stmt->get_result();

                $sl = 0;
                while ($data2 = $result->fetch_object()) {
                    $locationName = getLocationName($od_info->latitude, $od_info->longitude);
                    $sl++;
                ?>
                    <tr class="table-row">
                        <td class="serial-number"><?= $sl ?></td>
                        <td class="costs">
                            <p>Latitude: <?= htmlspecialchars($od_info->latitude) ?></p>
                            <p>Longitude: <?= htmlspecialchars($od_info->longitude) ?></p>
                        </td>
                        <td class="date-time">
                            <p class="date">Date: <span><?= htmlspecialchars($od_info->s_date) ?></span></p>
                            <p class="start-time">Start Time: <span><?= htmlspecialchars($od_info->s_time) ?></span></p>
                            <p class="end-time">End Time: <span><?= htmlspecialchars($od_info->e_time) ?></span></p>
                        </td>
                        <td class="costs">
                           <?php
                        if($data2->conveyance_type == 'Transport'){
                            if ($data2->from_address != '' && $data2->to_address != '') {
                                echo '<p><strong>From:</strong> ' . htmlspecialchars($data2->from_address ?? 'N/A') . '</p>';
                                echo '<p><strong>To:</strong> ' . htmlspecialchars($data2->to_address ?? 'N/A') . '</p>';

                            } elseif($data2->from_address != ''){
                                 echo '<p><strong>From:</strong> ' . htmlspecialchars($data2->from_address ?? 'N/A') . '</p>';
                            }elseif($data2->to_address != '') {
                                echo '<p><strong>To:</strong> ' . htmlspecialchars($data2->to_address ?? 'N/A') . '</p>';
                            }
                            else{
                                echo '<p>No address data</p>';

                            }
                        }
                            ?>
                        </td>
                        <td>
                             <?php
                       
                            echo $data2->conveyance_type;
                          
                            ?>
                        </td>
                        <td class="costs">
                           <?php
                       
                            echo $data2->amount;
                          
                            ?>
                        </td>
                       
                    </tr>
                <?php
                $total_amt +=  $data2->amount; 
                
                }
                $stmt->close();
                ?>
                <tr>
                    <td colspan="6" >Total Amount : <?php echo $total_amt; ?></td>
                    
                </tr>
            </tbody>
        </table>
    </div>

    <script>
    $(document).ready(function() {
        $('#type').change(function() {
            var selectedType = $(this).val();
            
            if (selectedType === 'Transport') {
                $('#transport_type_container').show();
                $('#transport_type').prop('required', true);
                $('#from_to').show();
                $('#from, #to').prop('required', true);
            } else {
                $('#transport_type_container').hide();
                $('#transport_type').prop('required', false);
                $('#transport_type').val('');
                $('#from_to').hide();
                $('#from, #to').prop('required', false);
                $('#from, #to').val('');
            }
        });

        // Form validation
        $('#tadaForm').on('submit', function(e) {
            var conveyanceType = $('#type').val();
            var amount = parseFloat($('#amount').val());

            if (!conveyanceType) {
                e.preventDefault();
                alert('Please select a conveyance type');
                return false;
            }

            if (isNaN(amount) || amount <= 0) {
                e.preventDefault();
                alert('Please enter a valid amount greater than 0');
                return false;
            }

            if (conveyanceType === 'Transport') {
                var from = $('#from').val().trim();
                var to = $('#to').val().trim();
                var transportType = $('#transport_type').val();

                if (!from || !to || !transportType) {
                    e.preventDefault();
                    alert('For transport type, please fill in from address, to address, and transport type');
                    return false;
                }
            }
        });
    });

    // Geolocation functionality (if needed)
    window.onload = function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        // Only set values if elements exist
        if (document.getElementById("latitude")) {
            document.getElementById("latitude").value = latitude;
        }
        if (document.getElementById("longitude")) {
            document.getElementById("longitude").value = longitude;
        }

        var latlng = latitude + "," + longitude;
        var apiKey = "AIzaSyAKYGY2-qCVcd9EdlPJCcSvawTOReYGJew";
        var url = "https://maps.googleapis.com/maps/api/geocode/json?key=" + apiKey + "&latlng=" + latlng + "&sensor=true";

        $.getJSON(url, function(data) {
            console.log(data);

            if (data.status === "OK" && data.results.length > 0) {
                if (document.getElementById("adresssss")) {
                    document.getElementById("adresssss").value = data.results[0].formatted_address;
                }
            } else {
                console.error("Geocoding failed: " + data.status);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error fetching geocoding data:", textStatus, errorThrown);
        });
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                console.log("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                console.log("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                console.log("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                console.log("An unknown error occurred.");
                break;
        }
    }
    </script>

</div>
<!-- End of Page Content--> 

<?php
// Only include layout.bottom.php if not an AJAX request
if (!$is_ajax) {
    require_once SERVER_CORE."routing/layout.bottom.php";
}
?>