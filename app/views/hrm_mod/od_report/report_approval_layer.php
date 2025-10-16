<?php



@session_start();



//



require "../../config/inc.all.php";



require "../../template/main_layout.php";



include ('../../../mail_function/mailer.php');?>    <!-- Datatables -->

    <link href="../../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <link href="../../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">

    <link href="../../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">

    <link href="../../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

    <link href="../../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">



    <!-- Custom Theme Style -->        <!-- top navigation -->



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

if($_GET['cancel_id']>0){ 

 $update_cancel = "update performance_appraisal set status='Cancel' where id='".$_GET['cancel_id']."'";

$queryy=mysql_query($update_cancel);

}





if($_GET['asign_id']>0){

$update = "update performance_appraisal set report_approval=1 where id='".$_GET['asign_id']."'";

$query=mysql_query($update);

//$to = 'nrain798@gmail.com';

$to = 'saud@aksidcorp.com';

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

  $ss = mysql_query("select a.*,p.PBI_NAME,p.PBI_DOJ from performance_appraisal a, personnel_basic_info p where a.PBI_ID=p.PBI_ID and a.id='".$_GET['asign_id']."'");

	 $data = mysql_fetch_object($ss);
	 
	 
	

	 

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

	 header('location:report_approval_layer.php');

} ?>



                  <div class="x_content">

                    <p class="text-muted font-13 m-b-30">  </p>

                    <table id="datatable-buttons" class="table table-striped table-bordered">

                      <thead>

                        <tr style="background-color:#3C7AB7; color:#F8F9FA;text-align:center">

                          <th>SL</th>

                          <th><center>Employee ID</center></th>

                          <th><center>Employee Name</center></th>
						  
						   <th><center>Department</center></th>
						   <th><center>Project</center></th>

                          <th><center>Appraisal Date</center></th>
						  
						  <th><center>Appraiser Name</center></th>

                          <th><center>Total Score</center></th>



                          <th>Status</th>

                        </tr>

                      </thead>

					    <tbody>

<?

//and a.entry_by='.$_SESSION['employee_selected'].'

  

  $sql = 'select a.*,p.PBI_NAME,p.pbi_code,a.PBI_DEPARTMENT,a.JOB_LOCATION

from performance_appraisal a,personnel_basic_info p

where  a.PBI_ID=p.PBI_ID and a.status="Done" and a.report_approval=0  order by a.PBI_DEPARTMENT,a.JOB_LOCATION ASC';

$query=mysql_query($sql);



while($data = mysql_fetch_object($query)){



?>



                        <tr style="text-align:center">

                          <td><center><?=++$s?></center></td>

                          <td><center><?=$data->pbi_code?></center></td>
                          <td><center><?=$data->PBI_NAME?></center></td>
						  
						  <td style="width:80px"><center><?=$data->PBI_DEPARTMENT;?></center></td>
						  <td style="width:80px"><center><?=$data->JOB_LOCATION;?></center></td>

                         
                          <td><center><?=date('d-M-Y',strtotime($data->submit_date)) ?></center></td>
						  
						  <td><center><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->entry_by.'"');?></center></td>



                          <td><center><?=$data->total_score?></center></td>

                          <td class="text-center" style=" width: 170px; ">

		                    <div class="btn-group" style=" width: 50% !important; float: left; font-size: 12px !important; "><a href="report_approval_layer.php?asign_id=<?=$data->id;?>" class="buttonn btn btn-primary" style=" font-size: 10px !important;     width: 98%; "><center>Approve</center></a></div>
					        <div class="btn-group" style=" width: 50% !important; float: right; font-size: 12px !important; "><a href="report_approval_layer.php?cancel_id=<?=$data->id;?>" class="buttonn btn btn-danger" style=" font-size: 10px !important; "><center>Not Approve</center></a></div>
					
					

						</td>
						
						
						
						

                        </tr>              <? } ?>

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



include_once("../../template/footer.php");



?>

