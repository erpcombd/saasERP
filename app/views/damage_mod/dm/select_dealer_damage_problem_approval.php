<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Problem Damage View';

do_calander('#fdate');
do_calander('#tdate');

$table_master = 'warehouse_damage_receive';
$unique = 'or_no';
$status = 'UNCHECKED';

$target_url = '../dm/item_damage_problem_approval.php';

if(isset($_POST['confirmm']))
{

		$$unique=$_POST[$unique];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		reinsert_damage_return_secoundary($$unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded.';
		
}
?>
<script language="javascript">
function custom(theUrl)
{
		location.href='<?=$target_url?>?or_no='+theUrl;
}
</script>
<div class="form-container_large">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 

$res='select  	a.or_no,a.or_no as id,a.or_date as issue_date, a.manual_or_no as serial_no, concat(d.dealer_name_e,"(",d.dealer_code,")","(",d.product_group,")") as dealer, b.warehouse_name as Depot from dealer_info d, warehouse_damage_receive a,warehouse b where a.vendor_id=d.dealer_code and d.depot=b.warehouse_id  and b.use_type!="PL" and  a.status="PROBLEMUNCHECKED"  order by a.or_no desc';

echo link_report($res,'print_view.php');
?>
</div></td>
</tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>