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
                              <td><select name="PBI_GROUP"  class="form-control" id="PBI_GROUP" >
							    <option></option>
                                  <? foreign_relation('hrm_group','id','group_name',$PBI_GROUP,'1 order by id');?>
                              </select>
                              </td>
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
					
                              <input name="create" id="create" value="SHOW EMPLOYEE" type="submit" class="btn1 btn1-bg-submit">
                            </div></td>
                            </tr>
                          </tbody>
                        </table>
						</form>



						
						

                <table   class="table1  table-striped table-bordered table-hover table-sm">



                      <thead  class="thead1">



                        <tr class="bgc-info">

             

                          <th style="text-align: center">Name</th>

                      			  

						  <th style="text-align: center">Req Date</th>

						

						  <th style="text-align: center">Visit Date</th>

							

						  <th style="text-align: center">Project Name</th>

						  

					       <th style="text-align: center">Client Name</th>

							

							<th style="text-align: center">Client Org Name</th>

						   

						   

						  

						  <th style="text-align: center">Visit Time</th>

							

						  <th style="text-align: center">Leader Status</th>

							

						  <th style="text-align: center">Req Status</th>

						  

						  <th style="text-align: center">HR Status</th>

						                       

						  <th style="width:50px;text-align: center">View</th>



                        </tr>



                      </thead>

					  

					   <form action="" method="post" id="form1">



				<tbody class="tbody1">



<?



//user id

$u_id=$_SESSION['user']['id'];



$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);





$g_s_date=date('Y-01-01');



$g_e_date=date('Y-12-31');



//and a.entry_by='.$_SESSION['employee_selected'].'





        if($_POST['department']>0)			$con .=' and p.DEPT_ID='.$_POST['department'];

		if($_POST['job_location']>0)		$con .=' and p.JOB_LOCATION='.$_POST['job_location'];

		if($_POST['group_for']>0)			$con .=' and p.PBI_ORG='.$_POST['group_for'];

		if($_POST['PBI_DOMAIN']!='')		$con .=' and p.PBI_DOMAIN="'.$_POST['PBI_DOMAIN'].'"';



  

 	 $sql = 'select a.*, p.PBI_NAME,p.PBI_ID

  

	

	from personnel_basic_info p,vehicle_requisition a

	

	where p.PBI_ID=a.PBI_ID  and a.req_date between "'.$g_s_date.'" and "'.$g_e_date.'" '.$con.' order by a.req_date desc';



	$query=db_query($sql);

	while($data = mysqli_fetch_object($query)){



?>

                 





                        <tr>                 



                          <td style="width:180px"><?=$data->PBI_NAME?></td>

                          <td style="width:130px"><?=$data->req_date?></td>						  

						  

                          <td style="width:130px"><?=date('d-M-Y',strtotime($data->v_date))?></td>

						  						 						 						  

						  						

						  <td style="width:80px;text-align:center"><?=$data->prj_name?></td> 

						 						  

						  

						  <td  style="text-align:center"><?=$data->person?></td>

						  <td  style="text-align:center"><?=$data->clnt_org_name?></td>

							

						  

							

						  <td  style="text-align:center"><?=$data->v_s_t?></td>

							

						  <td  style="text-align:center"><?=$data->reporting_auth_status?></td>

						  <td  style="text-align:center"><?=$data->status?></td>

						  <td  style="text-align:center"><?=$data->hr_status?></td>

											

						<td style="width:50px"> 

						

							

						  <div class="btn-group"><a href="car_req_view.php?req_id=<?=$data->req_id?>" class="buttonn btn btn-primary">Open</a></div>

						  

				

						

						

						</td>

						

				         </tr>



                 

						  <? } ?>

						  

		

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



                    </div>                      </div>





<?

//



//







require_once SERVER_CORE."routing/layout.bottom.php";







?>