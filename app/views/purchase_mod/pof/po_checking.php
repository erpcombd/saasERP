<?php
session_start();
ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Approving Purchase Entry';

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
		$msg='Requisition No Created. (PO No :-'.$_SESSION[$unique].')';
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
		$_POST['checked_by']=$_SESSION['user']['id'];
		$_POST['checked_at']=date('Y-m-d H:i:s');
		$_POST['status']='CHECKED';
		$_POST['sales_order']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded to Relevant Department.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$crud   = new crud($table_details);
		$item = explode('#>',$_POST['item_id']);
		$item_id = $item[2];
		
		$_POST['item_id'] = $item_id;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$crud->insert();
		unset($item_id);
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


auto_complete_from_db('item_info','item_name','concat(finish_goods_code,"-",item_name,"#>",item_id)','1 and product_nature="Salable"','item_id');
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



function PIcalculation(id){
var pkt_size = document.getElementById('pkt_size#'+id).value*1;
var pkt_unit = document.getElementById('pkt_unit#'+id).value*1;
var wo_qty = document.getElementById('qty#'+id).value= (pkt_size*pkt_unit);
var wo_rate = document.getElementById('unit_price#'+id).value*1;
var amount = document.getElementById('amount#'+id).value= (wo_qty*wo_rate);
//var amount = document.getElementById('amount#'+id).value= (pi_qty*pi_rate);
}



function update_edit(id)

{
var pkt_size = (document.getElementById("pkt_size#"+id).value);
var pkt_unit = (document.getElementById("pkt_unit#"+id).value);
var qty = (document.getElementById("qty#"+id).value);
var unit_price  = (document.getElementById("unit_price#"+id).value);
var amount = (document.getElementById("amount#"+id).value)*1;
var info = pkt_size+"<@>"+pkt_unit+"<@>"+qty+"<@>"+unit_price+"<@>"+amount;
getData2('po_edit_ajax.php', 'ppp',id,info);
}




function submitButtonStyle(_this) {
  _this.style.backgroundColor = "red";
}


</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td valign="top"><fieldset>
    <? $field='po_no';?>
      <div>
        <label for="<?=$field?>">PO  No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
		<input  name="po_type" type="hidden" id="po_type" value="FG" required/>
      </div>
    <? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?>
      <div>
        <label for="<?=$field?>">PO Date:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
    <?php /*?><? $field='req_no';?>
      <div>
        <label for="<?=$field?>">Req No:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div><?php */?>
	  
	  
    
<? $field='transport_bill';?>
<div>
<label for="<?=$field?>">Transport Bill:</label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
</div>

<? $field='tax';?>
<div>
<label for="<?=$field?>">VAT:</label>
<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
</div>
    </fieldset></td>
      <td><fieldset>
			
			<div>
			
			<div>
        <label for="<?=$group_for?>">Company Name:</label>
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
		
      <? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id,' vendor_category=15 ');?>
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
      
		       
			   <? $field='po_details';?>
      <div>
        <label for="<?=$field?>">Note:</label>
        <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
      </div>
      <div></div>
      </div>
			</fieldset></td>
    </tr>
    <tr>
      <td colspan="2"><div class="buttonrow" style="margin-left:390px;">
        <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
      </div></td>
    </tr>
  </table>
</form>


<? if($_SESSION[$unique]>0){?>
<table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>
    </tr>
  <tr>
    <td align="right" bgcolor="#CCFF99">Created By:</td>
    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>
    <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="po_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#CCFF99">Created On:</td>
    <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;<?=$entry_at?></td>
    </tr>
</table>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
                      <tr>
                        <td width="46%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                        <td width="8%" align="center" bgcolor="#0099FF"><strong>Stock</strong></td>
                        <td width="8%" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                        <td width="9%" align="center" bgcolor="#0099FF"><strong>Price</strong></td>
                        <td width="13%" align="center" bgcolor="#0099FF"><strong>Pack Unit </strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                          <td width="6%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
					    </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input  name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>
<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:320px;" required onblur="getData2('po_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>
<td colspan="3" align="center" bgcolor="#CCCCCC">
<span id="po">
<table>
<tr>
<td>
<input name="stk" type="text" class="input3" id="stk" style="width:80px;float:left;" readonly="readonly"/>
</td>
<td>
<input name="unit" type="text" class="input3" id="unit" style="width:80px;float:left;" readonly="readonly"/>
</td>
<td>
<input name="price" type="text" class="input3" id="price" style="width:80px;float:left;"  readonly="readonly"/>
</td>
</tr>
</table>
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="pkt_unit" type="text" class="input3" id="pkt_unit"  maxlength="100" style="width:90px;" onchange="count()" required/>
									<input name="qty" type="hidden" class="input3" id="qty"  maxlength="100" style="width:90px;" onchange="count()" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:110px;" readonly="readonly" required/></td>
      </tr>
    </table>
  <br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">&nbsp;
      <tr>
	  <br />
   
        <td><div class="tabledesign2">
          <table id="grp" width="100%" cellspacing="0" cellpadding="0"><tbody>
            
			
            <tr>
			<th width="1%" rowspan="2">SL</th>
			<th width="13%" rowspan="2">Item Code </th>
			<th width="47%" rowspan="2">Item Name</th>
			<th width="3%" rowspan="2">Unit  </th>
			<th width="7%" rowspan="2">Pkt Unit </th>
			<th width="7%" rowspan="2">Total Unit </th>
			<th colspan="2" ><center>
			  Price in KSA 
			</center> </th>
			<th width="4%" rowspan="2">Action</th>
      		<th width="4%" rowspan="2">Delete</th>
			</tr>
            <tr>
              <th width="6%">Unit Price</th>
              <th width="8%">Amount</th>
              </tr>
            

<?
$s=0;
 $res='select a.id,  b.finish_goods_code as item_code, concat(b.item_name) as item_name,a.rate as unit_price,
a.pkt_size, a.pkt_unit, a.qty ,a.unit_name,a.amount,"x" from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$po_no;

$query=db_query($res);

while($po_item=mysqli_fetch_object($query)){
?>
<tr>
<td style="text-align:center;"><?=++$s?></td>
<td><?=$po_item->item_code?></td>
<td>&nbsp;<?=$po_item->item_name?></td>
<td>&nbsp;<?=$po_item->unit_name?></td>
<td>
<input type="hidden" name="<?='pkt_size#'.$po_item->id?>" id="<?='pkt_size#'.$po_item->id?>" value="<?=$po_item->pkt_size?>" style="width:90px" onchange="PIcalculation(<?=$po_item->id?>)" />
<input type="text" name="<?='pkt_unit#'.$po_item->id?>" id="<?='pkt_unit#'.$po_item->id?>" value="<?=$po_item->pkt_unit?>" style="width:90px" onchange="PIcalculation(<?=$po_item->id?>)" /></td>
<td><input type="text" name="<?='qty#'.$po_item->id?>" id="<?='qty#'.$po_item->id?>" value="<?=$po_item->qty?>" style="width:90px" readonly="" onchange="PIcalculation(<?=$po_item->id?>)" /></td>

<td><input type="text" name="<?='unit_price#'.$wo_item->id?>" id="<?='unit_price#'.$po_item->id?>" value="<?=$po_item->unit_price?>"  onchange="PIcalculation(<?=$po_item->id?>)"  style="width:80px"/></td>
<td><input type="text" name="<?='amount#'.$po_item->id?>" id="<?='amount#'.$po_item->id?>" value="<?=$po_item->amount?>" style="width:100px"  readonly=""/></td>

<td><span id="ppp"><input name="<?='edit#'.$po_item->id?>" type="button" id="Edit" value="Edit" style="width:50px; height:30px; color:#000; font-weight:700 " onclick="submitButtonStyle(this);update_edit(<?=$po_item->id?>);" /></span></td>
<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$po_item->id?>">&nbsp;X&nbsp;</a></td>
</tr>
<? }?>







</table>
          </div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
</form>

<br  />

<form action="purchase_order_checked.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center">

      <input name="delete"  type="submit" class="btn1" value="DELETE PURCHASE" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">
	  
	  <input  name="po_no" type="hidden" id="po_no" value="<?=$$unique?>"/>

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM PURCHASE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />

      </td>
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