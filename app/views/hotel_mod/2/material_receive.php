<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Material Receive';
do_calander('#date');
$table='proc_raw_material_receive';
$unique='id';




if(isset($_POST['accept']))
{
$crud      =new crud('proc_raw_material_receive');
$po_id=$$unique = $_POST['id'];
$_POST['po_id']=$po_id;
$_POST['date_received']=date('Y-m-d');
$_POST['status']=1;
$crud->insert();
}

if(isset($_POST['new']))
$po_id=$$unique = $_POST['id'];
elseif($_GET['po_id']>0)
$po_id=$$unique = $_GET['po_id'];

if($po_id>0)
{
		$condition="id=".$po_id;
		$data=db_fetch_object('proc_raw_material_po',$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
}



if(isset($_POST['add']))
{
		$table		='proc_raw_material_receive_details';
		$crud      	=new crud($table);
		$sql="update proc_raw_material set qot=qot-".$_POST['material_receive_qty'].", qoh=qoh+".$_POST['material_receive_qty']." where id=".$_POST['material_id']." limit 1";
		mysql_query($sql);
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
			<label>Purchase Order  ID: </label>
			<select name="id" id="id">
<? 
foreign_relation('proc_raw_material_po','id','id',$id,'status=1');?>
			  </select>
			</div>
			
			<div class="buttonrow" style="margin-left:154px;"><input name="new" type="submit" class="btn1" value="Submit" />
			<? if($req_id>0)
			{$mr_id=find_a_field('proc_raw_material_receive','id','po_id='.$po_id);
			if($mr_id<1){
			?>
			<input name="accept" type="submit" class="btn1" value="Receive" />
			<? }}?>
			</div>
			</fieldset>	</td>
    <td>
			<fieldset>
			
			<div>
			<label>Managed By: </label> 
			<input  name="po_by" type="text" id="po_by" value="<?=$po_by?>"/>
			</div>
			<div>
			<label>Purchase Order  Date : </label> 
			<input  name="po_date" type="text" id="po_date" value="<?=$po_date?>"/>
			</div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<? if($po_id>0){
$res='select a.po_id,a.po_id,c.vendor_name,b.material_name,a.ship_on as receive_date,a.material_qty,a.material_unit_price,a.total_price from proc_raw_material_po_details a,proc_raw_material b,vendor c where b.id=a.material_id and a.vendor_id=c.vendor_id and a.po_id='.$po_id;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';
echo link_report($res);
		?>

      </div></td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
<? }?><br />
<? if($mr_id>0){?>
<form action="?po_id=<?=$po_id?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>PO ID </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Material</strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>PO Qty</strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>MR Qty </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Remaining<br>Qty</strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Receive<br>Date</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCCCCC"><input name="mr_id" type="text" id="mr_id" style="width:50px;"  tabindex="9" class="input3" value="<?=$mr_id?>"/>										    </td>
                          <td align="center" bgcolor="#CCCCCC"><span id="inst_no">
                            <select name="material_id" id="material_id">
                              <? 
foreign_relation('proc_raw_material','id','material_name',$material_id);?>
                            </select>
                          </span> </td>
                          <td align="center" bgcolor="#CCCCCC"><input name="purchase_invoice_qty" type="text" id="purchase_invoice_qty" style="width:50px;"  tabindex="9" class="input3" value="" onchange="count()"/></td>
                          <td align="center" bgcolor="#CCCCCC"><input name="material_receive_qty" type="text" id="material_receive_qty" style="width:50px;"  tabindex="9" class="input3" value=""  onchange="count()"/></td>
                          <td align="center" bgcolor="#CCCCCC"><input  name="material_remening_qty" type="text" id="material_remening_qty" style="width:50px;" /></td>
                          <td align="center" bgcolor="#CCCCCC"><input  name="date" type="text" id="date" style="width:50px;"/></td>
      </tr>
    </table>
					  <br /><br /><br /><br />
</form>
<? }?>
<? if($mr_id>0){
$res='select a.mr_id,a.mr_id,b.material_name,a.date as receive_date,a.purchase_invoice_qty as po_qty,a.material_receive_qty as mr_qty,a.	material_remening_qty as remaining_qty from proc_raw_material_receive_details a,proc_raw_material b where b.id=a.material_id and a.mr_id='.$mr_id;
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
<? }?>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>