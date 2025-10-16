<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Production Line for Receive';

if($_POST['line_id']>0) 
$line_id = $_SESSION['line_id']=$_POST['line_id'];
elseif($_SESSION['line_id']>0) 
$line_id = $_POST['line_id']=$_SESSION['line_id'];


$table_master='production_floor_receive_master';
$unique_master='pr_no';

$table_detail='production_floor_receive_detail';
$unique_detail='id';

if($_REQUEST['old_pr_no']>0)
$$unique_master=$_REQUEST['old_pr_no'];
else
$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){
if(isset($_POST['new']))
{
		$crud   = new crud($table_master);
		$$unique_master=$_POST[$unique_master];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['warehouse_to']=$line_id;
		if($_POST['flag']<1){
		$crud->insert();
		
		$type=1;
		$msg='Product Issued. (PI No-'.$$unique_master.')';
		}
		else {
		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';
		}
}

if(isset($_POST['confirm'])&&($_POST[$unique_master]>0))
{
		$sql = 'select * from item_info where item_id in (select fg_item_id from production_line_fg where line_id="'.$line_id.'")';
		$query = db_query($sql);
		while($data = mysqli_fetch_object($query)){
		if($_POST['total_unit_'.$data->item_id]>0){	
		$total_amt = $_POST['total_unit_'.$data->item_id]*$data->cost_price;
		
		$do = "INSERT INTO production_floor_receive_detail 
		(pr_no, pr_date, item_id, warehouse_from, warehouse_to, total_unit, unit_price, total_amt) VALUES 
('".$_POST['pr_no']."', '".$_POST['pr_date']."', '".$data->item_id."', '0', '".$line_id."', '".$_POST['total_unit_'.$data->item_id]."', '".$data->cost_price."', '".$total_amt."')";
		db_query($do);

$xid = db_insert_id();
journal_item_control($data->item_id ,$line_id,$_POST['pr_date'],$_POST['total_unit_'.$data->item_id],'0','Production',$xid,'0','0',$_POST['pr_no']);

		}}


		
}

}
else
{
	$type=0;
	$msg='Data Re-Submit Error!';
}


?>
<script language="javascript">
window.onload = function() {document.getElementById("dealer").focus();}
</script>









	<div class="form-container_large">

		<form action="production_receive_fg.php" method="post" name="codz" id="codz">

			<div class="container-fluid bg-form-titel">
				<div class="row">

					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
						<div class="form-group row m-0">
							<label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Select Production Line:	</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

								<select name="line_id" id="line_id" >
									<? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="PL" order by warehouse_name');?>
								</select>

							</div>
						</div>
					</div>

					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
						<input type="submit" name="submitit" id="submitit" value="Create PR" class="btn1 btn1-submit-input"/>

					</div>

				</div>
			</div>


		</form>
	</div>







<?/*>
<br/>
<br/>
<br/>
<br/>
<div class="form-container_large">
<form action="production_receive_fg.php" method="post" name="codz" id="codz">
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
<input type="submit" name="submitit" id="submitit" value="Create PR" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>


<*/?>




<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>