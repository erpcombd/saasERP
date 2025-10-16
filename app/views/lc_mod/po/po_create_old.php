<?php
//
//

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='New PI Entry';

do_calander('#po_date');
do_calander('#pi_date');
do_calander('#lc_date');
do_calander('#date_of_shipment');

 //create_combobox('vendor_id');

$table_master='lc_purchase_master';
$table_details='lc_purchase_invoice';
$unique='po_no';


 $pi_reference 		= $_REQUEST['pi_reference'];
  
 // $lc_data = find_all_field('lc_number_setup','','id="'.$lc_id.'"');

$pi_data =find_all_field('lc_pi_reference_setup','','id="'.$pi_reference.'"');
if($_GET['mhafuz']>0){
unset($_SESSION[$unique]);}

echo $_SESSION[$unique];

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
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='CHECKED';
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
		$iii=explode('-',$_POST['item_id']);
		$_POST['item_id']=$iii[0];
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
if($$unique>0) $btn_name='Update Data'; else $btn_name='Initiate Data';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_start_from_db

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);


//if ($req_no!="") {
//auto_complete_from_db('item_info i, requisition_fg_order r','i.item_name','concat(i.finish_goods_code,"-",i.item_name,"#>",r.item_id)','i.item_id=r.item_id
// and r.req_no in ('.$req_no.') group by r.item_id','item_id');
//}else{ 
//auto_complete_from_db('item_info','item_name','concat(finish_goods_code,"-",item_name,"#>",item_id)','1 and product_nature="Purchasable"','item_id');
//}


//auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item_id');

auto_complete_from_db('item_info','concat(item_id," - ",item_name)','concat(item_id," - ",item_name)','1','item_id');

?>
<script language="javascript">
function count()
{

var qty=(document.getElementById('qty').value)*1;

var rate_usd=(document.getElementById('rate_usd').value)*1;

var rate_ud=(document.getElementById('rate_ud').value)*1;

document.getElementById('amount_usd').value=(rate_usd*qty);

document.getElementById('amount_ud').value=(rate_ud*qty);

//var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);
//document.getElementById('amount').value = num.toFixed(2);	
}





function PIcalculation(id){

var wo_qty = document.getElementById('qty#'+id).value*1;

var rate_usd = document.getElementById('rate_usd#'+id).value*1;
var amount_usd = document.getElementById('amount_usd#'+id).value= (wo_qty*rate_usd);

var rate_ud = document.getElementById('rate_ud#'+id).value*1;
var amount_ud = document.getElementById('amount_ud#'+id).value= (wo_qty*rate_ud);
//var amount = document.getElementById('amount#'+id).value= (pi_qty*pi_rate);
}




function update_edit(id)

{

var qty = (document.getElementById("qty#"+id).value);
var rate_usd  = (document.getElementById("rate_usd#"+id).value);
var amount_usd = (document.getElementById("amount_usd#"+id).value)*1;

var rate_ud  = (document.getElementById("rate_ud#"+id).value);
var amount_ud = (document.getElementById("amount_ud#"+id).value)*1;
var info = qty+"<@>"+rate_usd+"<@>"+amount_usd+"<@>"+rate_ud+"<@>"+amount_ud;
getData2('po_edit_ajax.php', 'ppp',id,info);
}




function submitButtonStyle(_this) {
  _this.style.backgroundColor = "red";
}


window.onload = function() {
  document.getElementById("item_id").focus();
};
</script>

<style type="text/css">
<!--

.onhover:focus{
background-color:#66CBEA;

}
.style6 {font-size: 14}
.style7 {font-size: 14; font-weight: bold; }
-->
</style>

<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 300px;
    height: 38px;
    border-radius: 0px !important;
}


/*table thead  {
  / Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}*/


</style>
<div class="form-container_large">
<form action="?" method="post" name="codz" id="codz" >
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top" width="48%"><fieldset style="100%">
	
	<?php /*?><? $field='po_date'; if($po_date=='') $po_date =date('Y-m-d');?><?php */?>
      <div>
        <label style="width:30%" for="<?=$field?>">Entry Date:</label>
        <!--<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required style="width:50%" />-->
		
		 <input  name="po_date" type="text" id="po_date" value="<?=$po_date;?>" required style="width:50%" />
		
		
      </div>
	
	
    <? $field='po_no';?>
      <div>
        <label style="width:30%" for="<?=$field?>">PI  No: </label>
        <input  name="<?=$field?>" type="hidden" id="<?=$field?>" value="<?=$$field?>"/>
		
		<input  name="pi_no" type="text" id="pi_no" value="<?=$pi_no?>" required style="width:50%"/>
		
      </div>
    <?php /*?><? $field='pi_date'; if($pi_date=='') $pi_date =date('Y-m-d');?><?php */?>
      <div>
        <label style="width:30%" for="<?=$field?>">PI Date:</label>
        <!--<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:50%" required/>-->
		
		<input  name="pi_date" type="text" id="pi_date" value="<?=$pi_date;?>" style="width:50%" required/>
		
		
      </div>
	  
	  <div>
        <label style="width:30%" for="supplier_agent">Inco Tearms:</label>
		

		<? if($inco_tearms<1) {?>
        <select id="inco_tearms" name="inco_tearms" required style="width:50%" >

<option></option>

         <? foreign_relation('inco_tearms','id','inco_tearms',$inco_tearms, '1');?>
        </select>
		 <? } else {?>
		
		 <select id="inco_tearms" name="inco_tearms" required  style="width:50%" >


         <? foreign_relation('inco_tearms','id','inco_tearms',$inco_tearms, 'id="'.$inco_tearms.'"');?>
        </select>
		
		 <? }?>
      </div>
	  	  <div>
        <label style="width:30%" for="supplier_agent">Port Of Shipment:</label>
		
       <input  name="port_of_shipment" type="text" id="port_of_shipment" value="<?=$port_of_shipment?>"  style="width:50%"/>
		
		
	  </div>
	  
	   <div>
        <label style="width:30%" for="supplier_agent">Port Of Destination:</label>
		
       <input  name="port_of_destination" type="text" id="port_of_destination" value="<?=$port_of_destination?>" style="width:50%" />
		
		
	  </div>
	  <div>
        <label style="width:30%" for="supplier_agent">Partial Shipment:</label>
		
       <input  name="partial_shipment" type="text" id="partial_shipment" value="<?=$partial_shipment?>" style="width:50%" />
		
		
	  </div>	
	  
	  <div>
        <label style="width:30%" for="supplier_agent">Trans Shipment:</label>
		
       <input  name="trans_shipment" type="text" id="trans_shipment" value="<?=$trans_shipment?>"  style="width:50%" />
		
		
	  </div>  
	  
	  <div>
        <label style="width:30%" for="supplier_agent">Terms Of Payment:</label>
		
       <input  name="trans_of_payment" type="text" id="trans_of_payment" value="<?=$trans_of_payment?>" style="width:50%" />
		
		
	  </div>
	  
	  	  <div>
        <label style="width:30%" for="supplier_agent">Packing:</label>
		
       <input  name="packing" type="text" id="packing" value="<?=$packing?>" style="width:50%" />
		
		
	  </div>
	  
	  
	  <div> 
        <label style="width:30%">Supplier Name:</label>
	
	

<select  name="vendor_id" id="vendor_id" required style="width:50%">
<option></option>
		
      <? foreign_relation('vendor_foreign','vendor_id','vendor_name',$vendor_id,'1 order by vendor_id');?>
		 </select>


		
	
	
		
		</div>
	  
	  




	   
	   
	     <?php /*?><div> 
        <label style="width:30%">Supplier Name:</label>
		
		<? if($vendor_id<1) { ?>
		
	

<select  name="vendor_id" id="vendor_id" required style="width:50%">
<option></option>
		
      <? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id,'vendor_category=8 order by vendor_name');?>
		 </select>


		
		
		<? }?>
		
		
		<? if($vendor_id>0) { ?>
			<input  name="vendor_id2" type="text" id="vendor_id2"  readonly=""
			value="<?=find_a_field('vendor','vendor_name','vendor_id='.$vendor_id)?>" required style="width:50%"/>
			
			<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>" required/>
		
		<? }?>
		
		</div><?php */?>
		
		
		
			
			
		<div>
        <label style="width:30%" for="supplier_agent">Suppliers Agent:</label>
        <select id="supplier_agent" name="supplier_agent"  style="width:50%">
		<option></option>

         <? foreign_relation('agent_info','agent_id','agent_name',$supplier_agent);?>
        </select>
		
		
      </div>
			
	  <? $field='supplier_bank_details';?>
          <div>
            <label style="width:30%" for="<?=$field?>">Suppliers Bank Details:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:50%"/>
          </div>

      
		<div>
        <label style="width:30%" for="lc_manual_no">L/C Type:</label>
		
		
		<? if($lc_type<1) {?>
        <select id="lc_type" name="lc_type" required style="width:50%">
	

         <? foreign_relation('lc_type','id','lc_type',$lc_type, '1');?>
        </select>
		<? } else {?>
			 
		<select id="lc_type" name="lc_type" required style="width:50%" >
	
         <? foreign_relation('lc_type','id','lc_type',$lc_type, 'id="'.$lc_type.'"');?>
        </select>
		<? }?>
      </div>
	  
	  
        <div></div>
		
		
		
    </fieldset></td>
    <td width="48%">
			<fieldset style="100%">
			
			
			<div>
        <label style="width:30%" for="<?=$group_for?>">Company:</label>
		<? if($group_for<1) {?>
		<select  name="group_for" id="group_for" style="width:50%" required>
      <? foreign_relation('user_group','id','group_name',$group_for,'id="'.$pi_data->group_for.'"');?>
		 </select>
		 <? } else {?>
		 <select  name="group_for" id="group_for" style="width:50%" required>
      <? foreign_relation('user_group','id','group_name',$group_for,'id="'.$group_for.'"');?>
		 </select> 
		 <? }?>
		 
		 <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>" required/>
		  <input  name="lc_no" type="hidden" id="lc_no" value="<?=$pi_data->id?>"  />
      </div>
	  
	   
	  <div>
        <label style="width:30%" for="lc_manual_no">Reference No:</label>
		
		
		<? if($pi_reference<1) {?>
        <select id="pi_reference" name="pi_reference" required style="width:50%">
	

         <? foreign_relation('lc_pi_reference_setup','id','pi_number',$pi_reference, 'id="'.$pi_data->id.'"');?>
        </select>
		<? } else {?>
			 
		<select id="pi_reference" name="pi_reference" required style="width:50%" >
	

         <? foreign_relation('lc_pi_reference_setup','id','pi_number',$pi_reference, 'id="'.$pi_reference.'"');?>
        </select>
		<? }?>
      </div>
	  
	  <? $field='hs_code';?>
          <div>
            <label style="width:30%" for="<?=$field?>">H.S. Code:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:50%" />
          </div>
	  
	  		  
		<? $field='date_of_shipment';?>
          <div>
            <label style="width:30%" for="<?=$field?>">Date Of Shipment:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:50%" />
          </div>
		  
        <div></div>
		
		<? $field='place_of_expiry';?>
          <div>
            <label  style="width:30%" for="<?=$field?>">Place Of Expiry:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:50%"  />
          </div>
		  
		  		<? $field='available_with_by';?>
          <div>
            <label style="width:30%" for="<?=$field?>">Available With By:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:50%" />
          </div>
		  
        <div></div>
		
		
		<? $field='shipping_mark';?>
          <div>
            <label style="width:30%" for="<?=$field?>">Shipping Mark:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:50%"  />
          </div>
	  <div>
	  </div>
		
		
		<? $field='beneficiary';?>
          <div>
            <label style="width:30%" for="<?=$field?>">Beneficiary:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:50%"/>
          </div>
		  
        <div></div>
		
		
		<? $field='beneficiary_bank';?>
          <div>
            <label style="width:30%" for="<?=$field?>">Beneficiary Bank:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:50%"/>
          </div>
		  
        <div></div>
	  
	  <? $field='bank_swift_code';?>
          <div>
            <label style="width:30%" for="<?=$field?>">Bank Swift Code:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:50%"/>
          </div>
		  
		    <? $field='bank_address';?>
          <div>
            <label style="width:30%" for="<?=$field?>">Bank Address:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:50%"/>
          </div>
		  
        <div></div>
	  
	  
	  <? $field='bank_Ac_no';?>
          <div>
            <label style="width:30%" for="<?=$field?>">A/C NO:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:50%"/>
          </div>
	  
        <label style="width:30%" for="lc_manual_no">Commercial Licence:</label>
		
		
		<? if($commercial_licence<1) {?>
        <select id="commercial_licence" name="commercial_licence"   style="width:50%">
	

         <? foreign_relation('commercial_licence_info','company_id','company_name',$commercial_licence, 'company_id="'.$pi_data->commercial_licence.'"');?>
        </select>
		<? } else {?>
			 
		<select id="commercial_licence" name="commercial_licence"  style="width:50%" >
	

         <? foreign_relation('commercial_licence_info','company_id','company_name',$commercial_licence, 'company_id="'.$commercial_licence.'"');?>
        </select>
		<? }?>
      </div>
	  
	  
	  
	   
	  
	
	
		
		
		<? $field='remarks';?>
          <div>
            <label style="width:30%" for="<?=$field?>">Remarks:</label>
            <input name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:50%"/>
          </div>
		  
        <div></div>
	  
	  
	      
		  
        
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2" ><div class="buttonrow"  align="center">
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
                        <td width="34%" align="center" bgcolor="#0099FF"><strong>Item Name 
						
						</strong></td>
                        <td width="11%" align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
						  <td width="13%" align="center" bgcolor="#0099FF"><strong>Specification</strong></td>
                        <td width="9%" align="center" bgcolor="#0099FF"><strong>Quantity</strong></td>
                        <td width="9%" align="center" bgcolor="#0099FF"><strong>Rate(USD$)</strong></td>
                        <td width="13%" align="center" bgcolor="#0099FF"><strong>Amount(USD$) </strong></td>
                        <td width="11%"  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
					    </div>				        </td>
      </tr>
                      <tr>
<td align="center" bgcolor="#CCCCCC">
<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="po_date" type="hidden" id="po_date" value="<?=$po_date?>"/>
<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>
<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:90%; height:32px;" required onblur="getData2('po_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>
<td align="center" bgcolor="#CCCCCC">
<span id="po">
<table>
<tr>

<td>
<input name="unit" type="text" class="input3" id="unit" style="width:80px;float:left; height:32px;" readonly="readonly"/></td>
</tr>
</table>
</span></td>
<td align="center" bgcolor="#CCCCCC"><input name="specification" type="text" class="input3" id="specification"  maxlength="100" style="width:150px; height:32px;" /></td>
<td align="center" bgcolor="#CCCCCC">

<input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:80px; height:32px;" onchange="count()" required="required"/></td>
<td align="center" bgcolor="#CCCCCC"><input name="rate_usd" type="text" class="input3" id="rate_usd"  maxlength="100" style="width:80px; height:32px;" onchange="count()"  required/></td>
<td align="center" bgcolor="#CCCCCC">
<input name="amount_usd" type="text" class="input3" id="amount_usd" style="width:100px; height:32px;" readonly="readonly" required/>
<input name="rate_ud" type="hidden" class="input3" id="rate_ud"  maxlength="100" style="width:50px; height:32px;" onchange="count()"  />
<input name="amount_ud" type="hidden" class="input3" id="amount_ud" style="width:90px; height:32px;" readonly="readonly" /></td>
</tr>
    </table>
<? }?>				  
<br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">&nbsp;
      <tr>
	  <br />
   
        <td><div class="tabledesign2">
          <table id="grp" width="100%" cellspacing="0" cellpadding="0"><tbody>
            
			
            <tr>
			<th width="7%">SL</th>
			<th width="38%">Item Name</th>
			<th width="8%">Quantity</th>
			<th width="8%">Unit  </th>
			<th width="11%" >   Rate(USD$) </th>
			<th width="12%" >Amount(USD$)</th>
			<th width="6%">Action</th>
      		<th width="8%">Delete</th>
			</tr>
            
            

<?
$s=0;
 $res='select a.id,  b.finish_goods_code as item_code, concat(b.item_name) as item_name, a.specification,  a.rate as unit_price,
 a.qty, a.unit_name, a.amount,  a.rate_usd, a.amount_usd, a.rate_ud, a.amount_ud, "x" from lc_purchase_invoice a,item_info b where b.item_id=a.item_id  and a.po_no="'.$po_no.'" order by id desc';

$query=db_query($res);

while($po_item=mysqli_fetch_object($query)){
?>
<tr>
<td style="text-align:center;"><?=++$s?></td>
<td>&nbsp;<?=$po_item->item_name?></td>
<td><input type="hidden" name="<?='pkt_unit#'.$po_item->id?>" id="<?='pkt_unit#'.$po_item->id?>" value="<?=$po_item->pkt_unit?>" style="width:50px;  height:20px;" onchange="PIcalculation(<?=$po_item->id?>)" />
<input type="text" name="<?='qty#'.$po_item->id?>" id="<?='qty#'.$po_item->id?>" value="<?=$po_item->qty?>" style="width:80px;  height:32px;" onchange="PIcalculation(<?=$po_item->id?>)" /></td>
<td>&nbsp;<?=$po_item->unit_name?>
  <input type="hidden" name="<?='pkt_size#'.$po_item->id?>" id="<?='pkt_size#'.$po_item->id?>" value="<?=$po_item->pkt_size?>" style="width:50px; height:20px;" onchange="PIcalculation(<?=$po_item->id?>)" /></td>
<td><input type="text" name="<?='rate_usd#'.$wo_item->id?>" id="<?='rate_usd#'.$po_item->id?>" value="<?=$po_item->rate_usd?>"  onchange="PIcalculation(<?=$po_item->id?>)"  style="width:80px;  height:32px;"/></td>
<td><input type="text" name="<?='amount_usd#'.$po_item->id?>" id="<?='amount_usd#'.$po_item->id?>" value="<?=$po_item->amount_usd; $total_amount_usd+=$po_item->amount_usd;?>" style="width:100px;  height:32px;"  readonly=""/>
  <input type="hidden" name="<?='rate_ud#'.$wo_item->id?>" id="<?='rate_ud#'.$po_item->id?>" value="<?=$po_item->rate_ud?>"  onchange="PIcalculation(<?=$po_item->id?>)"  style="width:60px;  height:20px;"/>
  <input type="hidden" name="<?='amount_ud#'.$po_item->id?>" id="<?='amount_ud#'.$po_item->id?>" value="<?=$po_item->amount_ud; $total_amount_ud+=$po_item->amount_ud;?>" style="width:70px;  height:20px;"  readonly=""/></td>

<td><span id="ppp"><input name="<?='edit#'.$po_item->id?>" type="button" id="Edit" value="Edit" style="width:50px; height:30px; color:#000; font-weight:700 " onclick="submitButtonStyle(this);update_edit(<?=$po_item->id?>);" /></span></td>
<td><a onclick="if(!confirm('Are You Sure Execute this?')){return false;}" href="?del=<?=$po_item->id?>">&nbsp;X&nbsp;</a></td>
</tr>
<? }?>

<tr>
  <td style="text-align:center;"><span class="style6"></span></td>
  <td><span class="style6"></span></td>
  <td>&nbsp;</td>
  <td><span class="style6"></span></td>
  <td><span class="style6"></span></td>
  <td><span class="style7">
    <?=number_format($total_amount_usd,2);?>
  </span></td>
  <td><span class="style6"></span></td>
  <td><span class="style6"></span></td>
</tr>








</table>
          </div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>





</form>

<br />


<form action="" method="post" name="cz" id="cz" >
  <table width="100%" border="0">
    <tr>
      <td align="center">

      <input name="delete"  type="submit" class="btn1" value="DELETE ENTRY" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />

      </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn1" value="CONFIRM & SEND" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:#090" />
</tr>
  </table>
</form>
<? }?>
</div>
<script>$("#codz").validate();$("#cloud").validate();</script>
<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>