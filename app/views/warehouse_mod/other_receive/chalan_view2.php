<?php
require_once "../../../controllers/routing/print_view.top.php";

$or_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

$barcode_content = $or_no;
$barcodeText = $barcode_content;
$barcodeType='code128';
$barcodeDisplay='horizontal';
$barcodeSize=40;
$printText='';


$datas=find_all_field('warehouse_other_receive','s','or_no='.$or_no);

$sql111="select b.* from warehouse_other_receive b where b.or_no = '".$or_no."'";
$data111=db_query($sql111);
$data=mysqli_fetch_object($data111);

$group = find_all_field('user_group','','id='.$datas->group_for);

$rec_frm=$data->vendor_name;
$requisition_from=$data->requisition_from;
$or_date=$data->or_date;
$entry_by = $datas->entry_by;

$sql1="select b.* from warehouse_other_receive_detail b where b.or_no = '".$or_no."'";
$data1=db_query($sql1);

$pi=0; $total=0;
while($info=mysqli_fetch_object($data1)){ 
    $pi++;
    $order_no[]=$info->order_no;
    $qc_by=$info->qc_by;
    $item_id[] = $info->item_id;
    $rate[] = $info->rate;
    $amount[] = $info->amount;
    $unit_qty[] = $info->qty;
    $unit_name[] = $info->unit_name;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Local Purchase Receive</title>
<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
<style>
#pr input[type="button"] {
    width: 80px;
    height: 28px;
    background-color: #6cff36;
    color: #333;
    font-weight: bold;
    border-radius: 5px;
    border: 1px solid #333;
    cursor: pointer;
}
</style>
<script>
function hide(){
    document.getElementById("pr").style.display="none";
}
</script>
</head>

<body style="font-family:Tahoma, Geneva, sans-serif">
<div class="body" id="printContent">

<div id="pr" style="text-align:center; margin-bottom:10px;">
    <input name="button" type="button" onClick="hide();window.print();" value="Print" />
</div>

<table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
  <tr>
    <td>
	<div class="header">
		<table class="table1">
		<tr>
		<td class="logo">
			<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
		</td>
		<td class="titel">
				<h2 class="text-titel"><?=$group->group_name?></h2>			
				<p class="text"><?=$group->address?></p>
				<p class="text">Cell: <?=$group->mobile?>. Email: <?=$group->email?> <br> <?=$group->vat_reg?></p>
		</td>
		<?php /*?><td class="Qrl_code">
			<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			<p class="qrl-text"><?php echo $or_no;?></p>
		</td><?php */?>
		
		<td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($or_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/other_receive/chalan_view2.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
		</tr>
		</table>
	</div>

	<hr/>
	<h4 class="report-titel" style="text-align:center; margin:10px 0;"><u>LOCAL PURCHASE RECEIVE</u></h4>

	<table style="width:100%;" border="0" cellpadding="5" cellspacing="0">
	  <tr>
	    <td style="width:50%; vertical-align:top;">
	      <p><strong>Purchase From:</strong> <?=$rec_frm?></p>
	      <p><strong>Requisition From:</strong> <?=$requisition_from?></p>
	      <p><strong>LP Posting Information:</strong> <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?> / <?=$data->entry_at?></p>
	      <p><strong>LP Note:</strong> <?=$data->or_subject?></p>
	    </td>
	    <td style="width:50%; vertical-align:top; padding-left: 310px !important;">
	      <p><strong>LP No:</strong> <?=$or_no?></p>
	      <p><strong>LP Date:</strong> <?=date("d M, Y",strtotime($or_date))?></p>
	      <p><strong>QC By:</strong> <?=$data->qc_by?></p>
	      <p><strong>Chalan No:</strong> <?=$data->chalan_no?></p>
	    </td>
	  </tr>
	</table>
	</td>
  </tr>

  <tr>
    <td>
	<table class="table1" border="1" cellpadding="5" cellspacing="0" style="width:100%; margin-top:15px;">
       <thead>
         <tr>
           <th>SL</th>
           <th>Code</th>
           <th>Product Name</th>
           <th>Unit</th>
           <th>Rate</th>
           <th>Rec Qty</th>
           <th>Amount</th>
         </tr>
       </thead>
       <tbody>
<?php for($i=0;$i<$pi;$i++){ ?>
<tr>
  <td style="text-align:center;"><?=$i+1?></td>
  <td><?=$item_id[$i]?></td>
  <td><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
  <td style="text-align:center;"><?=$unit_name[$i]?></td>
  <td style="text-align:right;"><?=number_format($rate[$i],2)?></td>
  <td style="text-align:right;"><?=number_format($unit_qty[$i],2)?></td>
  <td style="text-align:right;"><?=number_format($amount[$i],2); $t_amount+=$amount[$i];?></td>
</tr>
<?php } ?>
<tr>
  <td colspan="6" style="text-align:right; font-weight:bold;">Total Amount:</td>
  <td style="text-align:right; font-weight:bold;"><?=number_format($t_amount,2)?></td>
</tr>
       </tbody>
    </table>
    </td>
  </tr>

  <tr>
    <td>
	<p style="font-size:12px; margin-top:20px;"><em>All goods are received in good condition as per Terms</em></p>
	<br/><br/><br/>
	<table style="width:100%; text-align:center;">
	  <tr>
	    <td><?=find_a_field('user_activity_management','fname','user_id="'.$entry_by.'"');?></td>
	    <td><?=$datas->qc_by?></td>
	    <td><?=$datas->approved_by?></td>
	  </tr>
	  <tr>
	    <td>--------------------</td>
	    <td>--------------------</td>
	    <td>--------------------</td>
	  </tr>
	  <tr>
	    <td>Prepared By</td>
	    <td>QC By</td>
	    <td>Store Incharge</td>
	  </tr>
	</table>
    </td>
  </tr>

</table>
</div>
</body>
</html>
<?php
$page_name="PO Print View";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>
