<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";




$title='Amendment Entry';	





do_calander('#f_date');







do_calander('#t_date');







$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';











auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');















$table='hrm_iom_info';







$unique='id';







$shown='PBI_ID';







$crud      =new crud($table);









if($_GET['emp_id']>0) $emp_id=$_GET['emp_id'];

if($_POST['PBI_ID']!='') { 

    

    



    

    

    $emp_id= $_POST['PBI_ID'];

    

    

    

}







if($_GET['emp_id']>0&&$_GET['iom_id']>0)





{		



$sql="delete from hrm_iom_info where id='".$_GET['iom_id']."'";

db_query($sql);









$up_query='update hrm_att_summary set iom_type="", iom_sl_no="", iom_reason="", iom_approved_by="", iom_entry_at="0000-00-00 00:00:00", iom_entry_by="" 

where iom_id="'.$_GET['iom_id'].'" and emp_id="'.$_GET['emp_id'].'"';







db_query($up_query);















echo 'Deleted';







}







if(prevent_multi_submit()){







if(isset($_POST['search'])&&$_POST['t_date']!=''&&$_POST['f_date']!='')







{		







$iom_type=$_POST['iom_type'];

$iom_reason = $_POST['reason'] =$_POST['iom_reason'];

$iom_entry_at=date('Y-m-d H:i:s');

$iom_entry_by=$_SESSION['user']['id'];

$s_date=($_POST['f_date']);

$e_date=($_POST['t_date']);

$iom_category = $_POST['iom_category'];



$s_time=($_POST['s_time']);

$e_time=($_POST['e_time']);



$from_date=$_REQUEST['s_date']=strtotime($_POST['f_date']);

$to_date=$_REQUEST['e_date']=strtotime($_POST['t_date']);





$old_iom = find_a_field('hrm_iom_info','id',' s_date = "'.$_REQUEST['f_date'].'" and e_date = "'.$_REQUEST['t_date'].'" and 
type= "'.$_POST['iom_type'].'" and dept_head_status!="Cancel" and  PBI_ID="'.$emp_id.'"'); 







if($old_iom==0){

$from_dates = date_create($from_date);

$to_dates = date_create($to_date);

$diff = date_diff(date_create($s_date),date_create($e_date)); 

$total_days =  $diff->format("%a")+1;



if($_POST['iom_type']=='Early Half'){

	 $s_time = '08:30';

	 $e_time = '12:45';

	}elseif($_POST['iom_type']=='Last Half'){

		$s_time = '12:45';

		$e_time = '17:00';

		}elseif($_POST['iom_type']=='Full'){

		$s_time = '08:30';

		$e_time = '17:00';

		}







 $ssql = "INSERT INTO hrm_iom_info (`dept_head_status` ,`PBI_ID` ,`type` ,`s_date` ,`e_date` , `reason` ,`iom_category`,`total_days`,`s_time`,`e_time`,`iom_status`,`entry_at`)



VALUES (  'Approve', '".$emp_id."', '".$_POST['iom_type']."',  '".$_POST['f_date']."', '".$_POST['t_date']."', '".$iom_reason."','".$iom_category."','".$total_days."', 
'".$s_time."' , '".$e_time."','GRANTED','".date('Y-m-d H:i:s')."')";







db_query($ssql);

//$iom_sl_no=  mysqli_insert_id();

$iom_sl_no = mysqli_insert_id($conn);	

	

for($i=$from_date; $i<=$to_date; $i=$i+86400)

{



$att_date=date('Y-m-d',$i);

$found = find_a_field('hrm_att_summary','1','emp_id="'.$emp_id.'" and att_date="'.$att_date.'"');

$in_late_found = find_a_field('hrm_att_summary','1','emp_id="'.$emp_id.'" and att_date="'.$att_date.'" and in_time>0');
$out_late_found = find_a_field('hrm_att_summary','1','emp_id="'.$emp_id.'" and att_date="'.$att_date.'" and in_time>0 OR out_time>0');



if($found==0) {

 $sql="INSERT INTO hrm_att_summary (emp_id, iom_type, iom_id, att_date,iom_start_time,iom_end_time,iom_entry_at,iom_entry_by,iom_category , iom_reason , dayname)

VALUES ('$emp_id', '$iom_type', '$iom_sl_no','$att_date','$s_time','$e_time','$iom_entry_at','$iom_entry_by','$iom_category' , '$iom_reason' , dayname('".$att_date."'))";
$query=db_query($sql);

} else{


if($iom_type == 'Full') {

  
 $sql='update hrm_att_summary set iom_type="'.$iom_type.'", iom_id="'.$iom_sl_no.'",iom_start_time="'.$s_time.'",
  iom_end_time="'.$e_time.'",dayname=dayname("'.$att_date.'"),

iom_entry_at="'.$iom_entry_at.'", iom_entry_by="'.$iom_entry_by.'",iom_category="'.$iom_category.'"

where  emp_id="'.$emp_id.'" and att_date="'.$att_date.'" ';

$query=db_query($sql);
  



}elseif($iom_type == 'Early Half'){

 if($in_late_found >0){
 $sql='update hrm_att_summary set iom_type="'.$iom_type.'", iom_id="'.$iom_sl_no.'",iom_start_time="'.$s_time.'",
  iom_end_time="'.$e_time.'",dayname=dayname("'.$att_date.'"),

iom_entry_at="'.$iom_entry_at.'", iom_entry_by="'.$iom_entry_by.'",iom_category="'.$iom_category.'"

where  emp_id="'.$emp_id.'" and att_date="'.$att_date.'" ';

$query=db_query($sql);
 }

}else{
 
  if($out_late_found >0){
 $sql='update hrm_att_summary set iom_type_early_out="'.$iom_type.'", iom_id_early_out ="'.$iom_sl_no.'",iom_start_time_early_out="'.$s_time.'",
 iom_end_time_early_out="'.$e_time.'",dayname=dayname("'.$att_date.'"),
 iom_entry_by_early_out="'.$iom_entry_by.'"
 where  emp_id="'.$emp_id.'" and att_date="'.$att_date.'" ';
 $query=db_query($sql);
  }

}





}



} 







}







else echo $msggg= "<h2 style='color:#FF0000'>You Can't Add Duplicate Amendment </h2>";







}}







		


















?>
<script type="text/javascript"> function DosNav(lk1,lk2){







	window.open('../attendence/iom_entry.php?iom_sl_no='+lk1+'&emp_id='+lk2,'_self');







	}</script>
	
	
<script>
function validateForm() {
    var reasonInput = document.getElementById("iom_reason").value;


    if (reasonInput.trim() === "") {
        alert("Please enter a valid reason.");
        return false; 
    }


    if (!/^[a-zA-Z\s]{5,}/.test(reasonInput)) {
        alert("Please enter a valid reason with alphabetic characters.");
        return false; 
    }


    return true;
}
</script>


<style type="text/css">






























</style>
<!--hello report-->
<form action="" method="post" enctype="multipart/form-data">
  <? include('../common/title_bar.php');?>
</form>
<form action="?"  method="post" onsubmit="return validateForm()">

  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mx-auto mt-5" style="max-width: 600px;">
                <div class="card-header bg-success text-white text-center">
                    <h2 class="mb-0">Amendment Entry</h2>
                </div>
                <div class="card-body">
           
                        <div class="form-group row">
                            <label for="iom_type" class="col-sm-4 col-form-label text-right">Amendment Type:</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" required>
                                <select name="iom_type" id="iom_type" class="form-control" required>
                                    <option></option>
                                    <option value="Full">Absent</option>
                                    <option value="Early Half">In Late</option>
                                    <option value="Last Half">Early Out</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="iom_reason" class="col-sm-4 col-form-label text-right">Reason:</label>
                            <div class="col-sm-8">
                                <input type="text" name="iom_reason" id="iom_reason" class="form-control" value="<?=$iom_reason?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="f_date" class="col-sm-4 col-form-label text-right">Date From:</label>
                            <div class="col-sm-8">
                                <input type="date" name="f_date" id="datePicker" class="form-control" autocomplete="off" value="<?=date("Y-m-d");?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t_date" class="col-sm-4 col-form-label text-right">Date To:</label>
                            <div class="col-sm-8">
                                <input type="date" name="t_date" id="datePicker" autocomplete="off" class="form-control" value="<?=date("Y-m-d");?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-8">
                                <button type="submit" name="view_data" id="view_data" class="btn btn-success">VIEW</button>
                                <button type="submit" name="search" class="btn btn-primary">SUBMIT</button>
                            </div>
                        </div>
                 
                </div>
            </div>
        </div>
    </div>
</div>


  <div class="container-fluid pt-5">
    <? if($emp_id>0 || $_POST['view_data']){?>
    <h4 class="text-center bg-titel bold pt-2 pb-2"> <strong>Employee Name: </strong>
      <? $pbi_date=find_all_field('personnel_basic_info','',' PBI_ID='.$emp_id); echo $pbi_date->PBI_NAME.' ('.$pbi_date->PBI_DESIGNATION.')'; ?>
    </h4>
    <center>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"></td>
        </tr>
      </table>
    </center>
    <table class="table1  table-striped table-bordered table-hover table-sm">
      <thead class="thead1">
        <tr class="bgc-info">
          <th>Id</th>
          <th>Emp Id</th>
          <th>Amendment  Type</th>
          <th>Amendment  No</th>
          <th>Reason</th>
          <th>Amendment Date</th>
          <th>Entry At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody  class="tbody1">
        <?
if($_SESSION['emp_id']>0)	 $emp_id_selected=$_SESSION['emp_id'];

else $emp_id_selected=0;




 $res="SELECT id,PBI_ID as emp_id, type, reason as iom_reason, s_date as att_date,
entry_at as iom_entry_at
FROM hrm_iom_info
WHERE PBI_ID=$emp_id and id>0
order by s_date desc";



$query = db_query($res);
while($data=mysqli_fetch_object($query)){

?>
        <tr <?=(++$i%2)?'class="alt"':'';?>>
          <td><?=$data->id?></td>
          <td><?=find_a_field('personnel_basic_info','PBI_CODE','PBI_ID='.$data->emp_id);?>
          </td>
          <td><? if($data->type=="Early Half") {
    echo "In Late";
}elseif($data->type=="Full"){
    
    echo "Absent";
    
}else{ echo "Early Out";} ?></td>
          <td><?=$data->iom_id?></td>
          <td><?=$data->iom_reason?></td>
          <td><?=$data->att_date?></td>
          <td><?=$data->iom_entry_at?></td>
          <td> <a href="iom_log_delete.php?asign_id=<?= $data->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-flat"> <i class="fa fa-trash"></i> </a> </td>
        </tr>
        <? }?>
      </tbody>
    </table>
    <? }?>
  </div>
</form>


	<script>

    </script>
	
	
<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>
