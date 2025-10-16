<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="Amendment Approve"
?>    <!-- Datatables -->



        <!-- page content -->



        
        	<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->



                  <div class="">



                <div class="clearfix"></div>

                    <div class="row">



                      <div class="col-md-12 col-sm-12 col-xs-12">



              	 <div class="openerp openerp_webclient_container">

                          <div class="x_content">



	  <!--edit form -->

<style>

.button {

  position: relative;

  background-color: #04AA6D;

  border: none;

  font-size: 28px;

  color: #FFFFFF;

  padding: 20px;

  width: 200px;

  text-align: center;

  -webkit-transition-duration: 0.4s; /* Safari */

  transition-duration: 0.4s;

  text-decoration: none;

  overflow: hidden;

  cursor: pointer;

}



.button:after {

  content: "";

  background: #90EE90;

  display: block;

  position: absolute;

  padding-top: 300%;

  padding-left: 350%;

  margin-left: -20px!important;

  margin-top: -120%;

  opacity: 0;

  transition: all 0.8s

}



.button:active:after {

  padding: 0;

  margin: 0;

  opacity: 1;

  transition: 0s

}
tr:nth-child(odd){
background-color: #fafafa !important;

}
tr:nth-child(Even){

}

</style>

 
 
 
 <?  
 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {


$display = $_POST['check_list'];
foreach ( $display as $key  ) {

 $update = "update hrm_iom_info set iom_status='GRANTED',dept_head_status='Approve' where id='".$key."'";

$query=db_query($update);

 $ss = db_query("select * from hrm_iom_info  where id='".$key."'");
$dataa = mysqli_fetch_object($ss);


$from_date = strtotime($dataa->s_date);
$to_date= strtotime($dataa->e_date);
$emp_id = $dataa->PBI_ID;
$iom_type =  $dataa->type;
$iom_sl_no =  $dataa->id;
$iom_entry_at= $dataa->entry_at;
$iom_entry_by= $dataa->entry_by;
$s_time = $dataa->s_time; 
$e_time =  $dataa->e_time;





for($i=$from_date; $i<=$to_date; $i=$i+86400)
{
$att_date=date('Y-m-d',$i);

$found = find_a_field('hrm_att_summary','1','emp_id="'.$emp_id.'" and att_date="'.$att_date.'"');
if($found==0)
{



 $sql="INSERT INTO hrm_att_summary (emp_id, iom_type, iom_id, att_date,iom_start_time,iom_end_time,iom_entry_at,iom_entry_by,iom_category, dayname)
VALUES ('$emp_id', '$iom_type', '$iom_sl_no','$att_date','$s_time','$e_time','$iom_entry_at','$iom_entry_by','$iom_category', dayname('".$att_date."'))";
$query=db_query($sql);



}

else{

if($dataa->type != 'Last Half') {


 $sql='update hrm_att_summary set iom_type="'.$iom_type.'", iom_id="'.$iom_sl_no.'",iom_start_time="'.$s_time.'",iom_end_time="'.$e_time.'",
 dayname=dayname("'.$att_date.'"),

iom_entry_at="'.$iom_entry_at.'", iom_entry_by="'.$iom_entry_by.'",iom_category="'.$iom_category.'"

where  emp_id="'.$emp_id.'" and att_date="'.$att_date.'" ';

$query=db_query($sql);

}else{

 $sql='update hrm_att_summary set iom_type_early_out="'.$iom_type.'", iom_id_early_out ="'.$iom_sl_no.'",iom_start_time_early_out="'.$s_time.'",
 iom_end_time_early_out="'.$e_time.'",dayname=dayname("'.$att_date.'"),
 iom_entry_by_early_out="'.$iom_entry_by.'"

where  emp_id="'.$emp_id.'" and att_date="'.$att_date.'" ';

$query=db_query($sql);


}

} } 

header('location:iom_approval_all.php');
	
	


}
	
}

 
 ?>
 
 
  	<?  
	
	
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["disapprove"])) {



$display = $_POST['check_list'];
foreach ( $display as $key  ) {

    $update = "update hrm_iom_info set iom_status='Cancel',dept_head_status='Cancel' 
   where id='".$key."'";
$query=db_query($update);


      if ($query) {
				echo "<script>
					$(document).ready(function() {
						swal({
							title: 'Amendment Successfully Disapproved.',
							text: 'You Follow The Right Step!',
							type: 'success',
							padding: '2em'
						});
					});
				</script>";
			}
}

	}
	
	?>		                   
					 
<form action="" method="post" enctype="multipart/form-data">



	<? include('../common/title_bar_new.php');?>
					
    <div class="container-fluid bg-form-titel">
      <div class="row">
	  
	   <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
      
        </div>
	  
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <div class="form-group row m-0">
             <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">
			 Select ID First : </label>
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 p-0">
            <input name="save" id="save" value="Approve" type="submit" class="btn btn-info">
			  
			  
			
            </div>
          </div>
        </div>
		
		
		
		
		
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
          <input name="disapprove" id="disapprove" value="Disapprove" type="submit" class="btn btn-danger">
        </div>
		
		
		
      </div>
    </div>
	
	
	<div class="container mt-5">
    <!-- Task Status Tabs -->
  
    <!-- Task Status Tab Content -->
    <div class="tab-content mt-3">
      <!-- Pending Tab -->
      <div class="tab-pane fade show active" id="pending">
        <div class="row">
          <div class="col">
            <!-- Bootstrap Table for Pending Tasks -->
            <div class="card">
              <div class="card-header"> Pending Tasks </div>
              <div class="card-body">
                
				<div style="overflow-x:auto;">
				
				<table   class="table1  table-striped table-bordered table-hover table-sm"  >

                      <thead  class="thead1" style=" z-index: 2 !important; ">

                        <tr class="bgc-info">
                            <th style="text-align: center">Mark</th>
                          <th style="text-align: center"> SL </th>
                         <th style="text-align: center"> ID  </th>

                          <th style="text-align: center">Name</th>
						  
						  
						   
						  <th style="text-align: center">Department</th>
						  
						  
						
						 
                      
                          <th style="text-align: center">Type</th>
						  
						  <th style="text-align: center">Apply Date</th>
						
						  
						  <th style="text-align: center">   From</th>
						  <th style="text-align: center">   To</th>
						  
					      <th style="text-align: center"> Days</th>
						   <th style="text-align: center">In Time</th><br />
                              <th style="text-align: center">Late Min</th>
							   <th style="text-align: center">Schedule</th>
					       
					       <th style="text-align: center">Reasons</th>
						   
					      <?php /*?>  <th style="text-align: center">Reporting Supervisor Name</th><?php */?>
						  
						  <th style="text-align: center">Reporting </th>
						  
						  <th style="text-align: center">HR </th>
			
			
                        </tr>

                      </thead>
					  
			

					    <tbody class="tbody1">

<?

		$g_s_date=date('Y-01-01');
		
		$g_e_date=date('Y-12-31');
		
		
  
                            if($_POST['PBI_CODE']!="") $codeConn = " and p.PBI_CODE='".$_POST['PBI_CODE']."'";
                            if($_POST['PBI_IDD']!="") $idConn = " and p.PBI_ID ='".$_POST['PBI_IDD']."'";
                          
                            if($_POST['PBI_NAME']!="") $NameConn = " and p.PBI_NAME='".$_POST['PBI_NAME']."'";
                            if($_POST['DESG_ID']>0) $desgConn = " and p.DESG_ID='".$_POST['DESG_ID']."'";
                            if($_POST['DEPT_ID']>0) $depConn = " and p.DEPT_ID='".$_POST['DEPT_ID']."'";
                            if($_POST['PBI_SEX']!="") $genderConn = " and p.PBI_SEX='".$_POST['PBI_SEX']."'";
                            if($_POST['grade']>0) $gradeConn = " and p.grade='".$_POST['grade']."'";  
                            if($_POST['work_station']>0) $work_station = " and p.PBI_WORK_STATION='".$_POST['work_station']."'";  
                            
                            
                            
                            if($_POST['PBI_RELIGION']!="") $ReligionConn = " and p.PBI_RELIGION='".$_POST['PBI_RELIGION']."'";
                            if($_POST['PBI_ORG']>0) $OrgConn = " and p.PBI_ORG='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and p.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
                            
                            if($_POST['section']>0) $secConn = " and p.section='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and p.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['cost_center']>0) $CostConn = " and p.cost_center='".$_POST['cost_center']."'";
                     
                            
                            if($_POST['class']>0) $classConn = " and p.class='".$_POST['class']."'";
                            if($_POST['line']>0) $lineConn = " and p.line='".$_POST['line']."'";
                            if($_POST['incharge_id']>0) $inchargeConn = " and p.incharge_id='".$_POST['incharge_id']."'";
							
                            if($_POST['DOJ']>0) $DOJConn = " and p.PBI_DOJ='".$_POST['DOJ']."'";
							if($_POST['shedule']>0) $shiftConn = " and a.shedule_1 ='".$_POST['shedule']."'";
							
							
                    if (!empty($_POST['START_DATE']) && !empty($_POST['END_DATE'])) 
                        $dateConn = " AND o.s_date BETWEEN '" . $_POST['START_DATE'] . "' AND '" . $_POST['END_DATE'] . "'";
                    
							
							
  
$sql = 'SELECT 
    o.id,
    p.PBI_NAME,
    p.PBI_ID,
    p.DEPT_ID,
    p.PBI_CODE,
    p.cost_center,
    p.section,
	od.project_id,
    o.s_time,
    o.e_time,
    o.s_date AS start_date,
    o.e_date AS end_date,
    o.type,
    o.iom_apply_date,
    o.total_days,
    o.dept_head_status,
    o.iom_status,
    o.reason,
    p.incharge_id,
    o.entry_at,
	
    (
        SELECT MIN(a.xtime) 
        FROM hrm_attdump a 
        WHERE a.EMP_CODE = p.PBI_ID AND a.xdate = o.s_date
    ) AS earliest_xtime,
    
    od.s_date AS od_s_date,
    od.reason AS od_reason

FROM 
    personnel_basic_info p
JOIN 
    hrm_iom_info o ON p.PBI_ID = o.PBI_ID
LEFT JOIN 
    hrm_od_info od ON od.PBI_ID = p.PBI_ID AND od.s_date = o.s_date

WHERE 
    o.dept_head_status != "Cancel" 
    AND o.iom_status = "Pending"  
    ' . $codeConn . $idConn . $genderConn . $NameConn . $ReligionConn . $DOJConn . $OrgConn . $classConn . $gradeConn . $work_station .
      $lineConn . $inchargeConn . $depConn . $desgConn . $secConn . $JoblocConn . $CostConn . $levelConn . $job_statusConn . $dateConn . $shiftConn . '

ORDER BY o.s_date DESC';



$query=db_query($sql);
while($data = mysqli_fetch_object($query)){


 $reporting_boss = find_a_field('personnel_basic_info','CONCAT(PBI_NAME,"-",PBI_CODE)','PBI_ID="'.$data->incharge_id.'"');

  $department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');
  $cost_center = find_a_field('hrm_cost_center','center_name','id="'.$data->cost_center.'"');
  $section = find_a_field('PBI_Section','sec_name','sec_id="'.$data->section.'"');
  
  

?>
                 


                        <tr>
                        <td style="width:10px"><input type="checkbox" style="width:50px" name="check_list[]" value="<?=$data->id;?>"></td>
                          <td><?=++$s?></td>
                          <td style="width:180px"><?=$data->PBI_CODE?></td>
                          <td style="width:180px"><?=$data->PBI_NAME?></td>
						 
						  <td style="width:180px"><?=$department?></td>
						
						  
                          <td style="width:130px">  
                          
                          <? if($data->type=="Early Half") {
								echo "In Late";
							}elseif($data->type=="Full"){
								
								echo "Absent";
								
							}else{ echo "Early Out";}
							
							?></td>
						  
						  
                          <td style="width:130px"><?=date('d-M-Y',strtotime($data->entry_at))?></td>
						  
						 
						  
						  <td style="width:110px"><?=date('d-M-Y',strtotime($data->start_date))?></td>
						  <td style="width:110px"><?=date('d-M-Y',strtotime($data->end_date))?></td>
						  
						
						  <td style="width:80px;text-align:center"><?=intval($data->total_days);?></td> 
						  <td style="width:80px;text-align:center"><?=date('h:i A', strtotime($data->earliest_xtime));?></td> 
													   <td> <?php
$xtime = strtotime($data->earliest_xtime);
$cutoff = strtotime(date('Y-m-d', $xtime) . ' 10:00:00');

$late_minutes = ($xtime > $cutoff) ? floor(($xtime - $cutoff) / 60) : 0;
echo $late_minutes;
?>
</td>
<td><?= find_a_field('crm_project_org','name', 'id="'.$data->project_id.'"'); ?></td>
						  <td style="width:80px;text-align:center"><?=$data->reason;?></td> 
						  
	                   <?php /*?>  <td style="width:80px;text-align:center"><?=$reporting_boss;?></td><?php */?>
						  
						  <td  style="text-align:center"><?=$data->dept_head_status?></td>
						  <td  style="text-align:center"><?=$data->iom_status?></td>
					

						
				         </tr>

                 
						  <? } ?>
						  
						  
						  
						  
						  
		 
						<div align="left"> 
	<input type="checkbox" class="form-check-input" id="select-all">
	<label for="checkbox"><span class="bg-danger text-white">Select All</span></label>
	</div>		  
						  
						

                    </tbody>
                 

                    
					
			
					   
					   
					 

                    </table>
				
				
				</div>	
				
              </div>
            </div>
            <!-- Pagination for Pending Tasks -->
            <nav aria-label="Page navigation">
              <!--<ul class="pagination">-->
              <!--  <li class="page-item"><a class="page-link" href="#">1</a></li>-->
              <!--  <li class="page-item"><a class="page-link" href="#">2</a></li>-->
                <!-- Add more pages as needed -->
              <!--</ul>-->
            </nav>
          </div>
        </div>
      </div>
      <!-- Complete Tab -->
      <div class="tab-pane fade" id="complete">
        <div class="row">
          <div class="col">
            <!-- Bootstrap Table for Complete Tasks -->
            <div class="card">
              <div class="card-header"> Complete Tasks </div>
              <div class="card-body">
                
				 	<table   class="table1  table-striped table-bordered table-hover table-sm"  >

                      <thead  class="thead1" style=" z-index: 2 !important; ">

                        <tr class="bgc-info">
                          <th style="text-align: center"> SL NO</th>
                         <th style="text-align: center"> ID NO </th>

                          <th style="text-align: center">Name</th>
						  
						   <th style="text-align: center">Cost Centre</th>
						   
						  <th style="text-align: center">Department</th>
						  
						  
						  <th style="text-align: center">Sectiom</th>
						 
                      
                          <th style="text-align: center">Type</th>
						  
						  <th style="text-align: center">Application Date</th>
						
						  
						  <th style="text-align: center"> Applied  From</th>
						  <th style="text-align: center"> Applied  To</th>
						  
					      <th style="text-align: center">Total Days</th>
					       
					       <th style="text-align: center">Reasons</th>
						   
					        <th style="text-align: center">Reporting Supervisor Name</th>
						  
						  <th style="text-align: center">Reporting Authority</th>
						  
						  <th style="text-align: center">HR Approval</th>
                        </tr>
                      </thead>
					  
			

					    <tbody class="tbody1">

<?

		$g_s_date=date('Y-01-01');
		
		$g_e_date=date('Y-12-31');
		
		
  
                            if($_POST['PBI_CODE']!="") $codeConn = " and p.PBI_CODE='".$_POST['PBI_CODE']."'";
                            if($_POST['PBI_IDD']!="") $idConn = " and p.PBI_ID ='".$_POST['PBI_IDD']."'";
                          
                            if($_POST['PBI_NAME']!="") $NameConn = " and p.PBI_NAME='".$_POST['PBI_NAME']."'";
                            if($_POST['DESG_ID']>0) $desgConn = " and p.DESG_ID='".$_POST['DESG_ID']."'";
                            if($_POST['DEPT_ID']>0) $depConn = " and p.DEPT_ID='".$_POST['DEPT_ID']."'";
                            if($_POST['PBI_SEX']!="") $genderConn = " and p.PBI_SEX='".$_POST['PBI_SEX']."'";
                            if($_POST['grade']>0) $gradeConn = " and p.grade='".$_POST['grade']."'";  
                            if($_POST['work_station']>0) $work_station = " and p.PBI_WORK_STATION='".$_POST['work_station']."'";  
                            
                            
                            
                            if($_POST['PBI_RELIGION']!="") $ReligionConn = " and p.PBI_RELIGION='".$_POST['PBI_RELIGION']."'";
                            if($_POST['PBI_ORG']>0) $OrgConn = " and p.PBI_ORG='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and p.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
                            
                            if($_POST['section']>0) $secConn = " and p.section='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and p.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['cost_center']>0) $CostConn = " and p.cost_center='".$_POST['cost_center']."'";
                     
                            
                            if($_POST['class']>0) $classConn = " and p.class='".$_POST['class']."'";
                            if($_POST['line']>0) $lineConn = " and p.line='".$_POST['line']."'";
                            if($_POST['incharge_id']>0) $inchargeConn = " and p.incharge_id='".$_POST['incharge_id']."'";
							
                            if($_POST['DOJ']>0) $DOJConn = " and p.PBI_DOJ='".$_POST['DOJ']."'";
							if($_POST['shedule']>0) $shiftConn = " and a.shedule_1 ='".$_POST['shedule']."'";
							
  
   $sql = 'select o.id,p.PBI_NAME,p.PBI_ID,p.DEPT_ID,p.PBI_CODE,p.cost_center,p.section,
  o.s_time,o.e_time,o.s_date as start_date,o.e_date as end_date,o.type,
  o.iom_apply_date,o.total_days,o.dept_head_status,o.iom_status,o.reason,p.incharge_id,o.entry_at
  
	
	from personnel_basic_info p,hrm_iom_info o
	
	where p.PBI_ID=o.PBI_ID and o.dept_head_status!="Cancel" and o.iom_status="GRANTED"  
	
	'.$codeConn.$idConn.$genderConn.$NameConn.$ReligionConn.$DOJConn.$OrgConn.$classConn.$gradeConn.$work_station.
$lineConn.$inchargeConn.$depConn.$desgConn.$secConn.$JoblocConn.$CostConn.$levelConn.$job_statusConn.$shiftConn.' order by o.s_date desc';

$query=db_query($sql);
while($data = mysqli_fetch_object($query)){


 $reporting_boss = find_a_field('personnel_basic_info','CONCAT(PBI_NAME,"-",PBI_CODE)','PBI_ID="'.$data->incharge_id.'"');

  $department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');
  $cost_center = find_a_field('hrm_cost_center','center_name','id="'.$data->cost_center.'"');
  $section = find_a_field('PBI_Section','sec_name','sec_id="'.$data->section.'"');
  
  

?>
                 


                        <tr>
                        <td><?=++$s?></td>
                          <td style="width:180px"><?=$data->PBI_CODE?></td>
                          <td style="width:180px"><?=$data->PBI_NAME?></td>
						  <td style="width:180px"><?=$cost_center?></td>
						  <td style="width:180px"><?=$department?></td>
						  <td style="width:180px"><?=$section?></td>
						  
                          <td style="width:130px">  
                          
                          <? if($data->type=="Early Half") {
								echo "In Late";
							}elseif($data->type=="Full"){
								
								echo "Absent";
								
							}else{ echo "Early Out";}
							
							?></td>
						  
						  
                          <td style="width:130px"><?=date('d-M-Y',strtotime($data->entry_at))?></td>
						  
						 
						  
						  <td style="width:110px"><?=date('d-M-Y',strtotime($data->start_date))?></td>
						  <td style="width:110px"><?=date('d-M-Y',strtotime($data->end_date))?></td>
						  
						
						  <td style="width:80px;text-align:center"><?=intval($data->total_days);?></td> 
						  <td style="width:80px;text-align:center"><?=$data->reason;?></td> 
						  
	                     <td style="width:80px;text-align:center"><?=$reporting_boss;?></td>
						  
						  <td  style="text-align:center"><?=$data->dept_head_status?></td>
						  <td  style="text-align:center"><?=$data->iom_status?></td>
				         </tr>

                 
						  <? } ?>
                    </tbody>
                    </table>
				
				
				
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Archives Tab -->
      <div class="tab-pane fade" id="archives">
        <div class="row">
          <div class="col">
            <!-- Bootstrap Table for Complete Tasks -->
            <div class="card">
              <div class="card-header"> Archieve Tasks </div>
              <div class="card-body">
                
				 	<table   class="table1  table-striped table-bordered table-hover table-sm"  >

                      <thead  class="thead1" style=" z-index: 2 !important; ">

                        <tr class="bgc-info">
                          <th style="text-align: center"> SL NO</th>
                         <th style="text-align: center"> ID NO </th>

                          <th style="text-align: center">Name</th>
						  
						   <th style="text-align: center">Cost Centre</th>
						   
						  <th style="text-align: center">Department</th>
						  
						  
						  <th style="text-align: center">Sectiom</th>
						 
                      
                          <th style="text-align: center">Type</th>
						  
						  <th style="text-align: center">Application Date</th>
						
						  
						  <th style="text-align: center"> Applied  From</th>
						  <th style="text-align: center"> Applied  To</th>
						  
					      <th style="text-align: center">Total Days</th>
					       
					       <th style="text-align: center">Reasons</th>
						   
					        <th style="text-align: center">Reporting Supervisor Name</th>
						  
						  <th style="text-align: center">Reporting Authority</th>
						  
						  <th style="text-align: center">HR Approval</th>
                        </tr>
                      </thead>
					  
			

					    <tbody class="tbody1">

<?

		$g_s_date=date('Y-01-01');
		
		$g_e_date=date('Y-12-31');
		
		
  
                            if($_POST['PBI_CODE']!="") $codeConn = " and p.PBI_CODE='".$_POST['PBI_CODE']."'";
                            if($_POST['PBI_IDD']!="") $idConn = " and p.PBI_ID ='".$_POST['PBI_IDD']."'";
                          
                            if($_POST['PBI_NAME']!="") $NameConn = " and p.PBI_NAME='".$_POST['PBI_NAME']."'";
                            if($_POST['DESG_ID']>0) $desgConn = " and p.DESG_ID='".$_POST['DESG_ID']."'";
                            if($_POST['DEPT_ID']>0) $depConn = " and p.DEPT_ID='".$_POST['DEPT_ID']."'";
                            if($_POST['PBI_SEX']!="") $genderConn = " and p.PBI_SEX='".$_POST['PBI_SEX']."'";
                            if($_POST['grade']>0) $gradeConn = " and p.grade='".$_POST['grade']."'";  
                            if($_POST['work_station']>0) $work_station = " and p.PBI_WORK_STATION='".$_POST['work_station']."'";  
                            
                            
                            
                            if($_POST['PBI_RELIGION']!="") $ReligionConn = " and p.PBI_RELIGION='".$_POST['PBI_RELIGION']."'";
                            if($_POST['PBI_ORG']>0) $OrgConn = " and p.PBI_ORG='".$_POST['PBI_ORG']."'";
                            if($_POST['PBI_JOB_STATUS']!="") $job_statusConn = " and p.PBI_JOB_STATUS='".$_POST['PBI_JOB_STATUS']."'";
                            
                            if($_POST['section']>0) $secConn = " and p.section='".$_POST['section']."'";
                            if($_POST['JOB_LOC_ID']>0) $JoblocConn = " and p.JOB_LOC_ID='".$_POST['JOB_LOC_ID']."'";
                            if($_POST['cost_center']>0) $CostConn = " and p.cost_center='".$_POST['cost_center']."'";
                     
                            
                            if($_POST['class']>0) $classConn = " and p.class='".$_POST['class']."'";
                            if($_POST['line']>0) $lineConn = " and p.line='".$_POST['line']."'";
                            if($_POST['incharge_id']>0) $inchargeConn = " and p.incharge_id='".$_POST['incharge_id']."'";
							
                            if($_POST['DOJ']>0) $DOJConn = " and p.PBI_DOJ='".$_POST['DOJ']."'";
							if($_POST['shedule']>0) $shiftConn = " and a.shedule_1 ='".$_POST['shedule']."'";
							
  
   $sql = 'select o.id,p.PBI_NAME,p.PBI_ID,p.DEPT_ID,p.PBI_CODE,p.cost_center,p.section,
  o.s_time,o.e_time,o.s_date as start_date,o.e_date as end_date,o.type,
  o.iom_apply_date,o.total_days,o.dept_head_status,o.iom_status,o.reason,p.incharge_id,o.entry_at
  
	
	from personnel_basic_info p,hrm_iom_info o
	
	where p.PBI_ID=o.PBI_ID and o.dept_head_status="Cancel" and o.iom_status="Cancel"  
	
	'.$codeConn.$idConn.$genderConn.$NameConn.$ReligionConn.$DOJConn.$OrgConn.$classConn.$gradeConn.$work_station.
$lineConn.$inchargeConn.$depConn.$desgConn.$secConn.$JoblocConn.$CostConn.$levelConn.$job_statusConn.$shiftConn.' order by o.s_date desc';

$query=db_query($sql);
while($data = mysqli_fetch_object($query)){


 $reporting_boss = find_a_field('personnel_basic_info','CONCAT(PBI_NAME,"-",PBI_CODE)','PBI_ID="'.$data->incharge_id.'"');

  $department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');
  $cost_center = find_a_field('hrm_cost_center','center_name','id="'.$data->cost_center.'"');
  $section = find_a_field('PBI_Section','sec_name','sec_id="'.$data->section.'"');
  
  

?>
                 


                        <tr>
                        <td><?=++$s?></td>
                          <td style="width:180px"><?=$data->PBI_CODE?></td>
                          <td style="width:180px"><?=$data->PBI_NAME?></td>
						  <td style="width:180px"><?=$cost_center?></td>
						  <td style="width:180px"><?=$department?></td>
						  <td style="width:180px"><?=$section?></td>
						  
                          <td style="width:130px">  
                          
                          <? if($data->type=="Early Half") {
								echo "In Late";
							}elseif($data->type=="Full"){
								
								echo "Absent";
								
							}else{ echo "Early Out";}
							
							?></td>
						  
						  
                          <td style="width:130px"><?=date('d-M-Y',strtotime($data->entry_at))?></td>
						  
						 
						  
						  <td style="width:110px"><?=date('d-M-Y',strtotime($data->start_date))?></td>
						  <td style="width:110px"><?=date('d-M-Y',strtotime($data->end_date))?></td>
						  
						
						  <td style="width:80px;text-align:center"><?=intval($data->total_days);?></td> 
						  <td style="width:80px;text-align:center"><?=$data->reason;?></td> 
						  
	                     <td style="width:80px;text-align:center"><?=$reporting_boss;?></td>
						  
						  <td  style="text-align:center"><?=$data->dept_head_status?></td>
						  <td  style="text-align:center"><?=$data->iom_status?></td>
				         </tr>

                 
						  <? } ?>
                    </tbody>
                    </table>
				
				
				
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
	
	
	
	
	
	
					
   
					
					
					


		




                       
		   </form>
<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../assets/js/popper.min.js"></script>
<script type="text/javascript" src="../../../assets/js/jquery-3.4.1.min.js"></script>
<script>

document.getElementById('select-all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}




</script>





<?


require_once SERVER_CORE."routing/layout.bottom.php";







?>