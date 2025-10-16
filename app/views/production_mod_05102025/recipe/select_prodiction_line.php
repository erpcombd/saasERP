<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Production Line for Issue';

$table_master='production_issue_master';
$unique_master='pi_no';


$table_detail='production_issue_detail';
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
		$_POST['status']='SEND';
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
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

		<form  action="create_new_batch.php?sr=1" method="post" name="codz" id="codz">

			<div class="container-fluid bg-form-titel">
				<div class="row">

					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Select Production Line: </label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<select name="line_id" id="line_id" style="width:200px;">
									<? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="PL" order by warehouse_name');?>
								</select>
							</div>
						</div>
					</div>

					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
						<input type="submit" name="submitit" id="submitit" value="Create PI" class="btn1 btn1-submit-input" />
					</div>

				</div>
			</div>

		</form>
	</div>






<?/*>
<br>
<br>
<br>
<br>
<br>
<div class="form-container_large">
<form action="create_new_batch.php?sr=1" method="post" name="codz" id="codz">
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
    <td align="right" bgcolor="#FF9966"><strong>Select Production Line: </strong></td>
    <td bgcolor="#FF9966"><strong>
      	  <select name="line_id" id="line_id" style="width:200px;">
	  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="PL" order by warehouse_name');?>
	  </select>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Create PI" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

		</strong></td>
  </tr>
</table>

</form>
</div>
	<*/?>









<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>