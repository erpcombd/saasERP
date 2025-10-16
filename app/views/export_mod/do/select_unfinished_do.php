<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Unfinished Sales Requisition';



$table_master='sale_requisition_master';

$unique_master='do_no';



$table_detail='sale_requisition_details';

$unique_detail='id';



$table_chalan='sale_do_chalan';

$unique_chalan='id';



$$unique_master=$_SESSION[$unique_master];



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

		unset($_SESSION[$unique_master]);

		$type=1;

		$msg='Successfully Deleted.';

}

if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['status']='PROCESSING';

		$crud   = new crud($table_master);

		$crud->update($unique_master);

		$crud   = new crud($table_detail);

		$crud->update($unique_master);

		$crud   = new crud($table_chalan);

		$crud->update($unique_master);

		unset($$unique_master);

		unset($_SESSION[$unique_master]);

		$type=1;

		$msg='Successfully Instructed to Depot.';

}





$table='sale_requisition_master';

$show='dealer_code';

$id='do_no';

$con='status="MANUAL"';



?>

<script language="javascript">

window.onload = function() {

  document.getElementById("dealer").focus();

}

</script>

<div class="form-container_large">

<form action="do.php" method="post" name="codz" id="codz">

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

    <td align="right" bgcolor="#FF9966"><strong>Unfinished SO  List: </strong></td>

    <td bgcolor="#FF9966"><strong>

	<?

	 $query ="select a.do_no,a.dealer_code,d.team_name,d.dealer_name_e from sale_requisition_master a,dealer_info d where d.dealer_code=a.dealer_code  and a.status='MANUAL'";
//and do_date='".date('Y-m-d')."'
	?>

     <select name="old_do_no" id="old_do_no" required>

	 <option></option>

	  <?



	  $sql = db_query($query);

	  while($data=mysqli_fetch_object($sql))

	  {

	  ?>

	   <option value="<?=$data->do_no?>"><?=$data->do_no.'-'.$data->dealer_name_e.'('.$data->dealer_code.')';?></option>

	  <?

	  }

	  ?></select>

    </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Complete Entry" style="width:180px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

</table>



</form>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>