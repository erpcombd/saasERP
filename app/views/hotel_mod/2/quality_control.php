<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Product Quality Control';
do_calander('#qc_date');
$table='proc_production_qc';
$unique='id';


if(isset($_POST['new']))
$p_id=$$unique = $_POST['p_id'];
elseif($_GET['p_id']>0)
$p_id=$$unique = $_GET['p_id'];

if($p_id>0)
{		$condition="id=".$p_id;
		$data=db_fetch_object('proc_production',$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
		$production_id=$id;
		$total_qty_for_qc=$qty;
}


if(isset($_POST['add']))
{		$table		='proc_production_qc';
		$crud      	=new crud($table);
		$sql="update proc_product_info set qop=qop-".($_POST['total_qty_for_qc']).",qoh=qoh+".($_POST['qty_approved'])." where id=".$_POST['product_id']." limit 1";
		mysql_query($sql);
		$_POST['qty_rejected']=$_POST['total_qty_for_qc']-$_POST['qty_approved'];
		$crud->insert();
}


?>
<script language="javascript">
function count()
{
document.getElementById('material_remening_qty').value=((document.getElementById('purchase_invoice_qty').value)*1)-((document.getElementById('material_receive_qty').value)*1);
}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
			<fieldset>
			
			<div>
			<label>Production  ID: </label>
			<select name="p_id" id="p_id">
<? foreign_relation('proc_production','id','id',$p_id);?>
			  </select>
			</div>
			
			<div class="buttonrow" style="margin-left:154px;"><input name="new" type="submit" class="btn1" value="Search" />
			
			</div>
			</fieldset>
			<br />
			<fieldset>
			

			<div>
			<label>QC Date: </label> 
			<input  name="qc_date" type="text" id="qc_date" value="<?=$qc_date?>"/>
			</div>
			<div>
			<label>Product ID: </label>
			<select name="product_id" id="product_id">
              <? foreign_relation('proc_product_info','id','product_name',$product_id);?>
            </select>
			</div>
			</fieldset>
			</td>
			
    		<td>
			<fieldset>
			<div>
			<label>Production ID : </label> 
			<input  name="production_id" type="text" id="production_id" value="<?=$production_id?>"/>
			</div>
			<div>
			<label>Qty for QC : </label> 
			<input  name="total_qty_for_qc" type="text" id="total_qty_for_qc" value="<?=$total_qty_for_qc?>"/>
			</div>
			<div>
			<label>Qty Approved: </label> 
			<input  name="qty_approved" type="text" id="qty_approved" value="<?=$qty_approved?>"/>
			</div>
			<div>
			<label>Description: </label> 
			<input  name="description" type="text" id="description" value="<?=$description?>"/>
			</div>
			<div>
			<label>Managed By: </label> 
			<input  name="po_by" type="text" id="po_by" value="<?=$po_by?>"/>
			</div>
			</fieldset>	
			</td>
  </tr>
  <tr>
    <td><label></label></td>
    <td>&nbsp;</td>
  </tr>
</table>
<div class="buttonrow" style="margin-left:304px;margin-right:304px;">
  <input name="add" type="submit" class="btn1" value="Submit" width="200px" />
</div>
</form>

<? 
$res='select a.qc_date,a.production_id,b.product_name,a.total_qty_for_qc as total_qty,a.qty_approved,a.qty_rejected,a.description from proc_production_qc a,proc_product_info b where b.id=a.product_id ';
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
echo link_report($res);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>