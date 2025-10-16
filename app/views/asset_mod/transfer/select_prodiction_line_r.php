<?php
require_once "../../../assets/template/layout.top.php";
$title='Pending Transfer Receive List';

$table_master='production_receive_master';
$unique_master='pr_no';

$table_detail='production_receive_detail';
$unique_detail='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='RECEIVED';
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		unset($$unique_master);
		unset($_POST[$unique_master]);
		$type=1;
		$msg='Successfully Send.';
}

if(isset($_POST['submitit'])){
 //header('location:production_receive.php?issue_no="'.$_POST['issue_no'].'"');
 echo '<script>location.href="production_receive.php?issue_no='.$_POST['issue_no'].'"</script>';
 echo 'bimol';
}

?>
<script language="javascript">
window.onload = function() {document.getElementById("dealer").focus();}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
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
    <td align="right" bgcolor="#FF9966"><strong>Pending Transfer List: </strong></td>
    <td bgcolor="#FF9966"><strong>
      	  <select name="issue_no" id="issue_no" style="width:200px;">
	  <? foreign_relation('warehouse w,production_issue_master p','p.pi_no','concat("Issue No:",p.pi_no,"## Send From - ",w.warehouse_name)',$line_id,'p.warehouse_from=w.warehouse_id and warehouse_to="'.$_SESSION['user']['depot'].'" and status="SEND"');?>
	  </select>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Receive" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

<?
require_once "../../../assets/template/layout.bottom.php";
?>