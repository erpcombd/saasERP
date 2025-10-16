<?php





require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Import Receive';

do_calander('#rec_date');

$table_master='purchase_master';

$table_details='warehouse_other_receive_detail';

$unique='or_no';

$or_no = $_REQUEST['or_no'];



if($_SESSION[$unique]>0)

$$unique=$_SESSION[$unique];



if($_REQUEST[$unique]>0){

$$unique=$_REQUEST[$unique];

$_SESSION[$unique]=$$unique;}

else

$$unique = $_SESSION[$unique];


if(prevent_multi_submit()){


if(isset($_POST['confirm'])){

        
		
		$warehouse_id = $_POST['warehouse_id'];

		$rec_date=$_POST['rec_date'];


	$jv_no=next_journal_sec_voucher_id();
	$proj_id = 'boishakhi'; 
	
	$group_for =  $_SESSION['user']['group'];
	
    $tr_id = $or_no;
	$tr_no = $or_no;
	$tr_from = 'Import';
	$narration = 'Import#'.$or_no.'';

	

	$config_ledger = find_all_field('config_group_class','',"group_for=".$_SESSION['user']['group']);
	$cc_code = $group_for;
	$vendor_id = find_a_field('warehouse_other_receive','vendor_id','or_no="'.$or_no.'"');
	$vendor = find_all_field('vendor','','vendor_id="'.$vendor_id.'"');
	$vendor_ledger = $vendor->ledger_id;
	$vendor_sub_ledger = $vendor->sub_ledger_id;


 
 $sql_all = 'select pr.*,s.item_ledger as item_ledger,i.item_name,sum(pr.amount) as invoice_amt,pr.item_id,i.sub_ledger_id  from lc_import pr, item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id and pr.item_id=i.item_id and pr.import_no="'.$or_no.'" and pr.journal_status="Pending" group by pr.item_id';
$qrr_all = db_query($sql_all);
while($pr_data = mysqli_fetch_object($qrr_all)){
$jv_date = $pr_data->import_rcv_date;
$narration_dr = 'Import#'.$or_no.'';
$narration_cr = 'Import#'.$or_no.', Supplier : '.$vendor->vendor_name;
//journal_item_control($pr_data->item_id ,$pr_data->warehouse_id,$pr_data->or_date,$pr_data->qty,0,$tr_from,$tr_id,$pr_data->rate,'',$tr_no);
//debit	
//add_to_sec_journal($proj_id, $jv_no, $jv_date, $pr_data->item_ledger, $narration_dr, ($pr_data->invoice_amt), '0', $tr_from, $tr_no,'', $tr_id,$cc_code,$group_for);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $pr_data->item_ledger, $narration_dr, $pr_data->invoice_amt,'0',  $tr_from, $tr_no,$pr_data->sub_ledger_id,$tr_id,$cc_code,$group_for);
//credit
//add_to_sec_journal($proj_id, $jv_no, $jv_date, $vendor_ledger, $narration_cr, '0', ($pr_data->invoice_amt), $tr_from, $tr_no,'', $tr_id,$cc_code,$group_for);
$import_update = 'update lc_import set journal_status="Done" where import_no="'.$or_no.'" and item_id="'.$pr_data->item_id.'"';
db_query($import_update);
$total_amt +=$pr_data->invoice_amt;
}
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->foreign_purchase, $narration_cr, '0',$total_amt, $tr_from, $tr_no,$vendor_sub_ledger,$tr_id,$cc_code,$group_for);
sec_journal_journal($jv_no,$jv, $tr_from);

$import_update = 'update warehouse_other_receive set journal="Done" where or_no="'.$or_no.'"';
db_query($import_update);
$po_qty = find_a_field('warehouse_other_receive_detail','sum(qty)','or_no="'.$or_no.'"');
$pr_qty = find_a_field('lc_import','sum(qty)','import_no="'.$or_no.'"');

if($po_qty==$pr_qty){
 $master_update = 'update warehouse_other_receive set status="COMPLETED" where or_no="'.$or_no.'"';
 db_query($master_update);
}

$_SESSION['or_no'] = '';
$_SESSION['or_no'] = '';

header("Location:import_list.php");

}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

			foreach ($data as $key => $value)

		{ $$key=$value;}


		

}

if($delivery_within>0)

{

	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);

}

$pr_all = find_all_field('purchase_receive','','or_no="'.$_REQUEST['or_no'].'"');

?>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  

  

  <tr>

    <td colspan="5" valign="top">

	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>

       

        <td align="right" bgcolor="#9999FF"><strong>Receive Date :</strong></td>

        <td bgcolor="#9999FF"><strong>

          <input style="width:105px;"  name="rec_date" type="text" id="rec_date" value="<?=date('Y-m-d');?>" required/>
		  <input type="hidden" name="or_no" id="or_no" value="<?=$_GET['or_no']?>" />

        </strong></td>

      </tr>

    </table></td>

    </tr>

</table>

<? if($$unique>0){

$sql='select a.id,a.item_id,b.item_name,b.unit_name,a.qty,a.rate,a.or_no from warehouse_other_receive_detail a,item_info b where b.item_id=a.item_id and a.or_no='.$$unique;

$res=db_query($sql);

?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th>SL</th>

            <th width="45%">Item Name</th>

            <th bgcolor="#FFFFFF">Unit</th>

            <th bgcolor="#FF99FF">Import Qty</th>

            <th bgcolor="#009900">Received Qty </th>

            <th bgcolor="#FFFF00">UnRecevied Qty </th>

            <th bgcolor="#0099CC">Rec Qty</th>
			
			<th bgcolor="#0099CC">Action </th>

          </tr>

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?> <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>

            
              <td><?=$row->item_name?>

                <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" />
				<input type="hidden" name="or_no" id="or_no" value="<?=$row->or_no?>" />
				</td>

              <td width="7%" align="center"><?=$row->unit_name?>

                <input type="hidden" name="unit_name" id="unit_name" value="<?=$row->unit_name?>" />
				<input type="hidden" name="order_no_<?=$row->id?>" id="order_no_<?=$row->id?>" value="<?=$row->id?>" /></td>

              <td width="7%" align="center"><?=$row->qty?></td>

              <td width="6%" align="center"><span id="rcvd_qtty_<?=$row->id?>"><? echo $rec_qty = (find_a_field('lc_import','sum(qty)','import_no="'.$row->or_no.'" and item_id="'.$row->item_id.'"')*(1));?></span></td>

              <td width="7%" align="center"><span id="rest_qtty_<?=$row->id?>"><? echo $unrec_qty=($row->qty-$rec_qty);?></span>

                <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>

              <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center">
 <span id="s_check_<?=$row->id?>">
			 
			 </span>
			  <? if($unrec_qty>0){$cow++;?>
            
                <input name="qty_<?=$row->id?>" type="text" id="qty_<?=$row->id?>" style="width:200px; float:none" value=""  />

                <? } else echo 'Done';?></td>
				
				<td><input type="button" name="add_item" id="add_item" value="ADD" class="btn btn-warning" onclick="insert_item(<?=$row->id?>)" /></td>

              </tr>

          <? }?>

      </tbody>

      </table>

      </div>

      </td>
	  </tr>
	    <tr>
		    <td>&nbsp;</td>
		  </tr>

	  <tr>
	  
	  <td><div class="tabledesign2">
	  <span id="codzList">
	  <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th>SL</th>

            <th>Import No</th>
			
            <th>Item Name</th>

            
            <th bgcolor="#009900">Rec Qty</th>

          </tr>
		
          

          <? 
		      $res='select p.import_no,i.item_name,i.unit_name,p.qty as qty,i.unit_name as action from lc_import p,item_info i where i.item_id=p.item_id and p.import_no="'.$_REQUEST['or_no'].'"';
			 $qr = db_query($res);
		  while($row=mysqli_fetch_object($qr)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->import_no?></td>
			
			<td><?=$row->item_name?></td>

              <td><?=$row->qty?></td>

              
              </tr>

          <? }?>

      </tbody>

      </table>
	  </span>
	  </div>
	  </td>

    </tr>

  </table><br />

<table width="100%" border="0">

<? if($cow<1){

$vars['status']='COMPLETED';

db_update('sale_do_chalan', $or_no, $vars, 'or_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS PURCHASE ORDER IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input name="delete" type="button" class="btn btn-danger" value="CANCEL PURCHASE ORDER" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" onclick="window.location = 'select_dealer_chalan.php?del=1&or_no=<?=$or_no?>';" />

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn btn-info" value="RECEIVE CONFIRM" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" /></td>

</tr>

<? }?>

</table>

<? }?>

</form>

</div>
<script>
function insert_item(id){
var item1 = $("#item_id_"+id);
var qty = $("#qty_"+id);

<?php /*?>if(qty.val()==""){
	 alert('Please Enter Item Serial Number!');
	  return false;
  }<?php */?>

$.ajax({
url:"import_input_ajax.php",
method:"POST",
dataType:"JSON",

data:$("#codz").serialize(),

success: function(result, msg){
var res = result;

$("#codzList").html(res[0]);	
$("#qty_no_"+id).val('');

}
});	

  }


</script>

<script>
function check_serial(id){

$.ajax({
		url: "serial_check_ajax.php",
		method: "POST",
		dataType:"json",
		data:{
		qty: $("#qty_"+id).val(),
		or_no: $("#or_no").val(),
		item_id: $("#item_id_"+id).val()
		},
		success: function(data){

		$("#s_check_"+id).html(data.msg);
		$("#rest_qtty_"+id).html(data.rest_qty);
		$("#rcvd_qtty_"+id).html(data.rcv_qty);
		
		
		}
		})
}
</script>
<script>$("#codz").validate();$("#cloud").validate();</script>

<?
$tr_from="Purchase";
require_once SERVER_CORE."routing/layout.bottom.php";

?>