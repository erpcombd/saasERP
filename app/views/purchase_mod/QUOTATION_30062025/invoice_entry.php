<?php
 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$title='Maintain Quotation';

//do_calander('#tdate');

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);


$req_no=$_REQUEST['req_no'];

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
	
	
	$req_no = $_POST['req_no'];
	$view_req_no = $_POST['view_req_no'];

	
	$folder ='maintain_quotation';
	$field = 'file_upload';
	$file_name = $field.'-'.$_POST['req_no'];
	if($_FILES['file_upload']['tmp_name']!=''){
	$_POST['file_upload']=upload_file($folder,$field,$file_name);
	}
	$file_upload = $_POST['file_upload'];
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
	  $ins_sql = 'INSERT INTO purchase_quotation_master (invoice_no, year, inv_id, view_invoice_no, invoice_date, group_for, warehouse_id, req_no, view_req_no, currency_type, vendor_id,  status, entry_at, entry_by, file_upload) VALUES

("'.$invoice_no.'", "'.$YR.'", "'.$cy_id.'", "'.$view_invoice_no.'", "'.$invoice_date.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$req_no.'", "'.$view_req_no.'", "'.$currency_type.'", "'.$vendor_id.'", 
 "'.$status.'", "'.$entry_at.'", "'.$entry_by.'", "'.$file_upload.'")';
	
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
	

	
	// $field = 'file_upload';
	// $file_name = $field.'-'.$_POST['req_no'];
	// if($_FILES['file_upload']['tmp_name']!=''){
	// $_POST['file_upload']=upload_file($folder,$field,$file_name);
	// }
	// $file_upload = $_POST['file_upload'];
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
			$remarks=$_POST['remarks_'.$data->id];

    $foe_invoice = 'INSERT INTO purchase_quotation_details (invoice_no, view_invoice_no, invoice_date, group_for, warehouse_id, req_no,  currency_type, vendor_id, order_no,  item_id, unit_name, unit_price, total_unit, status, entry_at, entry_by, item_type, count_type, req_qty, country_origin, last_po_no, last_po_id,remarks)
  
  VALUES("'.$invoice_no.'", "'.$view_invoice_no.'", "'.$invoice_date.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$req_no.'",  "'.$currency_type.'", "'.$vendor_id.'", "'.$order_no.'",  "'.$item_id.'", "'.$data->unit_name.'", "'.$unit_price.'", "'.$total_unit.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'", "'.$data->item_type.'", "'.$data->count_type.'", 
  "'.$req_qty.'",  "'.$data->country_origin.'", "'.$last_po_no.'", "'.$last_po_id.'", "'.$remarks.'")';

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
//while($data=mysql_fetch_object($query)){
foreach($data as $key=>$value){
?>
foe_amt = foe_amt + document.getElementById('foe_amt_<?=$data->ledger_id?>').value*1;;
<?
}

?>

document.getElementById('foe_amt').value = foe_amt;

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


<form action="" method="post" name="codz" id="codz" enctype="multipart/form-data">

<? if ($data_found==0) { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td width="8%" align="right" ><strong> REQ No: </strong></td>



    <td width="13%" >
	<? $req_data = find_all_field('requisition_master','','req_no="'.$req_no.'"'); ?>
	
	<input name="req_no" type="hidden" id="req_no" style="width:90%; height:32px;" value="<?=$req_data->req_no;?>" readonly="" required tabindex="1" />
	
	<input name="warehouse_id" type="hidden" id="warehouse_id" style="width:90%; height:32px;" value="<?=$req_data->warehouse_id;?>" readonly="" required tabindex="1" />
	
	<a href="../REQUISITION/invoice_print_view.php?invoice_no=<?=$req_data->req_no;?>" target="_blank">
	<input name="view_req_no" type="text" id="view_req_no" style="width:90%; height:32px;" value="<?=$req_data->req_no;?>" readonly="" required tabindex="1" /></a>	</td>
	
	 <td width="12%" align="right" ><strong>  Company: </strong></td>
	 <td width="22%" >
	 
	 <select name="group_for" id="group_for"  style="width:90%; height:32px;" required>

		<? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id="'.$_SESSION['user']['group'].'"');?>

      </select></td>
	 <td width="18%" align="right" ><strong>Currency: </strong></td>
	 <td width="12%"  >
	 <select name="currency_type" id="currency_type"  style="width:90%; height:32px;" required>
	 
	 <option></option>
	 
		<? foreign_relation('currency_type','currency_type','currency_type',$_POST['currency_type'],'1');?>

      </select>
	 </td>
	 <td width="15%" rowspan="8" align="center" ><strong>

     <input type="submit" name="master_data" id="master_data" value="Initiate Entry" style="width:160px; text-transform:uppercase; background:#87CEFA; color:#000000; text-align:center; font-weight:bold; font-size:12px; height:30px; "/>

    </strong></td>
    </tr>
	
	<tr>
								    <td align="right" ><strong> Requisition By: </strong></td>
								    <td ><input name="requisition_by" type="text" id="requisition_by" readonly="readonly" style="width:90%; height:32px;" value="<?=$req_data->req_for;?>"   tabindex="1" /></td>
								    <td align="right"><strong> Department: </strong></td>
								    <td >
		<select name="department" id="department"  style="width:90%; height:32px;"  readonly="readonly" >

     

		<? foreign_relation('wh_department','id','department_name',$req_data->department,'1');?>
      </select></td>
								    <td align="right"><strong> Section: </strong></td>
								    <td >
		<select name="section" id="section"  style="width:90%; height:32px;"  readonly="readonly" >

       

		<? foreign_relation('wh_section','id','section_name',$req_data->department,'1');?>
      </select></td>
							      </tr>
								  <tr>
								    <td align="right" ><strong> REQ Date: </strong></td>
								    <td >
									<input name="req_date" type="text" id="req_date" style="width:90%; height:32px;" value="<?=$req_data->req_date;?>" readonly="" required tabindex="1" />
									</td>
								    <td align="right"><strong> Vendor: </strong></td>
								    <td >
									<input list="vendor" type="text" name="vendor_id" value="<?=$_POST['vendor_id'];?>" id="vendor_id" />
									<datalist id="vendor">
									
									<option></option>

										<? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],'1 order by vendor_name');?>

      								</datalist>
									</td>
								    <td   align="right" ><strong>Quotation Date:</strong>  </td>
								    <td ><input name="invoice_date" type="text" id="invoice_date" style="width:90%; height:32px;" value="<?=$req_date;?>" required="required" tabindex="1" /></td>
							      </tr>
								  <tr>
								    <td align="right" ><strong> Requisition Remarks: </strong></td>
								    <td >
									<input name="req_remarks" type="text" id="req_remarks" style="width:90%; height:32px;" value="<?=$req_data->req_note;?>" readonly=""   tabindex="1" />
									</td>

								    <td align="right" ><strong> Attachment: </strong></td>
								    <td >
									<input name="file_upload" type="file" id="file_upload" style="width:90%; height:32px;" value="<?=$ms_data->file_upload;?>" readonly="" tabindex="1" />
									</td>
									<td align="right" width="17%"><!--<strong> Req. Type: </strong>--></td>
								    <td width="21%" align="right">
									<!--<select name="inv_type" id="inv_type"  style="width:90%; height:32px;" required>

      

		<? foreign_relation('requisition_type','id','requisition_type',$_POST['inv_type'],'id="'.$req_data->inv_type.'"');?>
      </select>-->
									</td>
								    
							      </tr>
								</table>

</div>


<? }?>



<? if ($data_found>0) { 
$ms_data = find_all_field('purchase_quotation_master','','invoice_no="'.$_REQUEST['request_no'].'"');
$req_data= find_all_field('requisition_master','*','req_no="'.$ms_data->req_no.'"');
?>
<?=$ms_data->file_upload?>
<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td width="11%" align="right" ><strong> QUOTE  No: </strong></td>



    <td width="20%" >
	 
	 
	<input name="invoice_no" type="hidden" id="invoice_no" style="width:90%; height:32px;" value="<?=$ms_data->invoice_no;?>" readonly="" required tabindex="1" />
	<input name="req_no" type="hidden" id="req_no" style="width:90%; height:32px;" value="<?=$ms_data->req_no;?>" readonly="" required tabindex="1" />
	
	<input name="warehouse_id" type="hidden" id="warehouse_id" style="width:90%; height:32px;" value="<?=$ms_data->warehouse_id;?>" readonly="" required tabindex="1" />
	<input name="view_invoice_no" type="text" id="view_invoice_no" style="width:90%; height:32px;" value="<?=$ms_data->view_invoice_no;?>" readonly="" required tabindex="1" /></td>
	
	 <td width="11%" align="right"><strong>REQ No: </strong></td>
	 <td width="18%" align="right">
	 <a href="../REQUISITION/invoice_print_view.php?invoice_no=<?=$ms_data->req_no;?>" target="_blank">
	<input name="view_req_no" type="text" id="view_req_no" style="width:90%; height:32px;" value="<?=$ms_data->view_req_no;?>" readonly="" required tabindex="1" /></a>	</td>
	 <td width="19%" align="right"><strong>Company: </strong></td>
	 <td width="21%" >
	<select name="group_for" id="group_for" style="width:90%; height:32px;" required>

		<? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id="'.$ms_data->group_for.'"');?>

      </select> </td>
	 </tr>
								  <tr>
								    <td align="right" width="11%" ><strong> QUOTE Date: </strong></td>
								    <td width="20%" >
									<input name="invoice_date" type="text" id="invoice_date" style="width:90%; height:32px;" value="<?=$ms_data->invoice_date?>" required readonly="" tabindex="1" />
							
									</td>
								    <td align="right" width="11%"><strong> Vendor: </strong></td>
								    <td width="18%" align="right">
									<input type="text" list="vendor" name="vendor_id" id="vendor_id"  required  value="<?=$ms_data->vendor_id?>"/>
									<datalist id="vendor">
									
										<? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],'vendor_id="'.$ms_data->vendor_id.'"');?>

      								</datalist>
									</td>
								    <td align="right" width="19%"><strong>Currency:</strong></td>
								    <td width="21%"><select name="currency_type" id="currency_type"  style="width:90%; height:32px;" required>
	

		<? foreign_relation('currency_type','currency_type','currency_type',$_POST['currency_type'],'currency_type="'.$ms_data->currency_type.'"');?>

      </select></td>
							      </tr>
								  <tr>
								    <td align="right" ><strong> Requisition By: </strong></td>
								    <td ><input name="requisition_by" type="text" id="requisition_by" readonly="readonly" style="width:90%; height:32px;" value="<?=$req_data->requisition_by;?>"   tabindex="1" /></td>
								    <td align="right"><strong> Department: </strong></td>
								    <td >
		<select name="department" id="department"  style="width:90%; height:32px;"  readonly="readonly" >

     

		<? foreign_relation('wh_department','id','department_name',$req_data->department,'1');?>
      </select></td>
								    <td align="right"><strong> Section: </strong></td>
								    <td >
		<select name="section" id="section"  style="width:90%; height:32px;"  readonly="readonly" >

       

		<? foreign_relation('wh_section','id','section_name',$req_data->department,'1');?>
      </select></td>
							      </tr>
								  <tr>
								    <td align="right" ><strong> Requisition Remarks: </strong></td>
								    <td >
									<input name="req_remarks" type="text" id="req_remarks" style="width:90%; height:32px;" value="<?=$req_data->remarks;?>" readonly=""   tabindex="1" />
									</td>
																	    <td align="right" ><strong> Attachment: </strong></td>
								    <td >
									<input name="file_upload" type="file" id="file_upload" style="width:90%; height:32px;" value="<?=$ms_data->file_upload;?>" readonly=""   tabindex="1" />

						<a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$ms_data->file_upload?>&folder=maintain_quotation&proj_id=<?=$_SESSION['proj_id']?>" target="_blank">View Attachment</a>
							

							
							</a>
									</td>
									 
								    
							      </tr>
								</table>

</div>


<div class="tabledesign2" style="width:100%">




<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">

  <tr>
    <th width="5%" rowspan="2">Category</th>

    <th width="21%" rowspan="2">Item Name</th>
    <th width="11%" rowspan="2">Type</th>
    <th width="6%" rowspan="2">Count</th>
    <th width="3%" rowspan="2">Unit  </th>
    <th width="7%" rowspan="2"><strong>Country of Origin</strong></th>
    <th colspan="4"><div align="center"><strong>Last Purchase info </strong></div></th>
    <th width="6%" rowspan="2">REQ Qty </th>
    <th width="8%" rowspan="2">Each Price in <?=$ms_data->currency_type;?></th>
    <th width="7%" rowspan="2">Remarks </th>
	<th width="7%" rowspan="2">Per Unit </th>
  </tr>
  <tr>
    <th width="7%"><strong>PO Date </strong></th>
    <th width="3%"><strong>PO Rate </strong></th>
    <th width="5%"><strong>PO Qty </strong></th>
    <th width="11%"><strong>Vendor</strong></th>
  </tr>
  

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!=''){ $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}
 
    if($_POST['po_date']!=''){
	$po_dt_con=" and m.po_date='".$_POST['po_date']."'";
    }
		
		  $sql = "select id,item_id, po_no, po_date, rate, qty, vendor_id from purchase_invoice where 1 group by item_id order by id desc";
		 $query = db_query($sql);
	
		 while($info=mysqli_fetch_object($query)){
	 
  		  $view_invoice_no[$info->item_id]=$info->po_no;
		 $invoice_date_get[$info->item_id]=$info->po_date;
		  $unit_price[$info->item_id]=$info->rate;
		 $total_unit[$info->item_id]=$info->qty;
		 $vendor_id[$info->item_id]=$info->vendor_id;
		}
		
		$sql = "select vendor_id, vendor_name from vendor where 1 group by vendor_id";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_row($query)){
  		 $vendor_name[$info->vendor_id]=$info->vendor_name;
		}
		
		

      $sqlfg = "select a.*, s.sub_group_name, i.finish_goods_code, i.item_name, i.unit_name from requisition_order a, item_info i, item_sub_group s where i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.req_no='".$ms_data->req_no."' order by a.id";

  $queryfg = db_query($sqlfg);
  

  while($datafg=mysqli_fetch_object($queryfg)){$i++;


  ?>



<? //if($po_no[$data->po_no]==0) { } ?>

  <tr bgcolor="<?=($i%2)?'#F5F5F5':'#fff';?>">
    <td><?=$datafg->sub_group_name?></td>

    <td> <?=$datafg->item_name?> </td>
    <td><?=$item_type[$datafg->item_type]?></td>
    <td><?=$count_type[$datafg->count_type]?></td>
    <td bgcolor="#99CCFF"><?=$datafg->unit_name?></td>
    <td bgcolor="#99CCFF"><?=$datafg->country_origin	;?></td>
    <td bgcolor="#99CCFF"><?php  

	echo date("d-M-y",strtotime($invoice_date_get[$datafg->item_id]));   ?></td>
    <td bgcolor="#99CCFF"><?= $unit_price[$datafg->item_id];?></td>
    <td bgcolor="#99CCFF"><?= $total_unit[$datafg->item_id];?></td>
    <td bgcolor="#99CCFF"><?= $vendor_name[$vendor_id[$datafg->item_id]]?></td>
    <td bgcolor="#99CCFF">
	<input name="order_no_<?=$datafg->id?>" type="hidden" id="order_no_<?=$datafg->id?>" value="<?=$datafg->id?>" />
    <input name="item_id_<?=$datafg->id?>" type="hidden" id="item_id_<?=$datafg->id?>" value="<?=$datafg->item_id?>" /> 
	<input name="last_po_no_<?=$datafg->id?>" type="hidden" id="last_po_no_<?=$datafg->id?>" value="<?=$datafg->last_po_no?>" />
	<input name="last_po_id_<?=$datafg->id?>" type="hidden" id="last_po_id_<?=$datafg->id?>" value="<?=$datafg->last_po_id?>" />
<input name="req_qty_<?=$datafg->id?>" type="text" id="req_qty_<?=$datafg->id?>" value="<?=$datafg->qty;?>" onkeyup="TRcalculationpo(<?=$data->id?>)" readonly="" style="width:80px; height:30px; " /></td>
    <td bgcolor="#99CCFF"><input name="unit_price_<?=$datafg->id?>" type="text" id="unit_price_<?=$datafg->id?>" value="" style="width:80px; height:30px; "/></td>
   <td bgcolor="#99CCFF"><input name="remarks_<?=$datafg->id?>" type="text" id="remarks_<?=$datafg->id?>"      style="width:85px; height:30px; "/></td>
    <td bgcolor="#99CCFF"><input name="total_unit_<?=$datafg->id?>" type="text" id="total_unit_<?=$datafg->id?>" value="1"  readonly="" style="width:50px; height:30px; "/></td>
	  
  </tr>
  

  <? } ?>
</table>
</div>



<? }?>
<br />



<? if($data_found>0){
	?>


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
<? } ?>


</table>


<?php /*?><table width="100%" border="0">

<? 

 		$pi_status = find_a_field('pi_master','status','id="'.$_POST['pi_id'].'"');
		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);


if($pi_status!="MANUAL"){




?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong> Master PI Data Entry Completed</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="COMPLETE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table><?php */?>




<? }?>








<p>&nbsp;</p>

</form>

</div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>