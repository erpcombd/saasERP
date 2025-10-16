<?php

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Dashboard';



?>



<?php /*?>function randomPassword() {

    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";

    $pass = array(); //remember to declare $pass as an array

    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

    for ($i = 0; $i < 5; $i++) {

        $n = rand(0, $alphaLength);

        $pass[] = $alphabet[$n];

    }

    return implode($pass); //turn the array into a string

}







$sql = 'select PBI_ID,PBI_CODE,JOB_LOCATION from personnel_basic_info where PBI_JOB_STATUS="In Service"';

$query = db_query($sql);



while($data = mysqli_fetch_object($query)){







   $password=randomPassword();





 $insert = 'insert into hrm_user_access (`user_name`,`emp_id`,`password`,`group_id`) values("'.$data->PBI_CODE.'","'.$data->PBI_ID.'","'.$password.'","'.$data->JOB_LOCATION.'")';

 db_query($insert);

<?php */?>




<style type="text/css">

<!--

.style1 {

	font-size: 24px;

	color: #006600;

}

-->

</style>





	

	

	<div class="">

            
         <?
		 
		 
		 $select = 'select * from crm_roll_assign where PBI_ID="'.$_SESSION['srrr'].'"';
		 $query = db_query($select);
		 $row = mysqli_fetch_object($query);
		  ?>          
	<? if($row->dashboard_panel==1) {?>
            

            <div class="row">

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<a href="../report/master_report.php?report=202&&lead_status=1" target="_blank">
                        <div class="tile-stats" style="background:#99FF66;">

                          <div class="icon"><i class="fa fa-caret-square-o-right"></i>

                          </div>

                          <div class="count"><?=find_a_field('crm_lead_master','count(lead_no)','1 and lead_status = 1');?></div>



                          <h3>Active Lead</h3>

                          <p>Customer Relationship Management</p>

                        </div>
						
						</a>

                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<a href="../report/master_report.php?report=201" target="_blank">
                        <div class="tile-stats" style="background:#CCFF33;">

                          <div class="icon"><i class="fa fa-comments-o"></i>

                          </div>

                          <div class="count"><?=find_a_field('crm_customer_info','count(dealer_code)',' 1 ');?></div>



                          <h3>Total Customer</h3>

                          <p>Customer Relationship Management</p>

                        </div>
</a>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<a href="../report/master_report.php?report=202" target="_blank">
                        <div class="tile-stats" style="background:#FFFF99;">

                          <div class="icon"><i class="fa fa-sort-amount-desc"></i>

                          </div>

                          <div class="count"><?=find_a_field('crm_lead_master','count(lead_no)',' 1 ');?></div>



                          <h3>Total Lead</h3>

                          <p>Customer Relationship Management</p>

                        </div>
</a>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<a href="../report/master_report.php?report=203" target="_blank">
                        <div class="tile-stats" style="background:#33CCCC;">

                          <div class="icon"><i class="fa fa-check-square-o"></i>

                          </div>

                          <div class="count"><?=find_a_field('crm_comunication','count(id)',' 1 ');?></div>



                          <h3 style="color:white;">Total Communication</h3>

                          <p>Customer Relationship Management</p>

                        </div>
</a>
                      </div>

                    </div>

            <? } else{?>
			
			
			<div class="row">
<div class="col-md-12" style="text-align: center;">
<h1 style="font-weight: bolder; padding-top: 100px;">Welcome To CRM Module</h1>
<h3 style="padding-bottom: 100px;">Store Your All Client Information</h3>

</div>
              

            </div>
			
			
			<? } ?>

            <div class="clearfix"></div>



            <div class="row">

              

            </div>

            <!--<div class="row">

              



              <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Employee Graph <small> 2019</small></h2>

                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                      </li>

                      <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        <ul class="dropdown-menu" role="menu">

                          <li><a href="#">Settings 1</a>

                          </li>

                          <li><a href="#">Settings 2</a>

                          </li>

                        </ul>

                      </li>

                      <li><a class="close-link"><i class="fa fa-close"></i></a>

                      </li>

                    </ul>

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">

                    <canvas id="mybarChart"></canvas>

                  </div>

                </div>

              </div>

			  

			  <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2>Payroll Graph <small> 2019</small></h2>

                    <ul class="nav navbar-right panel_toolbox">

                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                      </li>

                      <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                        <ul class="dropdown-menu" role="menu">

                          <li><a href="#">Settings 1</a>

                          </li>

                          <li><a href="#">Settings 2</a>

                          </li>

                        </ul>

                      </li>

                      <li><a class="close-link"><i class="fa fa-close"></i></a>

                      </li>

                    </ul>

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">

                    <canvas id="canvasDoughnut"></canvas>

                  </div>

                </div>

              </div>

            </div>-->

          </div>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>