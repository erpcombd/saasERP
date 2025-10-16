<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Asset Schedule Report';


$title='Select Branch For Transfer';

$table_master='asset_transfer_master';

$unique_master='pi_no';

$table_detail='asset_transfer_details';

$unique_detail='id';

unset($_SESSION[$unique_master]);
unset($_SESSION['line_id']);

$$unique_master=$_POST[$unique_master];


if(isset($_POST['confirm']))
{
		unset($_POST);
		$_POST[$unique_master]=$$unique_master;
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='SEND';
		$pi = find_all_field('asset_transfer_master','pi_no','pi_no='.$$unique_master);

		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		
		$sql = 'select p.*,i.item_type from asset_transfer_details p,item_info i where i.item_id=p.item_id and pi_no="'.$$unique_master.'"';
		$qry = db_query($sql);
		while($data=mysqli_fetch_object($qry)){
		
	   $journal_item_sql = 'insert into journal_asset_item (`ji_date`,`item_id`,`warehouse_id`,`serial_no`,`item_ex`,`item_price`,`final_price`,`tr_from`,`tr_no`,`sr_no`,`entry_by`,`entry_at`,`primary_id`,`group_for`) value("'.$data->pi_date.'","'.$data->item_id.'","'.$_SESSION['user']['depot'].'","'.$data->serial_no.'","'.$data->total_unit.'","'.$data->unit_price.'","'.$data->unit_price.'","Transit","'.$data->id.'","'.$data->pi_no.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d h:i:s').'","'.$data->id.'","'.$_SESSION['user']['group'].'")';
db_query($journal_item_sql);
}
        unset($$unique_master);
		unset($_POST[$unique_master]);
		
		$type=1;
		$msg='Successfully Send.';
}


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





?>

<script language="javascript">

window.onload = function() {document.getElementById("dealer").focus();}

</script>

<div class="form-container_large">

<form action="depot_transfer_entry.php" method="post" name="codz" id="codz">

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

    <td align="right" bgcolor="#FF9966"><strong>Select Branch: </strong></td>

    <td bgcolor="#FF9966"><strong>
<?php 
unset($_SESSION['pi_no']);
?>
      	  <select name="line_id" id="line_id" class="form-control" style="background:aliceblue;" required>

		  <option></option>

	  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','1 order by warehouse_name');?>



	  </select>

    </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Stock Transfer" style="width:180px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

</table>

</form>

</div>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
