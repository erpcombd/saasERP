<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




// ::::: Edit This Section ::::: 
$title='Att approve';			// Page Name and Page Title


$root='appsAtt';

$table='hrm_attdump_apps';		// Database Table Name Mainly related to this page
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



$_REQUEST['s_date']= date('Y-m-d',strtotime($_REQUEST['s_date']));
$_REQUEST['e_date']= date('Y-m-d',strtotime($_REQUEST['e_date']));


$prev_lv=mysqli_num_rows(db_query("select * from hrm_iom_info 
where 
PBI_ID='".$PBI_ID."' and s_date='".$_REQUEST['s_date']."' and e_date='".$_REQUEST['e_date']."'"));



if(isset($_POST['approve'])){
    
$_POST['incharge_status'] = "Approve";
$_POST['approve_by'] = $_SESSION['user']['id'];

$crud->update($unique);

$sql = 'insert into hrm_attdump(`ztime`,`bizid`,`EMP_CODE`, `xenrollid` ,`time`,`xtime`,`xdate`,`xlocationid`,`latitude`,`longitude`)

    value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'", "'.$PBI_ID.'" , "'.$PBI_ID.'" , "'.$_POST['in_time'].'","'.$_POST['in_time'].'","'.$full_att->xdate.'",

    "999","'.$full_att->latitude.'","'.$full_att->longitude.'")';
db_query($sql);	

 $sql = 'insert into hrm_attdump(`ztime`,`bizid`,`EMP_CODE`, `xenrollid` , `time`,`xtime`,`xdate`,`xlocationid`,`latitude`,`longitude`)

    value("'.date('Y-m-d H:i:s').'","'.$PBI_ID.'","'.$PBI_ID.'", "'.$PBI_ID.'", "'.$_POST['out_time'].'","'.$_POST['out_time'].'","'.$full_att->xdate.'",

    "999","'.$full_att->latitude.'","'.$full_att->longitude.'")';
db_query($sql);
	
	

echo '<script type="text/javascript">parent.parent.document.location.href = "../appsAtt/view_att_head.php";</script>';
}


// ----------------------------------------- FINAL Approve
if(isset($_POST['update'])){


	 $up_query="update hrm_attdump_apps set 
	 xtime ='".$_POST['in_time']."',
	 modified = 1
	
	 where sl=".$_POST['in_time_id'];
	 
	db_query($up_query);
	
	$up_query="update hrm_attdump_apps set 
	 xtime ='".$_POST['in_time']."',
	 modified = 1
	
	 where sl=".$_POST['out_time_id'];
	 
	db_query($up_query);


$crud->update($unique);


$msg='Successfully Updated.';

    
} // end update



//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);
		echo '<script type="text/javascript">
parent.parent.document.location.href = "../iom/unapp_iom_list.php";
</script>';
		$type=1;
		$msg='Successfully Deleted.';
}


/*if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}*/

if (isset($$unique)) {
    $condition = $unique . "=" . $$unique;
    $data = db_fetch_object($table, $condition);
    foreach ($data as $key => $value) {
        $$key = $value;
    }
}


if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
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
                  <div class="oe_form_sheet oe_form_sheet_width card shadow-sm p-3"> 
                    <?php echo $msggg; ?>
                    
                    <!-- Main Content -->
                    <div class="card-body">
                      <h4 class="card-title mb-4 border-bottom pb-2">Employee Attendance Details</h4>
                      
                      <!-- Employee Information Section -->
                      <div class="card mb-4 bg-light">
                        <div class="card-body">
                          <h5 class="card-title mb-3">Employee Information</h5>
                          
                          <table class="table table-borderless">
                            <tbody>
                              <tr>
                                <td width="15%" class="fw-bold text-secondary">Name:</td>
                                <td>
                                  <?
                                  $sql = db_query("select PBI_ID,PBI_NAME,PBI_DEPARTMENT,PBI_DESIGNATION from personnel_basic_info where PBI_ID = ".$_SESSION['employee_selected']."");
                                  $row = mysqli_fetch_object($sql);
                                  $full_name = $row->emptitle.' '.$row->first_name.' '.$row->middle_name.' '.$row->last_name;
                                  $full_desg = find_a_field('designation','DESG_DESC','DESG_ID='.$PBI->DESG_ID);
                                  ?>
                                  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                  <input name="PBI_ID" id="PBI_ID" value="<?=$PBI_ID?>" type="hidden" />
                                  <input name="first_name_bangla" type="text" id="first_name_bangla" value="<?=$PBI->PBI_NAME?>" class="form-control" />
                                </td>
                              </tr>
                              
                              <tr>
                                <td class="fw-bold text-secondary">Department:</td>
                                <td><input name="department" type="text" id="department" value="<?=$PBI->PBI_DEPARTMENT?>" class="form-control" /></td>
                              </tr>
                              
                              <tr>
                                <td class="fw-bold text-secondary">Designation:</td>
                                <td><input name="designation" type="text" id="designation" value="<?=$full_desg?>" class="form-control" /></td>
                              </tr>
                              
                              <tr>
                                <td class="fw-bold text-secondary">Att Date:</td>
                                <td><input name="xdate" type="text" value="<?=$full_att->xdate;?>" class="form-control" /></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      
                      <!-- Notes Section -->
                      <div class="card mb-4 bg-light">
                        <div class="card-body">
                          <h5 class="card-title mb-3">Notes</h5>
                          
                          <div class="mb-3">
                            <label for="schedule_notes" class="form-label fw-bold text-secondary">Additional Notes:</label>
                            <textarea name="schedule_notes" id="schedule_notes" class="form-control" rows="3"><?=$full_att->schedule_notes?></textarea>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Time Information Section -->
                      <div class="card mb-4 bg-light">
                        <div class="card-body">
                          <h5 class="card-title mb-3">Time Information</h5>
                          
                          <div class="row">
                            <? $inSq = 'select min(xtime) as xtime, sl from hrm_attdump_apps where xdate = "'.$full_att->xdate.'" and EMP_CODE = '.$full_att->EMP_CODE.' ';
                            $inQ = db_query($inSq);
                            $inData = mysqli_fetch_object($inQ);
                            
                            $outSq = 'select max(xtime) as xtime, sl from hrm_attdump_apps where xdate = "'.$full_att->xdate.'" and EMP_CODE = '.$full_att->EMP_CODE.' ';
                            $outQ = db_query($outSq);
                            $outData = mysqli_fetch_object($outQ);
                            ?>
                            
                            <div class="col-md-5">
                              <div class="input-group mb-3">
                                <span class="input-group-text fw-bold">IN Time</span>
                                <input name="in_time" readonly type="text" id="in_time" value="<?=$inData->xtime?>" class="form-control" />
                                <input name="in_time_id" type="hidden" id="in_time_id" value="<?=$inData->sl?>" />
                              </div>
                            </div>
                            
                            <div class="col-md-2 text-center d-flex align-items-center justify-content-center">
                              <span class="fw-bold text-secondary">to</span>
                            </div>
                            
                            <div class="col-md-5">
                              <div class="input-group mb-3">
                                <span class="input-group-text fw-bold">OUT Time</span>
                                <input name="out_time" readonly type="text" id="out_time" value="<?=$outData->xtime?>" class="form-control" />
                                <input name="out_time_id" type="hidden" id="out_time_id" value="<?=$outData->sl?>" />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Location Information Section -->
                      <div class="card mb-4 bg-light">
                        <div class="card-body">
           
                          
                          <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Location IN:</label>
                            <div class="border rounded overflow-hidden">
                              <iframe id="map" src="https://maps.google.com/maps?q=<?=$full_att->latitude?>,<?=$full_att->longitude?>&z=17&output=embed" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                          </div>
                          
                          <div>
                            <label class="form-label fw-bold text-secondary">Location OUT:</label>
                            <div class="border rounded overflow-hidden">
                              <iframe id="map" src="https://maps.google.com/maps?q=<?=$full_att->latitude?>,<?=$full_att->longitude?>&z=17&output=embed" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Approval Button Section -->
                      <div class="text-end mt-4">
                        <? if($full_att->incharge_status=="Pending"){?>
                          <button type="submit" name="approve" accesskey="S" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i>Approve Attendance
                          </button>
                        <? }?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="oe_chatter">
                  <div class="oe_followers oe_form_invisible">
                    <div class="oe_follower_list"></div>
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