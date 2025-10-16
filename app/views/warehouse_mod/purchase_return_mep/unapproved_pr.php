<?php


//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Unapproved Purchase Return';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_return_master';


$unique = 'pr_no';

$status = 'UNCHECKED';
$target_url = '../purchase_return_mep/return_checking.php';

// Purchase Journal
if(isset($_POST['confirmm'])){

$pr_no = $_REQUEST['pr_no'];
$now = date('Y-m-d H:i:s');
$rec_date=date('Y-m-d');


$pr_master = find_all_field('purchase_return_master','','pr_no='.$pr_no);
$grn_no=$pr_master->invoice_no;
$invoice_rcv=find_all_field('vendor_invoice_master','system_invoice_no','grn_no="'.$pr_master->invoice_no.'"');
$invoice_amt=find_a_field('vendor_invoice_details','sum(amount)','grn_no="'.$pr_master->invoice_no.'"');
$invoice=$invoice_rcv->system_invoice_no;
$tds_per=$invoice_rcv->tds_percent;
$tds_amount =$invoice_rcv->tds_amount;

$payment=find_a_field('journal','jv_no','tr_no="'.$invoice.'" and tr_from="Vendor_payment" group by jv_no');

$tds_payment=find_all_field('journal','jv_no','tr_no="'.$invoice.'" and tr_from in("vendor_tds_payment") and cr_amt>0');
$tds_cash_bank=$tds_payment->ledger_id;
$tds_cash_bank_sl=$tds_payment->sub_ledger;

$vds_payment=find_all_field('journal','jv_no','tr_no="'.$invoice.'" and tr_from in("vendor_vds_payment") and cr_amt>0');

$vds_cash_bank=$vds_payment->ledger_id;
$vds_cash_bank_sl=$vds_payment->sub_ledger;

$vendor = find_all_field('vendor','','vendor_id='.$pr_master->vendor_id);



$config_ledger = find_all_field('config_group_class','',"group_for=".$pr_master->group_for);




$doc_ledger =$config_ledger->doc_ledger;

$local_doc_ledger = $vendor->ledger_id;

$tds_payable=$config_ledger->tds_payable;

$vds_payable=$config_ledger->vds_payable;

$vat_control_acc =$config_ledger->purchase_vat;

$input_vat=$config_ledger->vat_current;

$proj_id = 'clouderp'; 

$jv_date = $rec_date;

$tr_from = 'Purchase Return';

$jv_no=next_journal_sec_voucher_id('','Purchase Return',$pr_master->group_for);

$narration = 'PR#'.$pr_no.' (Pr#'.$pr_no.')';




$sql = 'select a.*, m.pr_no,m.depot_id as warehouse_id,m.return_type, m.pr_date,s.return_type,sg.item_ledger as ledger_group_id,v.sub_ledger_id as sub_ledger_id,b.sub_ledger_id as item_sub_ledger
 
 from purchase_return_master m, purchase_return_details a, item_info b, purchase_return_type s, item_group g ,item_sub_group sg, vendor v
 
 where b.sub_group_id=sg.sub_group_id and sg.group_id=g.group_id and m.return_type=s.id and m.pr_no=a.pr_no and b.item_id=a.item_id and v.vendor_id=m.vendor_id and a.flag=0 and a.pr_no='.$pr_no.' order by a.id ';

$query = db_query($sql);

$vat_amt=0;

$rebate_amt=0;

$amount=0;

while($data=mysqli_fetch_object($query))

{


$qty=$data->total_unit;

$free_qty=0;
$rate=$data->unit_price;

$item_id =$data->item_id;

$unit_name =$data->unit_name;
$urate=$data->with_vat_rate;

$amount = round(($qty*$urate),2);

if($tds_per==0 && $tds_amount>0){
 $tds_amount=round((($invoice_rcv->tds_amount/$invoice_amt)*100),2);
}elseif($tds_per>0){

$tds_amount=$amount*($tds_per/100);
}
$total = $total+ $amount;

$rcv_amt=round(($qty*$urate),2);

//$xid = mysql_insert_id();
$xid = $data->id;

$avg_rate = find_a_field('journal_item', '(sum(item_in*final_price)-sum(item_ex*final_price))/(sum(item_in)-sum(item_ex))', 'item_id = "'.$data->item_id.'"');
	


	
journal_item_control($item_id, $data->warehouse_id, $rec_date,  0,$qty, 'Purchase Return', $xid, $urate,'',$pr_no,'','',$data->group_for, $avg_rate, '' );
		
		$inv_ledger =$data->ledger_group_id;







 //Update Flag
  $q = "UPDATE purchase_return_details 
  
  SET status='COMPLETED',remarks='".$remarks."', total_unit='".$qty."',total_amt='".$amount."',with_vat_rate='".$urate."',total_amt_with_vat='".$rcv_amt."',flag=1
  
  WHERE `pr_no` ='".$pr_no."' and id='".$data->id."' ";
db_query($q);

$vat_amt = number_format((($amount * $pr_master->vat)/100),2,'.','');

if($pr_master->rebate_percentage>0){

$rebate_amt = number_format((($vat_amt*$pr_master->rebate_percentage)/100),2,'.','');

$vat_amt=$vat_amt-$rebate_amt;

}

if($invoice_rcv->deductible=='Yes'){
  $vds_amount = $rebate_amt;

}else{
  $vds_amount = 0;
}


// echo $proj_id.$jv_no.$jv_date.$inv_ledger.$narration.($amount+$vat_amt).'0'. $tr_from. $pr_no.''.$data->id.$cc_code.$data->group_for;
//GRN REVERSE
//if($invoice==''){


add_to_sec_journal($proj_id, $jv_no, $jv_date,$inv_ledger, $narration, '0',($amount), $tr_from, $pr_no,$data->item_sub_ledger,$data->id,$cc_code,$data->group_for);


if($rebate_amt>0){
add_to_sec_journal($proj_id, $jv_no, $jv_date,$vat_control_acc, $narration, '0',($rebate_amt), $tr_from, $pr_no,$data->sub_ledger_id,$data->id,$cc_code,$data->group_for);
}

add_to_sec_journal($proj_id, $jv_no, $jv_date,$doc_ledger, $narration,($amount+$rebate_amt),'0',$tr_from,$pr_no,$data->sub_ledger_id,$data->id,$cc_code,$data->group_for);

//}

//Provision Reverse
if($invoice>0){



  add_to_sec_journal($proj_id, $jv_no, $jv_date,$local_doc_ledger, $narration, (($amount+$rebate_amt)-($tds_amount-$vds_amount)), '0',$tr_from, $pr_no,$data->sub_ledger_id,$data->id,$cc_code,$data->group_for);

  add_to_sec_journal($proj_id, $jv_no, $jv_date,$tds_payable, $narration,($tds_amount),'0', $tr_from, $pr_no,$data->sub_ledger_id,$data->id,$cc_code,$data->group_for);
 if($invoice_rev->deductible=='Yes'){
  add_to_sec_journal($proj_id, $jv_no, $jv_date,$vds_payable, $narration,($vds_amount),'0', $tr_from, $pr_no,$data->sub_ledger_id,$data->id,$cc_code,$data->group_for);
 }
  add_to_sec_journal($proj_id, $jv_no, $jv_date,$vat_control_acc, $narration, ($rebate_amt),'0', $tr_from, $pr_no,$data->sub_ledger_id,$data->id,$cc_code,$data->group_for);

  add_to_sec_journal($proj_id, $jv_no, $jv_date,$input_vat, $narration, '0',($rebate_amt), $tr_from, $pr_no,$data->sub_ledger_id,$data->id,$cc_code,$data->group_for);

  add_to_sec_journal($proj_id, $jv_no, $jv_date,$doc_ledger, $narration,'0',($amount+$rebate_amt),$tr_from,$pr_no,$data->sub_ledger_id,$data->id,$cc_code,$data->group_for);




}

//TDS payment Reverse
if($tds_payment!=''){

add_to_sec_journal($proj_id, $jv_no, $jv_date,$tds_payable, $narration,'0',($tds_amount), $tr_from, $pr_no,$data->sub_ledger_id,$data->id,$cc_code,$data->group_for);
add_to_sec_journal($proj_id, $jv_no, $jv_date,$tds_cash_bank, $narration, ($tds_amount),'0', $tr_from, $pr_no,$tds_cash_bank_sl,$data->id,$cc_code,$data->group_for);
}

//VDS payment Reverse
if($vds_payment!=''){

add_to_sec_journal($proj_id, $jv_no, $jv_date,$vds_payable, $narration,'0',($vds_amount), $tr_from, $pr_no,$data->sub_ledger_id,$data->id,$cc_code,$data->group_for);
add_to_sec_journal($proj_id, $jv_no, $jv_date,$vds_cash_bank, $narration, ($vds_amount),'0', $tr_from, $pr_no,$vds_cash_bank_sl,$data->id,$cc_code,$data->group_for);
}



 
}


  $sql3 = 'update purchase_return_master set status="COMPLETED", checked_by='.$_SESSION['user']['id'].',checked_at="'.date('Y-m-d H:i:s').'" where pr_no = '.$pr_no.'';
	db_query($sql3);


//auto_insert_purchase_secoundary_journal($pr_no);

$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');

$time_now = date('Y-m-d H:i:s');

if($sa_config=="Yes"){

$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up);

$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');

if($jv_config=="Yes"){

sec_journal_journal($jv_no,$jv_no,$tr_from);

$time_now = date('Y-m-d H:i:s');

$up2='update secondary_journal set checked="YES",checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($up2);

$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up2);

}

} else {

$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up);

}	



//header('location:unapproved_pr.php');

//header('location:return_checking.php');

echo '<span style="color:green;">Purchase Return Approved</span>';

}



?>
<script language="javascript">
function custom(theUrl)
{
  
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl+'','_self');
	//window.open('<?=$target_url?>');
}
</script>
<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="60%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#a2d9ce">
    <td align="right" ><strong>Date:</strong></td>
    <td width="1" ><strong>
      <input type="text" name="fdate" id="fdate" style="width:100px !important;" value="<? if($_POST['fdate']!='') echo $_POST['fdate']; else echo date('Y-m-01')?>" />
    </strong></td>
    <td align="center"><strong> -to- </strong></td>
    <td width="1"><strong>
      <input type="text" name="tdate" id="tdate" style="width:100px !important;" value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d')?>" />
    </strong></td>
    <td rowspan="2"><strong>
      <input type="submit" name="submitit" id="submitit" value="View Detail" class="btn1 btn1-submit-input" />
    </strong></td>
  </tr>
  <tr bgcolor="#a2d9ce">
    <td align="right"><strong><?=$title?>: </strong></td>
    <td colspan="3"><strong>
<select name="status" id="status" style="width:200px;">

<option <?=($_POST['status']=='UNCHECKED')?'selected':''?>>UNCHECKED</option>
<?php /*?><option <?=($_POST['status']=='CHECKED')?'selected':''?>>CHECKED</option><?php */?>
</select>
    </strong></td>
    </tr>
</table>

</form>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if($_POST['status']!=''&&$_POST['status']!='ALL')
$con .= 'and m.status="'.$_POST['status'].'"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and m.pr_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

  $res='select m.pr_no, m.pr_no, m.pr_date, t.return_type, d.vendor_name, us.fname, m.status 
 
 from  purchase_return_master m, purchase_return_details c,  vendor d, user_group u ,purchase_return_type t, user_activity_management us

where  m.entry_by= us.user_id and m.return_type	=t.id and m.group_for=u.id  and m.vendor_id=d.vendor_id  and m.pr_no=c.pr_no and m.status="UNCHECKED" '. $con.'  

group by c.pr_no order by m.pr_no desc';
echo link_report($res,'return_checking.php');
?>
</div></td>
</tr>
</table>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>