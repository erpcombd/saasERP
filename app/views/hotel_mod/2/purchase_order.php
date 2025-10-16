<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Purchase Order';
do_calander('#ship_on');
$table='proc_raw_material_po';
$unique='id';




if(isset($_POST['accept']))
{
$crud      =new crud('proc_raw_material_po');
$req_id=$$unique = $_POST['id'];
$_POST['req_id']=$req_id;
$_POST['po_date']=date('Y-m-d');
$_POST['status']=1;
$crud->insert();
}

if(isset($_POST['new']))
$req_id=$$unique = $_POST['id'];
elseif($_GET['req_id']>0)
$req_id=$$unique = $_GET['req_id'];

if($req_id>0)
{
		$condition="id=".$req_id;
		$data=db_fetch_object('proc_raw_material_requisition',$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
}



if(isset($_POST['add']))
{
		$table		='proc_raw_material_po_details';
		$crud      	=new crud($table);
		$sql="update proc_raw_material set qot=qot+".$_POST['material_qty']." where id=".$_POST['material_id']." limit 1";
		mysql_query($sql);
		$crud->insert();
		
}


?>
<script language="javascript">
function total_price_count()
{
document.getElementById('total_price').value=((document.getElementById('material_unit_price').value)*1)*((document.getElementById('material_qty').value)*1);
}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
			<fieldset>
			
			<div>
			<label>Requization ID: </label>
			<select name="id" id="id">
<? 
foreign_relation('proc_raw_material_requisition','id','id',$id,'status=1');?>
			  </select>
			</div>
			
			<div class="buttonrow" style="margin-left:154px;"><input name="new" type="submit" class="btn1" value="Submit" />
			<? if($req_id>0)
			{$po_id=find_a_field('proc_raw_material_po','id','req_id='.$req_id);
			if($po_id<1){
			?>
			<input name="accept" type="submit" class="btn1" value="Accept" />
			<? }}?>
			</div>
			</fieldset>	</td>
    <td>
			<fieldset>
			
			<div>
			<label>Request By: </label> 
			<input  name="requisition_by" type="text" id="requisition_by" value="<?=$requisition_by?>"/>
			</div>
			<div>
			<label for="email">Date of Requization: </label>
			<input  name="req_date" type="text" id="req_date" value="<?=$req_date?>"/>
			</div>
			<div>
			<label>Estimated Date : </label> 
			<input  name="need_by_date" type="text" id="need_by_date" value="<?=$need_by_date?>"/>
			</div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<? if($req_id>0){
$res='select a.req_id,a.req_id,b.material_name,a.qty,a.description from proc_raw_material_requisition_details a,proc_raw_material b where b.id=a.material_id and a.req_id='.$req_id;
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
<? if($po_id>0){?>
<form action="?req_id=<?=$req_id?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>PO ID </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Material</strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Supplier</strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Unit <br>Price </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Total</strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Receive <br>Date </strong></td>
                          <td align="center" bgcolor="#0099FF"><strong>Note</strong></td>
                          <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>				        </td>
      </tr>
                      <tr>
                        <td align="center" bgcolor="#CCCCCC"><input name="po_id" type="text" id="po_id" style="width:50px;"  tabindex="9" class="input3" value="<?=$po_id?>"/>										    </td>
                          <td align="center" bgcolor="#CCCCCC"><span id="inst_no">
                            <select name="material_id" id="material_id">
                              <? 
foreign_relation('proc_raw_material','id','material_name',$material_id);?>
                            </select>
                          </span> </td>
                          <td align="center" bgcolor="#CCCCCC"><select name="vendor_id" id="vendor_id">
                            <? 
foreign_relation('vendor','vendor_id','vendor_name',$vendor_id);?>
                                                    </select></td>
                          <td align="center" bgcolor="#CCCCCC"><input name="material_qty" type="text" id="material_qty" style="width:50px;"  tabindex="9" class="input3" value="" onchange="total_price_count()"/></td>
                          <td align="center" bgcolor="#CCCCCC"><input name="material_unit_price" type="text" id="material_unit_price" style="width:50px;"  tabindex="9" class="input3" value=""  onchange="total_price_count()"/></td>
                          <td align="center" bgcolor="#CCCCCC"><input  name="total_price" type="text" id="total_price" style="width:50px;"  onchange="total_price()"/></td>
                          <td align="center" bgcolor="#CCCCCC"><input  name="ship_on" type="text" id="ship_on" style="width:50px;"/></td>
                          <td align="center" bgcolor="#CCCCCC"><input  name="note" type="text" id="note" style="width:50px;"/></td>
      </tr>
    </table>
					  <br /><br /><br /><br />
</form>
<? }?>
<? if($po_id>0){
$res='select a.po_id,a.po_id,b.material_name,a.ship_on as receive_date,a.material_qty,a.material_unit_price,a.total_price from proc_raw_material_po_details a,proc_raw_material b where b.id=a.material_id and a.po_id='.$po_id;
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
<? }?>
</div>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>