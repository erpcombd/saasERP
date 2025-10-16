<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Production Issue Entry';



do_calander('#issue_date');



$table_master='sale_do_master';

$table_details='sale_do_details';

 $unique='do_no';






if($_SESSION[$unique]>0)

$$unique=$_SESSION[$unique];



if($_REQUEST[$unique]>0){

$$unique=$_REQUEST[$unique];

$_SESSION[$unique]=$$unique;}

else

 $$unique = $_SESSION[$unique];







if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

	
		
		$group_for = $_POST['group_for'];

		$issue_date=$_POST['issue_date'];
		
		$remarks=$_POST['remarks'];
		

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		

		
		
		//$chalan_no = next_transection_no($group_for,$ch_date,'sale_do_chalan','chalan_no');
		
		$chalan_no = next_transection_no('0',$issue_date,'sale_do_production_issue','chalan_no');
		
	
		$ms_data = find_all_field('sale_do_master','','do_no='.$do_no);

		 $sql = 'select * from sale_do_details where  do_no = '.$do_no;

		$query = db_query($sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);


		while($data=mysqli_fetch_object($query))

		{
	

			if($_POST['chalan_'.$data->id]>0)

			{
			

				$qty=$_POST['chalan_'.$data->id];

				$rate=$_POST['rate_'.$data->id];

				$item_id =$_POST['item_id_'.$data->id];
				
				$item_name =$_POST['item_name_'.$data->id];

				
				$amount = ($qty*$rate); 
 


  $so_invoice = "INSERT INTO sale_do_production_issue (chalan_no, chalan_date, order_no, do_no, do_date, job_no, delivery_date, group_for, dealer_code, buyer_code, merchandizer_code, destination, delivery_place, customer_po_no, unit_name, measurement_unit, ply, paper_combination_id, paper_combination, L_cm, W_cm, H_cm, WL, WW, item_id, formula_id, formula_cal, sqm_rate, sqm, additional_info, additional_charge, final_price, unit_price, total_unit, total_amt, style_no, po_no, referance, sku_no, printing_info, color, pack_type, size, depot_id, status, entry_time, edit_request, edit_accept, request_by, request_at, accept_by, accept_at, entry_by, entry_at, edit_by, edit_at, checked_by, checked_at, remarks)
  
  VALUES('".$chalan_no."', '".$issue_date."', '".$data->id."',  '".$data->do_no."', '".$data->do_date."', '".$data->job_no."', '".$data->delivery_date."', '".$data->group_for."', '".$data->dealer_code."', '".$data->buyer_code."', '".$data->merchandizer_code."', '".$data->destination."', '".$data->delivery_place."', '".$data->customer_po_no."', '".$data->unit_name."', '".$data->measurement_unit."', '".$data->ply."', '".$data->paper_combination_id."', '".$data->paper_combination."', '".$data->L_cm."', '".$data->W_cm."', '".$data->H_cm."', '".$data->WL."', '".$data->WW."', '".$data->item_id."', '".$data->formula_id."', '".$data->formula_cal."', '".$data->sqm_rate."', '".$data->sqm."', '".$data->additional_info."', '".$data->additional_charge."', '".$data->final_price."', '".$rate."', '".$qty."', '".$amount."', '".$data->style_no."', '".$data->po_no."', '".$data->referance."', '".$data->sku_no."', '".$data->printing_info."', '".$data->color."', '".$data->pack_type."', '".$data->size."', '".$data->depot_id."', 'UNCHECKED', '0', '0', '0', '0', '0', 
  '0', '0', '".$entry_by."', '".$entry_at."', '0', '0', '0', '0', '".$remarks."')";

db_query($so_invoice);



}

}



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



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

//if($delivery_within>0)
//{
//	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);
//}







?>


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



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td width="40%" valign="top"><fieldset style="width:100%;">

    <? $field='do_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">WO  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

      </div>

    <? $field='do_date';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">WO Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>
	  
	  
	  
	 
	  
	   <? $field='job_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">Job No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      </div>
	  
	  
	   <? $field='customer_po_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">Customer's PO:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      </div>

    

  
	  
	  
	   


     

    </fieldset></td>

    <td width="9%">			</td>

    <td width="40%"><fieldset style="width:100%;">
	
	
	
	<? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">Company:</label>

        <input  name="group_for2" type="text" id="group_for2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" style="width:200px;" />

		<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required="required"/>

      </div>
	  
	  
	  <div>

        <label style="width:120px;" for="<?=$field?>"> Customer:</label>

        <input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);?>" required="required"/>

		<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code?>" required="required"/>

      </div>
	
	


      <div>

        <label style="width:120px;" for="<?=$field?>"> Buyer:</label>

         <input  name="buyer_info2" type="text" id="buyer_info2" value="<?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer_code);?>" required="required"/>

		<input  name="buyer_code" type="hidden" id="buyer_code" value="<?=$buyer_code?>" required="required"/>

      </div>

      <div></div>
 

      <div>

        <label style="width:120px;" for="<?=$field?>">Merchandiser:</label>

        <input  name="merchandizer_code2" type="text" id="merchandizer_code2" value="<?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer_code);?>" required="required"/>

		<input  name="merchandizer_code" type="hidden" id="merchandizer_code" value="<?=$merchandizer_code?>" required="required"/>

      </div>

              

      <div>


      

      </div>

		</fieldset></td>

    <td width="2%">&nbsp;</td>

    <?php /*?><td width="16%" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;">

	          

        <tr>

          <td align="left" bgcolor="#9999CC"><strong>Date</strong></td>

          <td align="left" bgcolor="#9999CC"><strong>PR</strong></td>

        </tr>

<?

$sql='select distinct pr_no,rec_date from purchase_receive where po_no='.$po_no.' order by id desc';

$qqq=db_query($sql);

while($aaa=mysqli_fetch_object($qqq)){

?>

        <tr>

          <td bgcolor="#FFFF99"><?=$aaa->rec_date?></td>

          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="../pr_fg/chalan_view.php?v_no=<?=$aaa->pr_no?>"><img src="../../images/print.png" width="15" height="15" /></a></td>

        </tr>

<?

}

?>



      </table></td><?php */?>

  </tr>

  <tr>

    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="4" align="center" bgcolor="#CCFF99"><strong> Entry Information</strong></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created By:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

        

        <td rowspan="2" align="left" bgcolor="#CCFF99"><a title="WO Preview" target="_blank" href="../../../sales_mod/pages/wo/work_order_print_view.php?v_no=<?=$$unique?>" ><img src="../../../images/print.png" alt="" width="30" height="30" /></a></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created On:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=$entry_at?></td>
        </tr>

    </table></td>

  </tr>

  <tr>

    <td colspan="5" valign="top">

<?php /*?>	<? if($ex<time()){?>

	<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">

      <tr>

        <td align="right" bgcolor="#FF0000"><div align="center" style="text-decoration:blink"><strong>THIS PURCHASE ORDER IS EXPIRED</strong></div></td>

        </tr>

    </table>

    <? }?><?php */?>

	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
      <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr style="height:40px;">
          <td align="right" width="20%" bgcolor="#00A59A"><strong> Date :</strong></td>
          <td align="left" width="20%"bgcolor="#00A59A"><strong>
            <input style="width:120px;"  name="issue_date" type="text" id="issue_date" required="required" value="<?=date('Y-m-d')?>"/>
          </strong></td>
          <td bgcolor="#00A59A" align="right" width="20%"><strong>Reasons:</strong></td>
          <td bgcolor="#00A59A" align="left" width="40%"><strong>
            <input style="width:300px;"  name="remarks" type="text" id="remarks" required="required"/>
         
		
		  </strong></td>
        </tr>
      </table></td>
    </tr>
    </table></td>

    </tr>

</table>

<? if($$unique>0){

  $sql='select a.id,  a.item_id,  a.unit_price, s.sub_category,  b.item_name,  b.unit_name, a.ply, a.paper_combination, a.L_cm, a.W_cm, a.H_cm, a.measurement_unit,  a.total_unit as qty ,
  a.delivery_place, a.delivery_date, a.style_no, a.po_no, a.referance, a.sku_no, a.color, a.size, b.pack_size from sale_do_details a,item_info b, item_sub_group s where b.item_id=a.item_id 
  and b.sub_group_id=s.sub_group_id and  a.do_no='.$$unique;

$res=db_query($sql);

?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp" style="font-size:12px">

      <tbody>

          <tr>

            <th width="1%">SL</th>

            <th width="15%">Item_Name </th>

            <th width="3%"><strong>Style No</strong></th>
            <th width="2%"><strong>PO No</strong></th>
            <th width="2%">Referance</th>
            <th width="2%"><strong>SKU</strong></th>
            <th width="2%"><strong>Color</strong></th>
            <th width="2%"><strong>Size</strong></th>
            <th bgcolor="#FFFFFF">UOM</th>

            <th bgcolor="#FFFFFF">Ply</th>
            <th bgcolor="#FFFFFF">Measurement</th>
            <th bgcolor="#FFFFFF">Delivery Date </th>
            <th bgcolor="#FF99FF">WO_Qty </th>

            <th bgcolor="#009900">Produced</th>

            <th bgcolor="#FFFF00">Pending </th>

            <th bgcolor="#F57E22">Production Issue </th>
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
              <td>
			  <? 
		  if ($row->sku_no!="") {
		  echo $row->sku_no;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td>
			  
			  <? 
		  if ($row->color!="") {
		  echo $row->color;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td>
			  
			   <? 
		  if ($row->size!="") {
		  echo $row->size;
		  } else {
		  echo 'N/A';
		  }
		  ?>			  </td>
              <td width="2%" align="center"><?=$row->unit_name?>                </td>

              <td width="1%" align="center"><?=$row->ply?></td>
              <td width="6%" align="center">
			  
			  <? if($row->L_cm>0) {?><?=$row->L_cm?><? }?><? if($row->W_cm>0) {?>X<?=$row->W_cm?><? }?><? if($row->H_cm>0) {?>X<?=$row->H_cm?><? }?><?=$row->measurement_unit?>			  </td>
              <td width="4%" align="center"><?php echo date('d-m-Y',strtotime($row->delivery_date));?></td>
              <td width="2%" align="center"><?=number_format($row->qty,2);?></td>

              <td width="4%" align="center"><? echo number_format($so_qty = (find_a_field('sale_do_production_issue','sum(total_unit)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?></td>

              <td width="4%" align="center"><? echo number_format($unso_qty=($row->qty-$so_qty),2);?>

                <input type="hidden" name="unso_qty_<?=$row->id?>" id="unso_qty_<?=$row->id?>" value="<?=$unso_qty?>"  onKeyUp="calculation(<?=$row->id?>)" /></td>

              <td width="6%" align="center" bgcolor="#F57E22">
			   <? if($unso_qty>0){$cow++;?>

          <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" value=""  style="width:80px; height:25px; float:none"  onKeyUp="calculation(<?=$row->id?>)" />
  
		  
                <? } else echo 'Done';?>			  </td>
              </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br /> <br />
  

	
	<br />
  

<table width="100%" border="0">

<? 

 		 $wo_qty = find_a_field('sale_do_details','sum(total_unit)','do_no='.$$unique);
		  $issue_qty = find_a_field('sale_do_production_issue','sum(total_unit)','do_no='.$$unique);


if($issue_qty>=$wo_qty){




?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS  WORK ORDER IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/>
<input name="confirm" type="submit" class="btn1" value="CONFIRM ISSUE" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table>

<? }?>

</form>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";


?>