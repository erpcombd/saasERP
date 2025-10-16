<?php
session_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
//include 'config/db.php';
//include 'config/function.php';
include '../config/access.php';
$u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);
$user_id	= $PBI_ID; //$_SESSION['user_id'];
$page="do_unfinished";
include "../inc/header.php";
?>



<?   

$_SESSION['employee_selected'] = $PBI_ID;

$essentialInfo = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);

$leave_status = find_a_field('hrm_leave_info','leave_status','id='.$_REQUEST['id']);

$incharge_status = find_a_field('hrm_leave_info','incharge_status','id='.$_REQUEST['id']);


$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$PBI_ID);



$today_date = date('Y-m-d');




if(isset($_POST['insert']))

{

if(($_POST['half_leave_date']) < $today_date){
$msggg= "<p style='color:#FF0000'>You can not apply back date leave <br></p>";
}else{
$now= time();
$extention=explode('.',$_FILES['att_file']['name']);
$extention=strtolower(end($extention));
$target_dir = "picture/leave_files/";
$target_file = $target_dir . $$unique.'.'.$extention;
$projectId = array(2,3,4,5);
//$_REQUEST['PBI_ID']=$_SESSION['employee_selected'];

if(in_array($essentialInfo->ESSENTIAL_PROJECT, $projectId)){
$_REQUEST['PBI_DEPT_HEAD'] = 1007;}

$incharge = $PBI->incharge_id;
$leave_status = "Pending";
$incharge_status = "Pending";
$days = 0.5;
$leave_apply_date = $_POST['leave_apply_date'];
$leave_slot = $_POST['leave_slot'];
$entry_by = $PBI->PBI_ID;
$_POST['half_or_full'] = "Half";
$_POST['entry_at'] = date('Y-m-d H:i:s');


$start_date = date('Y-m-d',strtotime($_POST['leave_apply_date']));
$end_date   = date('Y-m-d',strtotime($_POST['leave_apply_date']));

if($_POST['leave_slot']=="Early Half"){
$_POST['sort_leave_start_time'] = '8:30';
$_POST['sort_leave_end_time']   = '12:45';

$_POST['s_time'] = '8:30';
$_POST['e_time']   = '12:45';

}else{
$_POST['sort_leave_start_time']= '12:45';
$_POST['sort_leave_end_time']   = '5:00';

$_POST['s_time'] = '12:45';
$_POST['e_time'] = '5:00';

}

if($_FILES['att_file']['tmp_name']!=""){
$_REQUEST['att_file']= $target_file;}


//$crud->insert();

echo $sql_master="INSERT INTO hrm_leave_info (leave_apply_date,PBI_IN_CHARGE,reporting_auth,incharge_status,PBI_ID,type,mon,year,s_date,e_date,total_days,reason,
 leave_status,entry_by,s_time,e_time,half_or_full,leave_slot,sort_leave_start_time,sort_leave_end_time)

VALUES ('".$leave_apply_date."', '".$incharge."', '".$incharge."', '".$incharge_status."', '".$PBI_ID."', '".$_POST['type']."','".$_POST['mon']."','".$_POST['year']."', 
'".$start_date."','".$end_date."','".$days."','".$_POST['reason']."','".$leave_status."','".$entry_by."','".$_POST['s_time']."','".$_POST['e_time']."','".$_POST['half_or_full']."','".$_POST['leave_slot']."',
'".$_POST['sort_leave_start_time']."','".$_POST['sort_leave_end_time']."')";

$insert = $conn->query($sql_master);

move_uploaded_file($_FILES["att_file"]["tmp_name"], '../../'.$target_file);

$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);



echo '<script type="text/javascript">parent.parent.document.location.href = "home.php?notify=12";</script>';


}















}



?>
<!-- main page content -->

<div class="main-container container">
  <!-- User list items  -->
  <div class="row">
    <div class="row text-center mb-2">
      <h4>Short Leave Application Form <?=$msggg; ?></h4>
    </div>
    
    <div class="row" style="margin: 0 auto">
      <div class="card">
        <form action="" method="post" style="padding:10px">
          <div class="form-group pt-1 pb-1">
            <label for="date"> Leave Types :</label>
			
			                            <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                        <input name="PBI_ID" id="PBI_ID" value="<?=$PBI_ID;?>" type="hidden" />
                                        <input name="mon" id="mon" value="<?=date('n')?>" type="hidden" />
                                        <input name="year" id="year" value="<?=date('Y')?>" type="hidden" />
										
            <input type="text" name="type"  class="form-control border border-info"   value="Short Leave (SHL)"  tabindex="1" readonly >
			
          </div>
          <div class="form-group pt-1 pb-1">
            <label for="date">Leave Slot :</label>
            <select  class="form-control border border-info" name="leave_slot" id="" required="required">
               <option value="<?=$leave_slot?>"><?=$leave_slot?></option>
               <option <?=($half_or_full=='Early Half')?'Selected':'';?> >Early Half</option>
               <option <?=($half_or_full=='Last Half')?'Selected':'';?> >Last Half</option>
            </select>
          </div>
          <div class="form-group pt-1 pb-1">
            <label for="date"> Leave Date :</label>
            <input type="date" name="half_leave_date" id="half_leave_date" value="<?php if($half_leave_date) echo $half_leave_date; ?>"  class="form-control border border-info" tabindex="1">
          </div>
          <div class="form-group pt-1 pb-1">
            <label for="date"> Reason :</label>
            <textarea class="form-control border border-info" name="reason" required="" spellcheck="false"></textarea>
          </div>
          <div class="form-group pt-1 pb-1">
            <label for="date"> Supporting Doc:</label>
            <input class="form-control border border-info"  type="file" name="att_file">
          </div>
          <div class="form-group pt-1 pb-1">
            <label for="date"> Substitute Associate :</label>
            <select class="form-control border border-info" name="leave_responsibility_name" id="leave_responsibility_name">
              <option value="1019">Abu Hasan :: Software Engineer</option>
              <option value="1004">Al Amin Ali Dawan :: Team Leader</option>
              <option value="1001">Bimol Chandra Das :: Chief Technical Officer(CTO)</option>
              <option value="1011">Chandan Das :: Software Engineer</option>
              <option value="1008">Iftekhar Wahid(Srabon) :: Chief Technical Officer(CTO)</option>
              <option value="1018">Jahirul Islam :: Software Engineer</option>
              <option value="1017">Jobaraj Miah :: Software Engineer</option>
              <option value="1002">Kawsar Mahmud :: Team Leader</option>
              <option value="1021">Mainul Islam Himel :: Software Engineer</option>
              <option value="1003">Md. Kamrul Hasan :: Team Leader</option>
              <option value="1005">Payer Alam Rony :: Team Leader</option>
              <option value="10117">Pintu  :: Jr. Software Engineer</option>
              <option value="30015">Shakil :: Software Engineer</option>
              <option value="1013">SK Akash :: Software Engineer</option>
              <option value="1010">Tanjil Khandokar :: Software Engineer</option>
              <option value="1016">Tariqul Islam :: Software Engineer</option>
            </select>
          </div>
          <div class="form-group pt-1 pb-1">
            <label for="date"> Submission Date :</label>
            <input type="date" name="leave_apply_date" class="form-control border border-info" tabindex="1" value="<?=$leave_apply_date?>">
          </div>
          
          <div align="center" class="class pt-3 pb-3">
            <input type="submit" name="insert" class="btn btn-info" value="Apply">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- main page content ends -->
<!-- Page ends-->
<?php include "../inc/footer.php"; ?>
