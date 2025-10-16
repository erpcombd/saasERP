<?php






require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title="SS Login Access";

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






if($_GET['cancel_id']>0){ 



 $update_cancel = "update ss_user set level='0',status='Inactive' where user_id='".$_GET['cancel_id']."'";



$queryy=db_query($update_cancel);



 $update_cancel_2 = "update user_activity_management set sfa_user='No' where user_id='".$_GET['cancel_id']."'";


$queryy2=db_query($update_cancel_2);








}
 

if($_GET['asign_id']>0){
$sqll = 'select user_id,username,fname from user_activity_management  where user_id="'.$_GET['asign_id'].'"  group by user_id';
$queryy=db_query($sqll);
while($datas = mysqli_fetch_object($queryy)){
$id = $datas->user_id;
$name = $datas->PBI_NAME;
$emp_id_no = $datas->fname;
$emp_password = md5($emp_id_no);

}

$update_cancel_4 = "update ss_user set level='5',status='Active' where user_id='".$_GET['asign_id']."'";
$queryy=db_query($update_cancel_4);


$check_id =find_a_field('ss_user','user_id','user_id="'.$datas->user_id.'" ');
if($check_id>0){




header('location:sfa_user_create.php');

}else{

//User Id Create
 $sql="INSERT INTO ss_user (user_id,username, password, level,fname,status,group_for,entry_at)
VALUES ('".$id."','".$id."', '".$id."', '5', '".$emp_id_no."', 'Active', '1', '".date("Y-m-d")."')";
$query=db_query($sql);

 $update_cancel_3 = "update user_activity_management set sfa_user='Yes' where user_id='".$_GET['asign_id']."'";
$queryy3=db_query($update_cancel_3);












header('location:sfa_user_create.php');



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
        <th>Company</th>
        <th>Status</th>
        
      </tr>
    </thead>
    <tbody class="tbody1">
      <?



//and a.entry_by='.$_SESSION['employee_selected'].'

					$s=1;

					  

					$sql = 'select p.fname,p.user_id,p.username

					

					from user_activity_management p

					

					where  1 order by p.user_id desc';

					

					$query=db_query($sql);

					while($data = mysqli_fetch_object($query)){

					

					

					

					?>
      <tr>
        <td><?=$s++;?></td>
        <td><?=$data->fname;?></td>
		<td><?=$data->username;?></td>
        <td><?=$data->user_id;?></td>
        <td><?=find_a_field('user_group','group_name','Id='.$data->DEPT_ID);?></td>
        <td><? $check_id =find_a_field('ss_user','user_id','user_id="'.$data->user_id.'" and level>0');

		if($check_id>0){  ?>
          <button class="btn1 btn1-bg-submit">Done</button>
		  
		  
          <? }else{ ?>
          <a href="sfa_user_create.php?asign_id=<?=$data->user_id;?>" class="btn1 btn1-bg-update">Activate</a>
          <? } ?>
          <a href="sfa_user_create.php?cancel_id=<?=$data->user_id;?>" class="btn1 btn1-bg-cancel">Deactivate</a> 
		  
		  </td>
		  
        
      </tr>
      <? } ?>
    </tbody>
  </table>
</div>
<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>
