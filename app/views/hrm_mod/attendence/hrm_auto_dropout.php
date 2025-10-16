<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="Machine Data Sync (Roster)";


do_calander('#m_date');


if($_POST['mon']!='')	$mon=$_POST['mon'];
else					$mon=date('n');






if(isset($_POST["upload"]))
{
if($_POST['s_date']!='' && $_POST['e_date']!=''){

$start_date = date('Y-m-d',strtotime($_POST['s_date']));
$end_date = date('Y-m-d',strtotime($_POST['e_date']));

$date_con = " and h.xdate BETWEEN '".$start_date."' AND '".$end_date."'";
}



 // __________________ ROSTER INSERT ____________
	
		 $sql = "SELECT a.emp_id, SUM(a.present) as total_attendance
			FROM hrm_att_summary a , personnel_basic_info p
			WHERE a.emp_id=p.PBI_ID  and a.att_date BETWEEN '" . $start_date . "' AND '" . $end_date . "' AND  
			p.PBI_JOB_STATUS = 'In Service' and
			p.Saturday != 'Day_off' AND Sunday != 'Day_off'
			GROUP BY a.emp_id
			HAVING total_attendance < 10 ";
			
		 $ros_assign = db_query($sql);
         $num_rows = mysqli_num_rows($ros_assign);
         if ($num_rows > 0) {
         
		 while($assign_roster = mysqli_fetch_object($ros_assign)){
            
        
		$assign_emp_id = $assign_roster->emp_id;
		
		 $last_att_date = find_a_field('hrm_att_summary','att_date','emp_id="'.$assign_emp_id.'" and in_time IS NOT NULL OR out_time IS NOT NULL order by id DESC');
		
		  
		echo $update = "UPDATE personnel_basic_info SET PBI_JOB_STATUS='Not In Service'  , emp_deletion_reason='Dropout' , resign_date = '".$last_att_date."'
		
		WHERE PBI_ID='".$assign_emp_id."'";
		
		$query=db_query($update);
				  
	
		
		   }
		
		        }
		
	
		
		
		
		

//_______________________ROSTER INSERT OFFFFFFFFF___________________



echo 'Complete';

}

?>





<style type="text/css">

<!--

.style1 {font-size: 24px}

.style2 {

	color: #FF66CC;

	font-weight: bold;

}

-->

</style>







<form action=""  method="post" enctype="multipart/form-data">

    <div class="d-flex justify-content-center">

        <div class="n-form1 fo-width pt-0">
            <h4 class="text-center bg-titel bold pt-2 pb-2">      Collect Machine Data Factory  </h4>
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group row  m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code :  </label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                            
								
	           <input type="text"  list='eip_ids' name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" />
                <datalist id='eip_ids'>
                  <option></option>
                  <?
			foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_CODE," - ",PBI_NAME)',$emp_id,'1');
			?>
                </datalist>
				
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company :    </label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                <select name="PBI_ORG"  id="PBI_ORG">

							  <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
						
							</select>
                            </div>
                        </div>

                    </div>


                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Location :    </label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                              
								
								
								       <select name="JOB_LOCATION" id="JOB_LOCATION"  class="form-control"  >
                                       
                                            <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$JOB_LOCATION);?>
                                          </select>
                                          
                                          
                            </div>
                        </div>

                    </div>


                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                        <div class="form-group row m-0 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department :    </label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                <select name="department"  class="form-control" id="department">

							  <option></option>
						
								<? foreign_relation('department','DEPT_ID','DEPT_DESC',$department,' 1 order by DEPT_DESC');?>
							  </select>
                            </div>
                        </div>

                    </div>



                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                                    <label for="group_for" 
                                    class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Start Date : </label>
                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                      <input type="date" name="s_date" id="s_date" value="<?=date("Y-m-01");?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">End Date :    </label>
                                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                                        <input type="date" name="e_date" id="e_date" value="<?=date("Y-m-d");?>" autocomplete="off"/>

                                    </div>
                                </div>
                            </div>



                </div>


                <div class="n-form-btn-class">
                    <input name="upload" class="btn1 btn1-bg-submit" type="submit" id="upload" value="Sync All Data" />
                </div>

            </div>

        </div>

    </div>


    


</form>




<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>




