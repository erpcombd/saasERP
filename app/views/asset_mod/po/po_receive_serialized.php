<?php


//


//



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




$title='Purchased Product Receive (PR)';


//do_calander('#rec_date');


$table_master='purchase_master';



$table_details='purchase_receive_asset';



$unique='po_no';


if($_SESSION[$unique]>0)



$$unique=$_SESSION[$unique];


if($_REQUEST[$unique]>0){



$$unique=$_REQUEST[$unique];



$_SESSION[$unique]=$$unique;}



else



$$unique = $_SESSION[$unique];
$unfinished_pr_check = find_a_field('purchase_receive_asset','pr_no','po_no="'.$_SESSION[$unique].'" and journal="Pending"');

if($unfinished_pr_check>0){

	$_SESSION['pr_no'] = $unfinished_pr_check;

	}




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



		$_POST['edit_at']=date('Y-m-d h:s:i');



		$_POST['status']='CANCELED';



		$crud   = new crud($table_master);



		$crud->update($unique);



		


		unset($$unique);



		unset($_SESSION[$unique]);



		$type=1;



		$msg='Canceled Remainning All Purchase Order.';



}



if($_GET['del']>0){

	echo 'bimol';

	$delete = 'delete from purchase_receive_asset where id="'.$_GET['del'].'"';

	db_query($delete);

	$j_del = 'delete from journal_item where primary_id="'.$_GET['del'].'" and tr_from="AssetPurchase"';

	db_query($j_del);

	header("Location:po_receive_serialized.php?po_no=$_SESSION[$unique]");

	echo '<script>location.href="po_receive_serialized.php?po_no="'.$_SESSION[$unique].'""</script>';

	

	

	}


if(prevent_multi_submit()){


if(isset($_POST['add_item'])){



		$vendor_id = $_POST['vendor_id'];



		$warehouse_id = $_POST['warehouse_id'];



		$qc_by=$_POST['qc_by'];



		$ch_no=$_POST['ch_no'];



		$rec_date=$_POST['rec_date'];



		$rec_no=$_POST['rec_no'];



		$now = date('Y-m-d H:s:i');

		

		

        $exist_pr_no = find_a_field('purchase_receive_asset','pr_no','po_no="'.$_REQUEST['po_no'].'"');

		if($exist_pr_no>0){

		$pr_no = $exist_pr_no;

		}else{

		$pr_no = find_a_field('purchase_receive_asset','max(pr_no)','1')+1;

		}



		$vendor = find_all_field('vendor','ledger_id',"vendor_id=".$vendor_id);



		$vendor_ledger = $vendor->ledger_id;



		//$jv=next_journal_sec_voucher_id();



	

			if(($_POST['serial_no']!=''))



			{



				$qty=1;



				$rate=$_POST['rate'];



				$item_id =$_POST['item_id'];

				

				$order_no =$_POST['order_no'];

				

				$serial_no =$_POST['serial_no'];



				$unit_name =$data->unit_name;



				$amount = ($qty*$rate);



				$total = $total + $amount;



echo $q = "INSERT INTO `purchase_receive_asset` (`pr_no`, `po_no`, `order_no`, `rec_no`,`rec_date`, `vendor_id`, `item_id`, `warehouse_id`, `rate`, `qty`, `unit_name`, `amount`, `qc_by`, `entry_by`, `entry_at`,ch_no,serial_no) VALUES('".$pr_no."', '".$po_no."', '".$order_no."', '".$rec_no."','".$rec_date."',".$vendor_id.", ".$item_id.",".$warehouse_id.", ".$rate.", '".$qty."', '".$unit_name."',  '".$amount."', '".$qc_by."',  '".$_SESSION['user']['id']."', '".$now."', '".$ch_no."','".$serial_no."')";



db_query($q);



$xid = mysqli_insert_id();

journal_item_control($data->item_id ,$warehouse_id,$rec_date,$qty,0,'Purchase',$xid,$rate,'',$pr_no);

}

			



//auto_insert_purchase_secoundary_journal($pr_no);




	$jv_no=next_journal_sec_voucher_id();

	$proj_id = 'Clouderp'; 

	$po_no =    find_a_field('purchase_receive_asset','po_no','pr_no='.$pr_no);

	$group_for =  $_SESSION['user']['group'];

	$po_master = find_all_field('purchase_master','','po_no='.$po_no);

    $vendor = find_all_field('vendor','',"vendor_id=".$po_master->vendor_id);

	

	

	

    $tr_id = $po_no;

	$tr_no = $pr_no;

	$tr_from = 'Purchase';

	$narration = 'PR#'.$pr_no.' (PO#'.$po_no.')';

    

	 $sql = "select sum(amount) as amount, rec_date from purchase_receive_asset  where  pr_no=".$pr_no;

	

	$pr = find_all_field_sql($sql);
$pr_amount = $pr->amount;



$vat_on_purchase = ($pr_amount*$po_master->tax)/100;

	



	//$jv_date = strtotime($do->chalan_date);

	

	$jv_date = $pr->rec_date;



	$invoice_amt = ($pr_amount + $vat_on_purchase);

	

	

	$config_ledger = find_all_field('config_group_class','',"group_for=".$_SESSION['user']['group']);

	$vendor_ledger= $vendor->ledger_id;

	$cc_code = $group_for;
 

$sql_all = 'select pr.*,s.ledger_id_2 as item_ledger,i.item_name from purchase_receive_asset pr, item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id and pr.item_id=i.item_id and pr.pr_no="'.$pr_no.'" and pr.item_id="'.$item_id.'" and serial_no="'.$serial_no.'"';

$qrr_all = db_query($sql_all);

while($pr_data = mysqli_fetch_object($qrr_all)){

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


header("Location:po_receive_serialized.php?po_no=$po_no");



}


if(isset($_POST['confirm'])){



        $pr_no = $_SESSION['pr_no'];//find_a_field('purchase_receive_asset','max(pr_no)','1')+1;

		$po_no =    find_a_field('purchase_receive_asset','po_no','pr_no='.$pr_no);

		$vendor_id = $_POST['vendor_id'];

		$warehouse_id = $_POST['warehouse_id'];

		$qc_by=$_POST['qc_by'];
        $acConfig=find_a_field('voucher_config','direct_journal','voucher_type like "%FIXED ASSET%"');

		$ch_no=$_POST['ch_no'];



		$rec_date=$_POST['rec_date'];



		$rec_no=$_POST['rec_no'];



		$now = date('Y-m-d H:s:i');

		$sql = 'select * from purchase_invoice where po_no = '.$po_no;



		$query = db_query($sql);



		



		$vendor = find_all_field('vendor','ledger_id',"vendor_id=".$vendor_id);



		$vendor_ledger = $vendor->ledger_id;



		//$jv=next_journal_sec_voucher_id();



		

		

	$jv_no=next_journal_sec_voucher_id();

	$proj_id = 'Clouderp'; 

	

	$group_for =  $_SESSION['user']['group'];

	$po_master = find_all_field('purchase_master','','po_no='.$po_no);

    $vendor = find_all_field('vendor','',"vendor_id=".$po_master->vendor_id);

	

	

	

    $tr_id = $po_no;

	$tr_no = $pr_no;

	$tr_from = 'AssetPurchase';

	$narration = 'PR#'.$pr_no.' (PO#'.$po_no.')';

    

	 $sql = "select sum(amount) as amount, rec_date from purchase_receive_asset  where  pr_no=".$pr_no;

	

	$pr = find_all_field_sql($sql);
$pr_amount = $pr->amount;



$vat_on_purchase = ($pr_amount*$po_master->tax)/100;

	



	//$jv_date = strtotime($do->chalan_date);

	

	$jv_date = $pr->rec_date;



	$invoice_amt = ($pr_amount + $vat_on_purchase);

	

	

	$config_ledger = find_all_field('config_group_class','',"group_for=".$_SESSION['user']['group']);

	$vendor_ledger= $vendor->ledger_id;

	$cc_code = $group_for;
 

$sql_all = 'select pr.*,s.ledger_id_2 as item_ledger,i.item_name from purchase_receive_asset pr, item_info i, item_sub_group s where i.sub_group_id=s.sub_group_id and pr.item_id=i.item_id and pr.pr_no="'.$pr_no.'" and pr.journal="Pending"';

$qrr_all = db_query($sql_all);

while($pr_data = mysqli_fetch_object($qrr_all)){

$narration_dr = 'PR#'.$pr_no.' (PO#'.$po_no.')';

$narration_cr = 'PR#'.$pr_no.' (PO#'.$po_no.'), Vendor Name : '.$vendor->vendor_name;

//debit	

add_to_sec_journal($proj_id, $jv_no, $jv_date, $pr_data->item_ledger, $narration_dr, ($pr_data->amount), '0', $tr_from, $tr_no,'', $tr_id,$cc_code,$group_for);

//credit

add_to_sec_journal($proj_id, $jv_no, $jv_date, $vendor_ledger, $narration_cr, '0', ($pr_data->amount), $tr_from, $tr_no,'', $tr_id,$cc_code,$group_for);



$pr_update = 'update purchase_receive_asset set journal="Done" where item_id="'.$pr_data->item_id.'" and pr_no="'.$pr_no.'" and serial_no="'.$pr_data->serial_no.'"';

db_query($pr_update);

}

if($vat_on_purchase>0){

$narration_vat = $narration.' VAT';

add_to_sec_journal($proj_id, $jv_no, $jv_date, $config_ledger->purchase_vat, $narration_vat, ($vat_on_purchase), '0', $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);

add_to_sec_journal($proj_id, $jv_no, $jv_date, $vendor_ledger, $narration_vat, '0', ($vat_on_purchase), $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);

}

if($acConfig=='Yes'){

sec_journal_journal($jv_no,$jv_no,$tr_from);

echo $sqlUp='update secondary_journal set checked="YES" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sqlUp);

}


$po_qty = find_a_field('purchase_invoice','sum(qty)','po_no="'.$po_no.'"');

$pr_qty = find_a_field('purchase_receive_asset','sum(qty)','po_no="'.$po_no.'"');



if($po_qty==$pr_qty){

 $master_update = 'update purchase_master set status="COMPLETED" where po_no="'.$po_no.'"';

 db_query($master_update);

}

$_SESSION['pr_no'] = '';

$_SESSION['po_no'] = '';

header("Location:upcoming_po.php");



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



$pr_all = find_all_field('purchase_receive_asset','','po_no="'.$_REQUEST['po_no'].'"');



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

           <input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" class="form-control" readonly/>



		<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" required="required"/>

          </div>

		  

		  

		   <div class="col-md-3 form-group">

		    <? $field='quotation_no';?>

            <label for="wo_detail">Ref No: </label>

             <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly  class="form-control"/>

          </div>

		  

		  

		  

		  

		    <div class="col-md-3 form-group">

			 <? $field='req_no';?>

            <label for="wo_detail">Req No: </label>

             <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly class="form-control" />

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

      <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly class="form-control"/>

          </div>

		  

		     <div class="col-md-3 form-group">

		  <? $field='checked_by';?>

            <label for="wo_subject"> Approved By: </label>

     <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" readonly class="form-control"/>

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



$sql='select distinct pr_no,rec_date from purchase_receive_asset where po_no='.$po_no.' order by pr_no desc';



$qqq=db_query($sql);



while($aaa=mysqli_fetch_object($qqq)){



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



        <td rowspan="2" align="center" bgcolor="#CCFF99"><a href="po_print_view.php?po_no=<?=$po_no?>" target="_blank"><img src="../../images/print.png" width="26" height="26" /></a></td>



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



        <!--<td align="right" bgcolor="#9999FF"><strong>Receive NO: </strong></td>



        <td align="right" bgcolor="#9999FF"><strong>



          <input style="width:105px;"  name="rec_no" type="hidden" id="rec_no" value="<? if($pr_all->rec_no!='') echo $pr_all->rec_no; else '';?>" required="required"/>



        </strong></td>-->



        <td align="right" bgcolor="#9999FF"><strong>Receive Date :</strong></td>



        <td bgcolor="#9999FF"><strong>



          <input style="width:105px; background:#fff;"  name="rec_date" type="text" id="rec_date" value="<?=date('Y-m-d');?>" required readonly/>



        </strong></td>



        <td align="right" bgcolor="#9999FF"><strong>QC By :</strong></td>



        <td bgcolor="#9999FF"><strong>



          <input style="width:105px;background:#fff;"  name="qc_by" type="text" id="qc_by" value="<? if($pr_all->qc_by!='') echo $pr_all->qc_by; else '';?>"/>



        </strong></td>



        <td bgcolor="#9999FF"><div align="right"><strong>Vendor Chalan No :</strong></div></td>



        <td bgcolor="#9999FF"><strong>



          <input style="width:105px;background:#fff;"  name="ch_no" type="text" id="ch_no" value="<? if($pr_all->ch_no!='') echo $pr_all->ch_no; else '';?>" required="required"/>
        </strong></td>



      </tr>



    </table></td>



    </tr>



</table>



<? if($$unique>0){



 $sql='select a.id,a.item_id,b.item_name,b.unit_name,a.qty,a.rate from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$$unique;



$res=db_query($sql);



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



            <th bgcolor="#FF99FF">PO Qty</th>



            <th bgcolor="#009900">Received Qty </th>



            <th bgcolor="#FFFF00">UnRecevied Qty </th>



            <th bgcolor="#0099CC">Item Serial Number </th>

			

			<th bgcolor="#0099CC">Action </th>



          </tr>



          



          <? while($row=mysqli_fetch_object($res)){
		  
		  
		  $bg++;

		  ?>



          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">



            <td><?=++$ss;?></td>



            <td><?=$row->item_id?>



              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>



              <td><?=$row->item_name?>


<input type="hidden" name="id_<?=$row->id?>" value="<?=$row->id?>" />
                <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" /></td>



              <td width="7%" align="center"><?=$row->unit_name?>



                <input type="hidden" name="unit_name" id="unit_name" value="<?=$row->unit_name?>" />

				<input type="hidden" name="order_no_<?=$row->id?>" id="order_no_<?=$row->id?>" value="<?=$row->id?>" /></td>



              <td width="7%" align="center"><?=$row->qty?></td>



              <td width="6%" align="center"><span id="rcvd_qtty_<?=$row->id?>"><? echo $rec_qty = (find_a_field('purchase_receive_asset','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1));?></span></td>



              <td width="7%" align="center"><span id="rest_qtty_<?=$row->id?>"><? echo $unrec_qty=($row->qty-$rec_qty);?></span>



                <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>



              <td width="5%" align="center" bgcolor="#6699FF" style="text-align:center">

 <span id="s_check_<?=$row->id?>">

			 

			 </span>

			  <? if($unrec_qty>0){$cow++;?>

            

 <input name="serial_no_<?=$row->id?>" type="text" id="serial_no_<?=$row->id?>" style="width:200px; float:none; background:#FFFFFF" onkeyup="check_serial(<?=$row->id?>)" value=""  />



                <? } else echo 'Done';?></td>

				

				<td>
<input type="button" name="add_item" id="add_item" value="ADD" class="btn btn-warning" onclick="insert_item(<?=$row->id?>)" />


</td>



              </tr>



          <?  }?>



      </tbody>



      </table>



      </div>



      </td>

	  </tr>

	    <tr>

		    <td>&nbsp;</td>

		  </tr>



	  <tr>

	  

	  <td><div class="tabledesign2">

	  <span id="codzList">

	  <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">



      <tbody>



          <tr>



            <th>SL</th>



            <th>PR No</th>

			

			<th>Item Code</th>



            <th>Item Name</th>



            <th bgcolor="#FFFFFF">Unit</th>



            <th bgcolor="#FF99FF">Qty</th>



            <th bgcolor="#009900">Item Serial No </th>

            <th bgcolor="#009900">Action </th>



          </tr>

		

          



          <? 

		     $sql = 'select p.*,i.item_name,i.unit_name from purchase_receive_asset p,item_info i where i.item_id=p.item_id and po_no="'.$_GET['po_no'].'" and p.journal="Pending"';

			 $qr = db_query($sql);
			 
			 $zx=1;

		  while($row=mysqli_fetch_object($qr)){$bg++?>



          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">



            <td><?=$zx++;?></td>



            <td><?=$row->pr_no?></td>

			

			<td><?=$row->item_id?></td>



              <td><?=$row->item_name?></td>



              <td align="center"><?=$row->unit_name?></td>



              <td align="center"><?=$row->qty?></td>



              <td align="center"><?=$row->serial_no?></td>

              <td align="center"><a href="?del=<?=$row->id?>">X</a></td>



              </tr>



          <? }?>



      </tbody>



      </table>

	  </span>

	  </div>

	  </td>



    </tr>



  </table><br />



<table width="100%" border="0">



<? if($cow<1){



$vars['status']='COMPLETED';



db_update('sale_do_chalan', $pr_no, $vars, 'pr_no');



?>



<tr>



<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS PURCHASE ORDER IS COMPLETE</strong></td>



</tr>



<? }else{?>



<tr>



<td align="center"><input name="delete" type="button" class="btn btn-danger" value="CANCEL PURCHASE ORDER" style="width:270px; font-weight:bold; font-size:12px;color:white; height:30px" onclick="window.location = 'select_dealer_chalan.php?del=1&po_no=<?=$po_no?>';" />



<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>



<td align="center"><input name="confirm" type="submit" class="btn btn-info" value="RECEIVE CONFIRM" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:white" /></td>



</tr>



<? }?>



</table>



<? }?>



</form>



</div>

<script>

function insert_item(id){

var item1 = $("#item_id_"+id);

var serial = $("#serial_no_"+id);



if(serial.val()==""){

	 alert('Please Enter Item Serial Number!');

	  return false;

  }



$.ajax({

url:"pr_input_ajax.php",

method:"POST",

dataType:"JSON",
data:$("#codz").serialize(),

success: function(result, msg){
var res = result;
$("#codzList").html(res[0]);	

$("#serial_no_"+id).val('');



}

});	



  }
</script>



<script>

function check_serial(id){


$.ajax({

		url: "serial_check_ajax.php",

		method: "POST",

		dataType:"json",

		data:{

		serial_no: $("#serial_no_"+id).val(),

		po_no: $("#po_no").val(),

		item_id: $("#item_id_"+id).val()

		},

		success: function(data){

		$("#s_check_"+id).html(data.msg);

		$("#rest_qtty_"+id).html(data.rest_qty);

		$("#rcvd_qtty_"+id).html(data.rcv_qty);

		}

		})

}

</script>

<script>$("#codz").validate();$("#cloud").validate();</script>



<?



//



//
require_once SERVER_CORE."routing/layout.bottom.php";


?>