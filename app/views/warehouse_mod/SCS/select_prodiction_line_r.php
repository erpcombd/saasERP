<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Production Line for Receive';

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
		$_POST['entry_at']=date('Y-m-d H:i:s');
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

?>
<script language="javascript">
window.onload = function() {document.getElementById("dealer").focus();}
</script>
<div class="form-container_large">
<form action="production_receive.php" method="post" name="codz" id="codz">
<table  style="width:100%; margin:0 auto; border:0; text-align:center;">
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
  <!-- Label Cell -->
  <td style="text-align:right; background-color:#ff9966; padding:8px; font-weight:bold; white-space:nowrap;">
    Select Depot:
  </td>

  <!-- Select Field Cell -->
  <td style="background-color:#ff9966; padding:8px;">
    <select name="line_id" id="line_id" style="width:100%; padding:6px; font-size:14px; border:1px solid #ccc; border-radius:4px;">
      <?php foreign_relation('warehouse','warehouse_id','warehouse_name',$line_id,'use_type="SD"'); ?>
    </select>
  </td>

  <!-- Submit Button Cell -->
  <td style="background-color:#ff9966; padding:8px; text-align:center;">
    <input 
      type="submit" 
      name="submitit" 
      id="submitit" 
      value="Create PR" 
      style="width:100%; max-width:170px; height:36px; font-weight:bold; font-size:14px; color:#090; background:#fff; border:1px solid #090; border-radius:4px; cursor:pointer;"
    />
  </td>
</tr>

</table>

</form>
</div>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>