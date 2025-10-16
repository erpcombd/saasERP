<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Purchase Order';

//do_calander('#tdate');



 $quote_no=$_REQUEST['quote_no'];

 $invoice_no=$_REQUEST['request_no'];

 $data_found = $invoice_no;

if ($data_found==0) {
do_calander('#invoice_date');
do_calander('#quotation_deadline');
//create_combobox('vendor_id');
  }


if(prevent_multi_submit()){


if(isset($_POST['master_data'])){
	
	$status = 'MANUAL';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	
	
	$quote_no = $_POST['quote_no'];
	$view_quote_no = $_POST['view_quote_no'];
	$req_no = $_POST['req_no'];
	$view_req_no = $_POST['view_req_no'];
	$group_for = $_POST['group_for'];
	$warehouse_id = $_POST['warehouse_id'];
	$currency_type = $_POST['currency_type'];
	$vendor_id = $_POST['vendor_id'];
	$freight_charge = $_POST['freight_charge'];
	$invoice_date = $_POST['invoice_date'];
	
	
	
	
		$YR = date('Y',strtotime($invoice_date));
 		$year = date('y',strtotime($invoice_date));
  		$month = date('m',strtotime($invoice_date));
 		$inv_cy_id = find_a_field('purchase_foreign_master','max(inv_id)','year="'.$YR.'"')+1;
  		$cy_id = sprintf("%06d", $inv_cy_id);
   		$invoice_no=''.$year.''.$month.''.$cy_id;
		$view_invoice_no='PO-'.$year.''.$month.''.$cy_id;
	
	
	

	 
	 if($quote_no>0) {
	  $ins_sql = 'INSERT INTO purchase_foreign_master (invoice_no, year, inv_id, view_invoice_no, invoice_date, group_for, warehouse_id, req_no, view_req_no, currency_type, vendor_id,  status, entry_at, entry_by, freight_charge, quote_no, view_quote_no) VALUES

("'.$invoice_no.'", "'.$YR.'", "'.$cy_id.'", "'.$view_invoice_no.'", "'.$invoice_date.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$req_no.'", "'.$view_req_no.'", "'.$currency_type.'", "'.$vendor_id.'", 
 "'.$status.'", "'.$entry_at.'", "'.$entry_by.'", "'.$freight_charge.'", "'.$quote_no.'", "'.$view_quote_no.'")';
	
	db_query($ins_sql);
	}
	
	
	
	 $sql_trm = 'select * from terms_conditions where 1 order by id';

		$query_trm = db_query($sql_trm);

		while($data_trm=mysqli_fetch_object($query_trm))

		{
			
  $trm_invoice = 'INSERT INTO purchase_terms_conditions (invoice_no, tearms, terms_conditions, entry_by, entry_at)
  
  VALUES("'.$invoice_no.'", "'.$data_trm->tearms.'", "'.$data_trm->terms_conditions.'", "'.$entry_by.'", "'.$entry_at.'")';

db_query($trm_invoice);

}

	
	
	

	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php?request_no=<?=$invoice_no?>";
</script>

<? 
		
}







if(isset($_POST['confirm'])){
	
	$status = 'CHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	
	$quote_no = $_POST['quote_no'];
	$view_quote_no = $_POST['view_quote_no'];
	$req_no = $_POST['req_no'];
	$view_req_no = $_POST['view_req_no'];
	$group_for = $_POST['group_for'];
	$warehouse_id = $_POST['warehouse_id'];
	$currency_type = $_POST['currency_type'];
	$invoice_date = $_POST['invoice_date'];
	$vendor_id = $_POST['vendor_id'];
	
	
	$invoice_no = $_POST['invoice_no'];
	$view_invoice_no = $_POST['view_invoice_no'];
	
	
	 $sql = 'select a.*, s.sub_group_name, i.finish_goods_code, i.item_name, i.unit_name from purchase_quotation_details a, item_info i, item_sub_group s where i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.invoice_no="'.$quote_no.'" order by a.id';

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{

			if($_POST['total_unit_'.$data->id]>0)

			{
			
				$order_no=$_POST['order_no_'.$data->id];
				$req_order_no=$_POST['req_order_no_'.$data->id];
				$rfq_qty=$_POST['rfq_qty_'.$data->id];
				$unit_price=$_POST['unit_price_'.$data->id];
				$total_unit=$_POST['total_unit_'.$data->id];
				$total_amt=$unit_price*$total_unit;
				$item_id=$_POST['item_id_'.$data->id];
		

  $foe_invoice = 'INSERT INTO purchase_foreign_details (invoice_no, view_invoice_no, invoice_date, group_for, warehouse_id, req_no, quote_no, currency_type, vendor_id, order_no, req_order_no, item_id, unit_name, rfq_qty, unit_price, total_unit, total_amt, status, entry_at, entry_by)
  
  VALUES("'.$invoice_no.'", "'.$view_invoice_no.'", "'.$invoice_date.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$req_no.'", "'.$quote_no.'", "'.$currency_type.'", "'.$vendor_id.'", "'.$order_no.'", "'.$req_order_no.'", "'.$item_id.'", "'.$data->unit_name.'", "'.$rfq_qty.'", "'.$unit_price.'", "'.$total_unit.'", "'.$total_amt.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';

db_query($foe_invoice);


	

}

}
	

	
	
	$con_sql1="UPDATE purchase_foreign_master SET status='".$status."', checked_by='".$entry_by."', checked_at='".$entry_at."' WHERE invoice_no = '".$invoice_no."' ";
	 db_query($con_sql1);
	 
	
	 
	 
	 ?>

<script language="javascript">
window.location.href = "create_po.php";
</script>

<? 
		
}






if(isset($_POST['delete'])){
	
	$status = 'CHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
		
	$invoice_no = $_POST['invoice_no'];
	
	
	$sql_del_ms = 'delete from purchase_foreign_master where  invoice_no="'.$invoice_no.'"';
	db_query($sql_del_ms);
	
	$sql_del_foe = 'delete from purchase_foreign_details where invoice_no="'.$invoice_no.'"';
	db_query($sql_del_foe);

	 ?>

<script language="javascript">
window.location.href = "create_po.php";
</script>

<? 
		
}







}








?>

<script>



function getXMLHTTP() { //fuction to return the xml http object



		var xmlhttp=false;	



		try{



			xmlhttp=new XMLHttpRequest();



		}



		catch(e)	{		



			try{			



				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){



				try{



				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");



				}



				catch(e1){



					xmlhttp=false;



				}



			}



		}



		 	



		return xmlhttp;



    }
	
	
	function count()
{


//if(document.getElementById('unit_price').value!=''){}


var rate = ((document.getElementById('rate').value)*1);

//var total_unit = (document.getElementById('total_unit').value) = pkt_unit*pkt_size;

var qty = ((document.getElementById('qty').value)*1);

var amount = (document.getElementById('amount').value) = rate*qty;

}


	
	

function TRcalculation(order_no){

var po_qty = document.getElementById('po_qty_'+order_no).value*1;

var unit_price = document.getElementById('unit_price_'+order_no).value*1;

var adj_qty = document.getElementById('adj_qty_'+order_no).value*1;

var adj_amt = document.getElementById('adj_amt_'+order_no).value= (unit_price*adj_qty);

 if(po_qty<adj_qty)
  {
alert('You can`t reduce the qty');
document.getElementById('adj_qty_'+order_no).value='';
document.getElementById('adj_amt_'+order_no).value='';
  } 

}




function TRcalculationpo(order_no){

var rate = document.getElementById('rate_'+order_no).value*1;

var qty = document.getElementById('qty_'+order_no).value*1;


var amount = document.getElementById('amount_'+order_no).value= (rate*qty);



}



	function update_value(order_no)



	{

var order_no=order_no; // Rent

var item_id=(document.getElementById('item_id_'+order_no).value);

var batch_qty=(document.getElementById('batch_qty_'+order_no).value);
var total_unit=(document.getElementById('total_unit_'+order_no).value);
//var amount=(document.getElementById('amount_'+order_no).value);
var flag=(document.getElementById('flag_'+order_no).value); 

var strURL="item_revise_ajax.php?order_no="+order_no+"&item_id="+item_id+"&batch_qty="+batch_qty+"&total_unit="+total_unit+"&flag="+flag;

		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+order_no).style.display='inline';

						document.getElementById('divi_'+order_no).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	



}






function SUMcalculation(ledger_id){
//var unit_price = (document.getElementById('unit_price_'+item_id).value)*1;
var foe_amt = (document.getElementById('foe_amt_'+ledger_id).value)*1;
//document.getElementById('foe_amt_'+item_id).value = unit_price*qty;

var foe_amt = 0;

<?

	$sql = "select l.group_name, a.ledger_id, a.ledger_name
	from ledger_group l, accounts_ledger a where l.group_id=a.ledger_group_id and a.ledger_group_id=411010
	order by l.group_id, a.ledger_id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
?>
foe_amt = foe_amt + document.getElementById('foe_amt_<?=$data->ledger_id?>').value*1;;
<?
}

?>

document.getElementById('foe_amt').value = foe_amt;

}








</script>






<style>



div.form-container_large input {
    width: 220px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">


<form action="" method="post" name="codz" id="codz">

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table   style="width:100%; border:0; border-collapse:collapse; padding:0;">

								  <tr>



    <td   style="width:8%; text-align:right;"><strong> QUOTE  No: </strong></td>



    <td   style="width:13%;">
	<? $qut_data = find_all_field('purchase_quotation_master','','invoice_no="'.$quote_no.'"'); ?>
	
	<input name="quote_no" type="hidden" id="quote_no" style="width:90%; height:32px;" value="<?=$qut_data->invoice_no;?>" readonly="" required tabindex="1" />
	<input name="req_no" type="hidden" id="req_no" style="width:90%; height:32px;" value="<?=$qut_data->req_no;?>" readonly="" required tabindex="1" />
	<input name="warehouse_id" type="hidden" id="warehouse_id" style="width:90%; height:32px;" value="<?=$qut_data->warehouse_id;?>" readonly="" required tabindex="1" />
	<input name="view_req_no" type="hidden" id="view_req_no" style="width:90%; height:32px;" value="<?=$qut_data->view_req_no;?>" readonly="" required tabindex="1" />
	
	<a href="../QUOTATION/invoice_print_view.php?invoice_no=<?=$quote_no;?>" target="_blank"><input name="view_quote_no" type="text" id="view_quote_no" style="width:90%; height:32px;" value="<?=$qut_data->view_invoice_no;?>" readonly="" required tabindex="1" /></a>	</td>
	
	 <td  style="width:11%; text-align:right;"><strong>  Company: </strong></td>
	 <td sytle="width:20%;" >
	 
	 <select name="group_for" id="group_for"  style="width:90%; height:32px;" required>

		<? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id="'.$qut_data->group_for.'"');?>

      </select></td>
	 <td   style="width:17%; text-align:right;"><strong>Currency Type: </strong></td>
	 <td  style="width:16%;" >
	 <input name="currency_type" type="text" id="currency_type" style="width:90%; height:32px;" value="<?=$qut_data->currency_type;?>" readonly="" required tabindex="1" />
	 </td>
	 <td rowspan="8" style="width:15%; text-align:center;" ><strong>

     <input type="submit" name="master_data" id="master_data" value="Initiate Entry" style="width:160px; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>

    </strong></td>
    </tr>
								  <tr>
								    <td style="text-align:right;" ><strong>PO Date:</strong></td>
								    <td >
									<input name="invoice_date" type="text" id="invoice_date" style="width:90%; height:32px;" value="<?=$invoice_date;?> " required tabindex="1" />
									</td>
								    <td style="text-align:right;"><strong> Vendor: </strong></td>
								    <td >
									<select name="vendor_id" id="vendor_id"  style="width:90%; height:32px;" required>
									

										<? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],'vendor_id="'.$qut_data->vendor_id.'"');?>

      								</select>
									</td>
								    <td   style="text-align:right;" ><strong>Freight Charge:</strong>  </td>
								    <td ><input name="freight_charge" type="text" id="freight_charge" style="width:90%; height:32px;" value="<?=$freight_charge;?> " required tabindex="1" /></td>
							      </tr>
								</table>

</div>


<? }?>



<? if ($data_found>0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%; border:0 border-collapse:collapse; padding:0;">

								  <tr>



    <td style="width:11%; text-align:right;" ><strong> PO  No: </strong></td>



    <td width="16%" >
	<? $ms_data = find_all_field('purchase_foreign_master','','invoice_no="'.$_REQUEST['request_no'].'"'); ?>
	 
	<input name="invoice_no" type="hidden" id="invoice_no" style="width:90%; height:32px;" value="<?=$ms_data->invoice_no;?>" readonly="" required tabindex="1" />
	<input name="req_no" type="hidden" id="req_no" style="width:90%; height:32px;" value="<?=$ms_data->req_no;?>" readonly="" required tabindex="1" />
	<input name="quote_no" type="hidden" id="quote_no" style="width:90%; height:32px;" value="<?=$ms_data->quote_no;?>" readonly="" required tabindex="1" />
	<input name="group_for" type="hidden" id="group_for" style="width:90%; height:32px;" value="<?=$ms_data->group_for;?>" readonly="" required tabindex="1" />
	<input name="warehouse_id" type="hidden" id="warehouse_id" style="width:90%; height:32px;" value="<?=$ms_data->warehouse_id;?>" readonly="" required tabindex="1" />
	
	<input name="view_invoice_no" type="text" id="view_invoice_no" style="width:90%; height:32px;" value="<?=$ms_data->view_invoice_no;?>" readonly="" required tabindex="1" /></td>
	
	 <td  style="width:13%; text-align:right;"><strong>QUOTE No: </strong></td>
	 <td  style="width:24%; text-align:right;"><a href="../QUOTATION/invoice_print_view.php?invoice_no=<?=$ms_data->quote_no;?>" target="_blank">
	<input name="view_quote_no" type="text" id="view_quote_no" style="width:90%; height:32px;" value="<?=$ms_data->view_quote_no;?>" readonly="" required tabindex="1" /></a>	</td>
	 <td  style="width="15%";text-align:right;"><strong>Currency:</strong></td>
	 <td style="width=21%;">
	<select name="currency_type" id="currency_type"  style="width:90%; height:32px;" required>
	

		<? foreign_relation('currency_type','currency_type','currency_type',$_POST['currency_type'],'currency_type="'.$ms_data->currency_type.'"');?>

      </select> </td>
	 </tr>
								  <tr>
								    <td style="text-align:right; width:11%;"  ><strong> PO Date: </strong></td>
								    <td  style="width:16%;" >
									<input name="invoice_date" type="text" id="invoice_date" style="width:90%; height:32px;" value="<?=$ms_data->invoice_date?>" required readonly="" tabindex="1" />
							
									</td>
								    <td style="text-align:right; width:13%;" ><strong> Vendor: </strong></td>
								    <td  style="text-align:right; width:24%;">
									
									<select name="vendor_id" id="vendor_id"  style="width:90%; height:32px;" required>
									
										<? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],'vendor_id="'.$ms_data->vendor_id.'"');?>

      								</select>
									</td>
								    <td style="text-align:right; width:15%;" ><strong>Freight Charge:</strong></td>
								    <td width="21%">
									<input name="freight_charge" type="text" id="freight_charge" style="width:90%; height:32px;" value="<?=$ms_data->freight_charge;?> " readonly=""  tabindex="1" /></td>
							      </tr>
								</table>

</div>


<div class="tabledesign2" style="width:100%">




<table id="grp"  style="width:100%; border:0; border-collapse:collapse; padding:0; text-align:center; font-size:12px; text-transform:uppercase;">

  <tr>
    <th style="width:14%;">Category</th>
    <th style="width:35%;">Item Name</th>
    <th style="width:10%;">Unit Name </th>
    <th style="width:13%;">RFQ Qty </th>
    <th style="width:12%;">Each Price in <?=$ms_data->currency_type;?></th>
    <th style="width:16%;">PO Qty </th>
  </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}
  



    if($_POST['po_date']!=''){
	$po_dt_con=" and m.po_date='".$_POST['po_date']."'";}
	
	
	




		
		

     $sqlfg = "select a.*, s.sub_group_name, i.finish_goods_code, i.item_name, i.unit_name from purchase_quotation_details a, item_info i, item_sub_group s where i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.invoice_no='".$ms_data->quote_no."' order by a.id";

  $queryfg = db_query($sqlfg);

  while($datafg=mysqli_fetch_object($queryfg)){$i++;


  ?>



<? //if($po_no[$data->po_no]==0) { } ?>

  <tr style="background-color: <?= ($i % 2) ? '#F5F5F5' : '#fff'; ?>;">
    <td><?= htmlspecialchars($datafg->sub_group_name) ?></td>
    <td><?= htmlspecialchars($datafg->item_name) ?></td>
    <td style="background-color:#99CCFF;"><?= htmlspecialchars($datafg->unit_name) ?></td>
    <td style="background-color:#99CCFF;">
        <input type="hidden" name="order_no_<?= $datafg->id ?>" id="order_no_<?= $datafg->id ?>" value="<?= $datafg->id ?>">
        <input type="hidden" name="req_order_no_<?= $datafg->id ?>" id="req_order_no_<?= $datafg->id ?>" value="<?= $datafg->req_order_no ?>">
        <input type="hidden" name="item_id_<?= $datafg->id ?>" id="item_id_<?= $datafg->id ?>" value="<?= $datafg->item_id ?>">
        <input type="text" name="rfq_qty_<?= $datafg->id ?>" id="rfq_qty_<?= $datafg->id ?>"
               value="<?= $datafg->rfq_qty ?>" 
               onkeyup="TRcalculationpo(<?= $data->id ?>)" 
               readonly 
               class="input-box">
    </td>
    <td style="background-color:#99CCFF;">
        <input type="text" name="unit_price_<?= $datafg->id ?>" id="unit_price_<?= $datafg->id ?>" 
               value="<?= $datafg->unit_price ?>" 
               readonly 
               class="input-box">
    </td>
    <td style="background-color:#99CCFF;">
        <input type="text" name="total_unit_<?= $datafg->id ?>" id="total_unit_<?= $datafg->id ?>" 
               value="" 
               class="input-box">
    </td>
</tr>

  

  <? } ?>
</table>
</div>



<? }?>
<br />



<? if($data_found>0){ ?>


<br /><br />




<table width="100%" border="0">





<? if($bill_data->status!="COMPLETED") {?>
<tr>

<td align="center">&nbsp;
<input name="delete" type="submit" class="btn1" value="DELETE" style="width:200px; font-weight:bold; float:left; font-size:12px; height:30px; background:#FF0000;color: #000000; border-radius:50px 20px;" />
</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" /></td>

</tr>
<? }?>


</table>







<? }?>








<p>&nbsp;</p>

</form>

</div>



<?

// $main_content=ob_get_contents();

// ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>