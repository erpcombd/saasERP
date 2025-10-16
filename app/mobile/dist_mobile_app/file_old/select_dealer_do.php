<?php
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';
//var_dump($_SESSION);

$title='Select Dealer for Demand Order';


$table_master='sale_do_master';

$unique_master='do_no';

$tr_type="Show";

$table_detail='sale_do_details';

$unique_detail='id';

if($_GET['mhafuz']){
unset($_SESSION['do_no']);
}

$table_chalan='sale_do_chalan';

$unique_chalan='id';



$$unique_master=$_POST[$unique_master];



if(isset($_POST['delete']))

{
		$crud   = new crud($table_master);

		$condition=$unique_master."=".$$unique_master;		

		$crud->delete($condition);

		$crud   = new crud($table_detail);

		$crud->delete_all($condition);

		$crud   = new crud($table_chalan);

		$crud->delete_all($condition);

		unset($$unique_master);

		unset($_POST[$unique_master]);
		
		$tr_type="Delete";
		$tr_from="Sales";

		$type=1;

		$msg='Successfully Deleted.';
?>
<script language="javascript">
window.location.href = "so.php";
</script>
<?
}

if(isset($_POST['confirm']))

{

$tr_type="Completed";
 $or_no = $_REQUEST['do_no2'];

$_POST['entry_by']=$_SESSION['user']['username'];

$_POST['entry_at']=date('Y-m-d h:i:s');

$do_master = find_all_field('sale_do_master','do_no','do_no='.$or_no);
$dealer = find_all_field('dealer_info','','dealer_code='.$do_master->dealer_code);

if($_POST['category_discount']){
    $mrp_amount = $_POST['mrp_amt'];
    $inv_amount = $_POST['inv_amt'];
    $discount_per = $_POST['discount_per'];
    $discount_amt = $_POST['category_discount'];
    $discount_id = $_POST['discount_id'];
  $insQ = "INSERT INTO `sale_do_discount`( `do_no`, `sub_group_id`, `mrp_value`, `inv_value`,
   `discount_per`, `discount_amt`, `discount_id`, tr_type, `entry_at`, `entry_by`, dealer_code) 
		VALUES ( '".$or_no."', '".$sub_group_id."', '".$mrp_amount."', '".$inv_amount."',
     '".$discount_per."', '".$discount_amt."', '".$discount_id."', 'slab', '".$now."', '".$_SESSION['user']['username']."', ".$do_master->dealer_code.")"; 
		mysqli_query($conn,$insQ);	

		$upql = mysqli_query("update sale_do_master set discount = '".$discount_per."' where do_no = '".$or_no."' ");	
}


//$chalan_no = date('ym').sprintf('%06d', $or_no);



//$prevent_multi=find_a_field('sale_do_chalan','chalan_no','do_no='.$or_no);

//if ($prevent_multi<1) {

//Company Transport

if($dealer->bank_reconsila=="YES"){
		$sql2 = 'update sale_do_details set status="UNCHECKED" where do_no = '.$or_no;
		mysqli_query($conn,$sql2);
		
		  $sql3 = 'update sale_do_master set status="UNCHECKED" where do_no = '.$or_no;
		mysqli_query($conn,$sql3);
}
else{
	$sql2 = 'update sale_do_details set status="PROCESSING" where do_no = '.$or_no;
		mysqli_query($conn,$sql2);
		
		  $sql3 = 'update sale_do_master set status="PROCESSING" where do_no = '.$or_no;
		mysqli_query($conn,$sql3);
}
	//auto_insert_sales_chalan_secoundary($chalan_no)
//for user_action_log
?>

<?
	//}	
?>
<script language="javascript">
window.location.href = "so.php";
</script>
<?



}


auto_complete_from_db('dealer_info','concat(dealer_name_e)','dealer_code','depot="'.$_SESSION['user']['warehouse_id'].'"','dealer');
$tr_from="Sales";
?>

<script language="javascript">

window.onload = function() {document.getElementById("dealer").focus();}

</script>

<div class="form-container_large">

<form action="do.php" method="post" name="codz" id="codz">

<table width="70%" border="0" align="center">

  <tr>

    <td></td>

    <td>&nbsp;</td>

    <td></td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Active Dealer List: </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input name="dealer" type="text" id="dealer" style="background-color:white;" class="form-control"/>

    </strong></td>

    <td bgcolor="#FF9966" style="text-align:center"><strong>

      <input type="submit" name="submitit" id="submitit" value="Create DO" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:DodgerBlue"/>

    </strong></td>

  </tr>

</table>



</form>

</div>



<?php 
 require_once '../assets/template/inc.footer.php';
 
 selected_two("#dealer_code");
 selected_two("#category_id");
 selected_two("#subcategory_id");
 selected_two("#item_id");
 ?>