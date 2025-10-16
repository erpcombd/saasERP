<?php



session_start();



ob_start();




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Batch Assignment in Production Order ';



//do_calander('#tdate');



//do_calander('#odate');



$bom_no=$_REQUEST['bom_no'];



 $batch_no=$_REQUEST['request_no'];



 $data_found = $batch_no;



if ($data_found==0) {

do_calander('#batch_date');

//create_combobox('fg_item_id');

  }





if(prevent_multi_submit()){





if(isset($_POST['master_data'])){

	

	$status = 'MANUAL';

	$entry_by = $_SESSION['user']['id'];

	$entry_at=date('Y-m-d H:i:s');

	

	$bom_no = $_POST['bom_no'];

	$bom_qty = $_POST['bom_qty'];

	$unit_name = $_POST['unit_name'];

	$group_for = $_POST['group_for'];

	$fg_item_id = $_POST['fg_item_id'];

	$batch_date = $_POST['batch_date'];

	$warehouse_id = $_POST['warehouse_id'];

	$batch_qty = $_POST['batch_qty'];

	$inv_type='BATCH-';

	//$pr_date = $_POST['so_date'];

	//$fg_item_id = $_POST['fg_item_id'];

	//$item_watt = find_a_field('item_info','item_watt','item_id="'.$_POST['fg_item_id'].'"');

	//$group_for=$_SESSION['user']['group'];

	//$warehouse_id=$_SESSION['user']['depot'];


		$YR = date('Y',strtotime($batch_date));

 		$year = date('y',strtotime($batch_date));

  		$month = date('m',strtotime($batch_date));

 		$inv_cy_id = find_a_field('batch_master','max(inv_id)','year="'.$YR.'"')+1;

  		$cy_id = sprintf("%06d", $inv_cy_id);

   		$batch_no=''.$year.''.$month.''.$cy_id;

	//$tr_no = date('ymd',strtotime($tr_date));

//	

//	$lot_cy_id = find_a_field('import_purchase_details','max(lot_id)','tr_no="'.$tr_no.'"')+1;

//		

//   	$cy_id = sprintf("%04d", $lot_cy_id);

//	

//   	 $lot_no_generate='LOT'.$tr_no.''.$cy_id;

	 

	 if($fg_item_id>0) {

	  $ins_sql = 'INSERT INTO batch_master (batch_no, year, inv_id, inv_type, group_for, bom_no, bom_qty, batch_date, fg_item_id, unit_name, batch_qty, warehouse_id, status, entry_at, entry_by) VALUES



("'.$batch_no.'", "'.$YR.'", "'.$cy_id.'", "'.$inv_type.'", "'.$group_for.'", "'.$bom_no.'", "'.$bom_qty.'", "'.$batch_date.'", "'.$fg_item_id.'", "'.$unit_name.'", "'.$batch_qty.'", "'.$warehouse_id.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';

	

	db_query($ins_sql);

	}

	

	

	 $sql1 = 'select * from bom_factory_overhead where bom_no="'.$bom_no.'" order by id';



		$query1 = db_query($sql1);



		while($data1=mysqli_fetch_object($query1))



		{

		

		$batch_amt=$data1->amount*$batch_qty;





$foe_batch='INSERT INTO batch_factory_overhead (batch_no, bom_no, group_for, warehouse_id, batch_date, fg_item_id, ledger_id, bom_amt, batch_amt, final_amt, status, entry_at, entry_by,

 batch_qty, foe_rate)

  

  VALUES("'.$batch_no.'", "'.$bom_no.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$batch_date.'", "'.$fg_item_id.'", "'.$data1->ledger_id.'", "'.$data1->amount.'", "'.$batch_amt.'", "'.$batch_amt.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'", "'.$batch_qty.'", "'.$data1->amount.'")';



db_query($foe_batch);



}







$sql2 = 'select * from bom_raw_material where bom_no="'.$bom_no.'" order by id';



		$query2 = db_query($sql2);



		while($data2=mysqli_fetch_object($query2))



		{

		

		$batch_cal_qty=$data2->total_unit*$batch_qty;





$rm_batch='INSERT INTO batch_raw_material (batch_no, bom_no, group_for, warehouse_id, batch_date, fg_item_id, item_id, unit_name, batch_qty, bom_qty, batch_cal_qty, final_unit, final_qty, status, entry_at, entry_by)

  

  VALUES("'.$batch_no.'", "'.$bom_no.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$batch_date.'", "'.$fg_item_id.'", "'.$data2->item_id.'", "'.$data2->unit_name.'", "'.$batch_qty.'", "'.$data2->total_unit.'", "'.$batch_cal_qty.'", "'.$data2->total_unit.'", "'.$batch_cal_qty.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';



db_query($rm_batch);



}



$sql3 = 'select * from bom_by_product where bom_no="'.$bom_no.'" order by id';



		$query3 = db_query($sql3);



		while($data3=mysqli_fetch_object($query3))



		{

		

		$batch_cal_qty=$data3->total_unit*$batch_qty;





 $rm_batch2='INSERT INTO batch_by_product (batch_no, bom_no, group_for, warehouse_id, batch_date, fg_item_id, item_id, unit_name,type,rate_ratio,batch_qty, bom_qty, batch_cal_qty, final_unit, final_qty, status, entry_at, entry_by)

  

  VALUES("'.$batch_no.'", "'.$bom_no.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$batch_date.'", "'.$fg_item_id.'", "'.$data3->item_id.'", "'.$data3->unit_name.'","'.$data3->type.'","'.$data3->rate_ratio.'" ,"'.$batch_qty.'", "'.$data3->total_unit.'", "'.$batch_cal_qty.'", "'.$data3->total_unit.'", "'.$batch_cal_qty.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';



db_query($rm_batch2);



}





	



	 

	 ?>



<script language="javascript">

window.location.href = "invoice_entry.php?request_no=<?=$batch_no?>";

</script>



<? 

		

}














//if(isset($_POST['confirm'])){



if(isset($_POST['create'])){

	

	$status = 'MANUAL';

	$entry_by = $_SESSION['user']['id'];

	$entry_at=date('Y-m-d H:i:s');

	$batch_no = $_POST['batch_no'];

	$batch_date = $_POST['batch_date'];	

	$batch_qty = $_POST['batch_qty'];	

	$bom_no = $_POST['bom_no'];	

	$group_for = $_POST['group_for'];

	$warehouse_id = $_POST['warehouse_id'];

	$fg_item_id = $_POST['fg_item_id'];

	$item_id = $_POST['item_id'];

	$unit_name = $_POST['unit_name'];

	$total_unit = $_POST['total_unit1'];

	$final_unit= $_POST['total_unit']/$batch_qty;
	
	$stkQty=find_a_field('journal_item','sum(item_in-item_ex)','warehouse_id="'.$warehouse_id.'" and item_id="'.$item_id.'"');

	 if($item_id>0) {

   if($total_unit<=$stkQty){

	   $ins_sql = 'INSERT INTO batch_raw_material (batch_no, bom_no, group_for, warehouse_id, batch_date, fg_item_id, item_id, unit_name, batch_qty, bom_qty, batch_cal_qty, final_unit, final_qty, status, entry_at, entry_by)

 
  VALUES("'.$batch_no.'", "'.$bom_no.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$batch_date.'", "'.$fg_item_id.'", "'.$item_id.'", "'.$unit_name.'", "'.$batch_qty.'", "0", "'.$total_unit.'", "'.$final_unit.'", "'.$total_unit.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';

	db_query($ins_sql);
	
	}else{
	echo "<script>alert('The floor stocks are currently insufficient.$warehouse_id')</script>";
	}
	


	}

	 ?>



<script language="javascript">

window.location.href = "invoice_entry.php?request_no=<?=$batch_no?>";

</script>



<? 

		

}

if(isset($_POST['bcreate'])){

echo  $rm_batch2='INSERT INTO batch_by_product (batch_no, bom_no, group_for, warehouse_id, batch_date, fg_item_id, item_id, unit_name,type,rate_ratio,batch_qty, bom_qty, batch_cal_qty, final_unit, final_qty, status, entry_at, entry_by)

  

  VALUES("'.$batch_no.'", "'.$bom_no.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$batch_date.'", "'.$fg_item_id.'", "'.$data3->item_id.'", "'.$data3->unit_name.'","'.$data3->type.'","'.$data3->rate_ratio.'" ,"'.$batch_qty.'", "'.$data3->total_unit.'", "'.$batch_cal_qty.'", "'.$data3->total_unit.'", "'.$batch_cal_qty.'", "'.$status.'", "'.$entry_at.'", "'.$entry_by.'")';
}











if(isset($_POST['confirm'])){

	

	$status = 'CHECKED';

	$entry_by = $_SESSION['user']['id'];

	$entry_at=date('Y-m-d H:i:s');

	$batch_no = $_POST['batch_no'];

	$bom_no = $_POST['bom_no'];

	//$find_foe_data = find_a_field('bom_factory_overhead','sum(amount)','bom_no="'.$bom_no.'"');

	//$find_rm_data = find_a_field('bom_raw_material','sum(total_unit)','bom_no="'.$bom_no.'"');

	//if($find_foe_data>0 && $find_rm_data>0) {}


	$con_sql1="UPDATE batch_master SET status='".$status."', checked_by='".$entry_by."', checked_at='".$entry_at."' WHERE batch_no = '".$batch_no."' ";

	 db_query($con_sql1);

	 

	 $con_sql2="UPDATE batch_factory_overhead SET status='".$status."', checked_by='".$entry_by."', checked_at='".$entry_at."' WHERE batch_no = '".$batch_no."' ";

	 db_query($con_sql2);

	 

	  $con_sql3="UPDATE batch_raw_material SET status='".$status."', checked_by='".$entry_by."', checked_at='".$entry_at."' WHERE batch_no = '".$batch_no."' ";

	 db_query($con_sql3);

	

	 ?>



<script language="javascript">

window.location.href = "batch_assignment.php";

</script>



<? 

		

}













if(isset($_POST['delete'])){

	

	$status = 'CHECKED';

	$entry_by = $_SESSION['user']['id'];

	$entry_at=date('Y-m-d H:i:s');

		

	$batch_no = $_POST['batch_no'];

	$bom_no = $_POST['bom_no'];

	

	$sql_del_ms = 'delete from batch_master where  batch_no="'.$batch_no.'"';

	db_query($sql_del_ms);

	

	$sql_del_foe = 'delete from batch_factory_overhead where batch_no="'.$batch_no.'"';

	db_query($sql_del_foe);

	

	$sql_del_rm = 'delete from batch_raw_material where batch_no="'.$batch_no.'"';

	db_query($sql_del_rm);

	

	 ?>



<script language="javascript">

window.location.href = "batch_assignment.php";

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

var floor_qty=(document.getElementById('floor_qty_'+order_no).value);

//alert(floor_qty);
//var amount=(document.getElementById('amount_'+order_no).value);

var flag=(document.getElementById('flag_'+order_no).value); 



var strURL="item_revise_ajax.php?order_no="+order_no+"&item_id="+item_id+"&batch_qty="+batch_qty+"&total_unit="+total_unit+"&floor_qty="+floor_qty+"&flag="+flag;

if(floor_qty>=total_unit){

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
		
		}	else{
		
		alert('The floor stocks are currently insufficient');
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



<? if ($data_found==0) { ?>



<div class="box" style="width:100%;">



								<table width="100%" border="0" cellspacing="0" cellpadding="0">



								  <tr>







    <td width="10%" align="right" ><strong> BOM No: </strong></td>







    <td width="14%" >

	<? $bom_data = find_all_field('bom_master','','bom_no="'.$bom_no.'"'); ?>

	

	<input name="bom_no" type="hidden" id="bom_no" style="width:90%; height:32px;" value="<?=$bom_no;?>" readonly="" required tabindex="1" />

	<input name="bom_qty" type="hidden" id="bom_qty" style="width:90%; height:32px;" value="<?=$bom_data->quantity;?>" readonly="" required tabindex="1" />

	<input name="unit_name" type="hidden" id="unit_name" style="width:90%; height:32px;" value="<?=$bom_data->unit_name;?>" readonly="" required tabindex="1" />

	<input name="group_for" type="hidden" id="group_for" style="width:90%; height:32px;" value="<?=$bom_data->group_for;?>" readonly="" required tabindex="1" />

	<a href="../BOM/invoice_print_view.php?bom_no=<?=$bom_no;?>" target="_blank"><input name="bom" type="text" id="bom" style="width:90%; height:32px;" value="<?=$bom_data->inv_type;?><?=$bom_data->bom_no;?>" readonly="" required tabindex="1" /></a>	</td>

	

	 <td width="11%" ><strong>  Product: </strong></td>

	 <td width="23%" >

	 

	 <select name="fg_item_id" id="fg_item_id" style="width:200px;" >





		<? foreign_relation('item_info','item_id','item_name',$_POST['fg_item_id'],'item_id="'.$bom_data->fg_item_id.'"');?>

      </select></td>

	 <td width="10%" ><strong>BOM Qty: </strong></td>

	 <td width="12%" ><input name="bom_qty" type="text" id="bom_qty" style="width:90%; height:32px;" value="<?=$bom_data->quantity;?> <?=$bom_data->unit_name;?> " required readonly="" tabindex="1" /></td>

	 <td width="20%" rowspan="8" align="center" ><strong>



      <input type="submit" name="master_data" id="master_data" value="Initiate Entry" style="width:180px; text-align:center; font-weight:bold; font-size:12px; height:30px; color:#090"/>



    </strong></td>

    </tr>

								  <tr>

								    <td align="right" ><strong> Batch Date: </strong></td>

								    <td ><input name="batch_date" type="text" id="batch_date" style="width:90%; height:32px;" value="<?=$batch_date;?>"  required tabindex="1" autocomplete="off" /></td>

								    <td ><strong> Factory Unit: </strong></td>

								    <td >

									<select name="warehouse_id" id="warehouse_id" style="width:200px;" required >

									<option></option>

										<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'use_type="PL"');?>

     								 </select>

									</td>

								    <td ><strong>Batch Qty:</strong>  </td>

								    <td ><input name="batch_qty" type="number" id="batch_qty" onblur="qtyLimit(this.value)" style="width:90%; height:32px;" value="<?=$batch_qty;?> " required tabindex="1" autocomplete="off"/></td>

							      </tr>

								</table>



</div>





<? }?>







<? if ($data_found>0) { ?>



<div class="box" style="width:100%;">



								<table width="100%" border="0" cellspacing="0" cellpadding="0">



								  <tr>







    <td width="15%" align="right" ><strong> Batch No: </strong></td>







    <td width="21%" >

	<? 

	$ms_data = find_all_field('batch_master','','batch_no="'.$_REQUEST['request_no'].'"');

	$bm_data = find_all_field('bom_master','','bom_no="'.$ms_data->bom_no.'"');

	 ?>

	 

	<input name="bom_no" type="hidden" id="bom_no" style="width:90%; height:32px;" value="<?=$ms_data->bom_no;?>" readonly="" required tabindex="1" />

	<input name="batch_qty" type="hidden" id="batch_qty" style="width:90%; height:32px;" value="<?=$ms_data->batch_qty;?>" readonly="" required tabindex="1" />

	

	<input name="batch_no" type="hidden" id="batch_no" style="width:90%; height:32px;" value="<?=$ms_data->batch_no;?>" readonly="" required tabindex="1" />

	<input name="group_for" type="hidden" id="group_for" style="width:90%; height:32px;" value="<?=$ms_data->group_for;?>" readonly="" required tabindex="1" />

	<input name="fg_item_id" type="hidden" id="fg_item_id" style="width:90%; height:32px;" value="<?=$ms_data->fg_item_id;?>" readonly="" required tabindex="1" />

	

	<input name="batch" type="text" id="batch" style="width:90%; height:32px;" value="<?=$ms_data->inv_type;?><?=$ms_data->batch_no;?>" readonly="" required tabindex="1" /></td>

	

	 <td width="12%" align="right"><strong>  Batch Date: </strong></td>

	 <td width="25%" align="right"><input name="batch_date" type="text" id="batch_date" style="width:90%; height:32px;" value="<?=$ms_data->batch_date?>" required readonly="" tabindex="1" /></td>

	 <td width="10%" align="right"><strong>BOM No : </strong></td>

	 <td width="17%" >

	<a href="../BOM/invoice_print_view.php?bom_no=<?=$ms_data->bom_no;?>" target="_blank">

	<input name="bom" type="text" id="bom" style="width:90%; height:32px;" 

	value="<?=$bm_data->inv_type;?><?=$bm_data->bom_no;?>" readonly="" required tabindex="1" /></a>	 </td>

	 </tr>

								  <tr>

								    <td align="right" width="15%" ><strong> Factory Unit: </strong></td>

								    <td width="21%" >

									<select name="warehouse_id" id="warehouse_id" style="width:200px;" required >

								

										<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$ms_data->warehouse_id.'"');?>

     								 </select>

							

									</td>

								    <td align="right" width="12%"><strong> Product Name: : </strong></td>

								    <td width="25%" align="right"><input name="item_name" type="text" id="item_name" style="width:90%; height:32px;" value="<?=find_a_field('item_info','item_name','item_id="'.$ms_data->fg_item_id.'"'); ?>" readonly="" required tabindex="1" /></td>

								    <td align="right" width="10%"><strong>Batch Qty : </strong></td>

								    <td width="17%"><input name="quantity" type="text" id="quantity" style="width:90%; height:32px;" value="<?=$ms_data->batch_qty;?> <?=$ms_data->unit_name;?>" readonly="" required tabindex="1" /></td>

							      </tr>

								</table>



</div>





<div class="tabledesign2" style="width:100%">









<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">



  <tr>

    <th width="16%">Ledger Group </th>



    <th width="27%">Ledger Name </th>

    <th width="11%">Amount </th>

    </tr>

  



  <?

  

  

  //if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

  

  

		//if($_POST['dealer_code']!='')

// 		$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";

//		

//		if($_POST['do_no']!='') 

//		$do_con .= ' and m.do_no in ('.$_POST['do_no'].') ';





   // if($_POST['po_date']!='')

	//$po_dt_con=" and m.po_date='".$_POST['po_date']."'";

	

	

	

	 	 //$sql = "select po_no, po_no from po_bill_details where 1 group by po_no";

//		 $query = db_query($sql);

//		 while($info=mysqli_fetch_object($query)){

//  		 $po_no[$info->po_no]=$info->po_no;

//	

//		}











		 $sql = "select ledger_id, final_amt as foe_exp from batch_factory_overhead where batch_no='".$batch_no."' group by ledger_id";

		 $query = db_query($sql);

		 while($info=mysqli_fetch_object($query)){

  		 $foe_exp[$info->ledger_id]=$info->foe_exp;

		}



		

		



      $sql = "select l.group_name, a.ledger_id, a.ledger_name

	from ledger_group l, accounts_ledger a where l.group_id=a.ledger_group_id and a.ledger_group_id=411010

	order by l.group_id, a.ledger_id";



  $query = db_query($sql);



  while($data=mysqli_fetch_object($query)){$i++;



 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');



  ?>







<? //if($po_no[$data->po_no]==0) { } ?>



<tr style="background-color: <?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>;">

    <td><?=$data->group_name?></td>



    <td> <?=$data->ledger_name?> </td>

    <td style="background-color:#99CCFF;" align="right">



<input name="ledger_id_<?=$data->ledger_id?>" type="hidden" id="ledger_id_<?=$data->ledger_id?>" value="<?=$data->ledger_id?>"  onkeyup="SUMcalculation(<?=$data->ledger_id?>)" />	

<input name="foe_amt_<?=$data->ledger_id?>" type="text" id="foe_amt_<?=$data->ledger_id?>" value="<?=$foe_exp[$data->ledger_id]; $tot_foe_exp +=$foe_exp[$data->ledger_id];?>" onkeyup="SUMcalculation(<?=$data->ledger_id?>)"  style="width:120px; height:30px;" readonly="" /></td>



 <? } ?>

    </tr>

  <tr>

    <td style="background-color:#90EE90;">&nbsp;</td>

    <td align="center" style="background-color:#90EE90;"><div align="center"><strong>Total</strong></div></td>

    <td style="background-color:#90EE90;" align="right"><input name="foe_amt" id="foe_amt" type="text" size="10"  value="<?=$tot_foe_exp;?>" style="width:120px; height:30px;" readonly="" /></td>

  </tr>

  

</table>

</div>





<?php /*?><div class="box" style="width:100%;">						

								<table width="100%">

                            <thead>

                              <tr class="oe_list_header_columns">

                                <th width="46%">&nbsp;</th>

                                <th width="31%">

								

								<!--<a href="invoice_print_view.php?do_no=<?=$data_found?>" target="_blank" style="padding:5px 30px; background:#20B2AA; color:#000000; font-size:12px; font-weight:700;"> VIEW DATA</a>--></th>

               <th width="23%" align="right"><input name="foe_data" type="submit" id="foe_data" value="CONFIRM" style="width:150px; height:30px; background:#FF6347; color:#000000; font-weight:700; float:right;" /></th>

                              </tr>

                            </thead>

                            <tfoot>

                            </tfoot>

                            <tbody>

                            </tbody>

                          </table>



    </div><?php */?>





<? }?>

<br />





<? if($data_found>0){ ?>



<div class="box text-center">

	<b class="display-4">RAW MATERIAL</b>

</div>

<div class="tabledesign2" style="width:100%">



								<table width="100%" border="0" cellspacing="0" cellpadding="0">



								  <tr>

								    <th>Item Code</th>

								    <th>Item Name</th>

								    <th>Quantity</th>

								    <th width="10%" rowspan="2"><input name="create" type="submit" id="create" value="ADD DATA" style="width:120px; height:40px; background:#FF0000; color:#000000; font-weight:700;" /></th>

								  </tr>

								  <tr>



								 <td width="15%">

									

								<? //auto_complete_from_db('item_info','concat(item_id,"-> ",item_name)','item_id','product_type="Spare Parts"','fg_code');?>

									

						<?php /*?> <input name="fg_code" type="text" class="input3"  value="" id="fg_code" style="width:90%; height:30px;" onblur="getData2('item_data_ajax.php', 'item_data_found', this.value, document.getElementById('fg_code').value);"/><?php */?>

						 

						 

<div>

<input list="item_name_list" name="fg_code" id="fg_code"   style="width:90%; height:30px; font-size:16px;"  onchange="getData2('item_data_ajax.php', 'item_data_found', this.value, 

document.getElementById('fg_code').value);"  autocomplete="off" >

  <datalist id="item_name_list" style="font-size:16px;" >

   

     <? foreign_relation('item_info','concat(item_id)','concat(item_id,"-> ",item_name)',$fg_code,'1');?>

  </datalist>

</div>						 									</td>

									<td width="20%">

									<span id="item_data_found">

									<input name="item_name" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="item_name" style="width:90%; height:30px;" /> </span>									</td>

		                            <td width="10%"><input name="total_unit1" type="text" class="input3"   autocomplete="off"  value="" id="total_unit1" style="width:80%; height:30px;" onkeyup="count()" /></td>

	                              </tr>

								</table>

								

	</div>

								

		



<? }?>





<? if($data_found>0){ ?>



<div class="tabledesign2" style="width:100%">



<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">



  <tr>

    <th width="19%">Category</th>



    <th width="37%">Item Name</th>

    <th width="10%">Unit Name </th>

    <th width="10%">FLOOR sTOCK </th>

    <th width="10%">Quantity</th>

    <th width="12%"><div align="center">Action</div></th>

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

	

	

	

	 	 //$sql = "select po_no, po_no from po_bill_details where 1 group by po_no";

//		 $query = db_query($sql);

//		 while($info=mysqli_fetch_object($query)){

//  		 $po_no[$info->po_no]=$info->po_no;

//	

//		}







		

		



    $sqlfg = "select a.*, s.sub_group_name, i.finish_goods_code, i.item_name, i.unit_name from batch_raw_material a, item_info i, item_sub_group s where i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.batch_no='".$batch_no."' order by a.id ";



  $queryfg = db_query($sqlfg);



  while($datafg=mysqli_fetch_object($queryfg)){$i++;

$sstk=find_a_field('journal_item','sum(item_in-item_ex)',' warehouse_id = '.$datafg->warehouse_id.' and item_id='.$datafg->item_id);


$checkStock[]=($sstk>0)?1:0;

 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');



  ?>







<? //if($po_no[$data->po_no]==0) { } ?>



  <tr style="background-color: <?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>;">

    <td><?=$datafg->sub_group_name?></td>



    <td> <?=$datafg->item_name?> </td>

    <td style="background-color:#99CCFF;"><?=$datafg->unit_name?></td>

    <td style="background-color:#99CCFF;" class="text-center"><input type="text" name="floor_qty_<?=$datafg->id?>" id="floor_qty_<?=$datafg->id?>" value="<?=$sstk?>" readonly/></td>

<?



?>


    <td style="background-color:#99CCFF;">

	<input name="order_no_<?=$datafg->id?>" type="hidden" id="order_no_<?=$datafg->id?>" value="<?=$datafg->id?>" />

      <input name="item_id_<?=$datafg->id?>" type="hidden" id="item_id_<?=$datafg->id?>" value="<?=$datafg->item_id?>" />

	  <input name="batch_qty_<?=$datafg->id?>" type="hidden" id="batch_qty_<?=$datafg->id?>" value="<?=$datafg->batch_qty?>" />

	 

	<input name="total_unit_<?=$datafg->id?>" type="text" id="total_unit_<?=$datafg->id?>" value="<?=$datafg->final_qty; ?>" onkeyup="TRcalculationpo(<?=$data->id?>)" style="width:80px; height:30px; " /></td>

    <td>

	<? if($reg_revise[$datafg->id]>0) {?>

	<center><b>Done!</b></center>

	<? }else {?>

	<span id="divi_<?=$datafg->id?>">

	<input name="flag_<?=$datafg->id?>" type="hidden" id="flag_<?=$datafg->id?>" value="0" />



	<input type="button" name="Button" value="EDIT"  onclick="update_value(<?=$datafg->id?>)" style="width:70px; font-size:12px; height:30px; background-color:#66CC66; font-weight:700;"/>

    </span><? }?></td>

  </tr>

  



  <? }
  
  
   ?>

</table>

</div>



<br />







<br /><br />









<table width="100%" border="0">











<?php /*?><? if($bill_data->status!="COMPLETED") {?>

<tr>



<td align="center">&nbsp;

<input name="delete" type="submit" class="btn1" value="DELETE" style="width:200px; font-weight:bold; float:left; font-size:12px; height:30px; background:#FF0000;color: #000000; border-radius:50px 20px;" />

</td>



<td align="center">

<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->

<input name="confirm" type="submit" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" /></td>



</tr>

<? }?><?php */?>





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







<? if($data_found>0){ ?>



<div class="box text-center">

	<b class="display-4">BY PRODUCT</b>

</div>



<div class="tabledesign2" style="width:100%">



								<table width="100%" border="0" cellspacing="0" cellpadding="0">



								  <tr>

								    <th>Item Code</th>

								    <th>Item Name</th>

								    <th>Quantity</th>

									<th>Type</th>

									<th>Ratio/Rate</th>

								    <th width="10%" rowspan="2"><input name="bcreate" type="submit" id="bcreate" value="ADD DATA" style="width:120px; height:40px; background:#FF0000; color:#000000; font-weight:700;" /></th>

								  </tr>

								  <tr>



								 <td width="15%">

									

								<? //auto_complete_from_db('item_info','concat(item_id,"-> ",item_name)','item_id','product_type="Spare Parts"','fg_code');?>

									

						<?php /*?> <input name="fg_code" type="text" class="input3"  value="" id="fg_code" style="width:90%; height:30px;" onblur="getData2('item_data_ajax.php', 'item_data_found', this.value, document.getElementById('fg_code').value);"/><?php */?>

						 

						 

<div>

<input list="item_name_list" name="fg_code" id="fg_code"   style="width:90%; height:30px; font-size:16px;"  onchange="getData2('item_data2_ajax.php', 'item_data_found2', this.value, 

document.getElementById('fg_code').value);"  autocomplete="off" >

  <datalist id="item_name_list" style="font-size:16px;" >

   

     <? foreign_relation('item_info','concat(item_id)','concat(item_id,"-> ",item_name)',$fg_code,'1 and sub_group_id not like "1000%" ');?>

  </datalist>

</div>						 									</td>

									<td width="20%">

									<span id="item_data_found2">

									<input name="item_name" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="item_name" style="width:90%; height:30px;" /> </span>									</td>

		                            <td width="10%"><input name="total_unit" type="text" class="input3"   autocomplete="off"  value="" id="total_unit" style="width:80%; height:30px;" onkeyup="count()" /></td>

								<td><select name="type">

									<option></option>

									<option>Ratio</option>

									<option>Rate</option>

								</select></td>

								<td><input name="rate_ratio" type="text" class="input3"   autocomplete="off"  value="" id="rate_ratio" style="width:80%; height:30px;"/></td>

	                              </tr>

								</table>

								

	</div>

								

		

	

<? }?>





<? if($data_found>0){ ?>















<div class="tabledesign2" style="width:100%">









<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">



  <tr>

    <th width="19%">Category</th>

    <th width="37%">Item Name</th>

    <th width="10%">Unit Name </th>

	<th width="10%">Type</th>

	<th width="10%">Rate/Ratio</th>

    <th width="10%">Quantity</th>

    <th width="12%"><div align="center">Action</div></th>

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

	

	

	

	 	 //$sql = "select po_no, po_no from po_bill_details where 1 group by po_no";

//		 $query = db_query($sql);

//		 while($info=mysqli_fetch_object($query)){

//  		 $po_no[$info->po_no]=$info->po_no;

//	

//		}







		

		



     $sqlfg = "select a.*, s.sub_group_name, i.finish_goods_code, i.item_name, i.unit_name from batch_by_product a, item_info i, item_sub_group s where i.item_id=a.item_id  and i.sub_group_id=s.sub_group_id and a.batch_no='".$batch_no."' order by a.id ";



  $queryfg = db_query($sqlfg);



  while($datafg=mysqli_fetch_object($queryfg)){$i++;



 // $op = find_all_field('journal_item','','warehouse_id="'.$_POST['warehouse_id'].'" and group_for="'.$_POST['group_for'].'" and item_id = "'.$data->item_id.'" and tr_from = "Opening" order by id desc');



  ?>







<? //if($po_no[$data->po_no]==0) { } ?>



  <tr style="background-color: <?= ($i % 2) ? '#E8F3FF' : '#fff'; ?>;">

    <td><?=$datafg->sub_group_name?></td>



    <td> <?=$datafg->item_name?> </td>

    <td style="background-color:#99CCFF;"><?=$datafg->unit_name?></td>

	<td style="background-color:#99CCFF;"><?=$datafg->type?></td>

	<td style="background-color:#99CCFF;"><?=$datafg->rate_ratio?></td>

    <td style="background-color:#99CCFF;">

	<input name="order_no_<?=$datafg->id?>" type="hidden" id="order_no_<?=$datafg->id?>" value="<?=$datafg->id?>" />

      <input name="item_id_<?=$datafg->id?>" type="hidden" id="item_id_<?=$datafg->id?>" value="<?=$datafg->item_id?>" />

	<input name="total_unit_<?=$datafg->id?>" type="text" id="total_unit_<?=$datafg->id?>" value="<?=$datafg->total_unit; $tot_total_unit +=$datafg->total_unit;?>" onkeyup="TRcalculationpo(<?=$data->id?>)" style="width:80px; height:30px; " /></td>

    <td>

	<? if($reg_revise[$datafg->id]>0) {?>

	<center><b>Done!</b></center>

	<? }else {?>

	<span id="divi_<?=$datafg->id?>">

	<input name="flag_<?=$datafg->id?>" type="hidden" id="flag_<?=$datafg->id?>" value="0" />



	<input type="button" name="Button" value="EDIT"  onclick="update_value2(<?=$datafg->id?>)" style="width:70px; font-size:12px; height:30px; background-color:#66CC66; font-weight:700;"/>

    </span><? }?></td>

  </tr>

  



  <? }
  
//  echo "<pre>";
//  print_r($checkStock);
//  echo "</pre>"; 
  
  ?>

</table>

</div>



<br />







<br /><br />









<table width="100%" border="0">











<? if($bill_data->status!="COMPLETED") {

if (in_array(0, $checkStock)) {


?>

<h1><center><span style="background-color: yellow; color: red;font-size: 30px !important;">Check Item Stock</span></center></h1>


<? }
else{

?>
<tr>

<td align="center">&nbsp;

<input name="delete" type="submit" class="btn1" value="DELETE" style="width:200px; font-weight:bold; float:left; font-size:12px; height:30px; background:#FF0000;color: #000000; border-radius:50px 20px;" />

</td>



<td align="center">

<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->

<input name="confirm" type="submit" class="btn1" value="CONFIRM &amp; SEND" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px;  background: #1E90FF; color: #000000; border-radius: 50px 20px;" /></td>



</tr>


<? } }?>





</table>





<?php /*?><table width="100%" border="0">



<? 



 		$pi_status = find_a_field('pi_master','status','id="'.$_POST['pi_id'].'"');

		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);





if($pi_status!="MANUAL"){









?>



<tr>



<td colspan="2" align="center" style="background-color:#FF3333;"><strong> Master PI Data Entry Completed</strong></td>



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


<script>
function qtyLimit(data){
var qqqi=$('#bom_qty').val();
var match = qqqi.match(/(\d+(\.\d+)?)/);

if (match) {
    var valuess = parseFloat(match[0]);  
}else{
 var valuess =qqqi;
}

if(valuess>data){

alert('Minimum need '+valuess+' Qty');

$('#batch_qty').val(valuess);
}

}

</script>




<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>