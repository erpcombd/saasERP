<?php

session_start();

ob_start();

require_once "../../../assets/support/inc.all.php";

$title='Set Blend Sheet for FG Product';



$table_master='blend_sheet_master';

$unique_master='blend_id';



$table_detail='blend_sheet_details';

$unique_detail='id';




var_dump($_SESSION);

session_destroy($_SESSION['blend_id']);

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

		$type=1;

		$msg='Successfully Deleted.';

}

/*if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['status']='PROCESSING';

		

		

		$crud   = new crud($table_master);

		$crud->update($unique_master);

		$crud   = new crud($table_detail);

		$crud->update($unique_master);

		unset($$unique_master);

		unset($_POST[$unique_master]);

		$type=1;

		$msg='Successfully Instructed to Depot.';

}*/



auto_complete_start_from_db('warehouse','concat(warehouse_name,"-",use_type)','warehouse_id','use_type="PL"','line_id');

?>

<script language="javascript">

window.onload = function() {document.getElementById("project").focus();}

</script>

<div class="form-container_large">

<form action="set_blend_sheet.php" method="post" name="codz" id="codz">

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

    <td align="right" bgcolor="#FF9966"><strong>Blend Sheet List: </strong></td>

    <td bgcolor="#FF9966"><strong>

     <select name="line_id" id="line_id" style="width:200px;">
	  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="PL"  order by warehouse_name');?>
	  </select>

    </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Set Blend Sheet" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

</table>



</form>

</div>



<?

require_once "../../../assets/template/layout.bottom.php";

?>