<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Commercial Invoice';


create_combobox('do_no');
do_calander('#ci_date');
do_calander('#expiry_date');
do_calander('#last_shipment_date');



 $pi_no 		= $_REQUEST['pi_no'];


if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

	
		
		

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		

		$pi_no=$pi_no;
	
		
		$ci_no = next_transection_no('0',$_POST['ci_date'],'commercial_invoice','ci_no');
		

 
   $so_invoice = 'INSERT INTO commercial_invoice (ci_no, ci_date, dn_no, dn_date, sc_invoice_no, sc_invoice_date, export_lc_no, export_lc_date,  group_for, pi_id, pi_no, view_pi_no, pi_date, pi_type, dealer_group, dealer_code, remarks, status, entry_at, entry_by)
  
  VALUES("'.$ci_no.'", "'.$_POST['ci_date'].'", "'.$_POST['dn_no'].'", "'.$_POST['dn_date'].'", "'.$_POST['sc_invoice_no'].'", "'.$_POST['sc_invoice_date'].'", "'.$_POST['export_lc_no'].'", "'.$_POST['export_lc_date'].'",  "'.$_POST['group_for'].'", "'.$_POST['pi_id'].'", "'.$_POST['pi_no'].'", "'.$_POST['view_pi_no'].'", "'.$_POST['pi_date'].'", "'.$_POST['pi_type'].'", "'.$_POST['dealer_group'].'", "'.$_POST['dealer_code'].'", "'.$_POST['remarks'].'", 
  "CHECKED", "'.$entry_at.'", "'.$entry_by.'")';

db_query($so_invoice);









		//if($ch_no>0)
//		{
//		auto_insert_sales_chalan_secoundary($ch_no);
//		}


//$ji_sql = "select a.id, a.so_no, a.so_date, a.item_id, a.group_for, a.group_for_to, a.warehouse_id, a.warehouse_to, w.pl_id, a.unit_price as unit_price, a.qty, a.unit_name, a.total_amt from spare_parts_sale_order a, item_info b, warehouse w where b.item_id=a.item_id and a.warehouse_to=w.warehouse_id and a.so_no='".$so_no."' ORDER by a.id ";
//
//$ji_query = db_query($ji_sql);	
//
//		while($data_ji=mysqli_fetch_object($ji_query))
//
//		{
//
//journal_item_control($data_ji->item_id,$data_ji->warehouse_id, $data_ji->so_date, 0, $data_ji->qty, 'Store Sales', $data_ji->id, $data_ji->unit_price, $data_ji->warehouse_to, $so_no, '','', '', '','',$data_ji->group_for,'');
//
//
//journal_item_control($data_ji->item_id,$data_ji->warehouse_to, $data_ji->so_date,  $data_ji->qty,  0,'Store Sales', $data_ji->id, $data_ji->unit_price, $data_ji->warehouse_id, $so_no, '','', '', '','',$data_ji->group_for,'');
//		
//		
//
//
//journal_item_control($data_ji->item_id,$data_ji->warehouse_to, $data_ji->so_date,  0, $data_ji->qty,'Consumption', $data_ji->id, $data_ji->unit_price, $data_ji->pl_id, $so_no, '','', '', '','',$data_ji->group_for_to,'');
//		
//		
//journal_item_control($data_ji->item_id,$data_ji->pl_id, $data_ji->so_date, $data_ji->qty, 0,  'Consumption', $data_ji->id, $data_ji->unit_price, $data_ji->warehouse_to, $so_no, '','', '', '','',$data_ji->group_for_to,'');
//
//		
//		}
//		
//		
//	

	

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



	function update_value(id)



	{


var id=id; // Rent

var issue_date=(document.getElementById('issue_date').value);
var revise_request=(document.getElementById('revise_request_'+id).value)*1; 

var wo_qty=(document.getElementById('wo_qty_'+id).value)*1; 
var pi_qty=(document.getElementById('pi_qty_'+id).value)*1;
var produced_qty=(document.getElementById('produced_qty_'+id).value)*1; 
var delivered_qty=(document.getElementById('delivered_qty_'+id).value)*1; 


var flag=(document.getElementById('flag_'+id).value); 

var strURL="master_data_revise_approval_ajax.php?id="+id+"&issue_date="+issue_date+"&revise_request="+revise_request+"&wo_qty="+wo_qty+"&pi_qty="+pi_qty
+"&produced_qty="+produced_qty+"&delivered_qty="+delivered_qty+"&flag="+flag;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+id).style.display='inline';

						document.getElementById('divi_'+id).innerHTML=req.responseText;						

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



<script>




function calculation(id){

var chalan=((document.getElementById('chalan_'+id).value)*1);


var pending_qty=((document.getElementById('unso_qty_'+id).value)*1);



 if(chalan>pending_qty)
  {
alert('Can not issue more than pending quantity.');
document.getElementById('chalan_'+id).value='';

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
    width: 215px;
    height: 38px;
    border-radius: 0px !important;
}



</style>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">



<table width="100%" align="center">


  
  <tr>
    <td align="right" bgcolor="#E0E1FF" width="33%">
	<table width="100%" align="center">
	
	<tr>
		  <td>
		  <? $pi_data = find_all_field('pi_master','','id='.$pi_no);?>
		  <? $sc_data = find_all_field('delivery_note','','pi_id='.$pi_no);?>
		  CI No: </td>
		  <td><input name="ci_no" type="text" id="" readonly="ci_no"  style="width:220px; height:30px;" autocomplete="off"  value="<?=$_POST['ci_no'];?>" /></td>
		  </tr>
		
		  
		  <tr>
		  <td>Export LC No: </td>
		  <td><input name="export_lc_no" type="text" id="export_lc_no" required style="width:220px; height:30px;" autocomplete="off"  
		  value="<?=$sc_data->export_lc_no?>" /></td>
		  </tr>
		  
		  <tr>
		  <td>Export LC  Date: </td>
		  <td><input name="export_lc_date" type="text" id="export_lc_date"  required style="width:220px; height:30px;" autocomplete="off"  
		  value="<?=$sc_data->export_lc_date?>" /></td>
		  </tr>
		  
		<tr>
			<td width="38%">Consignee:</td>
			<td width="62%">
			<input name="dealer_group" type="hidden" id="dealer_group"  required style="width:220px; height:30px;" autocomplete="off" 
			 value="<?=$pi_data->dealer_group;?>" />
			<input name="dealer_code" type="hidden" id="dealer_code"  required style="width:220px; height:30px;" autocomplete="off" 
			 value="<?=$pi_data->dealer_code;?>" />
			<input name="" type="text" id="" readonly="" required style="width:220px; height:30px;" autocomplete="off"  value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$pi_data->dealer_code);?>" /></td>
		</tr>
		<tr>
		  <td>Seller:</td>
		  <td>
		  <input name="group_for" type="hidden" id="group_for"  required style="width:220px; height:30px;" autocomplete="off" 
			 value="<?=$_SESSION['user']['group'];?>" />
		  <input name="" type="text" id="" readonly="" required style="width:220px; height:30px;" autocomplete="off"  value="<?=find_a_field('user_group','group_name','id='.$_SESSION['user']['group']);?>" /></td>
		  </tr>
		<tr>
		  <td>D/N No:</td>
		  <td><input name="dn_no" type="text" id="dn_no" readonly="" required style="width:220px; height:30px;" autocomplete="off" 
		   value="<?=$sc_data->dn_no?>" /></td>
		  </tr>
	</table>	</td>
    <td align="right" bgcolor="#E0E1FF"  width="36%">
	<table width="100%" align="center">
		<tr>
		  <td>CI Date: </td>
		  <td><input name="ci_date" type="text" id="ci_date"  required style="width:220px; height:30px;" autocomplete="off" 
		   value="<?=$_POST['ci_date'];?>" /></td>
		  </tr>
		<tr>
			<td width="44%">PI No:</td>
			<td width="56%">
			<input name="pi_id" type="hidden" id="pi_id" readonly="" required style="width:220px; height:30px;" autocomplete="off"  value="<?=$pi_data->id;?>" />
			<input name="pi_no" type="hidden" id="pi_no" readonly="" required style="width:220px; height:30px;" autocomplete="off"  value="<?=$pi_data->pi_no;?>" />
			
			<input name="pi_type" type="hidden" id="pi_type" readonly="" required style="width:220px; height:30px;" autocomplete="off"  value="<?=$pi_data->pi_type;?>" />
			
			<input name="view_pi_no" type="text" id="view_pi_no" readonly="" required style="width:220px; height:30px;" autocomplete="off"  value="<?=$pi_data->view_pi_no;?>" /></td>
		</tr>
		<tr>
		  <td>PI Date:</td>
		  <td><input name="pi_date" type="text" id="pi_date" readonly="" required style="width:220px; height:30px;" autocomplete="off"  value="<?=$pi_data->pi_date;?>" /></td>
		  </tr>
		<tr>
		  <td>Sales Contract No:</td>
		  <td><input name="sc_invoice_no" type="text" id="sc_invoice_no" readonly="" required style="width:220px; height:30px;" autocomplete="off" 
		   value="<?=$sc_data->sc_invoice_no?>" /></td>
		  </tr>
		<tr>
		  <td>Sales Contract Date:</td>
		  <td><input name="sc_invoice_date" type="text" id="sc_invoice_date" readonly="" required style="width:220px; height:30px;" autocomplete="off" 
		   value="<?=$sc_data->sc_invoice_date?>" /></td>
		  </tr>
		<tr>
		  <td>D/N Date:</td>
		  <td><input name="dn_date" type="text" id="dn_date" readonly="" required style="width:220px; height:30px;" autocomplete="off" 
		   value="<?=$sc_data->dn_date?>" /></td>
		  </tr>
	</table>	</td>
	</tr>
</table>

<br />

<?

if($pi_no>0){




	$sql = "select  order_no, sum(total_unit) as produced_qty  from sale_do_production_issue where 1  group by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $produced_qty[$info->order_no]=$info->produced_qty;

		}


	$sql = "select  order_no, sum(total_unit) as challan_qty  from sale_do_chalan where 1  group by order_no ";
		 $query = db_query($sql);
		 while($info=mysqli_fetch_object($query)){
  		 $challan_qty[$info->order_no]=$info->challan_qty;

		}



   $sql='select a.id, a.order_no, a.item_id,  a.unit_price, s.sub_category,  b.item_name,  b.unit_name, a.ply, a.paper_combination, a.L_cm, a.W_cm, a.H_cm, a.measurement_unit,  a.total_unit as total_unit, a.total_amt,
  a.delivery_place, a.delivery_date, a.style_no, a.po_no, a.referance, a.sku_no, a.color, a.size, a.weight_per_sqm, a.sqm
   from pi_details a,item_info b, item_sub_group s where b.item_id=a.item_id 
  and b.sub_group_id=s.sub_group_id and  a.pi_id="'.$pi_no.'" order by a.id';

$res=db_query($sql);

?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>

            <th width="2%" bgcolor="#BFE0FF">SL</th>

            <th width="14%" bgcolor="#BFE0FF">Item_Name </th>

            <th width="6%" bgcolor="#BFE0FF"><strong>Style No</strong></th>
            <th width="7%" bgcolor="#BFE0FF"><strong>PO No</strong></th>
            <th width="9%" bgcolor="#BFE0FF">Referance</th>
            <th bgcolor="#BFE0FF">UOM</th>

            <th bgcolor="#BFE0FF">Ply</th>
            <th bgcolor="#BFE0FF">Measurement</th>
            <th bgcolor="#BFE0FF">PI Qty </th>

            <th bgcolor="#BFE0FF">Qty in (KG) </th>
            <th bgcolor="#BFE0FF">Price</th>

            <th bgcolor="#BFE0FF">PI Value</th>
            <th bgcolor="#BFE0FF">Delivery Qty </th>
          </tr>
          
          

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_name?>
			
			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />	
			<input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->unit_price?>" />	</td>

              <td>
			  
		<? 
		  if ($row->style_no!="") {
		  echo $row->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td>
			  <? 
		  if ($row->po_no!="") {
		  echo $row->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td><? 
		  if ($row->referance!="") {
		  echo $row->referance;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td width="3%" align="center"><?=$row->unit_name?>                </td>

              <td width="2%" align="center"><?=$row->ply?></td>
              <td width="14%" align="center">
			  
			  <? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?><?=$row->measurement_unit?>			  </td>
              <td width="8%" align="center"><?=number_format($row->total_unit,2); $total_pcs +=$row->total_unit;?>			  </td>

              <td width="8%" align="center"><?= number_format($qty_in_kg = ($row->sqm*$row->weight_per_sqm*$row->total_unit),2); $total_qty_in_kg +=$qty_in_kg;  ?></td>
              <td width="6%" align="center">$ <?=$row->unit_price;?>		</td>

              <td width="11%" align="center">$ <?=$row->total_amt; $total_amt +=$row->total_amt;?></td>
              <td width="10%" align="center"><?=$challan_qty[$row->order_no];?></td>
          </tr>
          

          <? }?>
		  
		  <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center"><strong>Ttotal:</strong></td>
            <td align="center"><?=$total_pcs?></td>
            <td align="center"><?=number_format($total_qty_in_kg,2);?></td>
            <td align="center">&nbsp;</td>
            <td align="center">$ <?=number_format($total_amt,2);?></td>
            <td align="center">&nbsp;</td>
		  </tr>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br /> 
  

<table width="100%" border="0">

<? 

 		 //$wo_qty = find_a_field('sale_do_details','sum(total_unit)','do_no='.$_POST['do_no']);
		 // $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$_POST['do_no']);


//if($issue_qty>=$wo_qty){




?>

<?php /*?><tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS  WORK ORDER IS COMPLETE</strong></td>

</tr><?php */?>

<? //}else{?>

<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="CONFIRM ENTRY" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? //}?>

</table>

<? }?>

<p>&nbsp;</p>

</form>

</div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>