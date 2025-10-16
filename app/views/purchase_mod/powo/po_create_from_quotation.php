<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Purchased Order Create';



do_calander('#po_date');



$table_master='quotation_master';

$table_details='quotation_detail';

$unique='quotation_no';



if($_SESSION[$unique]>0)

$$unique=$_SESSION[$unique];



if($_REQUEST[$unique]>0){

$$unique=$_REQUEST[$unique];

$_SESSION[$unique]=$$unique;}

else

$$unique = $_SESSION[$unique];







if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$_POST['status']='COMPLETED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Completed All Purchase Order.';

}



if(isset($_POST['delete']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['status']='CANCELED';

		$crud   = new crud($table_master);

		$crud->update($unique);



		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Canceled Remainning All Purchase Order.';

}



if(prevent_multi_submit()){



if(isset($_POST['confirm'])){

		$vendor_id = $_POST['vendor_id'];

		$warehouse_id = $_POST['warehouse_id'];
		
		$group_for = $_POST['group_for'];

		$po_date=$_POST['po_date'];
		
		$tax=$_POST['tax'];
		
		$po_details=$_POST['po_details'];

		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		$po_no=find_a_field('purchase_master', 'max(po_no)','1')+1;
		
		
		
		
		
		
		$ms_sql = 'select * from quotation_master where quotation_no = '.$quotation_no;

		$ms_query = db_query($ms_sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);


		while($ms_data=mysqli_fetch_object($ms_query))

		{

			


 $po_ms = "INSERT INTO `purchase_master` (`po_no`, `group_for`,  `vendor_id`, `po_details`, `req_no`, `quotation_no`, `warehouse_id`, `po_date`, `status`,   `tax`,  `entry_at`, `entry_by`) VALUES('".$po_no."', '".$ms_data->group_for."',  
'".$ms_data->vendor_id."', '".$po_details."','".$ms_data->req_no."', '".$ms_data->quotation_no."', 
'1', '".$po_date."', 'CHECKED', '".$tax."',   
'".$entry_at."', '".$entry_by."')";

db_query($po_ms);



}

		
		
		
		

		

		$sql = 'select * from quotation_detail where quotation_no = '.$quotation_no;

		$query = db_query($sql);

		//$pr_no = next_pr_no($warehouse_id,$rec_date);


		while($data=mysqli_fetch_object($query))

		{

			if(($_POST['chalan_'.$data->id]>0))

			{

				$qty=$_POST['chalan_'.$data->id];

				$rate=$_POST['rate_'.$data->id];

				$item_id =$_POST['item_id_'.$data->id];

				
				$amount = ($qty*$rate);


 $po_invoice = "INSERT INTO `purchase_invoice` (`po_no`, `po_date`, `req_no`, `req_id`, `quotation_no`, `quotation_id`, `vendor_id`, `item_id`, `warehouse_id`, `rate`, order_qty, `qty`, `unit_name`,  `amount`, `entry_by`, `entry_at`, `status`) VALUES('".$po_no."', '".$po_date."', '".$data->req_no."', '".$data->order_no."', '".$data->quotation_no."', 
'".$data->id."', '".$data->vendor_id."','".$item_id."', '1', '".$rate."','".$qty."', 
 '".$qty."', '".$data->unit_name."', '".$amount."', '".$entry_by."',  '".$entry_at."', '0')";

db_query($po_invoice);

}

}


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



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td width="40%" valign="top"><fieldset style="width:100%;">

    <? $field='quotation_no';?>

      <div>

        <label style="width:130px;" for="<?=$field?>">Quotation  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

      </div>

    <? $field='quotation_date';?>

      <div>

        <label style="width:130px;" for="<?=$field?>">Quotation Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>

    

    <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>

      <div>

        <label style="width:130px;" for="<?=$field?>">Warehouse:</label>

        <input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'=1')?>" required="required"/>

		<input  name="warehouse_id" type="hidden" id="warehouse_id" value="1" required="required"/>

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
	
	

    <? $field='req_no';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">Requisition No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" />

      </div>

      <div></div>

      <? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>

      <div>

	  <label style="width:120px;" for="<?=$field?>">Vendor:</label>

      <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$vendor_id)?>"/>

      </div>

              

      <div>


      

      </div>

		</fieldset></td>

    <td width="2%">&nbsp;</td>

    <td width="16%" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;">

	          

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



      </table></td>

  </tr>

  <tr>

    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Quotation Entry Information</strong></td>

      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created By:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

        <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="../../../purchase_mod/pages/quotation/quotation_print_view.php?quotation_no=<?=$quotation_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>

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

	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>

        <td width="14%" align="right" bgcolor="#9999FF"><strong>PO Date :</strong></td>

        <td width="21%" bgcolor="#9999FF"><strong>

          <input style="width:120px;"  name="po_date" type="text" id="po_date" value="" required="required"/>

         
        </strong></td>

        <td width="16%" bgcolor="#9999FF"><div align="right"><strong>PO VAT (%):</strong></div></td>
        <td width="11%" bgcolor="#9999FF">
		<input style="width:80px;"  name="tax" type="text" id="tax" value="" required="required"/>		</td>
        <td width="10%" bgcolor="#9999FF"><div align="right"><strong>Remarks:</strong></div></td>
        <td width="28%" bgcolor="#9999FF">
			<input style="width:180px;"  name="po_details" type="text" id="po_details" value=""/>
		</td>
      </tr>
    </table></td>

    </tr>

</table>

<? if($$unique>0){

 $sql='select a.id, a.order_no, a.item_id,  b.item_name,  b.unit_name, a.quotation_brand, a.qty, a.quotation_price from quotation_detail a,item_info b where b.item_id=a.item_id and a.quotation_no='.$$unique;

$res=db_query($sql);

?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th width="3%">SL</th>

            <th width="41%">Item Name</th>

            <th bgcolor="#FFFFFF">Unit</th>

            <th bgcolor="#FF99FF">Quotation Price </th>
            <th bgcolor="#FF99FF">Req. Qty </th>

            <th bgcolor="#009900">Purchased </th>

            <th bgcolor="#FFFF00">Pending </th>

            <th bgcolor="#0099CC">PO Qty </th>
          </tr>
          

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_name?>
			
			<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" />              </td>

              <td width="4%" align="center"><?=$row->unit_name?>

                <input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>

              <td width="9%" align="center">
			  <?=$row->quotation_price?>
			    <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->quotation_price?>" />			  </td>
              <td width="11%" align="center"><?=$row->qty?></td>

              <td width="10%" align="center"><? echo $po_qty = (find_a_field('purchase_invoice','sum(qty)','req_id="'.$row->order_no.'" and item_id="'.$row->item_id.'"')*(1));?></td>

              <td width="8%" align="center"><? echo $unpo_qty=($row->qty-$po_qty);?>

                <input type="hidden" name="unpo_qty_<?=$row->id?>" id="unpo_qty_<?=$row->id?>" value="<?=$unpo_qty?>" /></td>

              <td width="9%" align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($unpo_qty>0){$cow++;?>

                <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" style="width:100px; float:none" value="" />

                <? } else echo 'Done';?></td>
              </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br />

<table width="100%" border="0">

<? if($cow<1){

$vars['status']='COMPLETED';

db_update($table_master, $po_no, $vars, 'quotation_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS PURCHASE REQUISITION IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input name="delete" type="button" class="btn1" value="CANCEL PO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" onclick="window.location = 'select_dealer_chalan.php?del=1&po_no=<?=$po_no?>';" />

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn1" value="PO CONFIRM" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>

<? }?>

</table>

<? }?>

</form>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?
$tr_from="Purchase";
require_once SERVER_CORE."routing/layout.bottom.php";
?>