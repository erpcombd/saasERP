<?php



session_start();



ob_start();



require_once "../../../assets/support/inc.all.php";




$title='Purchased Product Receive (PR)';



do_calander('#rec_date');



$table_master='purchase_master';

$table_details='purchase_receive';

$unique='po_no';



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

		$_POST['edit_at']=date('Y-m-d H:i:s');

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

		$qc_by=$_POST['qc_by'];

		$ch_no=$_POST['ch_no'];

		$rec_date=$_POST['rec_date'];

		$rec_no=$_POST['rec_no'];

		$now = date('Y-m-d H:i:s');

		

		$sql = 'select * from purchase_invoice where po_no = '.$po_no;

		$query = mysql_query($sql);

		$pr_no = find_a_field('purchase_receive','max(pr_no)','1')+1;

		$vendor = find_all_field('vendor','ledger_id',"vendor_id=".$vendor_id);

		$vendor_ledger = $vendor->ledger_id;

		//$jv=next_journal_sec_voucher_id();

		while($data=mysql_fetch_object($query))

		{

			if(($_POST['chalan_'.$data->id]>0))

			{

				$qty=$_POST['chalan_'.$data->id];

				$rate=$_POST['rate_'.$data->id];

				$item_id =$_POST['item_id_'.$data->id];

				$unit_name =$data->unit_name;

				$amount = ($qty*$rate);

				$total = $total + $amount;

$q = "INSERT INTO `purchase_receive` (`pr_no`, `po_no`, `order_no`, `rec_no`,`rec_date`, `vendor_id`, `item_id`, `warehouse_id`, `rate`, `qty`, `unit_name`, `amount`, `qc_by`, `entry_by`, `entry_at`,ch_no) VALUES('".$pr_no."', '".$po_no."', '".$data->id."', '".$rec_no."','".$rec_date."',".$vendor_id.", ".$item_id.",".$warehouse_id.", ".$rate.", '".$qty."', '".$unit_name."',  '".$amount."', '".$qc_by."',  '".$_SESSION['user']['id']."', '".$now."', '".$ch_no."')";

mysql_query($q);



$xid = mysql_insert_id();

journal_item_control($data->item_id ,$warehouse_id,$rec_date,$qty,0,'Purchase',$xid,$rate,'',$pr_no);



	
	




			}
			

		}

//auto_insert_purchase_secoundary_journal($pr_no);




	$jv_no=next_journal_sec_voucher_id();
	$proj_id = 'Clouderp'; 
	$po_no =    find_a_field('purchase_receive','po_no','pr_no='.$pr_no);
	$group_for =  $_SESSION['user']['group'];
	$po_master = find_all_field('purchase_master','','po_no='.$po_no);
    $vendor = find_all_field('vendor','',"vendor_id=".$po_master->vendor_id);
	
	
	
    $tr_id = $po_no;
	$tr_no = $pr_no;
	$tr_from = 'Purchase';
	$narration = 'PR#'.$pr_no.' (PO#'.$po_no.')';
    
	 $sql = "select sum(amount) as amount, rec_date from purchase_receive  where  pr_no=".$pr_no;
	
	$pr = find_all_field_sql($sql);


$pr_amount = $pr->amount;

$vat_on_purchase = ($pr_amount*$po_master->tax)/100;
	

	//$jv_date = strtotime($do->chalan_date);
	
	$jv_date = $pr->rec_date;

	$invoice_amt = ($pr_amount + $vat_on_purchase);
	
	
	$config_ledger = find_all_field('config_group_class','',"group_for=".$_SESSION['user']['group']);
	$vendor_ledger= $vendor->ledger_id;
	$cc_code = $group_for;


 
$sql_all = 'select pr.*,s.ledger_id_2 as item_ledger,i.item_name from purchase_receive pr, item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id and pr.item_id=i.item_id and pr.pr_no="'.$pr_no.'"';
$qrr_all = mysql_query($sql_all);
while($pr_data = mysql_fetch_object($qrr_all)){
$narration_dr = 'PR#'.$pr_no.' (PO#'.$po_no.')';
$narration_cr = 'PR#'.$pr_no.' (PO#'.$po_no.'), Vendor Name : '.$vendor->vendor_name;
//debit	
add_to_sec_journal($proj_id, $jv_no, $jv_date, $pr_data->item_ledger, $narration_dr, ($pr_data->amount), '0', $tr_from, $tr_no,'', $tr_id,$cc_code,$group_for);
//credit
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vendor_ledger, $narration_cr, '0', ($pr_data->amount), $tr_from, $tr_no,'', $tr_id,$cc_code,$group_for);
}
if($vat_on_purchase>0){
$narration_vat = $narration.' VAT';
add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->purchase_vat, $narration_vat, ($vat_on_purchase), '0', $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
add_to_sec_journal($proj_id, $jv_no, $jv_date, $vendor_ledger, $narration_vat, '0', ($vat_on_purchase), $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
}



header("Location:po_receive.php?po_no=$po_no");

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

		while (list($key, $value)=each($data))

		{ $$key=$value;}

		

}

if($delivery_within>0)

{

	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);

}

?>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<div class="row">
		<div class="col-sm-10">
			<div class="row ">
    
	
	     <div class="col-md-3 form-group">
		  <? $field='po_no';?>
            <label for="do_no" >PO No: </label>
         
			<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" class="form-control" />
          </div>
		  
		  <div class="col-md-3 form-group">
		   <? $field='po_date';?>
            <label for="dealer_code">PO Date:</label>
    <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" class="form-control" required/>
          </div>
		  
		  
		 <div class="col-md-3 form-group">
		  <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
            <label for="wo_detail2">Warehouse: </label>
           <input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" class="form-control" readonly="readonly"/>

		<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" required="required"/>
          </div>
		  
		  
		   <div class="col-md-3 form-group">
		    <? $field='quotation_no';?>
            <label for="wo_detail">Ref No: </label>
             <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="readonly"  class="form-control"/>
          </div>
		  
		  
		  
		  
		    <div class="col-md-3 form-group">
			 <? $field='req_no';?>
            <label for="wo_detail">Req No: </label>
             <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="readonly" class="form-control" />
          </div>
		  
		  
          <div class="col-md-3 form-group">
		  <? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>
            <label for="depot_id">Party: </label>
         <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$vendor_id)?>"  readonly="readonly" class="form-control"/>
            <!--<input style="width:155px;"  name="wo_detail" type="text" id="wo_detail" value="<?=$depot_id?>" readonly="readonly"/>-->
          </div>
		  
          <div class="col-md-3 form-group">
		   <? $field='po_details';?>
            <label for="rcv_amt">Note: </label>
            <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
          </div>
		  
        <div class="col-md-3 form-group">
            <label for="remarks">Address: </label>
            <input name="remarks" type="text" id="remarks"  value="<?=$vendor->address?>" class="form-control"  />
          </div>
		  
		  
		  
		  
		   <div class="col-md-3 form-group">
            <label for="do_date"> Note: </label>
             <textarea name="<?=$field?>" id="<?=$field?>" class="form-control"><?=$$field?></textarea>
          </div>
		  
          <div class="col-md-3 form-group">
		  <? $field='entry_by'; $table='user_activity_management';$get_field='user_id';$show_field='fname';?>
            <label for="wo_subject"> Entry By: </label>
      <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly="" class="form-control"/>
          </div>
		  
		     <div class="col-md-3 form-group">
		  <? $field='checked_by';?>
            <label for="wo_subject"> Approved By: </label>
     <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" readonly="" class="form-control"/>
          </div>
		     
		  
   
		
				
		
		
		</div>
		
		

		</div>
		<div class="col-sm-2">
			<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:10px;width:104px;">

	          

        <tr>

          <td align="left" bgcolor="#9999CC"><strong>Date</strong></td>

          <td align="left" bgcolor="#9999CC"><strong>PR</strong></td>

        </tr>

<?

$sql='select distinct pr_no,rec_date from purchase_receive where po_no='.$po_no.' order by pr_no desc';

$qqq=mysql_query($sql);

while($aaa=mysql_fetch_object($qqq)){

?>

        <tr>

          <td bgcolor="#FFFF99"><?=$aaa->rec_date?></td>

          <td align="center" bgcolor="#FFFF99"><a target="_blank" href="../pr_packing_mat/chalan_view.php?v_no=<?=$aaa->pr_no?>"><img src="print.png" width="15" height="15" /></a></td>

        </tr>

<?

}

?>



      </table>
		</div>
	</div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  

  <tr>

    <td colspan="5" valign="top"><table width="40%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

      <tr>

        <td colspan="3" align="center" bgcolor="#CCFF99"><strong>Entry Information</strong></td>

      </tr>

      <tr>

        <td align="right" bgcolor="#CCFF99">Created By:</td>

        <td align="left" bgcolor="#CCFF99">&nbsp;&nbsp;

            <?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>

        <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="po_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>

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

        <td align="right" bgcolor="#9999FF"><strong>Rec NO: </strong></td>

        <td align="right" bgcolor="#9999FF"><strong>

          <input style="width:105px;"  name="rec_no" type="text" id="rec_no" value="" required="required"/>

        </strong></td>

        <td align="right" bgcolor="#9999FF"><strong>Rec Date :</strong></td>

        <td bgcolor="#9999FF"><strong>

          <input style="width:105px;"  name="rec_date" type="text" id="rec_date" value="" required="required"/>

        </strong></td>

        <td align="right" bgcolor="#9999FF"><strong>QC By :</strong></td>

        <td bgcolor="#9999FF"><strong>

          <input style="width:105px;"  name="qc_by" type="text" id="qc_by" required="required"/>

        </strong></td>

        <td bgcolor="#9999FF"><div align="right"><strong>Chalan No :</strong></div></td>

        <td bgcolor="#9999FF"><strong>

          <input style="width:105px;"  name="ch_no" type="text" id="ch_no" required="required"/>


        </strong></td>

      </tr>

    </table></td>

    </tr>

</table>

<? if($$unique>0){

$sql='select a.id,a.item_id,b.item_name,b.unit_name,a.qty,a.rate from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$$unique;

$res=mysql_query($sql);

?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th>SL</th>

            <th>Item Code</th>

            <th width="45%">Item Name</th>

            <th bgcolor="#FFFFFF">Unit</th>

            <th bgcolor="#FF99FF">Ordered</th>

            <th bgcolor="#009900">Recd </th>

            <th bgcolor="#FFFF00">UnRecd </th>

            <th bgcolor="#0099CC">RecQty </th>

          </tr>

          

          <? while($row=mysql_fetch_object($res)){$bg++?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->item_id?>

              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>

              <td><?=$row->item_name?>

                <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" /></td>

              <td width="7%" align="center"><?=$row->unit_name?>

                <input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>

              <td width="7%" align="center"><?=$row->qty?></td>

              <td width="6%" align="center"><? echo $rec_qty = (find_a_field('purchase_receive','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1));?></td>

              <td width="7%" align="center"><? echo $unrec_qty=($row->qty-$rec_qty);?>

                <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>

              <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center">

			  <? if($unrec_qty>0){$cow++;?>

                <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" style="width:70px; float:none" value=""  />

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

db_update($table_master, $po_no, $vars, 'po_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS PURCHASE ORDER IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input name="delete" type="button" class="btn btn-danger" value="CANCEL PURCHASE ORDER" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" onclick="window.location = 'select_dealer_chalan.php?del=1&po_no=<?=$po_no?>';" />

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>

<td align="center"><input name="confirm" type="submit" class="btn btn-info" value="RECEIVE" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" /></td>

</tr>

<? }?>

</table>

<? }?>

</form>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

$main_content=ob_get_contents();

ob_end_clean();


include ("../../template/main_layout.php");



?>