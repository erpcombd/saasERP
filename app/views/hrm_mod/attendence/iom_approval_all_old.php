<?php


require_once "../../../controllers/routing/default_values.php";
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

                     
					 
					 <form action="?"  method="post">


					<? include('../../common/title_bar_new.php');?>
					
				
					<div class="oe_form_buttons"></div>
					
					
					
					
					<table width="100%" border="0" class="table table-bordered table-sm">
                        
                          <tbody>
                            
                            
                            
                            <tr>
                              <td align="right" style="background-color:#3d6485; color:#FFFFFF; font-size:16px;"><strong> Start Date : </strong></td>
                              <td align="left" style="background-color:#3d6485; font-size:16px;padding-top:4px">
                    <input type="date" style="width:160px;" id="fdate" name="fdate" class="form-control" placeholder="Start Date" 
                    value="<?php echo ($_POST['fdate'] > 0) ? $_POST['fdate'] : date('Y-m-01'); ?>" /></td>
                              <td align="right" style="background-color:#3d6485; font-size:16px;padding-top:4px">&nbsp;</td>
                              <td align="right" style="background-color:#3d6485; color:#FFFFFF; font-size:16px; "><strong> End Date : </strong></td>
                              <td style="background-color:#3d6485; font-size:16px;padding-top:4px">
                <input type="date" id="tdate" style="width:160px;" name="tdate" class="form-control" placeholder=" End Date" 
                
                value="<?php echo ($_POST['tdate'] > 0) ? $_POST['tdate'] : date('Y-m-d'); ?>" /></td>
                            </tr>
							
							
                            
                             <br />
                             <tr>
                            <td colspan="4" align="center" style="text-align: right"><div align="center">
					
                              <input name="create" id="create" value="SHOW EMPLOYEE" type="submit" class="btn1 btn1-bg-submit">
                            </div></td>
                            </tr>
                          </tbody>
                        </table>
						</form> 
						<!DOCTYPE html>



						

                    <table   class="table1  table-striped table-bordered table-hover table-sm" style="zoom:75% !important">

                      <thead  class="thead1" style=" z-index: 2 !important; ">

                        <tr class="bgc-info">
                            <th style="text-align: center">Mark</th>
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
			
						  <th style="width:50px;text-align: center">Approve</th>
						  
						  <th style="width:50px;text-align: center">Disapprove</th>
						  

                        </tr>

                      </thead>
					  
					   <form action="" method="post" id="form1">

					    <tbody class="tbody1">

<?

$g_s_date=date('Y-01-01');

$g_e_date=date('Y-12-31');

//and a.entry_by='.$_SESSION['employee_selected'].'

//and o.s_date>="' . $_POST['fdate'] . '" and o.e_date<="' . $_POST['tdate'] . '"


       /* if($_POST['department']>0)			$con .=' and p.DEPT_ID='.$_POST['department'];
		if($_POST['job_location']>0)		$con .=' and p.JOB_LOCATION='.$_POST['job_location'];
		if($_POST['group_for']>0)			$con .=' and p.PBI_ORG='.$_POST['group_for'];
		if($_POST['PBI_DOMAIN']!='')		$con .=' and p.PBI_DOMAIN="'.$_POST['PBI_DOMAIN'].'"';*/

  
  $sql = 'select o.id,p.PBI_NAME,p.PBI_ID,p.DEPT_ID,p.PBI_CODE,p.cost_center,p.section,
  o.s_time,o.e_time,o.s_date as start_date,o.e_date as end_date,o.type,
  o.iom_apply_date,o.total_days,o.dept_head_status,o.iom_status,o.reason,p.incharge_id,o.entry_at
  
	
	from personnel_basic_info p,hrm_iom_info o
	
	where p.PBI_ID=o.PBI_ID and o.dept_head_status!="Cancel"  and o.iom_status="Pending"  
	
	'.$con.' order by o.s_date desc';

$query=db_query($sql);
while($data = mysqli_fetch_object($query)){


 $reporting_boss = find_a_field('personnel_basic_info','CONCAT(PBI_NAME,"-",PBI_CODE)','PBI_ID="'.$data->incharge_id.'"');

  $department = find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');
  $cost_center = find_a_field('hrm_cost_center','center_name','id="'.$data->cost_center.'"');
  $section = find_a_field('PBI_Section','sec_name','sec_id="'.$data->section.'"');
  
  

?>
                 


                        <tr>
                        <td style="width:50px"><input type="checkbox" style="width:50px" name="check_list[]" value="<?=$data->PBI_ID;?>"></td>
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
					

						
						<td style="width:50px"> 
						
							
						  <div class="btn-group"><a href="iom_approval_all.php?asign_id=<?=$data->id;?>" class="buttonn btn btn-primary">Approve</a></div>
						  
				        
						
						
						</td>
						
						
<td style="width:50px"><div class="btn-group">	<a href="iom_approval_all.php?cancel_id=<?=$data->id;?>"  class="buttonn btn btn-danger">Disapprove</a> </div>	</td>
						
				         </tr>

                 
						  <? } ?>
						  
						  
						  
						  
						  
	<?  
	
	
	
if($_GET['asign_id']>0){

$update = "update hrm_iom_info set iom_status='GRANTED',dept_head_status='Approve' where id='".$_GET['asign_id']."'";

$query=db_query($update);

 $ss = db_query("select * from hrm_iom_info  where id='".$_GET['asign_id']."'");
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


 $sql='update hrm_att_summary set iom_type="'.$iom_type.'", iom_id="'.$iom_sl_no.'",iom_start_time="'.$s_time.'",iom_end_time="'.$e_time.'",dayname=dayname("'.$att_date.'"),

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

}



} 




header('location:iom_approval_all.php');
	
	
	}
	
	
	
if ($_GET['cancel_id']>0) {
 

    $update = "update hrm_iom_info set iom_status='Cancel',dept_head_status='Cancel' 
   where id='".$_GET['cancel_id']."'";
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

	
	
	?>				 
								  
						  
						

                    </tbody>
                    <div align="left">

                    
					
					   </form>
					   
					   
					 

                    </table>
   <div align="left"> 
	<input type="checkbox" class="form-check-input" id="select-all">
	<label for="checkbox"><span class="bg-danger text-white">Select All</span></label>
	</div>
					
					
					


		

                             </div>



                  		   </div>                  		   </div>



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



                    </div>                      </div>
                      <script>

document.getElementById('select-all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}




</script>





<?

$main_content=ob_get_contents();



ob_end_clean();







require_once SERVER_CORE."routing/layout.bottom.php";







?>