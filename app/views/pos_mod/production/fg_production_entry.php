<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Production Receive Entry';


create_combobox('cr_ledger_id');

do_calander('#receive_date');
//do_calander('#ldbc_no_date');
do_calander('#cheque_date');

 $data_found = $_POST['receive_date'];

//if ($data_found==0) {
// do_calander('invoice_date');
//  }



if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$receive_date=$_POST['invoice_date'];
		$group_for=$_POST['group_for'];
		$warehouse_id=$_POST['warehouse_id'];
		$remarks=$_POST['remarks'];
		
		
		//$lc_part_no = find_a_field('lc_bank_payment','lc_no_part','id="'.$bank_pay_id.'"');
		
	
  if($_POST['bill_type']!='')
  $bill_type_con=" and bill_type=".$_POST['bill_type'];
  


		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		
		//$YR = date('Y',strtotime($ch_date));
//  		$yer = date('y',strtotime($ch_date));
//  		$month = date('m',strtotime($ch_date));
//
//  		$ch_cy_id = find_a_field('sale_do_chalan','max(ch_id)','year="'.$YR.'"')+1;
//   		$cy_id = sprintf("%07d", $ch_cy_id);
//   		$chalan_no=''.$yer.''.$month.''.$cy_id;

		
			$receive_no = next_transection_no($group_for,$receive_date,'fg_production','receive_no');


		
	


		$sql = "SELECT i.item_id, i.item_name, i.unit_name FROM item_info i, item_sub_group s WHERE i.sub_group_id=s.sub_group_id  and s.group_id=200000000 order  by i.sub_group_id, i.item_id ";

		$query = mysql_query($sql);

		while($data=mysql_fetch_object($query))

		{
			if($_POST['total_amt_'.$data->item_id]>0)

			{

				$item_id=$_POST['item_id_'.$data->item_id];
				$receive_qty=$_POST['receive_qty_'.$data->item_id];
				$cost_price=$_POST['cost_price_'.$data->item_id];
				$total_amt=$_POST['total_amt_'.$data->item_id];

   $ins_invoice = 'INSERT INTO fg_production (receive_no, receive_date, group_for, warehouse_id, item_id, unit_name, receive_qty, cost_price, total_amt, remarks, entry_at, entry_by)
  
  VALUES("'.$receive_no.'", "'.$receive_date.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$item_id.'", "'.$data->unit_name.'", "'.$receive_qty.'", "'.$cost_price.'", "'.$total_amt.'", "'.$remarks.'", "'.$entry_at.'", "'.$entry_by.'")';

mysql_query($ins_invoice);

$xid = mysql_insert_id();

journal_item_control($item_id, $warehouse_id, $receive_date, $receive_qty,  0, 'Receive', $xid, $cost_price, '', $receive_no, '', '', $group_for, $cost_price, '' );


}

}


if($receive_no>0)
{
auto_insert_fg_production_secoundary($receive_no);
}

?>

<script language="javascript">
window.location.href = "fg_production_entry.php";
</script>

<?	

}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

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



	function update_value(pi_id)



	{



var pi_id=pi_id; // Rent


var lc_no=(document.getElementById('lc_no').value);


var flag=(document.getElementById('flag_'+pi_id).value); 

var strURL="lc_update_ajax.php?pi_id="+pi_id+"&lc_no="+lc_no+"&flag="+flag;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+pi_id).style.display='inline';

						document.getElementById('divi_'+pi_id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	



}


function EXPcalculation(item_id){
var receive_qty = document.getElementById('receive_qty_'+item_id).value*1;
var cost_price = document.getElementById('cost_price_'+item_id).value*1;
var total_amt = document.getElementById('total_amt_'+item_id).value= (receive_qty*cost_price);

}



</script>





<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


/*div.form-container_large input {*/
    /*width: 200px;*/
    /*height: 38px;*/
    /*border-radius: 0px !important;*/
/*}*/


/*table thead  {*/
  /*/ Important /*/
  /*background-color: red;*/
  /*position: sticky;*/
  /*z-index: 100;*/
  /*top: 0;*/
/*}*/

</style>







	<div class="form-container_large">
		<form action="" method="post" name="codz" id="codz">

			<? if ($data_found=="") { ?>
			<!--1 INPUT TABLE-->
			<div class="container-fluid bg-form-titel">
				<div class="row">
					<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
						<div class="form-group row m-0">
							<label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PRODUCTION RECEIVE DATE</label>
							<div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
									<input name="receive_date" type="text" id="receive_date"  value="<?=($receive_date!='')?$receive_date:date('Y-m-d')?>"   required />
							</div>
						</div>
					</div>


					<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
						<input type="submit" name="submit" id="submit" value="View Data" class="btn1 btn1-submit-input" />
					</div>

				</div>
			</div>
			<? }?>



			<? if(isset($_POST['submit'])){ ?>
			<!--        top form start hear-->
			<div class="container-fluid bg-form-titel">
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">ISSUE DATE</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="invoice_date" type="text" id="invoice_date"  readonly="" value="<?=$_POST['receive_date']?>"   required />
							</div>
						</div>

					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">COMPANY</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">


								<select name="group_for" id="group_for" required="required">

									<? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id="'.$_SESSION['user']['group'].'"');?>
								</select>

							</div>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">WAREHOUSE</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<select name="warehouse_id" id="warehouse_id" required>
									<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
								</select>

							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6  pt-1 pb-1">
						<div class="form-group row m-0">
							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">REMARKS</label>
							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
								<input name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks']?>"/>

							</div>
						</div>
					</div>

				</div>
			</div>

			<? }?>

			<? if(isset($_POST['submit'])){ ?>
			<!--return Table design start-->
			<div class="container-fluid pt-5 p-0 ">
				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>ITEM CODE</th>
						<th>ITEM NAME</th>
						<th> UNIT</th>
						<th> STOCK</th>
						<th> RECEIVE QTY</th>
						<th> COST PRICE</th>
						<th> TOTAL AMT</th>
					</tr>
					</thead>

					<tbody class="tbody1">
					<?


					if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



					if($_POST['account_code']!='')
						$account_code_con=" and d.ledger_id=".$_POST['account_code'];

					if($_POST['bill_type']!='')
						$bill_type_con=" and bill_type=".$_POST['bill_type'];






					//$sql = "select sum(dr_amt) as payment_amt, ledger_id, tr_id  from journal where tr_from='Payment' group by tr_id ";
					//$query = mysql_query($sql);
					//while($data=mysql_fetch_object($query)){
					//$payment_amt[$data->ledger_id][$data->tr_id]=$data->payment_amt;
					//}


					//$sql = "select item_id, sum(item_in) as tot_stock_in, sum(item_in*item_price) as tot_stock_amt  from journal_item where ji_date<='".$_POST['issue_date']."'  group by item_id";
					//$query = mysql_query($sql);
					//while($data=mysql_fetch_object($query)){
					//$tot_stock_in[$data->item_id]=$data->tot_stock_in;
					//$tot_stock_amt[$data->item_id]=$data->tot_stock_amt;
					//}
					//


					$sql = "select item_id, sum(item_in-item_ex) as stock_qty from journal_item where ji_date<='".$_POST['receive_date']."'  group by item_id";
					$query = mysql_query($sql);
					while($data=mysql_fetch_object($query)){
						$stock_qty[$data->item_id]=$data->stock_qty;
					}


					$sql = "SELECT i.item_id, i.item_name, i.unit_name, i.cost_price FROM item_info i, item_sub_group s WHERE i.sub_group_id=s.sub_group_id  and s.group_id=200000000 order  by i.sub_group_id, i.item_id ";

					$query = mysql_query($sql);

					while($data=mysql_fetch_object($query)){$i++;

						?>
						<? //if ($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no]>0) {?>

						<tr>
							<td><span>
      <?=$data->item_id;?>
    </span></td>

							<td>
								<?=$data->item_name;?>    </td>

							<td><span >
      <?=$data->unit_name;?>
    </span></td>
							<td><?=number_format($stock_qty[$data->item_id],2);?></td>
							<td>

								<input name="item_id_<?=$data->item_id?>" id="item_id_<?=$data->item_id?>" type="hidden"   value="<?=$data->item_id?>"  onkeyup="EXPcalculation(<?=$data->item_id?>)"  />


								<input name="receive_qty_<?=$data->item_id?>" id="receive_qty_<?=$data->item_id?>" type="text"  value=""  onkeyup="EXPcalculation(<?=$data->item_id?>)"  />	</td>
							<td><input name="cost_price_<?=$data->item_id?>" id="cost_price_<?=$data->item_id?>" type="text"  value="<?=$data->cost_price;?>" readonly="" onkeyup="EXPcalculation(<?=$data->item_id?>)"  /></td>
							<td ><input name="total_amt_<?=$data->item_id?>" id="total_amt_<?=$data->item_id?>" type="text"  readonly=""  value=""   />	</td>
						</tr>

					<? } //}?>


					</tbody>
				</table>

			</div>

			<div class="n-form-btn-class">
				<input name="confirmit" type="submit" class="btn1 btn1-bg-submit" value="SAVE & NEW" />
			</div>
			<? }?>
		</form>


	</div>


















<?php /*?><div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<? if ($data_found=="") { ?>

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>



    <td align="right" ><strong>PRODUCTION RECEIVE DATE: </strong></td>



    <td >
		<input style="width:220px; height:32px;"  name="receive_date" type="text" id="receive_date"  value="<?=($receive_date!='')?$receive_date:date('Y-m-d')?>"   required />
	</td>



    <td rowspan="4" ><strong>

      <input type="submit" name="submit" id="submit" value="View Data" class="btn1 btn1-submit-input" />

    </strong></td>
    </tr>
								</table>

    </div>

<? }?>



<? if(isset($_POST['submit'])){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

								  <tr>

								 <td width="11%">ISSUE DATE:</td>

									<td width="20%">
									
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  readonly="" value="<?=$_POST['receive_date']?>"   required />									</td>
									<td width="14%">COMPANY:</td>
									<td width="21%">
									
									<select name="group_for" id="group_for" required="required" style="width:220px;">
									
									  <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id="'.$_SESSION['user']['group'].'"');?>
									</select>									</td>
								  </tr>
						
								
								<tr>

								 <td>WAREHOUSE: </td>

									<td>

								<select name="warehouse_id" id="warehouse_id" style="width:220px;" required>
								 
								  
								  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
								</select>									</td>
									<td>REMARKS:</td>
									<td>
								<input style="width:220px; height:32px;" name="remarks" type="text" id="remarks"  value="<?=$_POST['remarks']?>"    />		
																	</td>
								  </tr>
								
								</table>

    </div>
	
	<? }?>



<? if(isset($_POST['submit'])){ ?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0" style="font-size:12px; text-transform:uppercase;">
 <thead>
  <tr>
    <th width="17%">Item Code</th>

    <th width="43%">Item Name </th>

    <th width="13%">Unit</th>
    <th width="13%">Stock</th>
    <th width="13%">Receive Qty </th>
    <th width="11%">cost Price </th>
    <th width="16%">Total Amt</th>
  </tr>
  </thead>

  <?
  
  
  if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and c.chalan_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
  
  
	
 if($_POST['account_code']!='')
  $account_code_con=" and d.ledger_id=".$_POST['account_code'];
  
 if($_POST['bill_type']!='')
  $bill_type_con=" and bill_type=".$_POST['bill_type'];
  




  

  
  
   $sql = "select item_id, sum(item_in-item_ex) as stock_qty from journal_item where ji_date<='".$_POST['receive_date']."'  group by item_id";
$query = mysql_query($sql);
while($data=mysql_fetch_object($query)){
$stock_qty[$data->item_id]=$data->stock_qty;
}
 
   
    $sql = "SELECT i.item_id, i.item_name, i.unit_name, i.cost_price FROM item_info i, item_sub_group s WHERE i.sub_group_id=s.sub_group_id  and s.group_id=200000000 order  by i.sub_group_id, i.item_id ";

  $query = mysql_query($sql);

  while($data=mysql_fetch_object($query)){$i++;

  ?>
<? //if ($due_amt=$data->invoice_amt-$payment_amt[$data->ledger_id][$data->tr_no]+$return_amt[$data->ledger_id][$data->tr_no]>0) {?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><span class="style13" style="color:#000000; font-weight:700;">
      <?=$data->item_id;?>
    </span></td>

    <td>
     <?=$data->item_name;?>    </td>

    <td><span class="style13" style="color:#000000; font-weight:700;">
      <?=$data->unit_name;?>
    </span></td>
    <td><?=number_format($stock_qty[$data->item_id],2);?></td>
    <td>
	
<input name="item_id_<?=$data->item_id?>" id="item_id_<?=$data->item_id?>" type="hidden"   value="<?=$data->item_id?>"  onkeyup="EXPcalculation(<?=$data->item_id?>)" style="width:120px; height:25px;"  />
	
	
 <input name="receive_qty_<?=$data->item_id?>" id="receive_qty_<?=$data->item_id?>" type="text"  value=""  onkeyup="EXPcalculation(<?=$data->item_id?>)" style="width:120px; height:25px;"  />	</td>
    <td><input name="cost_price_<?=$data->item_id?>" id="cost_price_<?=$data->item_id?>" type="text"  value="<?=$data->cost_price;?>" readonly="" onkeyup="EXPcalculation(<?=$data->item_id?>)"  style="width:100px; height:25px;"  /></td>
    <td align="center"><input name="total_amt_<?=$data->item_id?>" id="total_amt_<?=$data->item_id?>" type="text"  readonly=""  value="" style="width:120px; height:25px;"  />	</td>
  </tr>

  <? } //}?>
</table>



</div>
<br /><br />

<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>


<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirmit" type="submit" class="btn1" value="SAVE & NEW" style="width:220px; font-weight:bold; float:right; background:#6699FF; font-size:12px; height:30px; color: #000000;" /></td>

</tr>



</table>
















<p>&nbsp;</p>

</form>

</div><?php */?>



<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>