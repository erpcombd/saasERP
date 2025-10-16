<?php
session_start();
ob_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='New Purchase Entry';

do_calander('#po_date');
do_calander('#quotation_date');
create_combobox('vendor_id_draft');
$table_master='purchase_master';
$table_details='purchase_invoice';
$unique='po_no';


if(isset($_POST['new']))
{
		$crud   = new crud($table_master);
		
		
		if($_POST['vendor_id_draft']>0) {
		$_POST['vendor_id']=$_POST['vendor_id_draft'];
		}


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
auto_complete_from_db('item_info','item_name','concat(finish_goods_code,"-",item_name,"#>",item_id)','1 and product_nature="Salable"','item_id');

?>
<script language="javascript">
function count()
{
var ctn_rate=(document.getElementById('ctn_rate').value)*1;
var rate=(document.getElementById('rate').value)*1;
var pkt_size=(document.getElementById('pkt_size').value)*1;
var pkt_unit=(document.getElementById('pkt_unit').value)*1;
var qty=(document.getElementById('qty').value)=(pkt_size*pkt_unit);

document.getElementById('amount').value=(ctn_rate*pkt_unit);

//var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);
//document.getElementById('amount').value = num.toFixed(2);	
}
</script>


<style type="text/css">



/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 220px;
    height: 37px;
    border-radius: 0px !important;
}




.onhover:focus{
background-color:#66CBEA;

}


<!--
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
.style3 {font-weight: bold}
.style4 {font-weight: bold}
-->
</style>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top"><fieldset>
   <? $field='po_no';?>

      <div>

        <label for="<?=$field?>">PO  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>

      </div>
	  
	  
     <? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?>

      <div>

        <label for="<?=$field?>">PO Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>
    
	  <div>

        <label for="<?=$field?>">Company:</label>

        <select id="group_for" name="group_for" required style="width:220px;"  >


      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>

        </select>

      </div>
	  
	  
	  <? $field='remarks';?>

        <div>

          <label for="<?=$field?>">Remarks:</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

        </div>

      
	  
	  
	  
	       <div></div>

    </fieldset></td>
    <td>
			<fieldset>
			
 

      <div>
	  
	<div>

        <label for="<?=$field?>">Vendor :</label>
		
		<? if($vendor_id<1) { ?>
		<select name="vendor_id_draft" id="vendor_id_draft" required   >
	
		<option></option>						
		<? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id_draft,'1');?>
		</select>
		
		<? }?>
		
		<? if($vendor_id>0) { ?>
		
		 <input style="width:190px;"  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>" readonly=""  required/>
		
		 <input style="width:190px;"  name="vendor_view" type="text" id="vendor_view" value="<?=find_a_field('vendor','vendor_name','vendor_id="'.$vendor_id.'"');?>" readonly=""  required/>
		
		<? }?>
      </div>  
	  
	  
	  
	  

       <div>



<? $field='tax';?>

<label for="<?=$field?>">VAT (%):</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  />

</div>



<div>



<? $field='ait';?>

<label for="<?=$field?>">AIT (%):</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  />

</div>


		  
		  
  <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>

      <div>

        <label for="<?=$field?>">Warehouse:</label>

        <select id="<?=$field?>" name="<?=$field?>" required style="width:220px;"    >

        <option></option>

        <? foreign_relation($table,$get_field,$show_field,$$field,'1');?>

        </select>

      </div>


		
	
	
		      

      </div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2"><div class="buttonrow" style="margin-left:390px;">
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
                        <td width="46%" align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
                        <td width="8%" align="center" bgcolor="#0099FF"><strong>Stock in CTN </strong></td>
                        <td width="8%" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                        <td width="9%" align="center" bgcolor="#0099FF"><strong>CTN Price</strong></td>
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
<? }?>				  
<br /><br /><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td>
<div class="tabledesign2">
<? 
$res='select a.id, b.finish_goods_code as item_code, concat(b.item_name) as item_name,a.unit_name as unit, a.pkt_unit as ctn_unit,a.qty as total_unit,  a.ctn_rate as ctn_price,a.amount,"x" from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$po_no;


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


<form action="purchase_order_checked.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center">

      <input name="delete"  type="submit" class="btn1" value="DELETE PURCHASE" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">
	  
	  <input  name="po_no" type="hidden" id="po_no" value="<?=$$unique?>"/>

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM PURCHASE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />
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