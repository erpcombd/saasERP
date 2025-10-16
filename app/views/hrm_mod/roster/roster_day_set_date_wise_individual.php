
<?php

session_start();
//

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";

$title='Roster Day Set Date Wise Individual'; 

$page_id = 38;

//check_access($page_id);
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
//auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
do_calander('#s_date');
do_calander('#e_date');


if(isset($_POST['save']))
{
			
			$startTime = strtotime( $_POST['s_date'] );
			$endTime = strtotime( $_POST['e_date'] );
			
		$point_1 = $_POST['point_1_'.$info->PBI_ID];
		
		$shedule_1 = $_POST['shedule_1_'.$info->PBI_ID];
		$point_2 = $_POST['point_2_'.$info->PBI_ID];
		$shedule_2 = $_POST['shedule_2_'.$info->PBI_ID];
		$entry_by = $_SESSION['user']['id'];

			// Loop between timestamps, 24 hours at a time
			for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
			  $s_date = date( 'Y-m-d', $i );
			  $del_sql='delete from hrm_roster_allocation where s_date="'.$s_date.'" and PBI_ID='.$info->PBI_ID;
			  db_query($del_sql);

			//db_query('update personnel_basic_info set office_time="'.$schedule_id.'",off_day="'.$_POST['off_day'].'" where PBI_ID='.$info->PBI_ID);
			if($_POST['schedule_id'.$s_date]>0){
			db_query('insert into hrm_roster_allocation (PBI_ID,roster_date,point_1,shedule_1,point_2,shedule_2,job_location,group_for,entry_by) values("'.$_POST['PBI_ID'].'","'.$s_date.'","'.$point_1.'",
			 "'.$_POST['schedule_id'.$s_date].'", "'.$point_2.'", "'.$shedule_2.'", "'.$_POST['job_location'].'", "'.$_POST['group_for'].'", "'.$entry_by.'")');
			 }
			
			//echo 'insert into roster_date_wise (PBI_ID,s_date,e_date,sch_time,area) values("'.$_POST['PBI_ID'].'", "'.$s_date.'", "'.$s_date.'", "'.$_POST['schedule_id'.$s_date].'","'.$_POST['area'].'")';
			
			
		  }
		}
?>

<script>

function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp=false;	

		try{

			xmlhttp=new XMLHttpRequest();

		}

		catch(e)	{		

			try{			

				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){

				try{

				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

				}

				catch(e1){

					xmlhttp=false;

				}

			}

		}

		 	

		return xmlhttp;

    }

	function update_value(id)
	{
var PBI_ID=id; // Rent
var td=(document.getElementById('td_'+id).value)*1; // Other
var od=(document.getElementById('od_'+id).value)*1; // Rent + Other
var hd=(document.getElementById('hd_'+id).value)*1; // Paid
var lt=document.getElementById('lt_'+id).value; 
var ab=document.getElementById('ab_'+id).value;
var lv=document.getElementById('lv_'+id).value;
var pre=(document.getElementById('pre_'+id).value)*1; // Due
var pay=document.getElementById('pay_'+id).value;
var ot=document.getElementById('ot_'+id).value;

var mon=document.getElementById('mon').value;
var year=document.getElementById('year').value;
var area=document.getElementById('area').value;


var strURL="monthly_attendence_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&pre="+pre+"&pay="+pay+"&ot="+ot+"&mon="+mon+"&year="+year+"&area="+area;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {

			

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+id).style.display='inline';

						document.getElementById('divi_'+id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			

						

			req.open("GET", strURL, true);

			req.send(null);

		}	

}

	function cal_all(id)

	{
var PBI_ID=id; // Rent
var td=(document.getElementById('td_'+id).value)*1; // Other
var od=(document.getElementById('od_'+id).value)*1; // Rent + Other
var hd=(document.getElementById('hd_'+id).value)*1; // Paid
var lt=(document.getElementById('lt_'+id).value)*1; 
var ab=(document.getElementById('ab_'+id).value)*1;
var lv=(document.getElementById('lv_'+id).value)*1;

var ltd=lt/3; 
var ltdd=Math.floor(ltd);
var pre=td - (od + hd + ab + lv);
var pay=td - ab - ltdd;
document.getElementById('pay_'+id).value=pay;
document.getElementById('pre_'+id).value=pre;
	}
</script>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>

<div class="form-container_large">
 	<form action="?"  method="post">
          <h4 class="text-center bg-titel bold pt-2 pb-2">Select Option</h4>
        <div class="container-fluid bg-form-titel">
					
		
		
				<div class="row">
					
							<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
								<div class="form-group row m-0">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input name="s_date" type="text" id="s_date" value="<?php echo (isset($_POST['s_date']))?$_POST['s_date']:date('Y-m-01')?>" />
	  
									</div>
								</div>
				
							</div>
							<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
								<div class="form-group row m-0">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input name="e_date" type="text" id="e_date" value="<?php echo (isset($_POST['e_date']))?$_POST['e_date']:date('Y-m-d')?>" />
				
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
								<div class="form-group row m-0">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee ID</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input name="PBI_ID"  type="text" id="PBI_ID" list='eip_ids' size="10" onblur="" tabindex="1"  required="required" value="<?=$_POST['PBI_ID']?>" />
	  <datalist id='eip_ids'> <option></option> <? foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_CODE," - ",PBI_NAME)',$emp_id,'1');?> </datalist>
    
									</div>
								</div>
				
						
					</div>
				
					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
						
						<input name="open_sch" type="submit" id="open_sch" class="btn1 btn1-submit-input" value="OPEN FOR NEW SCHEDULE" />
					</div>
				</div>

			</div>
	
		
		
		<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>Date</th>
						<th>Schedule</th>
						
					</tr>
					</thead>

					<tbody class="tbody1">
							<?
		if($_POST['designation']>0)
		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];
		if($_POST['department']>0)
		$con .=' and a.PBI_DEPARTMENT='.$_POST['department'];
		
		
		
		 $sql = "select a.PBI_NAME,a.PBI_ID,c.DESG_DESC,d.DEPT_DESC,(select s.schedule_name from hrm_schedule_info s where s.id=a.office_time) as schedule_name, a.off_day from 
		personnel_basic_info a,designation c, department d
		where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_DOMAIN='".$_POST['area']."'".$con."  and a.PBI_JOB_STATUS='1' order by a.PBI_ID ";
		$query = db_query($sql);
		
		$startTime = strtotime( $_POST['s_date'] );
		$endTime = strtotime( $_POST['e_date'] );
		//while($info=mysqli_fetch_object($query))
		//{
		if(isset($_POST['open_sch'])){
		for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
			  $s_date = date( 'Y-m-d', $i );
		?>
        <tr>
		<td><?=$s_date?>
          <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_POST['PBI_ID']?>" /></td>
		  <td><span>
		  
		    <select name="schedule_id<?=$s_date?>"  id="schedule_id<?=$s_date?>" >
              <option></option><? foreign_relation('hrm_schedule_info','id','schedule_name',$_REQUEST['sch_time'.$s_date]);?>
            </select>
			
			
			
		
		  </span></td>
		  </tr>
        
        <?
		} }//}
		?>
				

					</tbody>
				</table>
				<div class="n-form-btn-class">
           				<input name="save" type="submit" class="btn1 btn1-bg-submit" id="save" value="SAVE" />
				</div>
			</form>
</div>



<?php /*?><form action="?"  method="post">

<table width="100%" border="0" class="table table-bordered table-sm"><thead>
<tr class="oe_list_header_columns" align="center"><th colspan="3" class="p-3 mb-2 bg-primary text-white"><span>Select Options</span></th></tr>
</thead><tfoot>
</tfoot><tbody>
  
<!--  <tr >
    <td align="right"><strong>Company Name  :</strong></td>
    <td align="right"><div align="left"><span class="oe_form_group_cell">
      <select name="area" style="width:360px;" id="area" required="required">
        <? foreign_relation('domai','DOMAIN_CODE','DOMAIN_DESC',$_REQUEST['area']);?>
      </select>
    </span></div></td>
  </tr>-->

  
  
       <tr>
      <td align="center">Chose Date:</td>
      <td><input name="s_date" type="text" id="s_date" value="<?php echo (isset($_POST['s_date']))?$_POST['s_date']:date('Y-m-01')?>" /></td>
	  <td><input name="e_date" type="text" id="e_date" value="<?php echo (isset($_POST['e_date']))?$_POST['e_date']:date('Y-m-d')?>" /></td>
      </tr>
	
	  <tr>
    <td align="center"><strong>Employee :</strong></td>
    <td align="center"><div align="left">
      <input name="PBI_ID"  type="text" id="PBI_ID" list='eip_ids' size="10" onblur="" tabindex="1" style="width:400px;" required="required" value="<?=$_POST['PBI_ID']?>" />
	  <datalist id='eip_ids'> <option></option> <? foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_CODE," - ",PBI_NAME)',$emp_id,'1');?> </datalist>
    </div></td>
	
	<td><input name="open_sch" type="submit" id="open_sch" class="btn1 btn1-submit-input" value="OPEN FOR NEW SCHEDULE" /></td>
  </tr>
	
  
  </tbody></table>


<div style="text-align:center">

  
  <!--<table width="100%" border="0" class="table table-striped table-sm" cellpadding="5" cellspacing="0">
    <tr class="table-success">
      <td align="center">Chose Date:</td>
      <td><input name="s_date" type="text" id="s_date" value="<?php echo (isset($_POST['s_date']))?$_POST['s_date']:date('Y-m-01')?>" /></td>
	  <td><input name="e_date" type="text" id="e_date" value="<?php echo (isset($_POST['e_date']))?$_POST['e_date']:date('Y-m-d')?>" /></td>
      <td><input name="open_sch" type="submit" id="open_sch" class="btn btn-primary" value="OPEN for NEW SCHEDULE" /></td>
    </tr>
	
  </table>-->


          
		<table width="100%" class="table table-bordered table-sm">
		<thead>
		<tr class="bg-warning">
        <th>Date</th>
        <th> Schedule</th>
        </tr>
		</thead>
        <tbody>
        <?
		if($_POST['designation']>0)
		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];
		if($_POST['department']>0)
		$con .=' and a.PBI_DEPARTMENT='.$_POST['department'];
		
		
		
		 $sql = "select a.PBI_NAME,a.PBI_ID,c.DESG_DESC,d.DEPT_DESC,(select s.schedule_name from hrm_schedule_info s where s.id=a.office_time) as schedule_name, a.off_day from 
		personnel_basic_info a,designation c, department d
		where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_DOMAIN='".$_POST['area']."'".$con."  and a.PBI_JOB_STATUS='1' order by a.PBI_ID ";
		$query = db_query($sql);
		
		$startTime = strtotime( $_POST['s_date'] );
		$endTime = strtotime( $_POST['e_date'] );
		//while($info=mysqli_fetch_object($query))
		//{
		if(isset($_POST['open_sch'])){
		for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
			  $s_date = date( 'Y-m-d', $i );
		?>
        <tr style="font-size:10px; padding:3px;">
		<td><?=$s_date?>
          <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_POST['PBI_ID']?>" /></td>
		  <td><span class="oe_form_group_cell">
		  
		    <select name="schedule_id<?=$s_date?>"  id="schedule_id<?=$s_date?>" >
              <option></option><? foreign_relation('hrm_schedule_info','id','schedule_name',$_REQUEST['sch_time'.$s_date]);?>
            </select>
			
			
			
		
		  </span></td>
		  </tr>
        
        <?
		} }//}
		?>
		<tr>
		 <td></td>
          
          <td><input name="save" type="submit" class="btn1 btn1-bg-submit" id="save" value="SAVE" /></td>
        </tr>
        </tbody>
        
        <tfoot>
        <tr><td></td><td></td>
          </tr>
        </tfoot>
        </table>          
    

</form><?php */?>

<?

$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";

?>


