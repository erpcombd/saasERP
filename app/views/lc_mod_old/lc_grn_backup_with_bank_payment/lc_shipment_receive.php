<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='GRN Entry';



do_calander('#rec_date');

do_calander('#lc_bill_date');


$table_master='lc_bank_payment';

$table_details='lc_purchase_invoice';

$unique='payment_no';



$lc_manual_no = find_a_field('lc_purchase_master','lc_manual_no','po_no='.$po_no);


if($_GET['po_no']>0)
$_SESSION[$unique]=$po_no=$_GET['po_no'];

if($_SESSION[$unique]>0)

$$unique=$_SESSION[$unique];



if($_REQUEST[$unique]>0){

$$unique=$_REQUEST[$unique];

$_SESSION[$unique]=$$unique;}

else

$$unique = $_SESSION[$unique];



if(prevent_multi_submit()){



if(isset($_POST['confirmm']))

{

		//unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$_POST['status']='WO COMPLETED';

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

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$_POST['status']='CANCELED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		



		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Canceled Remainning All Purchase Order.';

}





if(isset($_POST['journal_create']))

{

		$shipment_no = $_POST['pr_no'];

 		$sql1 = "update lc_purchase_receive set status='SHIPMENT COMPLETED' where shipment_no='".$shipment_no."'";
		db_query($sql1);
		
		//$sql2 = "update lc_purchase_shipment set status='SHIPMENT COMPLETED' where pr_no='".$shipment_no."'";
		//db_query($sql2);
		
		//auto_insert_shipment_complete_secoundary_journal($shipment_no);
		
		
		
		?>
		
		
<script language="javascript">
window.location.href = "select_upcoming_shipment.php";
</script>
		
		
		<?

}







if(isset($_POST['confirm'])){
//echo 'Omar';


		 $po_no = $_POST['po_no']; 

		$vendor_id = $_POST['vendor_id'];
		
		$group_for = $_POST['group_for']; 
		
		$pi_no = $_POST['pi_no'];
		$payment_no = $_POST['payment_no'];
		$payment_id = $_POST['payment_id'];
		
		$lc_no = $_POST['lc_no'];
		
		$lc_part = $_POST['lc_part'];
		
		$lc_date = $_POST['lc_date'];
		
		$group_for = $_POST['group_for'];
		
		$lc_manual_no = $_POST['lc_manual_no'];
		
		$warehouse_id = $_POST['warehouse_id'];
		
		$_POST['status']='PRODUCT RECEIVED';

		$rec_date=$_POST['rec_date'];

		
		$now = date('Y-m-d H:i:s');

	    $sql = 'select * from lc_purchase_invoice where po_no = '.$po_no;

		$query = db_query($sql);

		$rec_no = find_a_field('lc_purchase_receive','max(pr_no)','1')+1;



		while($data=mysqli_fetch_object($query))

		{
//echo 'Mhafuz1';
			if(($_POST['chalan_'.$data->id]>0))
			{
//echo 'Faruk';

			 	$qty=$_POST['chalan_'.$data->id];
				$undel_qty=$_POST['unrec_qty_'.$data->id];	
				$rate_usd =$_POST['rate_usd_'.$data->id];				
				$lot_no =$_POST['lot_no_'.$data->id];
				
				//$exchange_rate =$_POST['exchange_rate_'.$data->id];

				//$rate = $exchange_rate*$rate_usd;
				
				//$amount = ($qty*$rate);
				
				$amount_usd = ($qty*$rate_usd);

				//if($qty<=$undel_qty){

				$item_id =$_POST['item_id_'.$data->id];

				$unit_name =$data->unit_name;
				
				//$rate = ($rate_usd*$usd_exchange_rate);
				
				//$amount = (($qty*$rate_usd)*$usd_exchange_rate);

				//$total = $total + $amount; 

   $q = 'INSERT INTO lc_purchase_receive
   (pr_no, po_no, order_no, payment_no,  payment_id,  lc_part, rec_date,   lc_no, vendor_id, item_id, group_for, warehouse_id, exchange_rate, rate, rate_usd, qty, unit_name, amount, amount_usd, status, entry_by, entry_at) 

   VALUES("'.$rec_no.'", "'.$data->po_no.'", "'.$data->id.'", "'.$payment_no.'",  "'.$payment_id.'",  "'.$lc_part.'", 
   "'.$rec_date.'", "'.$lc_no.'",  "'.$data->vendor_id.'", "'.$item_id.'", "'.$group_for.'", "'.$warehouse_id.'",
    "'.$exchange_rate.'", "'.$rate.'", "'.$rate_usd.'",  "'.$qty.'", "'.$unit_name.'",  "'.$amount.'", "'.$amount_usd.'", "CHECKED", "'.$_SESSION['user']['id'].'", "'.$now.'")';

db_query($q);

$xid = db_insert_id();

//$moving_avg_price = moving_average_price_calculation($item_id,$qty,$amount,$data->group_for);

//journal_item_control($item_id, $warehouse_id, $rec_date,  $qty, 0,  'Purchase', $rec_no, $rate, $warehouse_id, $data->pr_no, 
//'', '', $data->po_no, $lc_manual_no, '', $data->group_for, $moving_avg_price);



//}

}
}






		//$up_sql1 = "update lc_bank_payment set status='COMPLETED' where payment_no='".$payment_no."'";
//		db_query($up_sql1);






	?>
		
		
<!--<script language="javascript">
window.location.href = "select_upcoming_shipment.php";
</script>-->
		
		
		<?



}



else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}

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

?>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td valign="top" width="45%" ><fieldset style="width:100%;">

    <? $field='payment_no';?>

      <div>

        <label style="width:150px;" for="<?=$field?>">Invoice No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" readonly="" value="<?=$$field?>"/>
		
		<input  name="payment_id" type="hidden" id="payment_id" readonly="" value="<?=$id;?>"/>

      </div>

   
	  
	 

    

    <? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>

      <div>

        <label style="width:150px;" for="<?=$field?>">Concern:</label>

        <input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" readonly="readonly"/>

		<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required="required"/>

      </div>
	  
	 
	  
	  
	  <div></div>
	   
	 

	  
	  
      <div></div>

      <? $field='vendor_id'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>
	  
	  <? $po_data = find_all_field('lc_purchase_master','','lc_no="'.$lc_no.'"');?>

      <div>

	  <label style="width:150px;" for="<?=$field?>">Supplier:</label>

      <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$po_data->vendor_id)?>"  readonly="readonly"/>

      </div>
	  
	   <div></div>
	   
	  


    

    </fieldset></td>

    <td>			</td>

    <td width="45%" ><fieldset style="width:100%;">
	
	
	
	

  
	  
	  
	 

      <div>

        <label style="width:110px;" for="<?=$field?>">PI No:</label>

        <input  name="pi_no" type="text" id="pi_no" value="<?=$po_data->pi_no?>" readonly="" required/>
		
		<input  name="po_no" type="hidden" id="po_no" value="<?=$po_data->po_no?>" readonly="" required/>

      </div>
	  
	 
	  
	  
   <div></div>
	   
	 

      <? $field='lc_no'; $table='lc_number_setup';$get_field='id';$show_field='lc_number';?>

      <div>

	  <label style="width:110px;" for="<?=$field?>"> L/C No:</label>

      <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>"  readonly="readonly"/>
	  
	  <input  name="lc_no" type="hidden" id="lc_no" value="<?=$lc_no?>" required="required"/>

      </div>
	  
	  
	   <? $field='lc_part';?>

        <div>

<label style="width:110px;" for="<?=$field?>">LC Part:</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="" required/>

        </div>


         

      

		</fieldset></td>

    <td>&nbsp;</td>

    <td valign="top"><?php /*?><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;">

	          

        <tr>

          <td align="left" bgcolor="#9999CC"><strong>Date</strong></td>

          <td align="left" bgcolor="#9999CC"><strong>PR</strong></td>

        </tr>

<?

$sql='select distinct pr_no,shipment_date from lc_purchase_shipment where po_no='.$po_no.' order by pr_no desc';

$qqq=db_query($sql);

while($aaa=mysqli_fetch_object($qqq)){

?>

        <tr>

          <td bgcolor="#FFFF99"><?=$aaa->shipment_date?></td>

          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="../lc_pr/lc_shipment_print_view.php?v_no=<?=$aaa->pr_no?>"><img src="../../images/print.png" width="15" height="15" /></a></td>

        </tr>

<?

}

?>



      </table><?php */?></td>

  </tr>

  <tr>

    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="3" align="center" bgcolor="#10afe7"><strong>Entry Information</strong></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#10afe7">Created By:</td>

        <td align="left" bgcolor="#10afe7">&nbsp;&nbsp;
          <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

        <td rowspan="2" align="center" bgcolor="#10afe7"><a href="lc_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#10afe7">Created On:</td>

        <td align="left" bgcolor="#10afe7">&nbsp;&nbsp;

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
        <td width="21%" align="right" bgcolor="#339999"><strong>Receive Date: </strong></td>
        <td width="9%" align="right" bgcolor="#339999">
		<input style="width:120px; height:25px;"  name="rec_date" type="text" id="rec_date" value="<?=($rec_date!='')?$rec_date:date('Y-m-d')?>" />		</td>
        <td width="18%" align="right" bgcolor="#339999"><strong> Warehouse: </strong><strong></strong></td>
        <td bgcolor="#339999"> 
		
		<select name="warehouse_id" id="warehouse_id" style="width:200px; height:25px; float:left" required tabindex="3">

						<option></option>

                       <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'], 'use_type="WH"');?>
		</select>
		
		<strong>
		
		</strong></td>
        <td width="17%" align="right" bgcolor="#339999"><strong>Remarks:</strong></td>
        <td width="14%" bgcolor="#339999"><input style="width:200px; height:25px;"  name="remarks" type="text" id="remarks" value="<?=$_POST['remarks'];?>" /></td>
      </tr>
      
	
	  
	 <?php /*?> <? if($status=="PRODUCT RECEIVED") {?>
	  
	  <tr>
        <td align="right" bgcolor="#9999FF"><strong> C&amp;F Agent: </strong><strong></strong></td>
        <td align="right" bgcolor="#9999FF">
		<select name="cnf_agent" id="cnf_agent" style="width:105px;">
			<option></option>
			<?= foreign_relation('cnf_company','company_id','company_name',$cnf_agent);?>
		</select>
		</td>
        <td align="right" bgcolor="#9999FF"><strong>Bill Date: </strong></td>
        <td bgcolor="#9999FF"><input style="width:105px;"  name="lc_bill_date" type="text" id="lc_bill_date"  value="<?= $_POST['lc_bill_date']=date('Y-m-d')?>" /></td>
        <td bgcolor="#9999FF"><strong>Item Asses. Value:</strong></td>
        <td bgcolor="#9999FF"><strong>
          <input style="width:105px;"  name="item_assessable_value" type="text" id="item_assessable_value" value="<?=$_POST['item_assessable_value'];?>" />
        </strong></td>
      </tr>
	  
	  
	  <tr>
        <td align="right" bgcolor="#9999FF"><strong>DF: </strong><strong></strong></td>
        <td align="right" bgcolor="#9999FF"><input style="width:105px;"  name="df_tax" type="text" id="df_tax" value="<?=$_POST['df_tax'];?>" /></td>
        <td align="right" bgcolor="#9999FF"><strong>Customs Duty: </strong></td>
        <td bgcolor="#9999FF"><input style="width:105px;"  name="cd_tax" type="text" id="cd_tax" value="<?=$_POST['cd_tax'];?>" /></td>
        <td bgcolor="#9999FF"><strong>Regulatory Duty: </strong><strong></strong></td>
        <td bgcolor="#9999FF"><strong>
          <input style="width:105px;"  name="rd_tax" type="text" id="rd_tax" value="<?= $_POST['rd_tax'];?>" />
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#9999FF"><strong>Supplementary Duty: </strong></td>
        <td align="right" bgcolor="#9999FF"><input style="width:105px;"  name="sd_tax" type="text" id="sd_tax" value="<?=$_POST['sd_tax'];?>" /></td>
        <td align="right" bgcolor="#9999FF"><strong>VAT</strong></td>
        <td bgcolor="#9999FF"><strong>
          <input style="width:105px;"  name="vat_lc" type="text" id="vat_lc" value="<?=$_POST['vat_lc'];?>"  />
        </strong></td>
        <td bgcolor="#9999FF"><strong>AIT</strong><strong>:</strong></td>
        <td bgcolor="#9999FF"><strong>
          <input style="width:105px;"  name="ait_tax" type="text" id="ait_tax" value="<?= $_POST['ait_tax'];?>" />
        </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#9999FF"><strong>ATV: </strong></td>
        <td align="right" bgcolor="#9999FF"><input style="width:105px;"  name="atv_tax" type="text" id="atv_tax" value="<?=$_POST['atv_tax'];?>" /></td>
        <td align="right" bgcolor="#9999FF"><strong> C&amp;F Commission: </strong><strong></strong></td>
        <td bgcolor="#9999FF"><input style="width:105px;"  name="cnf_agent_charge" type="text" id="cnf_agent_charge" value="<?=$_POST['cnf_agent_charge'];?>" /></td>
        <td bgcolor="#9999FF"><strong>C&amp;F Other Charge</strong><strong>:</strong></td>
        <td bgcolor="#9999FF"><strong>
          <input style="width:105px;"  name="cnf_charge_other" type="text" id="cnf_charge_other" value="<?=$_POST['cnf_charge_other'];?>" />
        </strong></td>
      </tr>
      
	    <? }?><?php */?>
	  
	  
     
    </table></td>

    </tr>

</table>

<? if($$unique>0){

  $sql='select a.id,a.item_id, s.sub_group_name, b.item_name,b.unit_name,a.qty, a.rate, a.rate_usd 
 from lc_purchase_invoice a, item_info b, item_sub_group s 
 where b.item_id=a.item_id and b.sub_group_id=s.sub_group_id and a.po_no='.$po_data->po_no;

$res=db_query($sql);

?>

<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th width="5%">SL</th>

            <th width="15%">Category</th>

            <th width="29%">Item Name</th>

            <th bgcolor="#FFFFFF">Unit</th>

            <th bgcolor="#FF99FF">Ordered</th>

            <th bgcolor="#009900"><strong>Received</strong></th>

            <th bgcolor="#FFFF00">PendingQty  </th>

            <th bgcolor="#0099CC"><strong>Receive</strong>Qty </th>
            </tr>

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->sub_group_name?>

              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>

              <td><?=$row->item_name?>

 <input type="hidden" name="exchange_rate_<?=$row->id?>" id="exchange_rate_<?=$row->id?>" value="<?=$exchange_rate;?>" />
							
<input type="hidden" name="rate_usd_<?=$row->id?>" id="rate_usd_<?=$row->id?>" value="<?=$row->rate_usd;?>" />				</td>

              <td width="3%" align="center"><?=$row->unit_name?>

                <input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>

              <td width="6%" align="center"><?=number_format($row->qty,2);?></td>

              <td width="9%" align="center"><? echo number_format($rec_qty = (find_a_field('lc_purchase_receive','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?></td>

              <td width="9%" align="center"><? echo number_format($unrec_qty=($row->qty-$rec_qty),2);?>

                <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>

              <td width="11%" align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($unrec_qty>0){$cow++;?>
			  <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" style="width:100px; float:none" value=""  />
			   <input name="lot_no_<?=$row->id?>" type="hidden" id="lot_no_<?=$row->id?>" style="width:100px; float:none" value="0"  />
			  <? } else echo 'Done';?></td>
              </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table> 
  
  <?php /*?>
  <?
  
   $sql2='select a.id,a.item_id,a.warehouse_id, b.item_name,b.unit_name,a.qty as rec_qty,a.rate, a.rate_usd from lc_purchase_receive a,item_info b where b.item_id=a.item_id and a.payment_no='.$$unique;

$res2=db_query($sql2);

?>
  
  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th width="5%">SL</th>

            <th width="10%">Item Code</th>

            <th width="33%">Item Name</th>

            <th bgcolor="#FFFFFF">Unit</th>

            <th bgcolor="#009900">Warehouse</th>
            <th bgcolor="#009900"><strong>Received</strong></th>
            </tr>

          

          <? while($row2=mysqli_fetch_object($res2)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss2;?></td>

            <td><?=$row2->item_id?>

              </td>

              <td><?=$row2->item_name?></td>

              <td width="8%" align="center"><?=$row2->unit_name?></td>

              <td width="30%" align="center"><?= find_a_field('warehouse','warehouse_name','warehouse_id='.$row2->warehouse_id); ?></td>
              <td width="14%" align="center"><?= number_format($row2->rec_qty,2);?></td>
              </tr>

          <? }?>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table>
  
  
 <?php */?> 
  
  
  
<table width="100%" border="0">

<? if($cow<1){

$vars['status']='COMPLETED';



db_update($table_master, $po_no, $vars, 'po_no');

$sql1 = "update lc_purchase_receive set status='PRODUCT RECEIVED' where shipment_no='".$$unique."'";
db_query($sql1);

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS SHIPMENT HAS BEEN RECEIVED </strong></td>

</tr>

<? }else{?>

<br />

<tr>

<td align="center">&nbsp;

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>

<td align="center">

<input  name="po_no" type="hidden" id="po_no" value="<?=$po_data->po_no;?>"/>
<input name="confirm" type="submit" class="btn1" value="RECEIVE" style="width:270px; float:right; background:#6699FF; font-weight:bold; font-size:12px; height:30px; color:#000" /></td>

</tr>

<? }?>

<br />


<?php /*?><?

$shipment_status = find_a_field('lc_purchase_receive','status',"shipment_no=".$$unique);
 if($shipment_status=="PRODUCT RECEIVED"){ ?>

<tr>

<td align="center">&nbsp;

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>

<td align="center">

<input  name="po_no" type="hidden" id="po_no" value="<?=$po_no;?>"/>
<input name="journal_create" type="submit" class="btn1" value="JOURNAL CREATE" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:#000" /></td>

</tr>

<? }?><?php */?>


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