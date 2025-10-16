<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";




$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);



$rep_auth = find_a_field('hrm_leave_info','PBI_IN_CHARGE','PBI_ID='.$_SESSION['employee_selected']);




?>





    <!-- Datatables -->
    <link href="../../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->


        <!-- top navigation -->

        <!-- /top navigation -->

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

<?

//$update = "update performance_appraisal set report_approval=1 where id='".$_GET['asign_id']."'";
//$query=mysql_query($update);


 ?>





 <div class="x_content">
				  
<div class="row">
<div class="col-md-12">
<div class="panel panel-primary" align="center">
<div class="panel-heading">
<h3 class="panel-title">Performance Appraisal</h3>
</div>
<div class="panel-body">
<div class="oe_view_manager oe_view_manager_current">


                    <p class="text-muted font-13 m-b-30">  </p>
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr style="background-color:#3C7AB7; color:#F8F9FA">
                          <th>SL</th>
						  <th>Employee ID</th>
                          <th>Employee Name</th>
                          <th>Designation</th>
                          <th>Department / Job Location</th>
						  <th>Appraisal Type</th>
						  <th>Appraisal No</th>
						 
                          <th>Click to Open</th>
                        </tr>
                      </thead>
					    <tbody>
<?

 /* $sql = 'select a.*,p.PBI_NAME
from performance_appraisal a,personnel_basic_info p
where  a.PBI_ID=p.PBI_ID and a.status="Done" and a.report_approval=0 order by a.PBI_ID desc';
$query=mysqli_query($sql);*/



   $res = "select p.PBI_ID as Emp_id,p.PBI_CODE,p.PBI_NAME,desg.DESG_DESC,

  (select DEPT_DESC from department where DEPT_ID=p.PBI_DEPARTMENT) as department,

  (select PROJECT_DESC from project where PROJECT_ID=p.JOB_LOCATION) as project 

  from personnel_basic_info p, designation desg, hrm_pa_set e 
  where p.PBI_DESIGNATION=desg.DESG_ID and e.status='Active' and p.PBI_ID=e.PBI_ID and p.PBI_JOB_STATUS='In Service' and e.LINE_MANAGER=".$_SESSION['employee_selected'];
  $query=mysqli_query($conn,$res);
  

foreach($data as $key =>$value){

  $current_year =  date("Y");
  $submit_year_s = date('Y-01-01');
  
  $submit_year_e = date('Y-m-d');

 $check_pa = find_a_field('performance_appraisal','PBI_ID','submit_date BETWEEN "'.$submit_year_s .'" AND "'.$submit_year_e .'"  and status="Done" and PBI_ID="'.$data->Emp_id.'" and entry_by="'.$_SESSION['employee_selected'].'"  and EMPLOYMENT_TYPE="Permanent"');
 
 $check_pa_probation = find_a_field('performance_appraisal','PBI_ID','year="'.$current_year.'" and status="Done" and PBI_ID="'.$data->Emp_id.'" and EMPLOYMENT_TYPE="Probationary"');
 
 //$emp_type_probation = find_a_field('performance_appraisal','EMPLOYMENT_TYPE','year="'.$current_year.'" and status="Done" and PBI_ID="'.$data->Emp_id.'"');
 
 $emp_type = find_a_field('essential_info','EMPLOYMENT_TYPE','PBI_ID="'.$data->Emp_id.'"');
 $app_no = find_a_field('performance_appraisal','count(PBI_ID)','year="'.$current_year.'" and status="Done" and PBI_ID="'.$data->Emp_id.'" and EMPLOYMENT_TYPE="Probationary"');
 
 
 
 
 if($emp_type=="Permanent" && $check_pa != $data->Emp_id ){
 
 
 ?>

                        <tr>
                          <td><?=++$s?></td>
                          <td><?=$data->PBI_CODE?></td>
						  <td><?=$data->PBI_NAME?></td>
                          <td><?=$data->DESG_DESC?></td>
                          <td><?=$data->department?></td>
						  <td><?=$emp_type ?></td>
						  <td></td>
						
                          <td class="text-center">
		                  <center>  <div class="btn-group"><a href="performance_appraisal.php?id=<?=$data->Emp_id;?>" class="buttonn btn btn-primary">Click</a></div></center>
						</td>
                        </tr>
			<? }elseif($emp_type=="Probationary"){ //&& $check_pa_probation != $data->Emp_id ?>
			
			            <tr>
                          <td><?=++$s?></td>
                          <td><?=$data->PBI_CODE?></td>
						  <td><?=$data->PBI_NAME?></td>
                          <td><?=$data->DESG_DESC?></td>
                          <td><?=$data->department?></td>
						  <td><?=$emp_type ?></td>
						   <? if($app_no>0){   ?>
						  <td><center> 
						  
						  <button type="button" class="btn btn-primary">
   <span class="badge badge-info" style="background-color:#DC3545; color:#FFFFFF"><?=$app_no;?></span>
  <span class="sr-only"></span>
</button></center> </td>
						  <? }else{?>
						  <td></td>
						  <? }?>
						
                          <td class="text-center">
		                  <center>  <div class="btn-group"><a href="performance_appraisal.php?id=<?=$data->Emp_id;?>" class="buttonn btn btn-primary">Click</a></div></center>
						</td>
                        </tr>
			
			
			<?  }else{} ?>	
						
						


              <?  }?>



                      </tbody>
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

                        </div>

                      </div>

                    </div>





                      </div>
					  
					  
					  
					  
					  

        <!-- /page content -->

        <!-- footer content -->







    <!-- Datatables -->
    <script src="../../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../../vendors/pdfmake/build/vfs_fonts.js"></script>



  </body>
</html>



<script src="asset.js"></script>




<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
