<?php

session_start();

ob_start();

require "../../support/inc.all.php";



$title='Creating Bills From Purchase';



do_calander('#bill_date');



$table_master='purchase_receive';

$table_details='purchase_receive';

 $unique='pr_no';




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

		$bill_no = $_POST['bill_no'];

		$bill_date = $_POST['bill_date'];
		
		$purchase_payment_type = $_POST['purchase_payment_type'];
		
		$acc_note = $_POST['acc_note'];
		
		$bill_create_by=$_SESSION['user']['id'];
		$bill_create_at=date('Y-m-d H:i:s');

		
		$now = date('Y-m-d H:i:s');

		 $pr_no = $$unique;
		 
		 $sql = 'update purchase_receive set bill_no="'.$bill_no.'",  bill_date="'.$bill_date.'", 
		 purchase_payment_type="'.$purchase_payment_type.'", 
		 acc_note="'.$acc_note.'", status="Bill Created", bill_create_by="'.$bill_create_by.'" , bill_create_at="'.$bill_create_at.'" where pr_no = '.$pr_no;
		db_query($sql);
		
		
		
		if($pr_no>0)
		{
		auto_insert_purchase_secoundary_journal($pr_no);
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


<?php /*?><?
if($pr_no>0)
		{

			echo "<script language='javascript'>window.open('pr_bill_print_view.php?pr_no=".$pr_no."','Chalan Print').focus();</script>";
	
		}
?><?php */?>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td width="40%" valign="top"><fieldset style="width:100%;">

    <? $field='po_no';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">PO  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
		
		<? $po_data = find_all_field('purchase_master','','po_no='.$$field);?>

      </div>

    <? $field=$po_data->po_date;?>

      <div>

        <label style="width:120px;" for="<?=$field?>">PO Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$po_data->po_date?>" required/>

      </div>

    

   <?php /*?> <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">Warehouse:</label>

        <input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required"/>

		<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" required="required"/>

      </div><?php */?>
	  
	  
	   <? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">Company:</label>

        <input  name="group_for2" type="text" id="group_for2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required"/>

		<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required="required"/>

      </div>
	  
	   <div>
	   
	   <? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>

	  <label style="width:120px;" for="<?=$field?>">Suppliyer:</label>

      <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$vendor_id)?>"/>

      </div>

            


     

    </fieldset></td>

    <td width="9%">			</td>

    <td width="40%"><fieldset style="width:100%;">
	
	
	
	<? $field='pr_no';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">PR  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

      </div>

    <? $field='rec_date';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">PR Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

      </div>
	
	
	
	

  <?php /*?>  <? $field='req_no';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">Req. No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" />

      </div><?php */?>

      <div></div>
	  
	     <? $field='ch_no';?>

      <div>

        <label style="width:120px;" for="<?=$field?>">Challan No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" />

      </div>
      

     

      <div>

<? $field='entry_by'; $table='user_activity_management';$get_field='user_id';$show_field='fname';?>

        <div>

<label style="width:120px;" for="<?=$field?>">Entry By:</label>

<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required"/>

        </div>

       

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

        <td colspan="3" align="center" bgcolor="#CCFF99"><strong>PO Entry Information</strong></td>

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

	<table width="91%" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr height="30px">

        <td width="9%" align="right" bgcolor="#9999FF"><strong>Bill NO: </strong></td>

        <td width="12%" align="right" bgcolor="#9999FF"><strong>

          <input style="width:90px;"  name="bill_no" type="text" id="bill_no" value="" required="required"/>

        </strong></td>

        <td width="6%" align="right" bgcolor="#9999FF"><strong> Date:</strong></td>

        <td width="11%" bgcolor="#9999FF"><strong>

          <input style="width:80px;"  name="bill_date" type="text" id="bill_date" value="" required="required"/>

          <input style="width:105px;"  name="qc_by" type="hidden" id="qc_by"/>
          <input style="width:105px;"  name="ch_no" type="hidden" id="ch_no"/>
        </strong></td>

        <td width="15%" bgcolor="#9999FF"><strong>Payment Type: </strong></td>
        <td width="16%" bgcolor="#9999FF">
			<select name="purchase_payment_type" id="purchase_payment_type" style="width:120px" required>

                      <option></option>
                      <? foreign_relation('purchase_payment_type','id','purchase_payment_type',$purchase_payment_type,'1');?>
                </select>
		</td>
        <td width="10%" bgcolor="#9999FF"><strong>Remarks: </strong></td>
        <td width="21%" bgcolor="#9999FF"><strong>
          <input style="width:140px;"  name="acc_note" type="text" id="acc_note" value="" />
        </strong></td>
      </tr>
    </table></td>

    </tr>

</table>

<? if($$unique>0){

$sql='select a.id, m.ait, m.tax,m.transport_bill, m.labor_bill, a.item_id, d.group_name, b.finish_goods_code, b.item_name, b.unit_name,a.pkt_unit,a.qty,a.rate, a.amount from purchase_master m, purchase_receive a,item_info b, item_sub_group c, item_group d where m.po_no=a.po_no and b.sub_group_id=c.sub_group_id and c.group_id=d.group_id and b.item_id=a.item_id and a.pr_no='.$$unique;

$res=db_query($sql);



?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div class="tabledesign2">

      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">

      <tbody>

          <tr>

            <th width="9%">SL</th>

            <th width="19%">Item Group</th>

            <th width="51%">Item Name</th>

            <th bgcolor="#FFFFFF">Unit</th>

            <th bgcolor="#009900">Bag/Crt</th>
            <th bgcolor="#009900">Received </th>

            <th bgcolor="#FFFF00">Rate</th>
            <th bgcolor="#FFFF00">Amount </th>
            </tr>

          

          <? while($row=mysqli_fetch_object($res)){$bg++?>
		  
		  <?  $vat = $row->tax;
		  	  $ait = $row->ait;
			  $transport_bill = $row->transport_bill;
			  $labor_bill = $row->labor_bill;
		  ?>

          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">

            <td><?=++$ss;?></td>

            <td><?=$row->group_name?>

              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>

              <td><?=$row->item_name?>

                <input type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" /></td>

              <td width="7%" align="center"><?=$row->unit_name?>

                <input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>

              <td width="6%" align="center"><? echo number_format($row->pkt_unit,2);?></td>
              <td width="6%" align="center"><? echo number_format($row->qty,2);?></td>

              <td width="8%" align="center"><? echo number_format($row->rate,2);?></td>
              <td width="8%" align="center"><? echo  number_format($row->amount,2); $sub_total +=$row->amount;?>                </td>
              </tr>
          

          <? }?>
		  
		  <tr >
            <td colspan="7"><div align="right"><strong>Sub Total: </strong></div></td>
            <td align="center"><strong><? echo  number_format($sub_total,2); ?></strong></td>
          </tr>
		  
		  <? if($vat>0) {?>
		  <tr >
		    <td colspan="7"><div align="right"><strong>VAT (<? echo  number_format($vat,1); ?> %): </strong></div></td>
		  <td align="center"><strong><? echo  number_format($vat_amt=($sub_total*$vat)/100,2); ?></strong></td>
		    </tr>
			 <? }?>
			
			<? if($transport_bill>0) {?>
			<tr >
            <td colspan="7"><div align="right"><strong>Transport Bill: </strong></div></td>
            <td align="center"><strong><? echo  number_format($transport_bill,2); ?></strong></td>
          </tr>
		  <? }?>
		  
		  <? if($labor_bill>0) {?>
		  <tr >
            <td colspan="7"><div align="right"><strong>Labour Bill: </strong></div></td>
            <td align="center"><strong><? echo  number_format($labor_bill,2); ?></strong></td>
          </tr>
		<? }?>
			
			
		  <tr >
		    <td colspan="7"><div align="right"><strong>Payable Amount: </strong></div></td>
		    <td align="center"><strong><? echo  number_format($payable_amt=($sub_total+$vat_amt+$ait_amt+$transport_bill+$labor_bill),2); ?></strong></td>
		    </tr>
      </tbody>
      </table>

      </div>

      </td>

    </tr>

  </table><br />

<table width="100%" border="0">

<? if($status!='Received'){

//$vars['status']='COMPLETED';

//db_update($table_master, $po_no, $vars, 'po_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>Bill Create Complete</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input name="delete" type="button" class="btn1" value="CANCEL PURCHASE ORDER" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" onclick="window.location = 'select_dealer_chalan.php?del=1&po_no=<?=$po_no?>';" />

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>

<td align="center">
<input  name="pr_no" type="hidden" id="pr_no" value="<?=$$unique?>"/>
<input name="confirm" type="submit" class="btn1" value="BILL CREATE" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>