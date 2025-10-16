<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';



$title='Final Payroll Proccess';	


?>    <!-- Datatables -->



        <!-- page content -->



        
        	<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->



                  <div class="">



                <div class="clearfix"></div>

                    <div class="row">



                      <div class="col-md-12 col-sm-12 col-xs-12">






	  <!--edit form -->

                     
			 
					 
					 
					 
					 
					 
					 
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



						
						

                    <table   class="table1  table-striped table-bordered table-hover table-sm">

                      <thead  class="thead1">

                        <tr class="bgc-info">

                
                          <th style="text-align: center">Employee ID</th>
                          <th style="text-align: center">Name</th>
                          <th style="text-align: center">Job Status</th>
				
					
						  
						  <th style="text-align: center">Date</th>
						  
						  <th style="text-align: center">HR Approval</th>
						  
					
					
                     
						  <th style="width:50px;text-align: center"">View</th>

                        </tr>

                      </thead>
					  
					   <form action="" method="post" id="form1">

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
  $sql = 'select o.*,p.PBI_NAME,p.PBI_ID,p.PBI_DEPARTMENT,p.PBI_JOB_STATUS
  
	
	from personnel_basic_info p,hrm_off_board o
	
	where p.PBI_ID=o.PBI_ID   '.$con.' order by o.PBI_ID';

$query=db_query($sql);
while($data = mysqli_fetch_object($query)){






?>
                 


                        <tr>

                    
                          <td style="width:130px"><?=$data->PBI_ID;?></td>
                          <td style="width:180px"><?=$data->PBI_NAME?></td>
                          <td style="width:130px"><?=$data->PBI_JOB_STATUS?></td>
						  
				
						  
						  <td  style="text-align:center"><? if($data->activity_date>0){ echo date('d-M-Y',strtotime($data->activity_date));}?></td>
						  <td  style="text-align:center"><?=$data->iom_status?></td>
					

						
						<td style="width:50px"> 
						
							
						  <div class="btn-group"><a href="emp_off_board_view.php?asign_id=<?=$data->PF_STATUS_ID;?>" class="buttonn btn btn-primary">Approve</a></div>
						  
				
						
						
						</td>
						
				         </tr>

                 
						  <? } ?>
						  
						  
						  
			
						

                    </tbody>
					
					   </form>
					   
					 

                    </table>
					
					
					


		

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



                    </div>                      </div>






<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
