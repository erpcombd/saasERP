<?php

 
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$c_id = $_SESSION['proj_id'];
$title='Competitive Sourcing';

//do_calander('#tdate');

$check_cogigure=find_all_field('quotation_setup','*','1');

 $invoice_no=$_REQUEST['req_no'];

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
	
	
	$req_no = $_POST['req_no'];
	$view_req_no = $_POST['view_req_no'];
	
	$group_for = $_POST['group_for'];
	$warehouse_id = $_POST['warehouse_id'];
	$currency_type = $_POST['currency_type'];
	$vendor_id = $_POST['vendor_id'];
	
	$invoice_date = $_POST['invoice_date'];
	
	
	
	
		$YR = date('Y',strtotime($invoice_date));
 		$year = date('y',strtotime($invoice_date));
  		$month = date('m',strtotime($invoice_date));
 		$inv_cy_id = find_a_field('purchase_quotation_master','max(inv_id)','year="'.$YR.'"')+1;
  		$cy_id = sprintf("%06d", $inv_cy_id);
   		$invoice_no=''.$year.''.$month.''.$cy_id;
		$view_invoice_no='QUT-'.$year.''.$month.''.$cy_id;
	
	
	

	//$tr_no = date('ymd',strtotime($tr_date));
//	
//	$lot_cy_id = find_a_field('import_purchase_details','max(lot_id)','tr_no="'.$tr_no.'"')+1;
//		
//   	$cy_id = sprintf("%04d", $lot_cy_id);
//	
//   	 $lot_no_generate='LOT'.$tr_no.''.$cy_id;
	 
	 if($req_no>0) {
	  $ins_sql = 'INSERT INTO purchase_quotation_master (invoice_no, year, inv_id, view_invoice_no, invoice_date, group_for, warehouse_id, req_no, view_req_no, currency_type, vendor_id,  status, entry_at, entry_by) VALUES

("'.$invoice_no.'", "'.$YR.'", "'.$cy_id.'", "'.$view_invoice_no.'", "'.$invoice_date.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$req_no.'", "'.$view_req_no.'", "'.$currency_type.'", "'.$vendor_id.'", 
 "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';
	
	db_query($ins_sql);
	}
	
	
	
	

	 
	 ?>

<script language="javascript">
window.location.href = "invoice_entry.php?request_no=<?=$invoice_no?>";
</script>

<? 
		
}







if(isset($_POST['confirm'])){
	
	$status = 'UNCHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
	
	
	$req_no = $_POST['req_no'];
	$view_req_no = $_POST['view_req_no'];
	$group_for = $_POST['group_for'];
	$warehouse_id = $_POST['warehouse_id'];
	$currency_type = $_POST['currency_type'];
	$invoice_date = $_POST['invoice_date'];
	$vendor_id = $_POST['vendor_id'];
	
	
	$invoice_no = $_POST['invoice_no'];
	$view_invoice_no = $_POST['view_invoice_no'];
	
	
	 $sql = 'select a.*, s.sub_group_name, i.finish_goods_code, i.item_name, i.unit_name from requisition_order a, item_info i, item_sub_group s where i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.req_no="'.$req_no.'" order by a.id';

		$query = db_query($sql);

		while($data=mysqli_fetch_object($query))

		{

			if($_POST['unit_price_'.$data->id]>0)

			{
			
				$order_no=$_POST['order_no_'.$data->id];
				$unit_price=$_POST['unit_price_'.$data->id];
				$total_unit=$_POST['total_unit_'.$data->id];
				$item_id=$_POST['item_id_'.$data->id];
				$req_qty=$_POST['req_qty_'.$data->id];
				
				$last_po_no=$_POST['last_po_no_'.$data->id];
				$last_po_id=$_POST['last_po_id_'.$data->id];
		

  $foe_invoice = 'INSERT INTO purchase_quotation_details (invoice_no, view_invoice_no, invoice_date, group_for, warehouse_id, req_no,  currency_type, vendor_id, order_no,  item_id, unit_name, unit_price, total_unit, status, entry_at, entry_by, item_type, count_type, req_qty, country_origin, last_po_no, last_po_id)
  
  VALUES("'.$invoice_no.'", "'.$view_invoice_no.'", "'.$invoice_date.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$req_no.'",  "'.$currency_type.'", "'.$vendor_id.'", "'.$order_no.'",  "'.$item_id.'", "'.$data->unit_name.'", "'.$unit_price.'", "'.$total_unit.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'", "'.$data->item_type.'", "'.$data->count_type.'", 
  "'.$req_qty.'",  "'.$data->country_origin.'", "'.$last_po_no.'", "'.$last_po_id.'")';

db_query($foe_invoice);


}

}
	

	
	
	$con_sql1="UPDATE purchase_quotation_master SET status='".$status."', checked_by='".$entry_by."', checked_at='".$entry_at."' WHERE invoice_no = '".$invoice_no."' ";
	 db_query($con_sql1);
	 
	
	 
	 
	 ?>

<script language="javascript">
window.location.href = "create_quotation.php";
</script>

<? 
		
}






if(isset($_POST['delete'])){
	
	$status = 'CHECKED';
	$entry_by = $_SESSION['user']['id'];
	$entry_at=date('Y-m-d H:i:s');
		
	$invoice_no = $_POST['invoice_no'];
	
	
	$sql_del_ms = 'delete from purchase_quotation_master where  invoice_no="'.$invoice_no.'"';
	db_query($sql_del_ms);
	
	$sql_del_foe = 'delete from purchase_quotation_details where invoice_no="'.$invoice_no.'"';
	db_query($sql_del_foe);

	 ?>

<script language="javascript">
window.location.href = "create_quotation.php";
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
	

	



function TRcalculationpo(order_no){

var rate = document.getElementById('rate_'+order_no).value*1;

var qty = document.getElementById('qty_'+order_no).value*1;


var amount = document.getElementById('amount_'+order_no).value= (rate*qty);

// if(po_qty<adj_qty)
//  {
//alert('You can`t reduce the qty');
//document.getElementById('adj_qty_'+order_no).value='';
//document.getElementById('adj_amt_'+order_no).value='';
//  } 

}



	function update_value(order_no)
	{
var order_no=order_no; // Rent

var item_id=(document.getElementById('item_id_'+order_no).value);
var rate=(document.getElementById('unit_price'+order_no).value);
var prev_rate=0;
var flag=(document.getElementById('flag_'+order_no).value); 
var strURL="quotation_cs_ajax.php?order_no="+order_no+"&item_id="+item_id+"&flag="+flag+"&rate="+rate+"&prev_rate="+prev_rate;
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

	function update_value_return(order_no)
	{
var order_no=order_no; // Rent

var item_id=(document.getElementById('item_id_'+order_no).value);
var rate=(document.getElementById('unit_price'+order_no).value);
var prev_rate=(document.getElementById('prev_unit_price'+order_no).value);
 var return_note = prompt("Please enter Return note for order " + order_no + ":");
     // If user pressed Cancel, stop here
    if (return_note === null) {
        return;
    }

var flag=(document.getElementById('flag_'+order_no).value); 
var strURL="quotation_cs_return_ajax.php?order_no="+order_no+"&item_id="+item_id+"&flag="+flag+"&rate="+rate+"&prev_rate="+prev_rate+"&return_note="+return_note;
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
</script>






<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 220px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">


<form action="" method="post" name="codz" id="codz">




<? if ($data_found>0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>


    <td width="19%" align="right"><strong>REQ No: </strong></td>
	 <td width="26%" align="right">
	 <? $ms_data = find_all_field('requisition_master','','req_no="'.$_REQUEST['req_no'].'"'); ?>
	 
	<input name="invoice_no" type="hidden" id="invoice_no" style="width:90%; height:32px;" value="<?=$ms_data->invoice_no;?>" readonly="" required tabindex="1" />
	
	<input name="warehouse_id" type="hidden" id="warehouse_id" style="width:90%; height:32px;" value="<?=$ms_data->warehouse_id;?>" readonly="" required tabindex="1" />
	 
	 
	 <a href="../../warehouse_mod/mr/mr_print_view.php?req_no=<?=$ms_data->req_no;?>" target="_blank">
	<input name="view_req_no" type="text" id="view_req_no" style="width:90%; height:32px;" value="<?=$ms_data->req_no;?>" readonly="" required tabindex="1" /></a>	</td>
	 <td width="19%" align="right"><strong>Company: </strong></td>
	 <td width="36%" >
	<select name="group_for" id="group_for"  style="width:90%; height:32px;" required>

		<? foreign_relation('user_group','id','company_name',$_POST['group_for'],'id="'.$ms_data->group_for.'"');?>
      </select> </td>
	 </tr>
								  <tr>
								    <td align="right" width="19%"><strong>REQ Date: </strong></td>
								    <td width="26%" align="right">
									
									<input name="invoice_date" type="text" id="invoice_date" style="width:90%; height:32px;" value="<?=$ms_data->req_date;?>" readonly="" required tabindex="1" />									</td>
								    <td align="right" width="19%"><strong>Warehouse:</strong></td>
								    <td width="36%"><select name="warehouse_id" id="warehouse_id"  style="width:90%; height:32px;" required>
	
								
										<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$ms_data->warehouse_id.'"');?>
								
									  </select></td>
							      </tr>
								</table>

</div>


<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr style="font-weight:bold;">
    <td width="5%" rowspan="2" bgcolor="lightgreen">Category</td>

    <td width="21%" rowspan="2" bgcolor="lightgreen">Item Name</td>
  <td width="11%" rowspan="2" bgcolor="lightgreen">Item Specification</td>
   <!--  <td width="6%" rowspan="2" bgcolor="lightgreen">Count</td>-->
    <td width="3%" rowspan="2" bgcolor="lightgreen">Unit  </td>
<!--    <td width="7%" rowspan="2" bgcolor="lightgreen">Country of Origin</td>-->
    <td colspan="4" bgcolor="lightgreen"><div align="center"><strong>Last Purchase info </strong></div></td>
    <td width="6%" rowspan="2" bgcolor="lightgreen">REQ Qty </td>
    </tr>
  <tr style="font-weight:bold;">
    <td width="7%" bgcolor="lightgreen">PO Date </td>
    <td width="3%" bgcolor="lightgreen">PO Rate </td>
    <td width="5%" bgcolor="lightgreen">PO Qty </td>
    <td width="11%" bgcolor="lightgreen">Vendor</td>
  </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
		//if($_POST['dealer_code']!='')
// 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
//		
//		if($_POST['do_no']!='') 
//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';


    if($_POST['po_date']!='')
	$po_dt_con=" and m.po_date='".$_POST['po_date']."'";
	
	
 
 
		
		/*$sql = "select id, po_no, po_date, rate, qty, vendor_id,item_id from purchase_invoice where 1 group by item_id order by id desc";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $view_invoice_no[$info->item_id]=$info->po_no;
		 $invoice_date[$info->item_id]=$info->po_date;
		 $unit_price[$info->item_id]=$info->rate;
		 $total_unit[$info->item_id]=$info->qty;
		 $vendor_id[$info->item_id]=$info->vendor_id;
		}
		
		$sql = "select vendor_id, vendor_name from vendor where 1 group by vendor_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $vendor_name[$info->vendor_id]=$info->vendor_name;
		}*/
		
		
		
		$sql = "select id,item_id, po_no, po_date, rate, qty, vendor_id from purchase_invoice where 1 group by item_id order by id desc";
		 $query = db_query($sql);
	
		 while($info=mysqli_fetch_object($query)){
	 
  		  $view_invoice_no[$info->item_id]=$info->po_no;
		 $invoice_date_get[$info->item_id]=$info->po_date;
		  $unit_price[$info->item_id]=$info->rate;
		 $total_unit[$info->item_id]=$info->qty;
		 $vendor_id[$info->item_id]=$info->vendor_id;
		}
		
		 $sql2 = "select vendor_id, vendor_name from vendor where 1 group by vendor_id";
		 $query2 = db_query($sql2);
		 while($vinfo=mysqli_fetch_object($query2)){
  		  $vendor_namee[$vinfo->vendor_id]=$vinfo->vendor_name;
		}
		
		

      $sqlfg = "select a.*, s.sub_group_name, i.finish_goods_code, i.item_name, i.unit_name from requisition_order a, item_info i, item_sub_group s where i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.req_no='".$ms_data->req_no."' order by a.id";

  $queryfg = db_query($sqlfg);

  while($datafg=mysqli_fetch_object($queryfg)){$i++;


  ?>



<? //if($po_no[$data->po_no]==0) { } ?>

  <tr>
    <td bgcolor="lightblue"><?=$datafg->sub_group_name?></td>

    <td bgcolor="lightblue"> <?=$datafg->item_name?> </td>
<!--    <td bgcolor="lightblue"><?=$item_type[$datafg->item_type]?></td>
    <td bgcolor="lightblue"><?=$count_type[$datafg->count_type]?></td>-->
	<td bgcolor="lightblue"><?=$datafg->specification?></td>
    <td bgcolor="lightblue"><?=$datafg->unit_name?></td>
<!--    <td bgcolor="lightblue"><?=$datafg->country_origin	;?></td>-->
   <td bgcolor="#99CCFF"><?php  if($invoice_date_get[$datafg->item_id]!=''){echo date("d-M-y",strtotime($invoice_date_get[$datafg->item_id]));}else{'';}   ?></td>
    <td bgcolor="#99CCFF"><?= $unit_price[$datafg->item_id];?></td>
    <td bgcolor="#99CCFF"><?= $total_unit[$datafg->item_id];?></td>
    <td bgcolor="#99CCFF"><?= $vendor_namee[$vendor_id[$datafg->item_id]]?></td>
    <td bgcolor="lightblue">
<input name="req_qty_<?=$datafg->id?>" type="text" id="req_qty_<?=$datafg->id?>" value="<?=$datafg->qty;?>" onkeyup="TRcalculationpo(<?=$data->id?>)" readonly="" style="width:80px; height:30px; " /></td>
 </tr>
 
 <tr>
 <td colspan="11">
 	<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">
  <tr>
  	<td width="10%" bgcolor="#FFFF99"><strong>Quotation No</strong></td>
    <td width="40%" bgcolor="#FFFF99"><strong>Vendor Name</strong></td>
	<td width="20%" bgcolor="#FFFF99"><strong>Product Specification</strong></td>
    <td width="16%" bgcolor="#FFFF99"><strong>Currency</strong></td>
    <td width="40%" bgcolor="#FFFF99"><strong>Each Price</strong></td>
	<td width="16%" bgcolor="#FFFF99"><strong>Req Quantity</strong></td>
	<td width="16%" bgcolor="#FFFF99"><strong>Amount</strong></td>
	 <td width="15%" bgcolor="#FFFF99"><strong>Remarks</strong></td>
	 
	   <td width="15%" bgcolor="#FFFF99"><strong>Revised Note</strong></td>
    <td width="18%" bgcolor="#FFFF99"><strong>Action  </strong></td>
  </tr>
  
<?



     $sqlq = "select a.*, s.sub_group_name, i.finish_goods_code, i.item_name, i.unit_name,a.return_status from purchase_quotation_details a, purchase_quotation_master m, item_info i, item_sub_group s where a.invoice_no=m.invoice_no and m.status NOT IN ('AC_Approval_Pending', 'MANUAL') and i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.req_no='".$ms_data->req_no."' and a.item_id='".$datafg->item_id."' order by a.id";

  $queryq = db_query($sqlq);

  while($dataq=mysqli_fetch_object($queryq)){


  ?>

<tr>


	<?php /*?><td><a style="color: green;background-color: transparent; text-decoration: underline;" href="../QUOTATION/invoice_print_view_all.php?invoice_no=<?=$dataq->invoice_no?>"><?=$dataq->invoice_no?></a>  </td>
	<?php */?>
	
		<td>
  <a style="color: green; background-color: transparent; text-decoration: underline;" 
     href="../QUOTATION/invoice_print_view_all.php?c=<?= rawurlencode(url_encode($c_id)) ?>&v=<?= rawurlencode(url_encode($dataq->invoice_no)) ?>">
     <?= $dataq->invoice_no ?>
  </a>
</td>

	
	
    <td>
	<input name="order_no_<?=$dataq->id?>" type="hidden" id="order_no_<?=$dataq->id?>" value="<?=$dataq->id?>" />
    <input name="item_id_<?=$dataq->id?>" type="hidden" id="item_id_<?=$dataq->id?>" value="<?=$dataq->item_id?>" /> 
	 <span style="font-weight: 700;"><?=$vendor_namee[$dataq->vendor_id];?></span> <br />
	 <?
	 $special_note = find_a_field('purchase_quotation_master','add_note','invoice_no="'.$dataq->invoice_no.'"');
	  if($special_note !=''){ ?>
	(Note: <?=$special_note;?>)
	<? } else{ echo '';} ?>
	 </td>
	<td><?=$dataq->vendor_specification?> </td>
    <td><?=$dataq->currency_type?> </td>
    <td>
	<?php if($check_cogigure->rate_revise_status=="Enable") { ?>	
	<input type="text" name="unit_price<?=$dataq->id?>" id="unit_price<?=$dataq->id?>" value="<?=$dataq->unit_price?>" />
	<?php } else{?>
	<input type="text" name="unit_price<?=$dataq->id?>" id="unit_price<?=$dataq->id?>" value="<?=$dataq->unit_price?>" readonly/>
	<?php } ?>
		<input type="hidden" name="prev_unit_price<?=$dataq->id?>" id="prev_unit_price<?=$dataq->id?>" value="<?=$dataq->unit_price?>" />
	<?php if($check_cogigure->return_status=="Enable") { ?>	<a href="rate_history.php?quotation_no=<?php echo $dataq->invoice_no;?>" target="_blank"><input type="button" class="btn btn-success" value="View History" style="max-width:15px;padding:2px!important;" /></a>
	<?php } ?>
	</td>
	<td><?=$dataq->req_qty?></td>
	<td><?=$dataq->unit_price*$dataq->req_qty?></td>
	 <td><?=$dataq->remarks?></td>
	 <td><?=$dataq->revised_note?></td>
    <td >
	<?php 
	if($dataq->return_status==0){
	?>
	<? if($dataq->app_status==1) {?>
	<center><b>Approved!</b></center>
	<? }else {?>
	<span id="divi_<?=$dataq->id?>">
	<input name="flag_<?=$dataq->id?>" type="hidden" id="flag_<?=$dataq->id?>" value="1" />

<input type="button" name="Button" value="APPROVE"  onclick="update_value(<?=$dataq->id?>)" style="width:75px; font-size:10px; height:26px; background-color:#2ecc71; font-weight:700;"/>
	<?php if($check_cogigure->return_status=="Enable") { ?>
			<input type="button" name="return" value="Return to Revise"  onclick="update_value_return(<?=$dataq->id?>)" style="width:75px; font-size:10px; height:26px; background-color:red; font-weight:700;"/>
	<?php } ?>
	
    </span><? }
	} else {
	?>	
	<center><b>Return For Revised</b></center>
	<?php } ?>
	</td>
  </tr>

<? }?>
 </table>
	  <br /><br />
 </td>
</tr>

   


  <?  }?>
</table>
</div>



<? }?>


</form>

</div>



<?
 

require_once SERVER_CORE."routing/layout.bottom.php";

?>