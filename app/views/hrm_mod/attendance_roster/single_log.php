<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Single Log  Report';

$page_id = 35;

do_datatable('grp');

function auto_dropdown($sql){

$res=db_query($sql);

while($data=mysqli_fetch_row($res)){

if($value==$data[0]){
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
}

else{
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}

}}



$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#start_date');

do_calander('#end_date');

$PBI_ID = $_POST['PBI_ID'];



?>



<div class="form-container_large">
 	<form action="?"  method="post">
          <h4 class="text-center bg-titel bold pt-2 pb-2">Select Employee</h4>
        <div class="container-fluid bg-form-titel">
					
		
		
				<div class="row">
					
							<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
								<div class="form-group row m-0">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input type="text" name="start_date" id="start_date"  required 

	value="<? if(isset($_POST['start_date'])){ echo $_POST['start_date']; }else{echo date('Y-m-01'); } ?>" />
	  
									</div>
								</div>
				
							</div>
							<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
								<div class="form-group row m-0">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input type="text" name="end_date" id="end_date"  required 

	 value="<? if(isset($_POST['end_date'])){ echo $_POST['end_date']; }else{echo date('Y-m-25'); } ?>"/>
				
									</div>
								</div>
							</div>
							<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
								<div class="form-group row m-0">
									<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee ID</label>
									<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
										<input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" required="required" value="<?=$_POST['PBI_ID']?>" />
    
									</div>
								</div>
				
						
					</div>
				
					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
						
						<input name="create" type="submit" id="create" class="btn1 btn1-bg-submit" value="Show Report" />
					</div>
				</div>

			</div>
	
		<br />
		
		<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					
					</thead>

					<tbody class="tbody1">
							<? if($_POST['PBI_ID']>0){


								
								$start_date = $_POST['start_date'];
								
								$end_date = $_POST['end_date'];
								
								
								
								$begin = new DateTime($start_date);
								
								$end = new DateTime($end_date);
								
								$end->modify('+1 day');
								
								
								
								$startTime = $days1=mktime(1,1,1,date('m',strtotime($start_date)),26,date('y',strtotime($start_date)));
								
								
								
								$endTime = $days2=mktime(1,1,1,date('m',strtotime($end_date)),25,date('y',strtotime($end_date)));
								
								
								
								$days_mon=($endTime - $startTime)/(3600*24);
								
								
								
								for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
								
								$day   = date('l',$i);
								
								${'day'.date('N',$i)}++;
								
								

								
								}
								
								
								
								$ab="SELECT 
								
								a.PBI_NAME as name,
								
								c.group_name as company,
								
								desi.DESG_DESC as designation, 
								
								d.DEPT_DESC as department,
								
								j.LOCATION_NAME
								
								FROM 
								
								personnel_basic_info a, 
								
								user_group c, 
								
								department d, 
								
								designation desi,
								
								office_location j 
								
								WHERE 
								
								a.PBI_ORG=c.id and 
								
								a.DEPT_ID=d.DEPT_ID and 
								
								a.DESG_ID=desi.DESG_ID and 
								
								
								
								a.PBI_ID='".$_POST['PBI_ID']."'";
								
								$abb = db_query($ab);
								
								$pbi=mysqli_fetch_object($abb);
								
						?>
						
						
						<tr class="">
							<td>Name: </td>
						
							<td>&nbsp;<?=$pbi->name?></td>
						
							<td>Company:</td>
						
							<td>&nbsp;<?=$pbi->company?>,<?=$pbi->LOCATION_NAME?></td>
						
						</tr>
						<tr class="">

							<td>Designation:</td>
						
							<td>&nbsp;<?=$pbi->designation?></td>
						
							<td>Department:</td>
						
							<td>&nbsp;<?=$pbi->department?></td>
						
						 </tr>
				
						
					</tbody>
				</table>
				
				<? 


					

					
					
					}
					
					
			 ?>
				
			</form>
			
			
		




    <form  action="" method="post" enctype="multipart/form-data">
        
        <div class="container-fluid pt-5 p-0 ">
			<?php
			
			$table='hrm_attdump';
			
			$unique='sl';
			
			$crud  =new crud($table);
			
			$res = "SELECT sl,xenrollid as code,xlocationid as location_id,xmechineid as machine_id,xdate,xtime
			
			FROM hrm_attdump WHERE xenrollid = '".$_POST['PBI_ID']."' and xdate between '".$_POST['start_date']."' and '".$_POST['end_date']."'
			
			";
			
			echo link_report1($res,$link);
			
			
			
			?>


            

        </div>

    </form>
</div>




<?php

require_once SERVER_CORE."routing/layout.bottom.php";

?>
