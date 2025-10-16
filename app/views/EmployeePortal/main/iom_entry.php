<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';

include '../config/access.php';



$u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];

$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$user_id	= $PBI_ID; //$_SESSION['user_id'];



$page="do_unfinished";

include "../inc/header.php";

?>





<?







$root='leave';



$table='hrm_leave_info';		// Database Table Name Mainly related to this page



$unique='id';			// Primary Key of this Database table



$shown='type';				// For a New or Edit Data a must have data field



$g_s_date=date('Y-01-01');



$g_e_date=date('Y-12-31');



do_calander('#leave_apply_date');



$unique_name = md5(uniqid(rand(), true));







$_SESSION['employee_selected'] = $PBI_ID;



$essentialInfo = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);



$leave_status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);



$incharge_status = find_a_field('hrm_leave_info','incharge_status','id='.$_REQUEST['id']);





$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);











if(isset($_POST['save_leave']))



{



    $now= time();



    $projectId = array(2,3,4,5);



    $incharge = $PBI->incharge_id; //$essentialInfo->ESSENTIAL_REPORTING;



    if(in_array($essentialInfo->ESSENTIAL_PROJECT, $projectId)){



        $_REQUEST['PBI_DEPT_HEAD'] = 111659;}
$leave_status = "Pending";
$incharge_status = "Pending";
$leave_apply_date = $_POST['s_date'];
$entry_at= date('Y-m-d H:i:s');

$entry_by = $PBI->PBI_ID;
$start_date = date('Y-m-d',strtotime($_POST['s_date']));


$end_date   = date('Y-m-d',strtotime($_POST['e_date']));
$mon = date('m',strtotime($_POST['s_date']));
$year = date('Y',strtotime($_POST['s_date']));

$start = strtotime($_POST['s_date']);
$end  = strtotime($_POST['e_date']);

$days_between = ceil(abs($start - $end) / 86400)+1;






if($_FILES['att_file']['tmp_name']!=''){
$file_name= $_FILES['att_file']['name'];
$file_tmp= $_FILES['att_file']['tmp_name'];
$ext=end(explode('.',$file_name));
$path='../file/leave_file/';
move_uploaded_file($file_tmp, $path.$max_id.'.'.$ext);
}

if($_POST['type'] =='Early Half'){

	 $s_time = '08:30';

	 $e_time = '12:45';

	}elseif($_POST['type']=='Last Half'){

		$s_time = '12:45';

		$e_time = '17:00';

		}elseif($_POST['type']=='Full'){

		$s_time = '08:30';

		$e_time = '17:00';

		}


  $sql_master="INSERT INTO hrm_iom_info (iom_apply_date,PBI_IN_CHARGE,PBI_DEPT_HEAD,dept_head_status,PBI_ID,type,mon,year,s_date,e_date,total_days,reason,iom_status,entry_by,s_time,e_time)

VALUES ('".$leave_apply_date."', '".$incharge."','".$incharge."','".$incharge_status."', '".$PBI_ID."', '".$_POST['type']."','".$mon."','".$year."', '".$start_date."',

'".$end_date."','".$days_between."','".$_POST['reason']."','".$leave_status."','".$entry_by."','".$s_time."','".$e_time."')";



    $insert = $conn->query($sql_master);




    unset($_POST);

    unset($$unique);

    echo '<script type="text/javascript">parent.parent.document.location.href = "iom_status.php?notify=12";</script>';

}





?>

    <!-- main page content -->







    <div class="main-container container">















        <!-- User list items  -->







        <div class="row">







            <div class="row text-center mb-2"><h4> IOM Entry Form</h4></div>



















            <div class="row" style="margin: 0 auto;">







                <div class="card">







                    <form action="iom_entry.php" method="post" style="padding:10px" id="form1">







                        <div class="form-group pt-1 pb-1">



                            <label for="date"> Employee Code:</label>

                            <input name="PBI_ID" type="text"   class="form-control border border-info" size="10" onblur="" tabindex="1" value="<?=$PBI_ID?>"  readonly />





                        </div>















                        <div class="form-group pt-1 pb-1">



                            <label for="date">   Date Form :</label>







                            <input type="date" name="s_date" value="<?php if($s_date=='') echo ''; else echo $s_date ; ?>" class="form-control border border-info" tabindex="1">







                        </div>















                        <div class="form-group pt-1 pb-1">



                            <label for="date">   Date To :</label>







                            <input type="date" name="e_date" id="e_date"  value="<?php if($e_date=='') echo ''; else echo $e_date ; ?>" class="form-control border border-info" tabindex="1">







                        </div>













                        <div class="form-group pt-1 pb-1">



                            <label for="date">   IOM Type :</label>



                            <select  class="form-control border border-info" name="type" id="type" required="">

                                <option></option>

                                <option>Full</option>

                                <option>Early Half</option>

                                <option>Last Half</option>

                            </select>







                        </div>











                        <div class="form-group pt-1 pb-1">



                            <label for="date"> Reason :</label>



                            <textarea class="form-control border border-info" name="reason" required="" spellcheck="false"></textarea>



                        </div>





















                        <div align="center" class="class pt-3 pb-3">







                            <input type="submit" name="save_leave"  class="btn btn-info" id="form1"  value="Apply">







                        </div>







                    </form>







                </div>







            </div>























        </div>



















    </div>







    <!-- main page content ends -->







    <!-- Page ends-->















<?php include "../inc/footer.php"; ?>