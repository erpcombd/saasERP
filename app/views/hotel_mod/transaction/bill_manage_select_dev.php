<?php
//ini_set('display_errors', '1');ini_set('display_startup_errors', '1');error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Advance Bill Information';
do_calander('#generate_date');
$table='hms_bill_payment';
$unique='id';
$time=time();
$now=($time-60*60*12);
$today=date("Y-m-d",$now);
$this_time=date("Y-m-d H:i:s",$time);
?>


<form action="bill_manage_advance.php" method="post" name="form2" id="form2">
<div class="container-fluid">
    <div class="d-flex justify-content-center">
        <div class="col-sm-8">
		<div class="n-form">
            
                <h4 align="center" class="n-form-titel1">Select Service Group</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Group Name:</label>
                    <div class="col-sm-9 p-0">
						<select name="service_group_id">
			<?
			advance_foreign_relation("select id, service_group from hms_service_group where id not in (4,5)",$service_group_id);
			?>
			</select>	                   
					</div>
                </div>  
				<div class="d-flex justify-content-center">
			  <label>
			  <input style="float:right"  class="btn1 btn1-bg-submit" type="submit" name="Submit" value="Submit"/>
			  </label>
			</div>   
			</div> 
			 
 </form>

<?
$sql="SELECT count(1) FROM `hms_rent_bill_generate` WHERE bill_date='".$today."'";
$due = find_a_field_sql($sql);
?>
<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>