<?php

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 
$title='TA DA edit';			// Page Name and Page Title


$root='appsAtt';

$table='bills_details';		// Database Table Name Mainly related to this page
$unique='sl';				// Primary Key of this Database table
$shown='status';				// For a New or Edit Data a must have data field

$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');

// ::::: End Edit Section :::::

$_SESSION['employee_selected']=$_SESSION['user']['id'];

/*echo $sql = 'select * from hrm_attdump_apps where sl = '.$_GET['sl'];
$squery = mysql_query($sql);
$full_att = mysql_fetch_object($squery);*/

$full_att = find_all_field('hrm_attdump_apps','*','sl='.$_GET['sl']);
$PBI_ID = $full_att->EMP_CODE; 
$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);


$crud      =new crud($table);


if($_GET['sl']>0){
$$unique = $_GET['sl'];

$check_status=find_all_field_sql("select incharge_status from hrm_attdump_apps where sl='".$_GET['sl']."'");
if($check_status=='Approve'){
    echo '<script type="text/javascript">parent.parent.document.location.href = "../inventory/home.php";</script>'; 
}
}


$prev_lv=mysqli_num_rows(db_query("select * from hrm_iom_info 
where 
PBI_ID='".$PBI_ID."' and s_date='".$_REQUEST['s_date']."' and e_date='".$_REQUEST['e_date']."'"));






if(isset($_POST['forward'])){
    
            $status = 'UNCHECKED';
            $id = $_POST['update_id'];
            $amount = $_POST['amount'];
            $update_stmt = $conn->prepare("UPDATE bills_details SET  status = ?, amount = ? WHERE bills_id = ?");
            $update_stmt->bind_param("sdi", $status, $amount, $id);
            
//             echo "DEBUG SQL: UPDATE bills_details SET status = '$status',amount = '$amount' WHERE bills_id = $id";
// exit;
            
            if ($update_stmt->execute()) {
                $message = "Record updated successfully";
                $message_type = "success";
            } else {
                $message = "Error updating record: " . $conn->error;
                $message_type = "error";
            }
            $update_stmt->close();
            
            header("Location: tada_status.php");
exit;
    
}



if (isset($$unique)) {
    $condition = $unique . "=" . $$unique;
    $data = db_fetch_object($table, $condition);
    foreach ($data as $key => $value) {
        $$key = $value;
    }
}


if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

$bills_id = $_GET['sl'];

$tada_details = find_all_field('bills_details','','bills_id = "'.$bills_id.'"')
?>


<style type="text/css">
.MATERNITY_LEAVE{
display:none;
}

input[type="radio"], input[type="checkbox"] {
    line-height: normal;
    margin: 4px 0 0;
	width:20px;
}
.radio, .checkbox {
    min-height: 20px;
    padding-left: 20px;
}
.checkbox {
    margin-right: 4px !important;
}

.radio.inline, .checkbox.inline {
    display: inline-block;
    margin-bottom: 0;
    padding-top: 5px;
    vertical-align: middle;
}.radio.inline, .checkbox.inline {
    display: inline-block;
    margin-bottom: 0;
    padding-top: 5px;
    vertical-align: middle;
}
.radio.inline + .radio.inline, .checkbox.inline + .checkbox.inline {
    margin-left: 10px;
}
</style>

   <script>
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
          alert("Geolocation is not supported by this browser.");
        }
      }
      function showPosition(position) {
        //var lat = position.coords.latitude;
        //var lon = position.coords.longitude;
        var mapSrc = "https://maps.google.com/maps?q=" + <?=$full_att->latitude?> + "," + <?=$full_att->longitude?> + "&z=17&output=embed";
        document.getElementById("map").src = mapSrc;
      }
    </script>

<form action="" method="post" enctype="multipart/form-data">
  <div class="oe_view_manager oe_view_manager_current">
    <? //include('../../common/title_bar.php');?>
    <div class="oe_view_manager_body">
      <div class="oe_view_manager_view_list"></div>
      <div class="oe_view_manager_view_form">
        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
          <div class="oe_form_container">
            <div class="oe_form">
              <div class="">
                <div class="oe_form_sheetbg">
                
                </div>
                <div class="oe_chatter">
                  <div class="oe_followers oe_form_invisible">
                    <div class="oe_follower_list">
                        
                        
                         <div class="oe_form_sheet oe_form_sheet_width card shadow-sm p-3"> 
                    <?php echo $msggg; ?>
                    
                    <!-- Main Content -->
                    <div class="card-body">
                      <h4 class="card-title mb-4 border-bottom pb-2">TA DA Details</h4>
                      
                      <!-- Employee Information Section -->
                      <div class="card mb-4 bg-light">
                        <div class="card-body">
                          <h5 class="card-title mb-3">TA DA Information</h5>
                          
                          
                          <table class="table table-borderless">
                            <tbody>
                              <tr>
                                <td width="15%" class="fw-bold text-secondary">Conveyance Name:</td>
                                <td>
                                  <input type="hidden" name="update_id" value="<?=$tada_details->bills_id ?>" />
                                  <input name="conveyance" type="text" id="conveyance_type" value="<?=$tada_details->conveyance_type?>" class="form-control"  disabled/>
                                </td>
                              </tr>
                              
                              <tr>
                                <td class="fw-bold text-secondary">Amount:</td>
                                <td><input name="amount" type="text" id="amount" value="<?=$tada_details->amount?>" class="form-control"/></td>
                              </tr>
                              <? if($tada_details->hr_remarks!='') { ?>
                                  <tr>
                                <td class="fw-bold text-secondary">HR Remarks:</td>
                                <input type="hidden" name="hr_remarks" value="<?=$tada_details->hr_remarks ?>" />
                                <td><input name="hr_remarks" type="text" id="hr_remarks" value="<?=$tada_details->hr_remarks?>" class="form-control" disabled/></td>
                              </tr>
                                  <tr>
                                <td class="fw-bold text-secondary">User Remarks:</td>
                                <input type="hidden" name="user_remarks" value="<?=$tada_details->user_remarks ?>" />
                                <td><input name="user_remarks" type="text" id="user_remarks" value="<?=$tada_details->user_remarks?>" class="form-control"/></td>
                              </tr>

                              <? }
                                ?>
                              
                              
                              <!--<tr>-->
                              <!--  <td class="fw-bold text-secondary">Designation:</td>-->
                              <!--  <td><input name="designation" type="text" id="designation" value="<?=$full_desg?>" class="form-control" /></td>-->
                              <!--</tr>-->
                              
                              <!--<tr>-->
                              <!--  <td class="fw-bold text-secondary">Att Date:</td>-->
                              <!--  <td><input name="xdate" type="text" value="<?=$full_att->xdate;?>" class="form-control" /></td>-->
                              <!--</tr>-->
                            </tbody>
                          </table>
                        </div>
                      </div>


  <?php if($tada_details->status == "MANUAL"){ ?>
    <!-- Forward Button Section -->
    <div class="text-center mt-4">
        <button type="submit" name="forward" class="btn btn-primary">Forward</button>
    </div>
<?php } ?>

                      </div>
                    </div>
                  </div>
                        
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<?


require_once SERVER_CORE."routing/layout.bottom.php";


?>