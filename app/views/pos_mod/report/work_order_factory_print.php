<?
session_start();
require "../../common/check.php";
require "../../config/db_connect.php";

require "../../common/my.php";
date_default_timezone_set('Asia/Dhaka');

$res='select a.id,b.item_name,a.style_no,a.specification,a.meassurment,a.qty,(select sum(qty) from lc_workorder_chalan where a.id=specification_id) as chalan_qty, (select a.qty-sum(qty) from lc_workorder_chalan where a.id=specification_id) as balance_qty from lc_workorder_details a,lc_product_item b where b.id=a.item_id and a.wo_id='.$_REQUEST["wo_id"];
$wo=find_all_field('lc_workorder','1','id='.$_REQUEST["wo_id"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report_print.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>
</head>
<body>
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">



  <p>
  <?
		$str 	.= '<div class="header">
		<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>';
		$str 	.= '<td><img src="../../pic/logu.jpg" width="50" height="60" /> </td>';		
		if($wo->for=='TT')
		{ 
		$str 	.= '<td><h1>TOTAL TRIMS</h1>';
		$str 	.= '<div>Office: House# 502(1st Floor), Road# 9(East Side), DOHS Baridhara, Dhaka-1206, <br>Tel: 88-02-8413370, 8413371</div>Work Order No: '.$_REQUEST["wo_id"];
		}
		else
		{
		$str 	.= '<td><h1>NETRAKONA ACCESSORIES LTD.</h1>';
		$str 	.= '<div>Office: House# 502(1st Floor), Road# 9(East Side), DOHS Baridhara, Dhaka-1206, <br>Tel: 88-02-8413370, 8413371</div>Work Order No: '.$_REQUEST["wo_id"];
		}
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		
		$str 	.= '</td></tr></table>';
		if(isset($to_date)) 
		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';
		$str 	.= '</div>';
		$str 	.= '<div class="left">';
		if(isset($project_name)) 
		$str 	.= '<p>Project Name: '.$project_name.'</p><span style="font-size:16px; text-align:center"></span>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		if(isset($client_name)) 
		$str 	.= '<p>Client Name: '.$client_name.'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';


?>
   <br /> <br /> <?=$str?><br />  
  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="10%" height="20"><strong>Date </strong></td>
      <td width="4%">:</td>
      <td><?=$wo->wo_date?>&nbsp;</td>
    </tr>
    <tr>
      <td height="20"><strong>To </strong></td>
      <td>:</td>
      <td>NETRAKONA ACCESSORIES LTD.</td>
    </tr>
    <tr>
      <td height="20"><strong>Attn</strong></td>
      <td>:</td>
      <td><strong>MR. NAZRUL ISLAM (GM)</strong></td>
    </tr>
    <tr>
      <td height="20"><strong>From</strong></td>
      <td>:</td>
      <td><?=find_a_field('user_activity_management','fname','user_id='.$wo->prepared_by)?>&nbsp;</td>
    </tr>
    <tr>
      <td height="20"><strong>Party Name</strong></td>
      <td>:</td>
      <td><?=find_a_field('lc_buyer','buyer_name','id='.$wo->buyer_id)?>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="20"><strong>Subject</strong></td>
      <td>:</td>
      <td><?='Work Order for '.$wo->wo_subject?></td>
    </tr>
    <tr>
      <td height="20"><strong>Thickness:</strong></td>
      <td>:</td>
      <td><?=$wo->thickness?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="20"><strong>Detail</strong></td>
      <td>:</td>
      <td><?=$wo->wo_detail?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" align="center">
      <div class="tabledesign">
        <? 
//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';
echo link_report_single($res);
		?>

      </div>
      &nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><div class="tabledesign">
        <p>&nbsp;</p>
        <p>&nbsp;</p></div></td>
    </tr>
  </table>
<p></div>
</body>
</html>