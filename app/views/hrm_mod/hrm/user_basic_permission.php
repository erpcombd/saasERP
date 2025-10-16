<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title="User Portal Login Access";
do_datatable('grp');

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

<!--<style>-->
<!---->
<!--.button {-->
<!---->
<!--  position: relative;-->
<!---->
<!--  background-color: #04AA6D;-->
<!---->
<!--  border: none;-->
<!---->
<!--  font-size: 28px;-->
<!---->
<!--  color: #FFFFFF;-->
<!---->
<!--  padding: 20px;-->
<!---->
<!--  width: 200px;-->
<!---->
<!--  text-align: center;-->
<!---->
<!--  -webkit-transition-duration: 0.4s; /* Safari */-->
<!---->
<!--  transition-duration: 0.4s;-->
<!---->
<!--  text-decoration: none;-->
<!---->
<!--  overflow: hidden;-->
<!---->
<!--  cursor: pointer;-->
<!---->
<!--}-->
<!---->
<!---->
<!---->
<!--.button:after {-->
<!---->
<!--  content: "";-->
<!---->
<!--  background: #90EE90;-->
<!---->
<!--  display: block;-->
<!---->
<!--  position: absolute;-->
<!---->
<!--  padding-top: 300%;-->
<!---->
<!--  padding-left: 350%;-->
<!---->
<!--  margin-left: -20px!important;-->
<!---->
<!--  margin-top: -120%;-->
<!---->
<!--  opacity: 0;-->
<!---->
<!--  transition: all 0.8s-->
<!---->
<!--}-->
<!---->
<!---->
<!---->
<!--.button:active:after {-->
<!---->
<!--  padding: 0;-->
<!---->
<!--  margin: 0;-->
<!---->
<!--  opacity: 1;-->
<!---->
<!--  transition: 0s-->
<!---->
<!--}-->
<!---->
<!--</style>-->
<!---->


<?

if($_GET['cancel_id']>0){ 

 $update_cancel = "update users_basic_permission set update_permission='0' where id='".$_GET['cancel_id']."'";

$queryy=db_query($update_cancel);

}





if($_GET['asign_id']>0){

//$update = "update performance_appraisal set report_approval=1 where id='".$_GET['asign_id']."'";
//$query=db_query($update);



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

//User Module Define 
/*$user_id =find_a_field('user_activity_management','user_id','PBI_ID="'.$id.'"');
echo $sql_m="INSERT INTO user_module_define (user_id,module_id,status)
VALUES ('".$user_id."', '17','enable')";
$queryy=db_query($sql_m);*/

//User Page Define 
/*echo $sql_m="INSERT INTO user_roll_activity (user_id,page_id,access)
VALUES ('".$user_id."', '17','enable')";
$queryy=db_query($sql_m);*/




header('location:user_basic_permission.php');

}

//$to = 'nrain798@gmail.com';

/*$to = 'saud@aksidcorp.com';

$subject = 'Performance Appraisal Summary';

$str = 'AKSID Human Resources';

$cc='';

$str ="<span style='font-weight:bold; font-size:16px;'>Performance Appraisal Summary</span><br>";

$str.='<table width="100%" border="1" cellspacing="1" cellpadding="1">

  <tr style="background:#abc4d6;">    

    <td width="5%"><div align="center" style="font-weight:bold; background:#abc4d6;">ID</div></td> 

    <td width="11%"><div align="center" style="font-weight:bold;">Name</div></td>

	<td width="10%"><div align="center" style="font-weight:bold;">Designation</div></td>
	
	<td width="15%"><div align="center" style="font-weight:bold;">Department/Job Location</div></td>

	<td width="10%"><div align="center" style="font-weight:bold;">Joining Date</div></td>

    <td width="20%"><div align="center" style="font-weight:bold;">Job Period</div></td>

	<td width="5%"><div align="center" style="font-weight:bold;">Total Mark</div></td>

    <td width="5%"><div align="center" style="font-weight:bold;">Category</div></td>

	<td width="15%"><div align="center" style="font-weight:bold;">Recommendation</div></td>

  </tr>';  

  $test = "select a.*,p.PBI_NAME,p.PBI_DOJ from performance_appraisal a, personnel_basic_info p where a.PBI_ID=p.PBI_ID and a.id='".$_GET['asign_id']."'";

  $ss = db_query("select a.*,p.PBI_NAME,p.PBI_DOJ from performance_appraisal a, personnel_basic_info p where a.PBI_ID=p.PBI_ID and a.id='".$_GET['asign_id']."'");

	 $data = mysqli_fetch_object($ss);
	 
	 
	

	 

	 $str.= '<tr align="center">';

     $str.= '<td>'.$data->PBI_ID.'</td>';

     $str.= '<td>'.$data->PBI_NAME.'</td>';

     $str.= '<td>'.$data->designation.'</td>';
	 
	 $str.= '<td>'.$data->PBI_DEPARTMENT.''.$data->JOB_LOCATION.'</td>';

     $str.= '<td>'.date('d-M-Y',strtotime($data->PBI_DOJ)).'</td>';

     $str.= '<td>'.$data->job_period.'</td>';

	 $str.= '<td>'.$data->total_score.'</td>';

     $str.= '<td>'.$data->category.'</td>';

	 $str.= '<td>'.$data->recommendation.'</td>';

	 $str.= '</tr>';



     smtp_mailer($to,$subject,$str,$cc);

	 header('location:report_approval_layer.php');*/

}; ?>


					
					<?php /*?><table width="100%" border="0" class="table table-bordered table-sm">
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
                                <? foreign_relation('office_location', 'ID', 'LOCATION_NAME',$_POST['job_location'],'1')?>
                              </select>
                                <input type='hidden' name='area' id='area' value='1' /></td>
                              <td>&nbsp;</td>
                            </tr>
                            
                             <br />
                             <tr>
                            <td colspan="4" align="center" style="text-align: right"><div align="center">
					
                              <input name="create" id="create" value="SHOW EMPLOYEE" type="submit" class="btn1 btn1-bg-submit">
                            </div></td>
                            </tr>
                          </tbody>
                        </table>
						
						
						

                    <table id="datatable-buttons" class="table table-bordered table-sm">

                      <thead>

                        <tr style="background-color:#3C7AB7; color:#F8F9FA">

                          <th>SL</th>

                          <th>Employee Name</th>

                          <th>Employee Id</th>

                          <th>Department</th>
                           <th>Company Name</th>
                          <th>Update Access</th>
						  <th>Create Access</th>

                        </tr>

                      </thead>

					    <tbody>

<?

//and a.entry_by='.$_SESSION['employee_selected'].'

  
$sql = 'select p.PBI_NAME,p.PBI_ID,p.DEPT_ID

from personnel_basic_info p

where  1 order by p.PBI_ID desc';

$query=db_query($sql);
while($data = mysqli_fetch_object($query)){



?>



                        <tr>

                          <td><?=++$s?></td>

                          <td><?=$data->PBI_NAME?></td>

                          <td><?=$data->PBI_ID?></td>

                          <td><?=find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');?></td>



                          <td><?=$data->total_score?></td>

                          <td class="text-center">

		                    <div class="btn-group">
							
							<? $check_id =find_a_field('users_basic_permission','PBI_ID','PBI_ID="'.$data->PBI_ID.'"');
							    
								if($check_id>0){
							
							
							 ?>
							 <button class="btn1 btn1-bg-submit">DONE</button>
							 
							 <? }else{ ?>
							
							<a href="user_basic_permission.php?asign_id=<?=$data->PBI_ID;?>" class="btn1 btn1-bg-submit">Activate</a>
							
							<? } ?>
							
							</div>&nbsp;&nbsp;
							
							
							
					        <div class="btn-group"><a href="user_basic_permission.php?cancel_id=<?=$data->PBI_ID;?>" class="btn1 btn1-bg-cancel">Deactivate</a></div>
					
					

						</td>
						
						<td><input type="checkbox" name="vehicle3" value="Basic Leave" checked></td>
						  <? } ?>

                    </tbody>

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



                    </div>                      </div>


<?php */?>


		 <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company Name</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="group_for" id="group_for"  class="form-control"   onchange="getData2('ajax_location.php', 'loc', this.value,  this.value)" required="required">
                                <? foreign_relation('user_group', 'id', 'group_name',$_POST['group_for'],'1 and id="'.$_SESSION['user']['group'].'"')?>
                              </select>
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Location</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <select name="job_location"  class="form-control" id="job_location" >
                                <? foreign_relation('office_location', 'ID', 'LOCATION_NAME',$_POST['job_location'],'1')?>
                              </select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                  
                    <input name="create" id="create" value="Show Employee" type="submit" class="btn1 btn1-submit-input">
                </div>
				
				

            </div>
        </div>

	</form>

        <div class="container-fluid pt-3 p-0 ">
           
            <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>SL</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>

                    <th>Department</th>
                    <th>Company</th>
                    <th>Update Access</th>

                    <th>Create Access</th>
                    
                </tr>
                </thead>

                <tbody class="tbody1">
					<?
					
					//and a.entry_by='.$_SESSION['employee_selected'].'
					
					 $s=1; 
					$sql = 'select p.PBI_NAME,p.PBI_ID,p.DEPT_ID
					
					from personnel_basic_info p
					
					where  1 order by p.PBI_ID desc';
					
					$query=db_query($sql);
					while($data = mysqli_fetch_object($query)){
					
					
					
					?>
                <tr>
                    <td><?=$s++;?></td>
                    <td><?=$data->PBI_NAME;?></td>
                   <td><?=$data->PBI_ID;?></td>
				    <td><?=find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');?></td>
					 <td><?=find_a_field('user_group','group_name','Id='.$data->DEPT_ID);?></td>
					  <td>
					  
					  		
							
						
							
							<? $check_id =find_a_field('users_basic_permission','PBI_ID','PBI_ID="'.$data->PBI_ID.'"');
							    
								if($check_id>0){
							
							
							 ?>
							 <button class="btn1 btn1-bg-submit">Done</button>
							 
							 <? }else{ ?>
							
							<a href="user_basic_permission.php?asign_id=<?=$data->PBI_ID;?>" class="btn1 btn1-bg-update">Activate</a>
							
							<? } ?>
							
							
							<a href="user_basic_permission.php?cancel_id=<?=$data->PBI_ID;?>" class="btn1 btn1-bg-cancel">Deactivate</a>
							
					  </td>

                    
					<td><input type="checkbox" name="vehicle3" value="Basic Leave" checked></td>
                </tr>
				
				<? } ?>
				
                </tbody>
            </table>


        </div>

  




<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>
