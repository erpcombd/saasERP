<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='FOC Order Request';



do_calander('#foc_date');



$table_master='sale_do_master';

$table_details='sale_do_details';

 $unique='do_no';



if($_REQUEST['old_do_no']>0)

$$unique=$_REQUEST['old_do_no'];


//if($_SESSION[$unique]>0)
//
//$$unique=$_SESSION[$unique];
//
//
//
//if($_REQUEST[$unique]>0){
//
//$$unique=$_REQUEST[$unique];
//
//$_SESSION[$unique]=$$unique;}
//
//else
//
// $$unique = $_SESSION[$unique];
//






if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:i:s');

		$_POST['status']='PROCESSING';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Completed All Purchase Order.';
		
		echo '<script>window.location.replace("select_unfinished_do.php")</script>';

}



if(isset($_POST['delete']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['status']='MANUAL';

		$crud   = new crud($table_master);

		$crud->update($unique);



		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Order Returned.';

}



if(prevent_multi_submit()){

if(isset($_POST['confirm'])){

		
		$do_no= $_POST['do_no'];
		$foc_type=$_POST['foc_type'];
		$foc_date=$_POST['foc_date'];
		$reason=$_POST['reason'];
		$entry_at = date('Y-m-d H:i:s');
		$entry_by =$_SESSION['user']['id'];			
		$cancel_no = next_transection_no('0',$cancel_date,'sale_do_chalan_cancel','cancel_no');
		$status = 'PENDING';
		
		$foc_no = find_a_field('sale_foc_master','max(foc_no)','1')+1;
		
		//$do = find_all_field('sale_do_chalan','do_no','chalan_no='.$chalan_no);
		//$do_no = $do->do_no;
		//$do_chalan_date = $do->chalan_date;
		//$config_ledger = find_all_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
		//$sales_ledger = find_a_field('config_group_class','sales_ledger',"group_for=".$_SESSION['user']['group']);
		//$dealer= find_all_field('dealer_info','account_code',"dealer_code=".$_POST['dealer_code']);
		//$dealer_ledger= $dealer->account_code;
		$master = find_all_field('sale_do_master','','do_no='.$do_no);
		
		 $ins_master = "INSERT INTO `sale_foc_master` (foc_no, foc_date, foc_reason, foc_type, do_no, do_date, year, job_id, job_no, fsc_claim, fsc_logo, cbm_no, group_for, dealer_group, dealer_code, buyer_code, merchandizer_code, marketing_team, marketing_person, order_throw, order_type, remarks, customer_po_no, customer_po_date, status, depot_id, sp_discount, vat, discount, cash_discount, entry_at, entry_by, checked_at, checked_by, entry_time, hold_req_date, hold_req_by, hold_req_at, hold_app_by, hold_app_at, unhold_by, unhold_at, cancel_req_date, cancel_req_by, cancel_req_at, cancel_app_by, cancel_app_at, hold_note, cancel_note)
  
  VALUES( '".$foc_no."', '".$foc_date."', '".$reason."', '".$foc_type."', '".$master->do_no."', '".$master->do_date."', '".$master->year."', '".$master->job_id."', '".$master->job_no."', '".$master->fsc_claim."', '".$master->fsc_logo."', '".$master->cbm_no."', '".$master->group_for."', '".$master->dealer_group."', '".$master->dealer_code."', '".$master->buyer_code."', '".$master->merchandizer_code."', '".$master->marketing_team."', '".$master->marketing_person."', '".$master->order_throw."', '".$master->order_type."', '".$master->remarks."', '".$master->customer_po_no."', '".$master->customer_po_date."', 'UNCHECKED', '".$master->depot_id."', '".$master->sp_discount."', '".$master->vat."', '".$master->discount."', '".$master->cash_discount."', '".$entry_at."', '".$entry_by."', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'  )";

db_query($ins_master);
		
		
		
		
		
		
		
		
		 $sql = 'select * from sale_do_chalan where do_no = '.$do_no.' ';
		$query = db_query($sql);	
		while($data=mysqli_fetch_object($query))
		{
			if(($_POST['chalan_'.$data->id]>0))
			{
			
			
			$qty=$_POST['chalan_'.$data->id];
			
			$amount = ($qty*$data->unit_price); 
			
			$reason=$_POST['reason_'.$data->id];

				
			 $ins_details = "INSERT INTO sale_foc_details (foc_no, foc_date, chalan_no, order_no, do_no, do_date, job_no, delivery_date, cbm_no, group_for, dealer_code, buyer_code, merchandizer_code, destination, delivery_place, customer_po_no, unit_name, measurement_unit, ply, paper_combination_id, paper_combination, L_cm, W_cm, H_cm, WL, WW, item_id, formula_id, formula_cal, sqm_rate, sqm, additional_info, additional_charge, number_format, final_price, unit_price, total_unit, total_amt, style_no, po_no, referance, sku_no, printing_info, color, pack_type, size, depot_id, edit_request, status, entry_time, request_by, request_at, accept_by, accept_at, entry_by, entry_at, edit_by, edit_at, reason, sst, count_id, count, length, length_unit)
  
  VALUES('".$foc_no."', '".$foc_date."', '".$data->chalan_no."', '".$data->id."',  '".$data->do_no."', '".$data->do_date."', '".$data->job_no."', '".$data->delivery_date."', '".$data->cbm_no."', '".$data->group_for."', '".$data->dealer_code."', '".$data->buyer_code."', '".$data->merchandizer_code."', '".$data->destination."', '".$data->delivery_place."', '".$data->customer_po_no."', '".$data->unit_name."', '".$data->measurement_unit."', '".$data->ply."', '".$data->paper_combination_id."', '".$data->paper_combination."', '".$data->L_cm."', '".$data->W_cm."', '".$data->H_cm."', '".$data->WL."', '".$data->WW."', '".$data->item_id."', '".$data->formula_id."', '".$data->formula_cal."', '".$data->sqm_rate."', '".$data->sqm."', '".$data->additional_info."', '".$data->additional_charge."', '".$data->number_format."', '".$data->final_price."', '".$data->unit_price."', '".$qty."', '".$amount."', '".$data->style_no."', '".$data->po_no."', '".$data->referance."', '".$data->sku_no."', '".$data->printing_info."', '".$data->color."', '".$data->pack_type."', '".$data->size."', '".$data->depot_id."', '".$data->edit_request."', 'UNCHECKED', '".$data->entry_time."', '0', '0', '0', '0', '".$entry_by."', '".$entry_at."', '0', '0', '".$reason."', '".$data->sst."', '".$data->count_id."', '".$data->count."', '".$data->length."', '".$data->length_unit."')";

db_query($ins_details);
			
	
			}
			
			
		}
		
		
		//$sql3 = 'update sale_do_chalan set status="CANCELED" where chalan_no = '.$chalan_no;
		//db_query($sql3);
		
	
		
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

var pending_qty=((document.getElementById('unso_qty_'+id).value)*1);
var bc_qty=((document.getElementById('issue_'+id).value)*1);



 if(bc_qty>pending_qty)
  {
alert('Can not issue more than pending quantity.');
document.getElementById('issue_'+id).value='';
document.getElementById('chalan_'+id).value='';


  } 



//if (pp_bag >0) {
//	var pp_qty= document.getElementById('pp_qty_'+id).value= (bag_size*pp_bag);
//	var hdpe_bag= document.getElementById('hdpe_bag_'+id).value= (pp_bag/3);
//	var hdpe_qty= document.getElementById('hdpe_qty_'+id).value= (bag_size*hdpe_bag);
//	
//	var total_bag= document.getElementById('total_bag_'+id).value= (pp_bag+hdpe_bag);
//	var total_qty= document.getElementById('total_qty_'+id).value= (pp_qty+hdpe_qty);
//} else if((pp_bag ==0)) {
//	var hdpe_bag=((document.getElementById('hdpe_bag_'+id).value)*1);
//	var hdpe_qty= document.getElementById('hdpe_qty_'+id).value= (bag_size*hdpe_bag);
//	
//	var total_bag= document.getElementById('total_bag_'+id).value= (hdpe_bag);
//	var total_qty= document.getElementById('total_qty_'+id).value= (hdpe_qty);
//}
//
//var wastage_starting=((document.getElementById('wastage_starting_'+id).value)*1);
//var wastage_on_process=((document.getElementById('wastage_on_process_'+id).value)*1);
//var total_wastage= document.getElementById('total_wastage_'+id).value= (wastage_starting+wastage_on_process);
//var net_total_qty= document.getElementById('net_total_qty_'+id).value= (total_qty-total_wastage);


}

</script>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td width="45%" valign="top"><fieldset style="width:100%;">

    <? $field='do_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">WO  No: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:250px;" />

      </div>

    <? $field='do_date';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">WO Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required  style="width:250px;" />

      </div>
	  
	  
	  
	 
	  
	   <? $field='job_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">Job No:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:250px;"  />

      </div>
	  
	  
	  
	  <div>

        <label style="width:140px;" for="<?=$field?>"> Customer:</label>

        <input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$dealer_code);?>" 
		style="width:250px;" required="required"/>

		<input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code?>" required="required" style="width:250px;"/>

      </div>
	  
	  
	  
	  
	  
	  <div>

        <label style="width:140px;" for="<?=$field?>"> Buyer:</label>

         <input  name="buyer_info2" type="text" id="buyer_info2" value="<?=find_a_field('buyer_info','buyer_name','buyer_code='.$buyer_code);?>" required="required" 
		 style="width:250px;"/>

		<input  name="buyer_code" type="hidden" id="buyer_code" value="<?=$buyer_code?>" required="required"/>

      </div>
	  
	  
	  <div>

        <label style="width:140px;" for="<?=$field?>">Merchandiser:</label>

        <input  name="merchandizer_code2" type="text" id="merchandizer_code2" value="<?=find_a_field('merchandizer_info','merchandizer_name','merchandizer_code='.$merchandizer_code);?>" required="required" style="width:250px;"/>

		<input  name="merchandizer_code" type="hidden" id="merchandizer_code" value="<?=$merchandizer_code?>" required="required"/>

      </div>
	 


    </fieldset></td>

    <td width="9%">			</td>

    <td width="45%"><fieldset style="width:100%;">
	
	
	
	<? $field='group_for'; $table='user_group';$get_field='id';$show_field='group_name';?>

      <div>

        <label style="width:140px;" for="<?=$field?>">Company:</label>

        <input  name="group_for2" type="text" id="group_for2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" style="width:250px;" />

		<input  name="group_for" type="hidden" id="group_for" value="<?=$group_for?>" required="required"/>

      </div>
	  
	  
	   <? $field='customer_po_no';?>

      <div>

        <label style="width:140px;" for="<?=$field?>"><span style="width:140px;">Customer's PO</span>:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"   style="width:250px;"/>

      </div>
	  
	  
	   <? $field='customer_po_date';?>

      <div>

        <label style="width:140px;" for="<?=$field?>"><span style="width:140px;">PO Date</span>:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  style="width:250px;" />

      </div>
	
	
	


      <div>

        <label style="width:140px;" for="<?=$field?>"> Marketing Team:</label>

        <input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('marketing_team','team_name','team_code='.$marketing_team);?>"
		style="width:250px;" required="required"/>

		<input  name="marketing_team" type="hidden" id="marketing_team" value="<?=$marketing_team?>" required="required" style="width:250px;"/>

      </div>
	  
	  	  <div>

        <label style="width:140px;" for="<?=$field?>"> Marketing Person:</label>

        <input  name="dealer_code2" type="text" id="dealer_code2" value="<?=find_a_field('marketing_person','marketing_person_name','person_code='.$marketing_person);?>" 
		style="width:250px;" required="required"/>

		<input  name="marketing_person" type="hidden" id="marketing_person" value="<?=$marketing_person?>" required="required" style="width:250px;"/>

      </div>
	  
	  
	  <div>

        <label style="width:140px;" for="<?=$field?>">Remarks:</label>


		<input  name="remarks" type="text" id="remarks" value="<?=$remarks?>"  readonly="" style="width:250px;"/>

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

        

        <td rowspan="2" align="left" bgcolor="#CCFF99">
		<a title="WO Preview" target="_blank" href="../wo/work_order_print_view.php?v_no=<?=$$unique?>"><img src="../../../images/print.png" alt="" width="30" height="30" /></a>
		</td>
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
          <td align="right" width="20%" bgcolor="#00A59A"><strong>FOC Date :</strong></td>
          <td align="left" width="20%"bgcolor="#00A59A"><strong>
            <input style="width:120px;"  name="foc_date" type="text" id="foc_date" required="required" value="<?=date('Y-m-d')?>"/>
          </strong></td>
          <td bgcolor="#00A59A" align="right" width="20%"><strong>Criteria:</strong></td>
          <td bgcolor="#00A59A" align="left" width="20%">
		 <select name="foc_type" id="foc_type" style="width:250px;" required>
        <option></option>
        <?
		
		foreign_relation('foc_criteria','id','criteria',$_POST['foc_type'],'1');

		?>
      </select>
		  </td>
          <td bgcolor="#00A59A" align="right" width="20%"><strong>Reason:</strong></td>
          <td bgcolor="#00A59A" align="left" width="40%"><strong>
            <input style="width:300px;"  name="reason" type="text" id="reason" required="required"/>
          </strong></td>
        </tr>
      </table></td>
    </tr>
    </table></td>

    </tr>

</table>

<? if($$unique>0){

  $sql = "select c.*, i.item_name from item_info i, sale_do_chalan c where i.item_id=c.item_id and c.do_no=".$$unique;

 

$res=db_query($sql);

?>


<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="tabledesign2">
      <table width="100%" align="center" cellpadding="0" cellspacing="0" id="grp">
      <tbody>
          <tr>
            <th width="1%">SL</th>
            <th width="3%">Color</th>
            <th width="5%">Referance</th>
            <th width="7%">Shade</th>
            <th width="7%">Style No</th>
            <th width="8%">PO No</th>
            <th width="7%">Type</th>
            <th width="8%">SST</th>
            <th width="8%">Count</th>
            <th width="7%">Lenght</th>
            <th width="7%">UOM</th>
            <th width="11%">Challan Qty </th>
            <th width="9%">FOC Qty </th>
            <th width="12%"><strong>Reason</strong></th>
          </tr>
          
          <? while($row=mysqli_fetch_object($res)){$bg++?>
          <tr bgcolor="<?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>">
            <td><?=++$ss;?></td>
            <td><?=$row->color?></td>
              <td><?=$row->referance?></td>
              <td><?=$row->shade?></td>
              <td><? 
		  if ($row->style_no!="") {
		  echo $row->style_no;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><? 
		  if ($row->po_no!="") {
		  echo $row->po_no;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><? 
		  if ($row->pack_type!="") {
		  echo $row->pack_type;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><? 
		  if ($row->sst!="") {
		  echo $row->sst;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><? 
		  if ($row->count!="") {
		  echo $row->count;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><? 
		  if ($row->length!="") {
		  echo $row->length;
		  } else {
		  echo 'N/A';
		  }
		  ?></td>
              <td><?=$row->unit_name?></td>
              <td><?=$row->total_unit?></td>
              <td>
			  
			  <?php /*?><? if($unso_qty>0){$cow++;?>
			  
			   <? } else echo 'Done';?><?php */?>

          <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" value=""  style="width:80px; height:25px; float:none"  onKeyUp="calculation_1(<?=$row->id?>)" />			  </td>
              <td>
			  
			  <input list="foc_reason" name="reason_<?=$row->id?>" id="reason"  style="width:120px;"   autocomplete="off" >
  <datalist id="foc_reason">
   
     <? foreign_relation('foc_reason','foc_reason','foc_reason',$reason,'1');?>
  </datalist>			  </td>
          </tr>
          <? }?>
		    <tr>
            <td colspan="14">&nbsp;</td>
            </tr>
      </tbody>
      </table>
      </div>
      </td>
    </tr>
  </table><br />
  

	
	<br />
	
	
	
	<table width="100%" border="0">


<tr>

<td align="center"><!--<input name="delete" type="submit" class="btn1" value="CANCEL WO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />-->

</td>

<td align="center">
<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/>
<input name="confirm" type="submit" class="btn1" value="CONFIRM FOC" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>





</table>
	
	
  

<?php /*?><table width="100%" border="0">

<? 

 $wo_status = find_a_field('sale_do_master','status','do_no='.$$unique);

if($wo_status!="CHECKED"){

?>



<tr>

<td align="center"><!--<input name="delete" type="submit" class="btn1" value="CANCEL WO" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />-->

</td>

<td align="center">
<input  name="do_no" type="hidden" id="do_no" value="<?=$do_no;?>"/>
<input name="confirm" type="submit" class="btn1" value="WO HOLD REQUEST" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>




<? }else{?>

<tr>

<td colspan="2" align="center" bgcolor="#FF3333"><strong>THIS  WORK ORDER  
  <?=$wo_status?></strong></td>

</tr>

<? }?>

</table><?php */?>

<? }?>

</form>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";


?>