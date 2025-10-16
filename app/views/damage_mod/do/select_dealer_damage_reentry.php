<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Dealer Return Order';

$page_for = 'Return';
do_calander('#or_date');
do_calander('#quotation_date');

//$sql = 'select or_no from warehouse_damage_receive where or_no=3768';
//$query = db_query($sql);
//while($data=mysqli_fetch_object($query))
//{
//	reinsert_damage_return_secoundary($data->or_no);
//}

$table_master='warehouse_damage_receive';
$table_details='warehouse_damage_receive_detail';
$unique='or_no';
$$unique = $_POST[$unique];

if(isset($_POST['confirmm']))
{
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='PROBLEMUNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		reinsert_damage_return_secoundary($$unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded.';
		
}

if(isset($_POST['delete']))
{
		
		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Deleted.';
}
?>
<script language="javascript">
window.onload = function() {document.getElementById("do").focus();}
</script>
<div class="form-container_large">
<form action="item_damage_reentry_problem.php" method="post" name="codz" id="codz">
<table width="70%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Damage NO : </strong></td>
    <td bgcolor="#FF9966"><strong>


<input name="or_no" type="text" id="or_no" required />
    </strong></td>
<td bgcolor="#FF9966">
<strong>
<input type="submit" name="submitit" id="submitit" value="Damage Re-Entry" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
</strong>
</td>
</tr>
</table>

</form>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>