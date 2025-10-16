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




echo $sqll = 'select a.id,a.lead_name,b.address,b.contact_number,b.contact_email
from 
crm_project_lead a,
crm_project_org b  where a.id="'.$_GET['asign_id'].'" and a.organization=b.id  group by a.id';
$queryy=db_query($sqll);

while($datas = mysqli_fetch_object($queryy)){

//$id = $datas->PBI_ID;
//$name = $datas->PBI_NAME;
//$emp_id_no = $datas->PBI_CODE;
//$emp_password = md5($emp_id_no);

$customer_name = $datas->lead_name;
$address = $datas->address;
$phone_no = $datas->contact_number;
$email = $datas->contact_email;
$crm_proj_lead_id = $datas->id;




$proj_id=$_SESSION['proj_id'];
$_POST['entry_at']=date('Y-m-d H:i:s');

$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['ledger_name'] =  $customer_name; //$_POST['customer_name'];

$_POST['ledger_group_id']= 122001; //$_POST['ledger_group'];

$gl_group = find_all_field('ledger_group','','group_id='.$_POST['ledger_group_id']); 

$cy_id  = find_a_field('accounts_ledger','max(ledger_sl*1)','ledger_group_id='.$_POST['ledger_group_id'])+1;

$_POST['ledger_sl'] = sprintf("%05d", $cy_id);

$_POST['ledger_id'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];


//$customer = find_a_field('crm_service_customer','customer_id','crm_proj_lead_id='.$crm_proj_lead_id);
if ($customer==0) {


$sql="INSERT INTO crm_service_customer (customer_name, address, phone_no,email,ledger_id,crm_proj_lead_id,entry_by,entry_at)
VALUES ('".$customer_name."', '".$address."', '".$phone_no."', '".$email."', '".$_POST['ledger_id']."', '".$crm_proj_lead_id."',
 '".$_POST['entry_by']."' ,'".$_POST['entry_at']."')";
$query=db_query($sql);

}


$ledger_gl_found = find_a_field('accounts_ledger','ledger_id','ledger_name='.$_POST['ledger_name']);

if ($ledger_gl_found==0) {

   $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id, acc_class, acc_sub_class, opening_balance, balance_type, depreciation_rate, credit_limit, proj_id, budget_enable, group_for, parent, cost_center, entry_by, entry_at)

  

  VALUES("'.$_POST['ledger_id'].'", "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$_POST['ledger_group_id'].'", "'.$gl_group->acc_class.'", "'.$gl_group->acc_sub_class.'", "0", "Both", "0", "0", "'.$proj_id.'", "YES", "'.$_SESSION['user']['group'].'", "0", "0", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';



db_query($acc_ins_led);

}


}

//__________USER CREATE ____________



/*
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

}else{*/

//User Id Create
/*$sql="INSERT INTO user_activity_management (username, password, level,fname,status,group_for,PBI_ID,user_type,entry_date,expire_date,warehouse_id,default_checker,master_user)
VALUES ('".$emp_id_no."', '".$emp_password."', '5', '".$name."', 'Active', '1', '".$id."','User','".date("Y-m-d")."','2030-12-31','1','1','1')";
$query=db_query($sql);*/

//User Module Define 

/*$user_id =find_a_field('user_activity_management','user_id','PBI_ID="'.$id.'"');

echo $sql_m="INSERT INTO user_module_define (user_id,module_id,status)

VALUES ('".$user_id."', '17','enable')";

$queryy=db_query($sql_m);*/



//User Page Define 
/*
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

$queryy=db_query($sql_5);*/










header('location:auto_customer_create.php');



//}





}; ?>
<div class="container-fluid pt-5 p-0 ">
  <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">
    <thead class="thead1">
      <tr class="bgc-info">
        <th>SL</th>
        <th>Customer Name</th>
		<th>Assign Person</th>
        <th>Organization</th>
        <th>Status</th>
     
        <th>Actions</th>
      
      </tr>
    </thead>
    <tbody class="tbody1">
      <?



//and a.entry_by='.$_SESSION['employee_selected'].'

					$s=1;

					  

					$sql = 'select p.id,p.lead_name,p.assign_person,p.status,p.organization

					

					from crm_project_lead p

					

					where  1 order by p.id desc';

					

					$query=db_query($sql);

					while($data = mysqli_fetch_object($query)){

					

					

					

					?>
      <tr>
        <td><?=$s++;?></td>
        <td><?=$data->lead_name;?></td>
		<td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$data->assign_person); ?></td>
		<td><?=find_a_field('crm_project_org','name','id='.$data->organization);?></td>
        <td><?=find_a_field('crm_lead_status','status','id='.$data->status);?></td>  
        
        <td><? $check_id =find_a_field('crm_service_customer','customer_id','crm_proj_lead_id="'.$data->id.'"');

		if($check_id>0){  ?>
          <button class="btn1 btn1-bg-submit">Done</button>
		  
		  
          <? }else{ ?>
          <a href="auto_customer_create.php?asign_id=<?=$data->id;?>" class="btn1 btn1-bg-update">Activate</a>
          <? } ?>
          <a href="auto_user_create.php?cancel_id=<?=$data->id;?>" class="btn1 btn1-bg-cancel">Deactivate</a> 
		  
		  <a href="auto_user_create.php?reset_id=<?=$data->id;?>" class="btn1 btn1-bg-hrm">Reset</a> </td>
		  
   
      </tr>
      <? } ?>
    </tbody>
  </table>
</div>
<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>
