<?php







session_start();







ob_start();







require "../../support/inc.all.php";















$title='Import Receive (Raw)';



















$page_for = 'Import';







//do_calander('#or_date','-60','0');



do_calander('#or_date');







do_calander('#quotation_date');



do_calander('#mfg_date');



do_calander('#expire_date');















$table_master='warehouse_other_receive';







$table_details='warehouse_other_receive_detail';







$unique='or_no';











$_SESSION['or_no3'] = $_GET['v_no']; 











if(isset($_POST['new']))







{







		$crud   = new crud($table_master);















		if(!isset($_SESSION['or_no3'])) {







		$_POST['entry_by']=$_SESSION['user']['id'];







		$_POST['entry_at']=date('Y-m-d h:s:i');







		$_POST['edit_by']=$_SESSION['user']['id'];







		$_POST['edit_at']=date('Y-m-d h:s:i');







		$$unique=$_SESSION['or_no3']=$crud->insert();







		unset($$unique);







		$type=1;







		$msg=$title.'  No Created. (No :-'.$_SESSION['or_no3'].')';







		}







		else {







		$_POST['edit_by']=$_SESSION['user']['id'];







		$_POST['edit_at']=date('Y-m-d h:s:i');







		$crud->update($unique);







		$type=1;







		$msg='Successfully Updated.';







		}







}















$$unique=$_SESSION['or_no3'];















if(isset($_POST['delete']))







{







		$crud   = new crud($table_master);







		$condition=$unique."=".$$unique;		







		$crud->delete($condition);







		$crud   = new crud($table_details);







		$condition=$unique."=".$$unique;		







		$crud->delete_all($condition);







		unset($$unique);







		unset($_SESSION['or_no3']);







		$type=1;







		$msg='Successfully Deleted.';







}















if($_GET['del']>0)







{







		$crud   = new crud($table_details);







		$condition="id=".$_GET['del'];		







		$crud->delete_all($condition);







		







		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";







		mysql_query($sql);







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
        //Accounts part start



		



		$jv_no=next_journal_sec_voucher_id();
        $entry_by = $_SESSION['user']['id'];
        $entry_at = date('Y-m-d h:i:s');



		$labour_ledger = '2063001900000000';
        $transport_ledger = '2066018100000000';
        $cc_code = '134';



		$tr_no = $$unique;
		
		$narration = 'Import Receive. IR No#'.$$unique.'IV_NO#'.$invoice_no.'IV_Date#'.$invoice_date;

        

		



		$tr_from = 'ImportReceive';



		$vendor_ledger = find_a_field('warehouse_other_receive','vendor_ledger','or_no="'.$$unique.'"');

        if($vendor_ledger>0){

	    $jsql = 'select d.*,m.vendor_ledger from warehouse_other_receive_detail d,warehouse_other_receive m where d.or_no=m.or_no and m.or_no="'.$$unique.'"';



		$jquery = mysql_query($jsql);



		while($jdata = mysql_fetch_object($jquery)){

        $jv_date = strtotime($jdata->or_date);

		$vendor_amount =round($jdata->material_price+$jdata->vat_amount);

        $labour_cost += $jdata->labour_cost;

        $transport_cost += $jdata->transport_cost;
		
		$item_amount=round($jdata->amount);

		

		$invoice_no=$jdata->invoice_no;
		
		
		$narrationinvoice = 'Import Receive. IR No#'.$$unique.'IV_NO#'.$invoice_no.'.IV_Date#'.$invoice_date;
		
		
		
		

		$invoice_date=$jdata->or_date;

		

		

		$item_ledger = find_a_field('item_info','acc_ledger','item_id="'.$jdata->item_id.'"');



		//item



		add_to_sec_journal('AKSID', $jv_no, $jv_date, $item_ledger, $narrationinvoice, $item_amount,0, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$cc_code,$group='',$entry_by,$entry_at,$jdata->or_no);
		
		
		
		
		 //vendor



		add_to_sec_journal('AKSID', $jv_no, $jv_date, $vendor_ledger, $narrationinvoice, 0,$vendor_amount, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$cc_code,$group='',$entry_by,$entry_at,$$unique);



		



		 }



		 //labour

		add_to_sec_journal('AKSID', $jv_no, $jv_date, $labour_ledger, $narration, 0, $labour_cost, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$cc_code,$group='',$entry_by,$entry_at,$$unique);



		

		//transport



		add_to_sec_journal('AKSID', $jv_no, $jv_date, $transport_ledger, $narration, 0, $transport_cost, $tr_from, $tr_no,$sub_ledger='',$tr_id='',$cc_code,$group='',$entry_by,$entry_at,$$unique);



		




		 

		 //Accounts part end

		 



		 



		unset($$unique);







		unset($_SESSION['or_no3']);

		$msg='Successfully Forwarded.';

       

	   

       



		$type=1;







		



}else{



$msg='<span style="color:red">Vendor Ledger Not Found! Select Vendor</span>';



}

}




if(isset($_POST['add'])&&($_POST[$unique]>0))







{

	$crud   = new crud($table_details);
	
	$iii	=explode('#>',$_POST['item_id']);
	
	$_POST['item_id']=$iii[1];
	$lot_no = $_POST['or_no'];
	$_POST['entry_by']=$_SESSION['user']['id'];
	$_POST['entry_at']=date('Y-m-d h:s:i');
	$_POST['edit_by']=$_SESSION['user']['id'];
	
	$_POST['edit_at']=date('Y-m-d h:s:i');


	
	$xid = $crud->insert();
	
	
	journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['or_date'],$_POST['qty'],0,$page_for,$xid,$_POST['rate'],'','',$_POST['expire_date'],$lot_no);
	




}

if(isset($_POST['deleteall'])){

 

 if($$unique>0){

  $master_del = 'delete from warehouse_other_receive where or_no="'.$$unique.'" and receive_type="Import"';

  mysql_query($master_del);

  

  $details_del = 'delete from warehouse_other_receive_detail where or_no="'.$$unique.'" and receive_type="Import"';

  mysql_query($details_del);

  header('location:import_status_approve.php');

 }

}



if($$unique>0)


{

$condition=$unique."=".$$unique;
$data=db_fetch_object($table_master,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}

}

if($$unique>0) $btn_name='Update IR Information'; else $btn_name='Initiate IR Information';
if($_SESSION['or_no3']<1)
$$unique=db_last_insert_id($table_master,$unique);
//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1 and product_nature!="Salable"','item_id');

?>
<script language="javascript">
function focuson(id) {
if(document.getElementById('item_id').value=='')
document.getElementById('item_id').focus();
else
document.getElementById(id).focus();
}
window.onload = function() {
if(document.getElementById("warehouse_id").value>0)
document.getElementById("item_id").focus();
else
document.getElementById("req_date").focus();
}
</script>

<script language="javascript">
function count(id)
{
//var cost_price = ((document.getElementById('cost_price').value)*1);
var labour_cost = ((document.getElementById('labour_cost_'+id).value)*1);
var transport_cost = ((document.getElementById('transport_cost_'+id).value)*1);

var vat = ((document.getElementById('vat_'+id).value)*1);



var num=((document.getElementById('qty_'+id).value)*1)*((document.getElementById('cost_price_'+id).value)*1);
document.getElementById('material_price_'+id).value = num.toFixed(2);
//add vat amount new 
var vat_amount = num/100*vat;
document.getElementById('vat_amount_'+id).value = vat_amount.toFixed(2);
//end vat amount 
var total_price = +num+labour_cost+transport_cost+vat_amount;
var actual_price = total_price/((document.getElementById('qty_'+id).value)*1);
document.getElementById('amount_'+id).value = total_price.toFixed(2);
document.getElementById('rate_'+id).value = actual_price.toFixed(2);
	
}
</script>

<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td valign="top"><fieldset>
          <? $field='or_no';?>
          <div>
            <label for="<?=$field?>">Import Rcv  No: </label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
          </div>
          <? $field='or_date';  ?>
          <div>
            <label for="<?=$field?>">Import Rcv Date:</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
          </div>
          <? $field='requisition_from';?>
          <div>
            <label for="<?=$field?>">Requisition From:</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
          </div>
          <? $field='vendor_ledger';?>
          <div>
            <label for="<?=$field?>">Supplier:</label>
            <select  name="<?=$field?>" id="<?=$field?>" required>
              <option></option>
              <option value="2066017600000000" <?=($$field==2066017600000000)? 'selected':''?>>SIKA Bangladesh Limited</option>
              <option value="2066020500000000" <?=($$field==2066020500000000)? 'selected':''?>>Building Products Services (SIKA) </option>
              <option value="2066023000000000" <?=($$field==2066023000000000)? 'selected':''?>>Insha chemical ( SIKA)</option>
              <option value="2066025200000000" <?=($$field==2066025200000000)? 'selected':''?>>HATEM ALI (Sika)</option>
            </select>
          </div>
          <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>
          <input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required/>
          </fieldset></td>
        <td><fieldset>
          <? $field='or_subject';?>
          <div>
            <label for="<?=$field?>">Note:</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
          </div>
          <? $field='invoice_no';?>
          <div>
            <label for="<?=$field?>">Invoice No. :</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
          </div>
          <div></div>
          <? $field='vendor_name'; ?>
          <div>
            <label for="<?=$field?>">Received From :</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required="required"/>
          </div>
          <div>
            <? $field='approved_by';?>
            <div>
              <label for="<?=$field?>">Approved By :</label>
              <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
            </div>
          </div>
          </fieldset></td>
      </tr>
      <tr>
        <td colspan="2"><div class="buttonrow" style="margin-left:240px;">
            <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
          </div></td>
      </tr>
    </table>
  </form>
  <? if($_SESSION['or_no3']>0){?>
  <form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
    <table   border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5; width:1250px;" cellpadding="2" cellspacing="2">
      <tr>
        <td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Stock</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Price</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Cost Price</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Material Price</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Labour</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Transport</strong></td>
		 <td align="center" bgcolor="#0099FF"><strong>Vat%</strong></td>
		 <td align="center" bgcolor="#0099FF"><strong>Vat Amount</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Total Material Cost</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Per Unit Price</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Mfg Date</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Exp. Date</strong></td>
        <td align="center" bgcolor="#0099FF"><strong>Invoice No.</strong></td>
        <td  align="center" bgcolor="#FF0000">Action</td>
      </tr>
      <?



	    $ssql = 'select * from warehouse_other_receive_detail where or_no="'.$_SESSION['or_no3'].'"';



		$query = mysql_query($ssql);



		while($update_data = mysql_fetch_object($query)){



		$item_info = find_all_field('item_info','','item_id="'.$update_data->item_id.'"');



	  ?>
      <tr>
        <td align="center" bgcolor="#CCCCCC"><input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
          <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
          <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
          <input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/>
          <input  name="vendor_name" type="hidden" id="vendor_name" value="<?=$vendor_name?>"/>
          <input  name="vendor_ledger" type="hidden" id="vendor_ledger" value="<?=$vendor_ledger?>"/>
          <input  name="id_<?=$update_data->id?>" type="hidden" id="id_<?=$update_data->id?>" value="<?=$update_data->id?>"/>
          <input  name="item_id" type="text" id="item_id" value="<?=$item_info->item_name.'#>'.$update_data->item_id?>" style="width:200px;" required /></td>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><span id="po">
          <table width="100%" border="1">
            <tr>
              <td width="33%"><input name="stk" type="text" class="input3" id="stk" style="width:98%;" readonly="readonly"/></td>
              <td width="33%"><input name="unit" type="text" class="input3" id="unit" value="<?=$item_info->unit_name?>" style="width:98%;" readonly="readonly"/></td>
              <td width="33%"><input name="price" type="text" class="input3" id="price" value="<?=$item_info->d_price?>" style="width:98%;"  readonly="readonly"/></td>
            </tr>
          </table>
          </span></td>
        <td align="center" bgcolor="#CCCCCC"><input name="qty_<?=$update_data->id?>" type="text" class="input3" id="qty_<?=$update_data->id?>"  value="<?=$update_data->qty?>" maxlength="100"  style="width:60px;" onchange="count(<?=$update_data->id?>)" required/></td>
		
        <td align="center" bgcolor="#CCCCCC"><input name="cost_price_<?=$update_data->id?>" type="text" class="input3" id="cost_price_<?=$update_data->id?>"  value="<? if($update_data->cost_price>0) echo $update_data->cost_price; else echo '';?>"  maxlength="100" style="width:60px;" onchange="count(<?=$update_data->id?>)" required /></td>
		
        <td align="center" bgcolor="#CCCCCC"><input name="material_price_<?=$update_data->id?>" type="text" class="input3" id="material_price_<?=$update_data->id?>" value="<?=$update_data->material_price?>"   maxlength="100" style="width:60px;" readonly="readonly" /></td>
		
        <td align="center" bgcolor="#CCCCCC"><input name="labour_cost_<?=$update_data->id?>" type="text" class="input3" id="labour_cost_<?=$update_data->id?>" value="<? if($update_data->labour_cost>0) echo $update_data->labour_cost; else echo '';?>"   maxlength="100" style="width:60px;" onchange="count(<?=$update_data->id?>)" required /></td>
		
        <td align="center" bgcolor="#CCCCCC"><input name="transport_cost_<?=$update_data->id?>" type="text" class="input3" id="transport_cost_<?=$update_data->id?>" value="<? if($update_data->transport_cost>0) echo $update_data->transport_cost; else echo '';?>"    maxlength="100" style="width:60px;" onchange="count(<?=$update_data->id?>)" required /></td>
		
		
		<td align="center" bgcolor="#CCCCCC"><input name="vat_<?=$update_data->id?>" type="text" class="input3" id="vat_<?=$update_data->id?>" value="<? if($update_data->vat>0) echo $update_data->vat; else echo '';?>" maxlength="100" style="width:60px;" onchange="count(<?=$update_data->id?>)" required /></td>
		
		
		<td align="center" bgcolor="#CCCCCC"><input name="vat_amount_<?=$update_data->id?>" type="text" class="input3" id="vat_amount_<?=$update_data->id?>" 
		value="<?=$update_data->vat_amount?>" style="width:60px;" readonly="readonly"/></td>
		
		
        <td align="center" bgcolor="#CCCCCC"><input name="amount_<?=$update_data->id?>" type="text" class="input3" id="amount_<?=$update_data->id?>" style="width:90px;" 
		value="<?=$update_data->amount?>"  readonly="readonly" /></td>
		
        <td align="center" bgcolor="#CCCCCC"><input name="rate_<?=$update_data->id?>" type="text" class="input3" id="rate_<?=$update_data->id?>" style="width:90px;" value="<?=$update_data->rate?>" readonly="readonly" /></td>
		
        <td align="center" bgcolor="#CCCCCC"><input name="mfg_date_<?=$update_data->id?>" type="text" class="input3" id="mfg_date_<?=$update_data->id?>" style="width:90px;" value="<?=$update_data->mfg_date?>"  readonly="readonly" /></td>
        <td align="center" bgcolor="#CCCCCC"><input name="expire_date_<?=$update_data->id?>" type="text" class="input3" id="expire_date_<?=$update_data->id?>" style="width:90px;" value="<?=$update_data->expire_date?>" readonly="readonly" /></td>
        <td align="center" bgcolor="#CCCCCC"><input name="invoice_no_<?=$update_data->id?>" type="text" class="input3" id="invoice_no_<?=$update_data->id?>" style="width:90px;" value="<?=$update_data->invoice_no?>" /></td>
        <td><div class="button"> <span id="line_<?=$update_data->id?>">
            <button name="add_<?=$update_data->id?>" type="button" id="add_<?=$update_data->id?>"  onclick="getData2('import_update_ajax.php', 'line_<?=$update_data->id?>',document.getElementById('id_<?=$update_data->id?>').value,



						  document.getElementById('rate_<?=$update_data->id?>').value+'<#>'+
                          document.getElementById('qty_<?=$update_data->id?>').value+'<#>'+
                          document.getElementById('amount_<?=$update_data->id?>').value+'<#>'+
                          document.getElementById('labour_cost_<?=$update_data->id?>').value+'<#>'+
                          document.getElementById('transport_cost_<?=$update_data->id?>').value+'<#>'+
                          document.getElementById('material_price_<?=$update_data->id?>').value+'<#>'+
                          document.getElementById('mfg_date_<?=$update_data->id?>').value+'<#>'+
                          document.getElementById('expire_date_<?=$update_data->id?>').value+'<#>'+
                          document.getElementById('invoice_no_<?=$update_data->id?>').value+'<#>'+
						  document.getElementById('vat_<?=$update_data->id?>').value+'<#>'+
						  document.getElementById('vat_amount_<?=$update_data->id?>').value+'<#>'+
						
                          document.getElementById('cost_price_<?=$update_data->id?>').value);">Edit</button>
            </span> </div></td>
      </tr>
      <? } ?>
    </table>
    <br />
    <br />
    <br />
    <br />
    <!--<table width="100%" border="0" cellspacing="0" cellpadding="0">















    <tr>







      <td>







<div class="tabledesign2">







<? 







$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.cost_price,a.material_price,a.labour_cost,a.transport_cost,a.mfg_date,a.expire_date,a.amount,"x" from warehouse_other_receive_detail a,item_info b where b.item_id=a.item_id and a.or_no='.$or_no;







echo link_report_add_del_auto($res,'',4,6);







?>







</div>







</td>







    </tr>







    <tr>







     <td>







 </td>







    </tr>







  </table>-->
  </form>
  <form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    <table width="100%" border="0">
      <tr>
        <td align="center"><input name="deleteall" type="submit" class="btn1" value="Delete This Import Receive" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:red" /></td>
        <td align="center"><input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD IR" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />
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







include ("../../template/main_layout.php");







?>
