<?php


session_start();


//====================== EOF ===================


//var_dump($_SESSION);



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


function next_journal_journal_voucher_id($date=''){
if($date==''){
	$min = date("Ymd")."0000";
	$max = $min+10000;
}else{
	$min = date("Ymd",strtotime($date))."0000";
	$max = $min+10000;
}
	$s ="select MAX(jv_no) jv_no from journal where jv_no between '".$min."' and '".$max."'";
			$jv_no=@mysqli_fetch_row(db_query($s));
			if($jv_no[0]>$min)
				$jv=$jv_no[0]+1;
			else
				$jv=$min+1;
			return $jv;
}



if($_REQUEST['pi_no']>0)


$pi_no = $_REQUEST['pi_no'];


if(isset($_POST['approved'])){


$now = date('Y-m-d H:i:s');


$pi_date = $_POST['pi_date'];


$select = 'select * from production_floor_issue_master where pi_date="'.$pi_date.'" and warehouse_to = "'.$_GET['warehouse_to'].'" and status="UNCHECKED"';


$queryy = db_query($select); 


while($row = mysqli_fetch_object($queryy)){


$consump_amt = find_a_field('production_floor_issue_detail','sum(total_amt)','pi_no='.$row->pi_no);


$consump_rate = ($consump_amt/$row->batch_qty);


if($row->batch_type=='Foreign'){


journal_item_control($row->item_id,12,$pi_date,$row->batch_qty,0,'Production Receive',$row->pi_no,'','',$row->pi_no);


}


else {


journal_item_control($row->item_id,$_SESSION['user']['depot'],$pi_date,$row->batch_qty,0,'Production Receive',$row->pi_no,'','',$row->pi_no);


}


$q = "UPDATE `production_floor_issue_master` SET `status`='COMPLETE', approved_at='".$now."',unit_price='".$consump_rate."', total_amt='".$consump_amt."', approved_by='".$_SESSION['user']['id']."'  where pi_no=".$row->pi_no;


db_query($q);


$avg=find_a_field('journal_item','final_price','item_id = '.$row->item_id.' and final_price!=0 order by id desc');
if($avg>0){
$update='update item_info set cost_price="'.$avg.'" where item_id="'.$row->item_id.'" ';
db_query($update);
}else{

$update='update item_info set cost_price="'.$consump_rate.'" where item_id="'.$row->item_id.'" ';
db_query($update);

}

$update1='update journal_item set final_price="'.$consump_rate.'" where item_id="'.$row->item_id.'" ';
db_query($update1);

$sub_group_id=find_a_field('item_info','sub_group_id','item_id='.$row->item_id); 


$jv=next_journal_journal_voucher_id();


if($sub_group_id==500100000){ 


if($row->batch_type=='Foreign'){


$dr_ledger=find_a_field('item_info i,brand_category_info b','b.ledger_id_export','i.brand_category=b.brand_category and i.item_id='.$row->item_id);


}else{ $dr_ledger=find_a_field('item_info i,brand_category_info b','b.ledger_id_local','i.brand_category=b.brand_category and i.item_id='.$row->item_id);}


}else{


$dr_ledger=find_a_field('item_sub_group','ledger_id_2','sub_group_id='.$sub_group_id);


}




$pi_date_1 = $pi_date;


$test="INSERT INTO `journal` (`id`, `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `sub_ledger`, `cc_code`, `entry_by`, `tr_id`, `group_for`, `entry_at`) VALUES ( NULL, 'Alinfoods', '".$jv."', '".$pi_date_1."', '".$dr_ledger."', '(PI#".$row->pi_no.") sub group id-".$sub_group_id." item id-".$row->item_id."', '".$consump_amt."', '0.00', 'Production Receive', '".$row->pi_no."', '', '0', '".$_SESSION['user']['id']."', '', '2', '".date('Y-m-d H:i:s')."')";


db_query($test);


$test1="INSERT INTO `secondary_journal` (`id`, `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `sub_ledger`, `cc_code`, `entry_by`, `tr_id`, `group_for`, `entry_at`) VALUES ( NULL, 'Alinfoods', '".$jv."', '".$pi_date_1."', '".$dr_ledger."', '(PI#".$row->pi_no.") sub group id-".$sub_group_id." item id-".$row->item_id."', '".$consump_amt."', '0.00', 'Production Receive', '".$row->pi_no."', '', '0', '".$_SESSION['user']['id']."', '', '2', '".date('Y-m-d H:i:s')."')";


db_query($test1);


$cr_select="SELECT i.item_id,p.total_amt,s.ledger_id_1 FROM production_floor_issue_detail p,item_info i, item_sub_group s WHERE i.item_id=p.item_id and i.sub_group_id=s.sub_group_id AND p.pi_no=".$row->pi_no;


$qu=db_query($cr_select);


while($roww=mysqli_fetch_object($qu)){


db_query("INSERT INTO `journal` (`id`, `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `sub_ledger`, `cc_code`, `entry_by`, `tr_id`, `group_for`, `entry_at`) VALUES ( NULL, 'Alinfoods', '".$jv."', '".$pi_date_1."', '".$roww->ledger_id_1."', '(PI#".$row->pi_no.") sub group id-".$sub_group_id." item id-".$roww->item_id."', '0.00','".$roww->total_amt."',  'Production Receive', '".$row->pi_no."', '', '0', '".$_SESSION['user']['id']."', '', '2', '".date('Y-m-d H:i:s')."')");


db_query("INSERT INTO `secondary_journal` (`id`, `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, `sub_ledger`, `cc_code`, `entry_by`, `tr_id`, `group_for`, `entry_at`) VALUES ( NULL, 'Alinfoods', '".$jv."', '".$pi_date_1."', '".$roww->ledger_id_1."', '(PI#".$row->pi_no.") sub group id-".$sub_group_id." item id-".$roww->item_id."', '0.00','".$roww->total_amt."',  'Production Receive', '".$row->pi_no."', '', '0', '".$_SESSION['user']['id']."', '', '2', '".date('Y-m-d H:i:s')."')");


}


}


$sr = "<button style='background: red; color: white; border-color: green;'>UPDATED</button>";


//journal_item_control($item,12,$pi_date,$batch_qty,0,'Production Receive',$pi_no,'','',$pi_no);


}


if(isset($_POST['return'])){


$q = "UPDATE `purchase_receive` SET `pr_status`='RETURNED' where pr_no=".$_REQUEST['v_no']." ";


db_query($q);


$re = "<button style='background: red; color: white; border-color: green;'>UPDATED</button>";


}


$pi=0;


$total=0;


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">


<head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />


<title>.: Finish Goods Receive :.</title>


<link href="../../damage_mod/pages/css/invoice.css" type="text/css" rel="stylesheet"/>


<script type="text/javascript">


function hide()


{


document.getElementById("pr").style.display="none";


}


function reloadPage() {


location.reload();


}


</script>


<script type="text/javascript" src="../js/paging.js"></script>


<style type="text/css">


<!--


.style1 {font-weight: bold}


-->


</style>


</head>


<body style="font-family:Tahoma, Geneva, sans-serif"><br />


<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">


<tr>


<td><div class="header">


<table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>


<td><table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>


<td><table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>


<td>


<table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">


<tr>


<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:24px; font-weight:bold;">Aleya Food &amp; Beverage Ltd.</td>


</tr>


<tr>


<td bgcolor="#666666" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;">Finished Goods Issue Challan</td>


</tr>


</table></td>


</tr>


</table></td>


</tr>


</table></td>


</tr>


<tr>


<td><table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>


<td width="6%" valign="top">


<table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">


<tr>


<td>


<input name="button" type="button" onclick="hide();window.print();" value="Print" />				  </td>


</tr>


</table>		      </td>


<td width="94%" valign="top"><table width="79%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">


<tr>


<td width="18%" align="right" valign="middle"> PI Date</td>


<td width="82%"><table width="100%" border="1" cellspacing="0" cellpadding="3">


<tr>


<td><?=$_GET['pi_date']?>


&nbsp;</td>


</tr>


</table></td>


</tr>


</table></td>


</tr>


</table>		</td>


</tr>


</table>


</div></td>


</tr>


<tr>


<td>	</td>


</tr>


<tr>


<td>


<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5" style="margin-top: 100px;">


<tr style="font-size:13px;">


<? //echo $avg='SELECT sum(batch_qty*`unit_price`)/sum(batch_qty) as cost_price FROM `production_floor_issue_master` WHERE `item_id` = 500100317 and unit_price!=0 and status="COMPLETE"'


//db_query($avg);


$avg=find_a_field('production_floor_issue_master','sum(batch_qty*unit_price)/sum(batch_qty)','item_id = 500100317 and unit_price!=0 and status="COMPLETE"');


?>


<td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>


<td align="center" bgcolor="#CCCCCC"><div align="center"><strong>Product Name</strong></div></td>


<td align="center" bgcolor="#CCCCCC"><strong>Unit</strong></td>


<td align="center" bgcolor="#CCCCCC"><strong>Batch NO</strong>&nbsp;</td>


<td align="center" bgcolor="#CCCCCC"><strong>Batch CTN</strong>&nbsp;</td>


<td align="center" bgcolor="#CCCCCC"><strong>Batch PCS</strong>&nbsp;</td>


<td align="center" bgcolor="#CCCCCC"><strong>Batch Section</strong>&nbsp;</td>


<td align="center" bgcolor="#CCCCCC"><strong>Batch Type</strong>&nbsp;</td>


<td align="center" bgcolor="#CCCCCC"><strong>Shipment No</strong>&nbsp;</td>


</tr>


<? 


if($_GET['batch_type'] !=''){ $batch='and m.batch_type="'.$_GET['batch_type'].'"';}


if($_GET['warehouse_to']!=''){$warehouse=' and m.warehouse_to="'.$_GET['warehouse_to'].'"';}


$select = 'select i.item_name, i.unit_name,m.pi_no,m.batch_ctn,m.batch_pcs,w.warehouse_name,m.remarks,m.batch_type from production_floor_issue_master m, item_info i, warehouse w where m.warehouse_to=w.warehouse_id and  m.item_id=i.item_id and m.status="UNCHECKED" and m.pi_date="'.$_GET['pi_date'].'" '.$batch.''.$warehouse.'';


$sl = 0;


$query = db_query($select);


while($row = mysqli_fetch_object($query)){


?>


<tr style="font-size:12px; height:40px;" <?=($i%2)?'bgcolor="#F7F7F7"':'';?>>


<td align="center" valign="top"><?=++$sl?></td>


<td align="left" valign="top"><?=$row->item_name;?></td>


<td align="right" valign="top"><?=$row->unit_name?></td>


<td align="right" valign="top"><?=$row->pi_no?>&nbsp;</td>


<td align="right" valign="top"><?=$row->batch_ctn; $tctn += $row->batch_ctn;?>&nbsp;</td>


<td align="right" valign="top"><?=$row->batch_pcs; $tpcs += $row->batch_pcs;?>&nbsp;</td>


<td align="right" valign="top"><?=$row->warehouse_name;?>&nbsp;</td>


<td align="right" valign="top"><?=$row->batch_type?>&nbsp;</td>


<td align="right" valign="top"><?=$row->remarks?>&nbsp;</td>


</tr>


<? $t_batch_qty +=$row->batch_qty; } ?>


<tr style="font-size:14px;"><td colspan="4" align="center" valign="top"><div align="right"><strong>Total Amount: </strong></div></td>


<td align="right" valign="top"><span class="style1"> <?=number_format($tctn,2)?></span></td>


<td align="right" valign="top"><span class="style1"> <?=number_format($tpcs,2)?></span></td>


<td>&nbsp;</td>


<td>&nbsp;</td>


<td>&nbsp;</td>


</tr>


</table></td>


</tr>


<tr>


<td align="center">


<table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>


<td colspan="2" style="font-size:12px"><em>All goods are checked and confirmed as per Terms.</em></td>


</tr>


<tr>


<td width="50%">&nbsp;</td>


<td>&nbsp;</td>


</tr>


<tr>


<td></td>


<td><form action="" method="post">


<div id="pr">


<div align="left">


<input type="hidden" name="pi_date" value="<?=$_GET['pi_date']?>" />


<input type="submit" value="APPROVED" name="approved" style="margin-top: 20px; float: right; font-size: 15px; background: green; border: 1px solid black; color: white; padding:5px; border-radious: 5px;" />


<span style="margin-top: 24px; float: right; margin-right: 20px;"><?=$sr;?></span>


<!--<input type="submit" value="RETURN" name="return" style="margin-top: 20px; float: right;font-size: 15px; background: #9A0000; border: 1px solid black; color: white; padding:5px; border-radious: 5px;"><span style="margin-top: 24px; float: right; margin-right: 20px;"> <?=$re;?></span>-->


</div>


</div>


</form></td>


</tr>


<tr>


<td>&nbsp;</td>


<td>&nbsp;</td>


</tr>


<tr>


<td>&nbsp;</td>


<td>&nbsp;</td>


</tr>


<tr>


<td colspan="2" align="center"><strong><br />


</strong>


<table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>


<td>


<div align="center">


<!--   <?


if($pr_status=='UNCHECKED' || $pr_status=='APPROVED' || $pr_status=='CHECKED') echo '<img src="sign/manager store.jpg"  style="width: 170px;">';


?>-->


<br />


------------------------<br />


Issued By</div></td>


<td>


<div align="center">


<!--   <?


if($pr_status=='UNCHECKED' || $pr_status=='APPROVED' || $pr_status=='CHECKED') echo '<img src="sign/manager store.jpg"  style="width: 170px;">';


?>-->


<br />


------------------------<br />


Checked By</div></td>


<td><div align="center">


<!--<?


if($pr_status=='APPROVED' || $pr_status=='CHECKED' ) {


echo '<img src="sign/QC.jpg"  style="width: 170px;">';


}  else{ echo '<br><br><br><br><br>' ;};


?>-->


<br />


------------------------<br />Received By</div></td>


<td><div align="center">


<!-- <?


if($pr_status=='CHECKED') {echo '<img src="sign/AGM factory.jpg"  style="width: 170px;">';} else{ echo '<br><br><br><br><br>' ;};


?>-->


<br />


------------------------<br />Approved by </div></td>


</tr>


</table></td>


</tr>


</table>


<div class="footer1"> </div>


</td>


</tr>


</table>


</body>


</html>





