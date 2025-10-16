<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='GRN Entry';



do_calander('#rec_date');

do_calander('#lc_bill_date');


$table_master='lc_commercial_invoice';

$table_details='lc_purchase_invoice';

$unique='id';
 





if($_GET['tr_no']>0)
 $_SESSION[$unique]=$tr_no=$_GET['tr_no'];

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
		
		$tr_no = $_POST['tr_no']; 
		
		$payment_id = $_POST['payment_id']; 
		$payment_no = $_POST['payment_no']; 

		 $vendor_id = $_POST['vendor_id'];
		
		 $group_for = $_POST['group_for'];
		
		$pi_no = $_POST['pi_no'];
		
		$lc_no = $_POST['lc_no'];
		
		$lc_number = $_POST['lc_number'];

		$lc_date = $_POST['lc_date'];
		$lc_part = $_POST['lc_part'];
		$lc_no_part = $_POST['lc_no_part'];
	
		$grn_no = $_POST['grn_no'];
		
		$warehouse_id = $_SESSION['user']['depot'];

		$rec_date=$_POST['rec_date'];
		
		$remarks = $_POST['remarks'];
		
		$tr_unique=12;

		$entry_by = $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		$pr_no = next_transection_no($tr_unique,$rec_date,'lc_purchase_receive','pr_no');

	    $sql = 'select * from lc_commercial_invoice where tr_no = '.$tr_no;

		$query = db_query($sql);

		

		while($data=mysqli_fetch_object($query))

		{
//echo 'Mhafuz1';
			if(($_POST['chalan_'.$data->id]>0))
			{
//echo 'Faruk';

			 	$qty=$_POST['chalan_'.$data->id];
				$undel_qty=$_POST['unrec_qty_'.$data->id];	
				$rate_usd =$_POST['rate_usd_'.$data->id];				
		
				//$exchange_rate =$_POST['exchange_rate_'.$data->id];

				$rate = $_POST['pre_cost_rate_'.$data->id];
				
				$amount = ($qty*$rate);
				
				$amount_usd = ($qty*$rate_usd);

				//if($qty<=$undel_qty){

				$item_id =$_POST['item_id_'.$data->id];

				$unit_name =$data->unit_name;
				
				//$rate = ($rate_usd*$usd_exchange_rate);
				
				//$amount = (($qty*$rate_usd)*$usd_exchange_rate);

				//$total = $total + $amount; 

     $q = 'INSERT INTO lc_purchase_receive
   (pr_no, rec_date, grn_no, tr_no,  ci_no, lc_no, lc_number, po_no, order_no, payment_no, payment_id, lc_part, lc_no_part, vendor_id, item_id, specification, group_for, warehouse_id, exchange_rate, rate, rate_usd, qty, unit_name, amount, amount_usd, entry_by, entry_at,  status, remarks) 
   
   
   VALUES("'.$pr_no.'", "'.$rec_date.'", "'.$grn_no.'", "'.$tr_no.'",  "'.$data->ci_no.'", "'.$lc_no.'", "'.$lc_number.'", "'.$po_no.'", "'.$data->id.'", "'.$payment_no.'", "'.$payment_id.'", "'.$lc_part.'", "'.$lc_no_part.'", "'.$vendor_id.'", "'.$item_id.'", "'.$data->specification.'", "'.$group_for.'", "'.$warehouse_id.'", "'.$exchange_rate.'", "'.$rate.'", "'.$rate_usd.'", "'.$qty.'", "'.$unit_name.'", "'.$amount.'", "'.$amount_usd.'", "'.$entry_by.'", "'.$entry_at.'",  "CHECKED", "'.$remarks.'")';

db_query($q);

$xid = db_insert_id();

//$moving_avg_price = moving_average_price_calculation($item_id,$qty,$amount,$data->group_for);

journal_item_control($item_id, $warehouse_id, $rec_date,  $qty, 0, 'LC Purchase', $xid, $rate, $r_warehouse, $pr_no);



//}

}
}

auto_insert_lc_grn_secoundary_cus($pr_no);
$up_sql1 = "update lc_commercial_invoice set status='COMPLETED' where tr_no='".$tr_no."'";
db_query($up_sql1);




//$sql_shipment_rcv="SELECT pr_no, po_no, shipment_no, group_for, rec_date, lc_manual_no, lc_part, cash_ledger_transport, transport_bill  
//FROM `lc_purchase_receive` WHERE `pr_no`=".$pr_no." group by `pr_no`";
//$shipment_rec_data = find_all_field_sql($sql_shipment_rcv);
//
//
//$lc_ledger_id=find_a_field('lc_purchase_master','lc_ledger_id','po_no='.$shipment_rec_data->po_no);
//
//$lc_manual_no=find_a_field('lc_number_setup','lc_number','id='.$shipment_rec_data->lc_manual_no);

//$sql_config="SELECT * FROM `config_group_class` WHERE group_for = ".$shipment_rec_data->group_for;
//$config = find_all_field_sql($sql_config);


//$jv_no=next_journal_sec_voucher_id('','Product Receive',$_SESSION['user']['depot']);
//$jv_date = $shipment_rec_data->rec_date;
//$proj_id = 'faridgroup';
//$tr_from = 'Product Receive';
//$tr_no = $shipment_rec_data->pr_no;
//
//$narration = 'Receive No: '.$pr_no.', L/C: '.$lc_manual_no.' - ('.$shipment_rec_data->lc_part.')';
//
//if($shipment_rec_data->transport_bill>0) {
//add_to_sec_journal($proj_id, $jv_no, $jv_date, $lc_ledger_id, $narration, $shipment_rec_data->transport_bill, '0.00', $tr_from, $shipment_rec_data->po_no,'',$tr_no, $shipment_rec_data->group_for, $shipment_rec_data->group_for); }
//
//
//if($shipment_rec_data->transport_bill>0) {
//add_to_sec_journal($proj_id, $jv_no, $jv_date, $shipment_rec_data->cash_ledger_transport, $narration,  '0.00', $shipment_rec_data->transport_bill, $tr_from, $shipment_rec_data->po_no,'',$tr_no, $shipment_rec_data->group_for, $shipment_rec_data->group_for); }





//$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');
//
//if($jv_config=="Yes"){
//sec_journal_journal($jv_no,$jv_no,$tr_from);
//$time_now = date('Y-m-d H:i:s');
//$up2='update secondary_journal set checked="YES", checked_at="'.$time_now.'",checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';
//db_query($up2);
//}





		//$up_sql1 = "update lc_bank_payment set status='COMPLETED' where payment_no='".$payment_no."'";
		//db_query($up_sql1);


		  		$link = "voucher_view.php?payment_no=" .$pr_no;
$redirect = "upcoming_ci_for_grn.php"; // page you want current tab to go

echo "<script>
        // Open invoice in a new tab
        window.open('$link', '_blank');

        // Redirect current page to another page
        window.location.href = '$redirect';
      </script>";	



	?>
		
		
<script language="javascript">
//window.location.href = "upcoming_ci_for_grn.php";
</script>
		
		
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

	foreach($data as $key=>$value)

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


      <div>

        <label style="width:110px;" for="<?=$field?>">PI No: </label>
		
		<?  $ci_data = find_all_field('lc_commercial_invoice','','tr_no="'.$tr_no.'"');
			$pi_data = find_all_field('lc_purchase_master','','po_no="'.$ci_data->po_no.'"');
		?>

        <input  name="pi_no" type="text" id="pi_no" readonly="" value="<?=$pi_data->pi_no?>"/>
		
		   <input  name="tr_no" type="hidden" id="tr_no" readonly="" value="<?=$tr_no?>"/>
		
		<input  name="po_no" type="hidden" id="po_no" readonly="" value="<?=$ci_data->po_no?>"/>
		
		<input  name="payment_id" type="hidden" id="payment_id" readonly="" value="<?=$ci_data->payment_id?>"/>
		<input  name="payment_no" type="hidden" id="payment_no" readonly="" value="<?=$ci_data->payment_no?>"/>
		
		

      </div>
	  
	  

      <div>

        <label style="width:110px;" for="<?=$field?>">PI Date: </label>

        <input  name="pi_date" type="text" id="pi_date" readonly="" value="<?=$pi_data->pi_date?>"/>
		
		

      </div>

   
	  


      <div>

        <label style="width:110px;" for="<?=$field?>">Concern:</label>

        <input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field('user_group','group_name','id="'.$ci_data->group_for.'"');?>" readonly="readonly"/>

		<input  name="group_for" type="hidden" id="group_for" value="<?=$ci_data->group_for?>" required="required"/>
		<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$ci_data->vendor_id?>" required="required"/>

      </div>
	  
	  <div></div>


      <div>

	  <label style="width:110px;" for="<?=$field?>">Supplier Name:</label>

      <input  name="Supplier" type="text" id="Supplier" value="<?=find_a_field('vendor_foreign','vendor_name','vendor_id="'.$ci_data->vendor_id.'"');?>"  readonly="readonly"/>


      </div>
	  
	   
	  
      <div></div>

    


      
	  


    

    </fieldset></td>

    <td>			</td>

    <td width="45%" ><fieldset style="width:100%;">
	
	
	
	

  
	  
	  
	 

      <div>

        <label style="width:120px;" for="<?=$field?>">Reference:</label>
		
		  <? $lc_data = find_all_field('lc_bank_entry','','po_no="'.$ci_data->po_no.'"');?>

        <input  name="lc_number" type="text" id="lc_number" value="<?=$ci_data->lc_number?>" readonly="" style="width:200px;" required/>
		
		

      </div>
	  
	 
	  
	  
   <div></div>
	   
	 

     

      <div>

	  <label style="width:120px;" for="<?=$field?>"> LC No:</label>

      <input  name="bank_lc_no" type="text" id="bank_lc_no" value="<?=$lc_data->bank_lc_no?>"  readonly="readonly" style="width:200px;"/>
	  
	  <input  name="lc_no" type="hidden" id="lc_no" value="<?=$ci_data->lc_no?>" required="required"/>
	  
	  <input  name="lc_part" type="hidden" id="lc_part" value="<?=$ci_data->lc_part?>" required="required"/>
	  <input  name="lc_no_part" type="hidden" id="lc_no_part" value="<?=$ci_data->lc_no_part?>" required="required"/>
	 

      </div>
	  
	  
	   <? $field='lc_type';?>

        <div>

<label style="width:120px;" for="<?=$field?>">LC Type:</label>

<input  name="lc_type" type="text" id="lc_type" value="<?= find_a_field('lc_type','lc_type','id="'.$lc_data->lc_type.'"');?>"  readonly="readonly" style="width:200px;"/>

        </div>


         

      <div>


        <div>

<label style="width:120px;" for="<?=$field?>">CI No:</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$ci_data->ci_no?>" readonly=""  style="width:200px;"/>

        </div>
		


	  
		

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
          <?=find_a_field('user_activity_management','fname','user_id='.$ci_data->entry_by);?></td>

   <td rowspan="2" align="center" bgcolor="#10afe7"><?php /*?><a href="lc_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a><?php */?></td>
      </tr>

      <tr>

        <td align="right" bgcolor="#10afe7">Created On:</td>

        <td align="left" bgcolor="#10afe7">&nbsp;&nbsp;

            <?=$ci_data->entry_at?></td>
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
        <td width="21%" align="right" bgcolor="#339999"><strong>REC No: </strong></td>
        <td width="9%" align="right" bgcolor="#339999">
		<input style="width:120px; height:25px;"  name="grn_no" type="text" id="grn_no" value="<?=$_POST['grn_no']?>" />		</td>
        <td width="18%" align="right" bgcolor="#339999"><strong>REC Date: </strong></td>
        <td bgcolor="#339999"> 
		
		<input style="width:120px; height:25px;"  name="rec_date" type="text" id="rec_date" value="<?=($rec_date!='')?$rec_date:date('Y-m-d')?>" />
		
		<strong>
		
		</strong></td>
        <td width="17%" align="right" bgcolor="#339999"><strong>Remarks:</strong></td>
        <td width="14%" bgcolor="#339999"><input style="width:200px; height:25px;"  name="remarks" type="text" id="remarks" value="<?=$_POST['remarks'];?>" /></td>
      </tr>
      
	
	  
	  
	  
     
    </table></td>

    </tr>

</table>

<? if($$unique>0){
///////////////zero processs////////

  $sqlc = 'SELECT sum(a.pay_amt_in) as pay_amt_in, sum(a.pay_amt_out) as pay_amt_out,   a.payment_no, a.payment_date, b.bill_type,a.lc_no from lc_bill_payment_provision a, lc_bill_type b, lc_bill_category c 
		 where b.id=c.bill_type and a.bill_category=c.id  and a.lc_no="'.$ci_data->lc_no.'" group by a.lc_no ';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			$tot_exp_amt_bdt[$datac->lc_no]=$datac->pay_amt_in-$datac->pay_amt_out;
			}
	 		 
		//////////////////////First find out item wise payement///////////		
				  $sql='select sum(payment_amt) as item_wise_pay,lc_no,item_id from item_wise_payment_provision where 1 and lc_no="'.$ci_data->lc_no.'" group by lc_no,item_id';
	  $query=db_query($sql);
	  while($row=mysqli_fetch_object($query)){
	 $tot_item_pay_amt[$row->lc_no][$row->item_id]=$row->item_wise_pay;
	  
	  $gr_tot_item_pay_amt+=$row->item_wise_pay;
	  }	
	  
	  ///////////2nd find out just carring charge//////////
	  
	  				  $sql='select sum(pay_amt_in) as tot_carry_charge,lc_no,bill_type from lc_bill_payment_provision where 1 and bill_type=5 and lc_no="'.$ci_data->lc_no.'" group by lc_no';
	  $query=db_query($sql);
	  while($row=mysqli_fetch_object($query)){
	 $tot_carrying_charge[$row->lc_no]=$row->tot_carry_charge;  
	  }	
	  $tot_carrying_charge[$ci_data->lc_no];
	  
	  $tot_exp_without_carry_and_partial=$tot_exp_amt_bdt[$ci_data->lc_no]-($tot_carrying_charge[$ci_data->lc_no]+$gr_tot_item_pay_amt);
	  
 	  $sql = "select sum(i.qty) as invoice_qty, i.rate_usd as invoice_rate_usd, sum(i.amount_usd) as invoice_amount_usd,i.po_no,m.po_no,m.lc_no from lc_purchase_invoice i,lc_purchase_master m where m.lc_no=".$ci_data->lc_no." and m.po_no=i.po_no group by i.po_no";
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$invoice_qty_get[$data->po_no][$data->item_id]=$data->invoice_qty;
$invoice_rate_usd_get[$data->po_no][$data->item_id]=$data->invoice_rate_usd;
$invoice_amount_usd_get[$data->po_no][$data->item_id]=$data->invoice_amount_usd;

$gr_tot_usd_amt_invoice+=$data->invoice_amount_usd;
$gr_invoice_qty_get_invoice+=$data->invoice_qty;
}
    $sqlc = 'select d.*, i.item_name from lc_purchase_master m, lc_purchase_invoice d, item_info i where m.po_no=d.po_no and i.item_id=d.item_id and m.lc_no='.$ci_data->lc_no.'
			 group by d.item_id order by d.id';
			$queryc=db_query($sqlc);
			while($datac = mysqli_fetch_object($queryc)){
			 $value_based_percentage_get= ((100*$datac->amount_usd) /$gr_tot_usd_amt_invoice);
			 $qty_based_percentage_get= ((100*$datac->qty) /$gr_invoice_qty_get_invoice);
			 
			 $amount_without_carry_and_duty_get=(($tot_exp_without_carry_and_partial*$value_based_percentage_get)/100);
			  $amount_carry_get=(($tot_carrying_charge[$ci_data->lc_no]*$qty_based_percentage_get)/100);
			  $amount_duty_get= $tot_item_pay_amt[$ci_data->lc_no][$datac->item_id];
			    $final_cost_of_item=($amount_without_carry_and_duty_get+$amount_carry_get+$amount_duty_get);
			  $cost_rate[$datac->item_id]=$final_cost_of_item/$datac->qty;
			}
 
 
 
 
 
 
 
 
 

    $sqlc='select a.id,a.item_id, a.specification, s.sub_group_name, b.item_name,b.unit_name,a.qty, a.rate, a.rate_usd , a.amount_usd
 from lc_commercial_invoice a, item_info b, item_sub_group s 
 where b.item_id=a.item_id and b.sub_group_id=s.sub_group_id and a.tr_no='.$tr_no;

$res=db_query($sqlc);
?>

<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th width="3%">SL</th>

            <th width="42%">Item Name</th>

            <th bgcolor="#FFFFFF"><strong>Specification</strong></th>
            <th bgcolor="#FFFFFF">Unit</th>
   <th bgcolor="#FFFFFF">Pre-Costing Rate</th>
            <th bgcolor="#FF99FF">CI Qty </th>

            <th bgcolor="#0099CC"><strong>GRN </strong>Qty </th>
            </tr>

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_name?>
			  
			   <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>

              <td width="29%" align="left"><?=$row->specification?></td>
              <td width="6%" align="center"><?=$row->unit_name?>

                <input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>
				<td><input type="text" name="pre_cost_rate_<?=$row->id?>" id="pre_cost_rate_<?=$row->id?>" value="<?=$cost_rate[$row->item_id];?>" readonly="readonly" /></td>

              <td width="10%" align="center"><?=number_format($row->qty,2);?>
			  
			  <input type="hidden" name="rate_usd_<?=$row->id?>" id="rate_usd_<?=$row->id?>" value="<?=$row->rate_usd;?>" style="width:80px" />
			  <input type="hidden" name="amount_usd_<?=$row->id?>" id="amount_usd_<?=$row->id?>" value="<?=$row->amount_usd;?>" style="width:100px" readonly="" />			 
			  
			  <?  number_format($rec_qty = (find_a_field('lc_purchase_receive','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1)),2);?>
			  <?  number_format($unrec_qty=($row->qty-$rec_qty),2);?>
			  <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" />			   </td>

              <td width="10%" align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($unrec_qty>0){$cow++;?>
			  <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" style="width:80px; float:none" value="<?=$row->qty?>"  />
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

//$vars['status']='PRODUCT RECEIVED';
//
//
//
//db_update($table_master, $po_no, $vars, 'po_no');

 $sql1 = "update lc_commercial_invoice set status='PRODUCT RECEIVED' where tr_no='".$tr_no."'";
db_query($sql1);

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS INVOICE HAS BEEN RECEIVED </strong></td>

</tr>

<? }else{?>

<br />

<tr>

<td align="center">&nbsp;

</td>

<td align="center">

<input  name="tr_no" type="hidden" id="tr_no" value="<?=$tr_no;?>"/>
<input name="confirm" type="submit" class="btn1" value="CONFIRM & SEND" style="width:270px; float:right; background:#6699FF; font-weight:bold; font-size:12px; height:30px; color:#000" /></td>

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>