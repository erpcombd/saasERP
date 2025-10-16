<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Attendance Approved Status";
$page = "daily_attendance_status.php";
$username	= $_SESSION['user']['username'];
$emp_code = $username;
require_once '../assets/template/inc.header.php';

?>


    
<!-- start of Page Content-->  
<div class="page-content header-clear-medium">
<div class="card card-style mb-0">
<form action="" method="post" name="codz" id="codz">
        <div class="card card-style">
            <div class="content mt-0 ms-0 me-0">
                <label for="fdate">Date Form</label>
                <input type="date" class="form-control validate-text" name="fdate" id="fdate" value="<?=date('Y-m-01');?>" />

                <label for="tdate">Date To</label>
                <input type="date" class="form-control validate-text" name="tdate" id="tdate" value="<?=date('Y-m-d'); ?>" />

                <label for="region_id">User</label>
                <select class="form-select form-control" name="user_id" id="user_id">
					<option></option>
                    <?php optionlist("select user_id,fname  from ss_user  where 1"); ?>
                </select>

                <div class="d-flex justify-content-center row m-0 mt-3">
                    <div class="col-6">
                        <input class="b-n btn btn-success btn-3d btn-block text-light w-100 py-3" 
                               type="submit" name="submitit" id="submitit" value="View" />
                    </div>
                </div>
            </div>
        </div>
    </form>
	
<div class="content m-0">
<div class="table-responsive pt-3" style="zoom: 70%;">

<table class="table table-borderless text-center table-scroll table_new_border" style="overflow: hidden;">
						<thead>
							<tr class="bg-night-light1">
								<th scope="col" class="color-white"> User Name</th>
								<th scope="col" class="color-white"> Schedule Shop</th>
								<th scope="col" class="color-white"> Attendance Date & Submit Time</th>
								<th scope="col" class="color-white"> status</th>
								<th scope="col" class="color-white"> Approved Status</th>
							</tr>
						</thead>
						<tbody>
<?
if(isset($_POST['submitit'])){
  if ($_POST['fdate'] != '' && $_POST['tdate'] != '') {
    	$con .= 'access_date between "' .$_POST['fdate']. '" and "' .$_POST['tdate']. '"';
  }
  
  if ($_POST['user_id'] != '') {
            $user_con = ' and user_id="' .$_POST['user_id']. '"';
  }

$sql = "SELECT * FROM ss_location_log WHERE ".$con.$user_con." ORDER BY id DESC";
 $query=db_query($sql);
while($data=mysqli_fetch_object($query)){
?>                            
   							<tr>
								<td align="left" style=" color: green; font-weight: bold;"> <strong style=" color: #0069b5 !important;"><?=$data->user_id;?></strong> - <?=find1("select fname from ss_user where username='".$data->user_id."'");?></td>
								<td align="left" style=" color: #0069b5; font-weight: bold;"><? if($data->shop_name != ''){?><?=$data->shop_name;?><? } ?>
									<? if($data->shop_name_unschedule != ''){?><?=$data->shop_name_unschedule;?><? } ?>
								</td>
								
								<td><?=$data->access_time;?></td>

								<td <? if($data->status == 'APPROVED'){?> style=" color: green; font-weight: bold;" <? }else{?> style=" color: #0069b5; font-weight: bold;"  <? } ?>><?=$data->status;?></td>
								<td <? if($data->approved_status == 'ALLOWED'){?> style=" color: green; font-weight: bold;" <? }elseif($data->approved_status == 'PENDING'){?> style=" color: #0069b5; font-weight: bold;" <? } else{?> style=" color: #ff0000; font-weight: bold;"  <? } ?>><?=$data->approved_status;?></td>
							</tr>	
			
<? }
}
?>				
							
							
							
							
							    
						</tbody>
					</table>
					</div>
</div>
</div>

			
        </div>
    <!-- End of Page Content--> 
 
<script>
	$(document).ready(function() {
		$('#user_id').select2({
			placeholder: "Select", // Placeholder text
			allowClear: true, // Allow clearing the selection
			dropdownAutoWidth: true, // Auto width for dropdown
			width: '100%' // Full width for the dropdown
		});
	});
</script>

<?php 
 require_once '../assets/template/inc.footer.php';
 ?>