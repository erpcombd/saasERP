<?php
session_start();
ob_start();
require "../../support/inc.all.php";

$title='New Purchase Entry';

do_calander('#po_date');
do_calander('#quotation_date');

$table_master='purchase_master';
$table_details='purchase_invoice';
$unique='po_no';


if(isset($_POST['new']))
{
		$crud   = new crud($table_master);

		if(!isset($_SESSION[$unique])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Purchase Order No Created. (PO No :-'.$_SESSION[$unique].')';
		}
		else {
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}
}

$$unique=$_SESSION[$unique];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;		
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Deleted.';
}

if($_GET['del']>0)
{
		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirmm']))
{
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='UNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded for Approval.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[1];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$crud->insert();
}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update PO Information'; else $btn_name='Initiate PO Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_start_from_db

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
auto_complete_from_db('item_info','item_name','concat(finish_goods_code,"-",item_name,"#>",item_id)','1 and sub_group_id in (1700010000,1700020000,1700030000)','item_id');

?>
<script language="javascript">
function count()
{
var rate=(document.getElementById('rate').value)*1;
var pkt_size=(document.getElementById('pkt_size').value)*1;
var pkt_unit=(document.getElementById('pkt_unit').value)*1;
var qty=(document.getElementById('qty').value)=(pkt_size*pkt_unit);

document.getElementById('amount').value=(rate*qty);

//var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);
//document.getElementById('amount').value = num.toFixed(2);	
}
</script>

<style type="text/css">
<!--

.onhover:focus{
background-color:#66CBEA;

}



.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top"><fieldset>
    <? $field='po_no';?>
      <div>
        <label for="<?=$field?>">Purchase  No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
		<input  name="po_type" type="hidden" id="po_type" value="FG" required/>
      </div>
    <? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?>
      <div>
        <label for="<?=$field?>">Purchase Date:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
    
	  
	<?php /*?>
<? $field='transport_bill';?>
<div>
<label for="<?=$field?>">Transport Bill:</label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
</div><?php */?>

<? $field='tax';?>
<div>
<label for="<?=$field?>">VAT (%):</label>

<? if($tax<1) { ?>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field('vat_setup','vat_percent',"id=2");?>" required/>
<? }?>

<? if($tax>0) { ?>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field;?>" required readonly=""/>
<? }?>
</div>
    </fieldset></td>
    <td>
			<fieldset>
			
			<div>
			
			<div>
        <label for="<?=$group_for?>">Company:</label>
		<select  name="group_for" id="group_for">
		
      <? foreign_relation('user_group','id','group_name',$group_for,' id="'.$_SESSION['user']['group'].'" ');?>
		 </select>
      </div>
	  
	  
	    
    <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
      <div>
        <label for="<?=$field?>">Warehouse:</label>
		
		<? if($warehouse_id<1) { ?>
		
        <select id="<?=$field?>" name="<?=$field?>" required   onchange="getData2('ajax_vendor.php', 'vendor_space', this.value,  this.value)">
        <option></option>
        <? foreign_relation($table,$get_field,$show_field,$$field,'use_type="WH"');?>
        </select>
		
		<? }?>
		
		<? if($warehouse_id>0) { ?>
			<input  name="warehouse_to2" type="text" id="warehouse_to2"  readonly=""
			value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id)?>" required/>
			
			<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" required/>
		
		<? }?>
		
      </div>
			

	     
      <? $field='vendor_id'; $table='vendor'; $get_field='vendor_id'; $show_field='vendor_name'; ?>
	  
      <div>
        <label for="<?=$field?>">Supplier:</label>
		
		<? if($vendor_id<1) { ?>
		
		  <span id="vendor_space"> 

<select  name="vendor_id" id="vendor_id">
		
      <? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id,'group_for="'.$group_for.'" order by vendor_name');?>
		 </select>


		 </span>
		
		<? }?>
		
		
		<? if($vendor_id>0) { ?>
			<input  name="vendor_id2" type="text" id="vendor_id2"  readonly=""
			value="<?=find_a_field('vendor','vendor_name','vendor_id='.$vendor_id)?>" required/>
			
			<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>" required/>
		
		<? }?>
		
		<? if($vendor_id>0){ 
$vendor = find_all_field('vendor','','vendor_id='.$vendor_id);
 } ?>
		
		
      </div>
	  
	  
      <!--<div>
        <? $field='quotation_no';?>
        <div>
          <label for="<?=$field?>">Quotation No:</label>
          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
        </div>
		</div>
        <? $field='quotation_date';?>
        <div>
          <label for="<?=$field?>">Quotation Date:</label>
          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
        </div>-->
       
		       
			 <?php /*?>  <? $field='po_details';?>
      <div>
        <label for="<?=$field?>">Note:</label>
        <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
      </div><?php */?>
      <div></div>
      </div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2" ><div class="buttonrow" style="margin-left:300px;">
      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div></td>
    </tr>
</table>
</form>
<? if($_SESSION[$unique]>0){?>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

<? 
$group_for = find_a_field('warehouse','group_for','warehouse_id='.$warehouse_id.' ');
if(($vendor->ledger_id==0)&&($group_for==2||$group_for==3)){ ?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
<tr><td bgcolor="#FF3333"><div align="center" class="style1">VERDOR IS BLOCKED. NO ACCOUNT CODE FOUND</div></td></tr>
</table>

<? }else{?>
			<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td width="31%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                        <td width="13%" align="center" bgcolor="#0099FF"><strong>Warehouse</strong></td>
                        <td width="8%" align="center" bgcolor="#0099FF"><strong>Stock</strong></td>
                        <td width="8%" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                        <td width="8%" align="center" bgcolor="#0099FF"><strong>Price</strong></td>
                        <td width="10%" align="center" bgcolor="#0099FF"><strong>Pack Unit </strong></td>
                        <td width="10%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                          <td width="10%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
					    </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>
<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:280px; height:20px;" required onblur="getData2('po_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>
<td align="center" bgcolor="#CCCCCC">
<select name="warehouse_id" id="warehouse_id" required style="width:150px; height:25px;" class="onhover" tabindex="0">
               	    <option></option>
               	    <? foreign_relation('warehouse', 'warehouse_id', 'warehouse_name',$_POST['depot_id'],' 1 and use_type = "WH" ');?>
           	      </select>
</td>
<td colspan="3" align="center" bgcolor="#CCCCCC">
<span id="po">
<table>
<tr>
<td>
<input name="stk" type="text" class="input3" id="stk" style="width:80px;float:left; height:20px;" readonly="readonly"/></td>
<td>
<input name="unit" type="text" class="input3" id="unit" style="width:80px;float:left; height:20px;" readonly="readonly"/></td>
<td>
<input name="price" type="text" class="input3" id="price" style="width:80px;float:left; height:20px;"  readonly="readonly"/></td>
</tr>
</table>
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="pkt_unit" type="text" class="input3" id="pkt_unit"  maxlength="100" style="width:90px; height:20px;" onchange="count()" required/>
									<input name="qty" type="hidden" class="input3" id="qty"  maxlength="100" style="width:90px; height:20px;" onchange="count()" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:100px; height:20px;" readonly="readonly" required/></td>
      </tr>
    </table>
<? }?>				  
<br /><br /><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td>
<div class="tabledesign2">
<? 
$res='select a.id, concat(b.item_name) as item_name, w.warehouse_name, a.unit_name as unit, a.pkt_unit,a.qty as total_unit,  a.rate as unit_price,a.amount,"x" from purchase_invoice a, item_info b,
warehouse w where b.item_id=a.item_id and a.warehouse_id=w.warehouse_id and a.po_no='.$po_no;


echo link_report_add_del_auto($res,'',5,8);
?>
</div>
</td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
</form>

<br />


<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center">

      <input name="delete"  type="submit" class="btn1" value="DELETE PURCHASE" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM PURCHASE" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:#090" />
</tr>
  </table>
</form>
<? }?>
</div>
<script>$("#codz").validate();$("#cloud").validate();</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>