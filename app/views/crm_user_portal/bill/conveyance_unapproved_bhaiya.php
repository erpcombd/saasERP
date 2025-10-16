<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


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

</style>            <form action="" method="post" id="form1">
						
							
							<table   class="table1  table-striped table-bordered table-hover table-sm">

                      <thead  class="thead1">

                    <tr>
                              <td align="right" style="background-color:#3d6485; color:#FFFFFF; font-size:16px;"><strong> Start Date : </strong></td>
                              <td align="left" style="background-color:#3d6485; font-size:16px;padding-top:4px">
							  <input type="date" style="width:160px;" id="fdate" name="fdate" class="form-control" placeholder="Start Date" value="<?=date('Y-m-01')?>" /></td>
							  
                              <td align="right" style="background-color:#3d6485; font-size:16px;padding-top:4px">&nbsp;</td>
                              <td align="right" style="background-color:#3d6485; color:#FFFFFF; font-size:16px; "><strong> End date : </strong></td>
							  
                              <td style="background-color:#3d6485; font-size:16px;padding-top:4px">
							  <input type="date" id="tdate" style="width:160px;" name="tdate" class="form-control" placeholder=" End Date" value="<?=date('Y-m-d')?>" /></td>
                            </tr>
					
				
                              <td align="right" style="background-color:#3d6485; color:#FFFFFF; font-size:16px;"><strong> Group : </strong></td>
                              <td width="25%" align="left" ><span class="oe_form_group_cell">
                                <select name="PBI_GROUP" style="width:160px;" class="form-control" id="PBI_GROUP">
                                     <option selected="selected" value="<?=$_POST['PBI_GROUP']?>"><?=find_a_field('hrm_group','group_name','id='.$_POST['PBI_GROUP']);?></option>
                                  <? foreign_relation('hrm_group','id','group_name',$PBI_GROUP,'1 order by id');?>
                                </select>
                                </span></td>
							
                              <td width="9%" align="right" >&nbsp;</td>
                              <td align="right"></td>
                              <td align="left"><span class="oe_form_group_cell"><input name="show" type="submit" class="btn btn-success" id="show" value="View Sheet" /></span></td>
                     
						  

                      </thead>
								<br>
					  
					

				<tbody class="tbody1">

					
					
                   <table   class="table1  table-striped table-bordered table-hover table-sm">

                      <thead  class="thead1">

                        <tr class="bgc-info">
						
						 <th style="text-align: center">Emp Code</th>
             
                          <th style="text-align: center">Name</th>
                      			  
			             <th style="text-align: center">Conveyance No</th>
						 
						  <th style="text-align: center">Conveyance Date</th>
							
						<th style="text-align: center">Means of Conveyance</th>
							
			             <th style="text-align: center">Leader Status</th>
						  
						  <th style="text-align: center">HR Status</th>
							
						                      
						  <th style="width:50px;text-align: center">View</th>

                        </tr>

                      </thead>
					  
					

				<tbody class="tbody1">

<?

//user id
$u_id=$_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);





if(isset($_POST['fdate'])) {

$g_s_date=$_POST['fdate'];
$g_e_date=$_POST['tdate'];

} else {
  
$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');

}









//and a.entry_by='.$_SESSION['employee_selected'].'


        if($_POST['department']>0)			$con .=' and p.DEPT_ID='.$_POST['department'];
		if($_POST['job_location']>0)		$con .=' and p.JOB_LOCATION='.$_POST['job_location'];
		if($_POST['group_for']>0)			$con .=' and p.PBI_ORG='.$_POST['group_for'];
		if($_POST['PBI_GROUP']!='')		    $con .=' and p.PBI_GROUP="'.$_POST['PBI_GROUP'].'"';

  //and  a.PBI_ID="'.$PBI_ID.'"
 	 $sql = 'select a.*, p.PBI_NAME,p.PBI_ID
  
	
	from personnel_basic_info p,bills a
	
	where p.PBI_CODE=a.emp_code and status="Checked" and hr_status!="Completed" and a.conveyance_date between "'.$g_s_date.'" and "'.$g_e_date.'" '.$con.' GROUP by a.conveyance_no';

	$query=db_query($sql);
	while($data = mysqli_fetch_object($query)){

?>
                 

					

                        <tr>                 
                           <td style="width:180px"><?=$data->emp_code?></td>
                          <td style="width:180px"><?=$data->PBI_NAME?></td>
                          <td style="width:130px"><?=$data->conveyance_no?></td>						  
						  
                          <td style="width:130px"><?=date('d-M-Y',strtotime($data->conveyance_date))?></td>
						  	<td style="width:180px"><?=$data->means?></td>					 						 						  
			
						  <td  style="text-align:center"><?=$data->status?></td>
						  <td  style="text-align:center"><?=$data->hr_status?></td>
											
						<td style="width:50px"> 
						
							
						  <div class="btn-group"><a href="conveyance_view.php?con_id=<?=$data->conveyance_no?>" class="buttonn btn btn-primary" target="_blank">Open</a></div>
						  
				
						
						
						</td>
						
				         </tr>

                 
						  <? } ?>
						  
						  
						  
						  
						  
	<?  
/*	if($_GET['asign_id']>0){

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
 $sql='update hrm_att_summary set iom_type="'.$iom_type.'", iom_id="'.$iom_sl_no.'",iom_start_time="'.$s_time.'",iom_end_time="'.$e_time.'",dayname=dayname("'.$att_date.'"),

iom_entry_at="'.$iom_entry_at.'", iom_entry_by="'.$iom_entry_by.'",iom_category="'.$iom_category.'"

where  emp_id="'.$emp_id.'" and att_date="'.$att_date.'" ';

$query=db_query($sql);

}



} 




header('location:iom_approval_all.php');
	
	
	}*/
	
	
	?>				 
								  
						  
						

                    </tbody>
					
					   </form>
					   
					 

                    </table>
					
					
					


		

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



                    </div>                      
																																	 </div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>