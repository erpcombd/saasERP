<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title="User Portal Login Access";


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

</style>



<?php



/*if(!empty($_POST['check_list']))
{
     foreach($_POST['check_list'] as $id){
        echo "<br>$id was checked! ";
     }
}*/



/////////////
if(!empty($_POST['check_list']))
{
$display = $_POST['check_list'];
//echo '<pre>';print_r($display);echo '</pre>';  

foreach ( $display as $key  ) {

	
	 $update = "UPDATE hrm_od_info SET od_status='Granted' WHERE id='".$key."' and od_status='Pending'";
    $query=db_query($update);
	
	

    }
	
}

///////////
?>


<?






if($_GET['asign_id']>0){

//$update = "update performance_appraisal set report_approval=1 where id='".$_GET['asign_id']."'";
//$query=db_query($update);


/*
$sqll = 'select PBI_NAME,PBI_ID from personnel_basic_info  where PBI_ID="'.$_GET['asign_id'].'"  group by PBI_ID';
$queryy=db_query($sqll);
while($datas = mysqli_fetch_object($queryy)){

$id = $datas->PBI_ID;
$name = $datas->PBI_NAME;

}


$check_id =find_a_field('users_basic_permission','PBI_ID','PBI_ID="'.$datas->PBI_ID.'"');

if($check_id>0){
header('location:user_basic_permission.php');
}else{

//User Id Create
$sql="INSERT INTO users_basic_permission (PBI_ID, update_permission	, create_permission )
VALUES ('".$id."', '1', '0' )";
$query=db_query($sql);




header('location:user_basic_permission.php');

}*/



}; ?>
                   <form action="?"  method="post">

					
					<table width="100%" border="0" class="table table-bordered table-sm">
                          <thead>
                            
                            <tr>
                              <th colspan="4" class="p-3 mb-2 bg-info text-white"><div align="center"><span>Select Options</span></div></th>
                            </tr>
                          </thead>
                          <tfoot>
                          </tfoot>
                          <tbody>
                            
                            
                            
                            
                            <tr>
                              <td align="center" style="text-align: right">&nbsp;</td>
                              <td align="center" style="text-align: right"><div align="right"><strong>Company : </strong></div></td>
                              <td><select name="group_for" id="group_for"  class="form-control"   onchange="getData2('ajax_location.php', 'loc', this.value,  this.value)" required="required">
                                <? foreign_relation('user_group', 'id', 'group_name',$_POST['group_for'],'1 and id="'.$_SESSION['user']['group'].'"')?>
                              </select></td>
                              <td>&nbsp;</td>
                            </tr>
                            
                            <tr>
                              <td align="right">&nbsp;</td>
                              <td align="right"><div align="right"><strong>Job Location : </strong></div></td>
                              <td><select name="job_location"  class="form-control" id="job_location" >
							    <option></option>
                                <? foreign_relation('office_location', 'ID', 'LOCATION_NAME',$_POST['job_location'],'1')?>
                              </select>
                                <input type='hidden' name='area' id='area' value='1' /></td>
                              <td>&nbsp;</td>
                            </tr>
							
							
							<tr>
                              <td align="right">&nbsp;</td>
                              <td align="right"><div align="right"><strong>department : </strong></div></td>
                              <td> <select name="department"  class="form-control" id="department">
							  <option></option>
                                   <? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['department'],' 1 order by DEPT_DESC');?>
                                 </select></td>
                              <td>&nbsp;</td>
                            </tr>
							
							
                            
                             <br />
                             <tr>
                            <td colspan="4" align="center" style="text-align: right"><div align="center">
					
                              <input name="create" id="create" value="SHOW EMPLOYEE" type="submit" class="btn btn-danger">
                            </div></td>
                            </tr>
                          </tbody>
                        </table>
						</form>
						
						

                    <table id="datatable-buttons" class="table table-bordered table-sm">

                      <thead>

                        <tr style="background-color:#3C7AB7; color:#F8F9FA">

                          <th>SL</th>

                          <th>Employee Name</th>
                          <th>ID</th>
                          <th>Department</th>
						  
						  <th>Submission Date</th>
						  <th>Rep. Auth. App. Date</th>
						  
						  <th>Start Date</th>
						  <th>End Date</th>
						  
						  <th>Start Time</th>
						  <th>End Time</th>
						  
						  <th>Total Hrs</th>
						  
						  <th>Total Days</th>
						  
						  <th>Reporting Auth</th>
					
                     
						  <th>Mark</th>

                        </tr>

                      </thead>
					  
					   <form action="od_approval_all.php" method="post" id="form1">

					    <tbody>

<?

//and a.entry_by='.$_SESSION['employee_selected'].'


        if($_POST['department']>0)			$con .=' and p.DEPT_ID='.$_POST['department'];
		if($_POST['job_location']>0)		$con .=' and p.JOB_LOCATION='.$_POST['job_location'];
		if($_POST['group_for']>0)			$con .=' and p.PBI_ORG='.$_POST['group_for'];
		if($_POST['PBI_DOMAIN']!='')		$con .=' and p.PBI_DOMAIN="'.$_POST['PBI_DOMAIN'].'"';

  
 $sql = 'select p.PBI_NAME,p.PBI_ID,p.DEPT_ID,o.od_date,o.id as od_id,o.auth_date,o.s_date,o.e_date,o.s_time,o.e_time,o.total_hrs,o.total_days,o.incharge_status

from personnel_basic_info p,hrm_od_info o

where p.PBI_ID=o.PBI_ID and o.od_status="Pending" '.$con.' order by p.PBI_ID desc';

$query=db_query($sql);
while($data = mysqli_fetch_object($query)){



?>
                 


                        <tr>

                          <td><?=++$s?></td>

                          <td><?=$data->PBI_NAME?></td>

                          <td><?=$data->PBI_ID?></td>

                          <td><?=find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');?></td>
                          <td><?=$data->od_date?></td>
						  <td><?=$data->auth_date?></td>
						  <td><?=$data->s_date?></td>
						  <td><?=$data->e_date?></td>
						  <td><?=$data->s_time?></td>
						  <td><?=$data->e_time?></td>
						  
						  <td><?=$data->total_hrs?></td>
						  <td><?=$data->total_days?></td>
						  <td><?=$data->incharge_status?></td>

						
						<td><input type="checkbox"  name="check_list[]" value="<?=$data->od_id;?>"></td>
						
				         </tr>

                      
						  <? } ?>
						  
						

                    </tbody>
					
					   </form>
					   
					 

                    </table>
					
					
					


					
					
					     <div class="btn-group">
						 
						 <button type="submit" class="btn btn-info" form="form1" value="Submit">Granted</button>
						 
							<!--<a href="od_approval_all.php?asign_id=1" class="buttonn btn btn-primary">Activate</a>-->
							
					
							
							</div>  
							
							<div align="right"><input type="checkbox" class="form-check-input" id="select-all"><label for="checkbox">Select All</label></div>

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



/*document.getElementById('select-all').onclick = function() {
    var checkboxes = document.getElementsByName('vehicle');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
}
*/

</script>




<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>
