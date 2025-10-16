<?php








require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="User Portal Login Access";

do_datatable('grp');



?>
<!-- Datatables -->
<!-- page content -->

<div class="right_col" role="main">
<!-- Must not delete it ,this is main design header-->
<div class="">
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="openerp openerp_webclient_container">
<div class="x_content">

<?


if($_GET['reset_id']>0){
$sqll = 'select PBI_NAME,PBI_ID,PBI_CODE from personnel_basic_info  where PBI_ID="'.$_GET['reset_id'].'"  group by PBI_ID';
$queryy=db_query($sqll);
while($datas = mysqli_fetch_object($queryy)){
$id = $datas->PBI_ID;
$name = $datas->PBI_NAME;
$emp_id_no = $datas->PBI_CODE;
$emp_password = md5($emp_id_no);

$update_reset= "update user_activity_management set password='".$emp_password."' , default_checker = 0  where PBI_ID = '".$_GET['reset_id']."'";
$query_update = db_query($update_reset);

}
}



if($_GET['cancel_id']>0){ 



 $update_cancel = "update user_activity_management set level='0',status='deactive' where PBI_ID='".$_GET['cancel_id']."'";



$queryy=db_query($update_cancel);



}


if($_GET['asign_id']>0){
$sqll = 'select PBI_NAME,PBI_ID,PBI_CODE from personnel_basic_info  where PBI_ID="'.$_GET['asign_id'].'"  group by PBI_ID';
$queryy=db_query($sqll);
while($datas = mysqli_fetch_object($queryy)){
$id = $datas->PBI_ID;
$name = $datas->PBI_NAME;
$emp_id_no = $datas->PBI_CODE;
$emp_password = md5($emp_id_no);

}

$check_id =find_a_field('user_activity_management','PBI_ID','PBI_ID="'.$datas->PBI_ID.'"');
if($check_id>0){
header('location:auto_user_create.php');

}else{

//User Id Create
$sql="INSERT INTO user_activity_management (username, password, level,fname,status,group_for,PBI_ID,user_type,entry_date,expire_date,warehouse_id,default_checker,master_user)
VALUES ('".$emp_id_no."', '".$emp_password."', '5', '".$name."', 'Active', '1', '".$id."','User','".date("Y-m-d")."','2030-12-31','1','1','1')";
$query=db_query($sql);

//User Module Define 

$user_id =find_a_field('user_activity_management','user_id','PBI_ID="'.$id.'"');

echo $sql_m="INSERT INTO user_module_define (user_id,module_id,status)

VALUES ('".$user_id."', '17','enable')";

$queryy=db_query($sql_m);



//User Page Define 

echo $sql_m="INSERT INTO user_roll_activity (user_id,page_id,access)

VALUES ('".$user_id."', '1298','1')";

$queryy=db_query($sql_m);
echo $sql_2="INSERT INTO user_roll_activity (user_id,page_id,access)

VALUES ('".$user_id."', '1299','1')";

$queryy=db_query($sql_2);

echo $sql_3="INSERT INTO user_roll_activity (user_id,page_id,access)

VALUES ('".$user_id."', '1302','1')";

$queryy=db_query($sql_3);

echo $sql_4="INSERT INTO user_roll_activity (user_id,page_id,access)

VALUES ('".$user_id."', '1304','1')";

$queryy=db_query($sql_4);
echo $sql_5="INSERT INTO user_roll_activity (user_id,page_id,access)

VALUES ('".$user_id."', '1334','1')";

$queryy=db_query($sql_5);

echo $sql_6="INSERT INTO user_roll_activity (user_id,page_id,access)

VALUES ('".$user_id."', '1310','1')";

$queryy=db_query($sql_6);


echo $sql_7="INSERT INTO user_roll_activity (user_id,page_id,access)

VALUES ('".$user_id."', '1311','1')";

$queryy=db_query($sql_7);


echo $sql_8="INSERT INTO user_roll_activity (user_id,page_id,access)

VALUES ('".$user_id."', '1312','1')";

$queryy=db_query($sql_8);


echo $sql_9="INSERT INTO user_roll_activity (user_id,page_id,access)

VALUES ('".$user_id."', '1313','1')";

$queryy=db_query($sql_9);



echo $sql_10="INSERT INTO user_roll_activity (user_id,page_id,access)

VALUES ('".$user_id."', '1314','1')";

$queryy=db_query($sql_10);












header('location:auto_user_create.php');



}





}; ?>
<div class="container-fluid pt-5 p-0 ">
  <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
    <thead class="thead1">
      <tr class="bgc-info">
        <th>SL</th>
        <th>Employee Name</th>
		<th>Employee ID</th>
        <th>Employee CODE</th>
        <th>Department</th>
        <th>Company</th>
        <th>Status</th>
        
      </tr>
    </thead>
    <tbody class="tbody1">
      <?



//and a.entry_by='.$_SESSION['employee_selected'].'

					$s=1;

					  

					$sql = 'select p.PBI_NAME,p.PBI_ID,p.DEPT_ID,p.PBI_CODE

					

					from personnel_basic_info p

					

					where  1 order by p.PBI_ID desc';

					

					$query=db_query($sql);

					while($data = mysqli_fetch_object($query)){

					

					

					

					?>
      <tr>
        <td><?=$s++;?></td>
        <td><?=$data->PBI_NAME;?></td>
		<td><?=$data->PBI_CODE;?></td>
        <td><?=$data->PBI_ID;?></td>
        <td><? //=find_a_field('department','DEPT_DESC','DEPT_ID="'.$data->DEPT_ID.'"');?></td>
        <td><?=find_a_field('user_group','group_name','Id='.$data->DEPT_ID);?></td>
        <td><? $check_id =find_a_field('user_activity_management','PBI_ID','PBI_ID="'.$data->PBI_ID.'"');

		if($check_id>0){  ?>
          <button class="btn1 btn1-bg-submit">Done</button>
		  
		  
          <? }else{ ?>
          <a href="auto_user_create.php?asign_id=<?=$data->PBI_ID;?>" class="btn1 btn1-bg-update">Activate</a>
          <? } ?>
          <a href="auto_user_create.php?cancel_id=<?=$data->PBI_ID;?>" class="btn1 btn1-bg-cancel">Deactivate</a> 
		  
		  <a href="auto_user_create.php?reset_id=<?=$data->PBI_ID;?>" class="btn1 btn1-bg-hrm">Reset</a> </td>
		  
        
      </tr>
      <? } ?>
    </tbody>
  </table>
</div>
<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>
