<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Employee On-Board Info' ; 
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

					
					<table width="100%" border="0" class="table table-bordered table-sm">
                          <thead>
                            
                            <tr>
                              <th colspan="4" class="text-center bg-titel bold pt-2 pb-2">Select Options</th>
                            </tr>
                          </thead>
                          <tfoot>
                          </tfoot>
                          <tbody>
                            
                            
                            
                            
                            
                            
                            <tr>
                              <td align="right">&nbsp;</td>
                              <td align="right"><div align="right"><strong>Job Location : </strong></div></td>
                              <td><select name="job_location"  class="form-control" id="job_location" >
							    <option></option>
                                <? foreign_relation('project', 'PROJECT_ID', 'PROJECT_DESC',$_POST['job_location'],'1')?>
                              </select>
                              </td>
                              <td>&nbsp;</td>
                            </tr>
							
							
							<tr>
                              <td align="right">&nbsp;</td>
                              <td align="right"><div align="right"><strong>Department : </strong></div></td>
                              <td> <select name="department"  class="form-control" id="department">
							        <option></option>
						
                                   <? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['department'],' 1 order by DEPT_DESC');?>
                                 </select></td>
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
						</form>


                    <form action="" method="post" id="form1" enctype="multipart/form-data">
			
                    <table   class="table1  table-striped table-bordered table-hover table-sm">

                      <thead  class="thead1">

                        <tr class="bgc-info">

                
                          <th style="text-align: center">Employee ID</th>
                          <th style="text-align: center">Name</th>
                          <th style="text-align: center">Job Status</th>
						  
						  <th style="text-align: center">Department</th>
						  <th style="text-align: center">Designation</th>
				
					
						  
						  <th style="text-align: center">Joining Date</th>
						  
						  <th style="text-align: center">HR Approval</th>
						  
					
					
                     
						  <th style="width:50px;text-align: center"">View</th>

                        </tr>

                      </thead>
					  
					

					    <tbody class="tbody1">

<?

$g_s_date=date('Y-01-01');

$g_e_date=date('Y-12-31');

//and a.entry_by='.$_SESSION['employee_selected'].'


        if($_POST['department']>0)			$con .=' and p.DEPT_ID='.$_POST['department'];
		if($_POST['job_location']>0)		$con .=' and p.JOB_LOCATION='.$_POST['job_location'];
		if($_POST['group_for']>0)			$con .=' and p.PBI_ORG='.$_POST['group_for'];
		if($_POST['PBI_DOMAIN']!='')		$con .=' and p.PBI_DOMAIN="'.$_POST['PBI_DOMAIN'].'"';

  //and o.s_date between "'.$g_s_date.'" and "'.$g_e_date.'"
  $sql = 'select p.*
  
	
	from personnel_basic_info p
	
	where p.PBI_JOB_STATUS="On Board"   '.$con.' order by p.PBI_ID';

$query=db_query($sql);
while($data = mysqli_fetch_object($query)){


$employee_id = $data->PBI_ID;



?>
                 


                        <tr>

                    
                          <td style="width:130px"><?=$data->PBI_ID;?></td>
                          <td style="width:180px"><?=$data->PBI_NAME?></td>
                          <td style="width:130px"><?=$data->PBI_JOB_STATUS?></td>
						  
						  <td style="width:130px"><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$data->DEPT_ID);?></td>
						  <td style="width:130px"><?=find_a_field('designation','DESG_DESC','DESG_ID='.$data->DESG_ID);?></td>
						  
				
						  
						  <td  style="text-align:center"><? if($data->PBI_DOJ>0){ echo date('d-M-Y',strtotime($data->PBI_DOJ));}?></td>
						  <td  style="text-align:center">
						  
						  <div class="btn-group"><a href="employee_Onboard_information.php?asign_id=<?=$data->PBI_ID;?>" class="buttonn btn btn-danger">Approve</a></div></td>
					

						
						<td style="width:50px"> 
						
							
						  <div class="btn-group"><a href="employee_recruitment_information_bhaiya.php?asign_id=<?=$data->PBI_ID;?>" class="buttonn btn btn-success">Open</a></div>
						  
				
						
						
						</td>
						
				         </tr>

                 
						  <? } ?>
						  
						  
						  
			
						

                    </tbody>
					
				
					   
					 

                    </table>
					
					
					</form>


<?  


	if($_GET['asign_id']>0){

echo $updateb = "UPDATE personnel_basic_info SET PBI_JOB_STATUS='In Service' WHERE PBI_ID='".$_GET['asign_id']."'";
$query=db_query($updateb);

header('location:employee_Onboard_information.php');


}


?>		

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





<?



require_once SERVER_CORE."routing/layout.bottom.php";


?>