<?php
session_start();
require_once "../../../controllers/routing/print_view.top.php";

$or_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

$barcode_content = $or_no;
$barcodeText = $barcode_content;
$barcodeType='code128';
$barcodeDisplay='horizontal';
$barcodeSize=40;
$printText='';

$datas = find_all_field('warehouse_other_receive','s','or_no='.$or_no);
$group = find_all_field('user_group','','id='.$datas->group_for);

// Get main OR info
$sql1="select * from warehouse_other_receive where or_no = '".$or_no."'";
$data1=db_query($sql1);
while($info=mysqli_fetch_object($data1)){ 
    $rec_frm = $info->vendor_name;
    $requisition_from = $info->requisition_from;
    $or_subject = $info->or_subject;
    $or_date = $info->or_date;
}

// Get OR detail info
$sql2="select * from warehouse_other_receive_detail where or_no = '".$or_no."'";
$data2=db_query($sql2);

$pi=0;
$total_amount=0;
$item_id = [];
$unit_qty = [];
$unit_name = [];
$rate = [];
$amount = [];

while($info=mysqli_fetch_object($data2)){ 
    $pi++;
    $item_id[] = $info->item_id;
    $unit_qty[] = $info->qty;
    $unit_name[] = $info->unit_name;
    $rate[] = $info->rate;
    $amount[] = $info->amount;
    $total_amount += $info->amount;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Other Receive Report</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
<style>
.left .left-text, .right .right-text {
    font-weight: bold;
    margin: 0;
    padding: 2px;
    border: none !important;
}
.left .new-div, .right .new-div {
    border: 1px solid black;
    min-height: 100px;
    margin-top: 15px;
    padding:5px;
}
.footer1 {
    page-break-inside: avoid; 
	margin-top: 100px !important;
}
.footer1 table {
    width: 100%;
    text-align: center;
    border-collapse: collapse;
}
.footer1 td {
    vertical-align: bottom;
    padding-top: 5px; 
}
th span {
    font-size: 12px;
    color: #333;
}
.table1, .tabledesign {
    width: 100%;
    border-collapse: collapse;
	
}
.tabledesign th, .tabledesign td {
    border: 1px solid #000;
    padding: 5px;
    font-size: 12px;
	font-size:14px !important;
}

.tabledesign {
    width: 100%;
    border-collapse: collapse;
    font-size: 16px; /* Increased font size */
    margin-top: 15px;
}
.tabledesign th, .tabledesign td {
    border: 1px solid #000;
    padding: 10px;
    text-align: center; /* Center all text */
    vertical-align: middle;
}
.tabledesign th {
    background-color: #e3e3e3;
    font-weight: bold;
}
.tabledesign tr:nth-child(even) {
    background-color: #f2f2f2; /* Alternating row color */
}

.total-row td {
    font-weight: bold;
}

.total-row td:first-child {
    text-align: right;
    font-weight: bold;
}



.report-titel {
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); 
    color: #fff;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    padding: 4px 25px;
    margin: 15px auto; 
    display: inline-block; 
    border-radius: 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); 
    letter-spacing: 1px;
    text-transform: uppercase;
	margin-left: 460px !important;
}


@media print {
    .report-titel {
       margin-left: 360px !important;
    }
}

</style>
<script type="text/javascript">
function hide() {
    document.getElementById("pr").style.display="none";
}
</script>
</head>
<body>

<div class="body" id="printContent">

<table border="0" cellpadding="2" cellspacing="0" width="100%">
    <thead>
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
                                <p class="text">Cell: <?=$group->mobile?>. Email: <?=$group->email?></p>
                            </td>
                            <?php /*?><td class="Qrl_code">
                                <img class="barcode Qrl_code_barcode" alt="<?=$barcodeText?>" 
                                src="barcode.php?text=<?=$barcodeText?>&codetype=<?=$barcodeType?>&orientation=<?=$barcodeDisplay?>&size=<?=$barcodeSize?>&print=<?=$printText?>"/>
                                <p class="qrl-text"><?=$or_no?></p>
                            </td><?php */?>
							
							
							<td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($or_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/other_receive/or_receive_report.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <hr class="hr"/>
                <h5 class="report-titel"><?=$datas->receive_type;?> Report</h5>
					<br>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 left">
                        <p class="left-text">Receive From: <span><?=$rec_frm?></span></p>
                        <p class="left-text">Requisition From: <span><?=$requisition_from?></span></p>
                        <p class="left-text">Note: <span><?=$or_subject?></span></p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 right" style="padding-left: 297px !important;">
                        <p class="right-text">OR No: <span><?=$or_no?></span></p>
                        <p class="right-text">OR Date: <span><?=date("d M, Y",strtotime($or_date))?></span></p>
                        <p class="right-text">Slip No: <span><?=$or_subject?></span></p>
                    </div>
                </div>

                <div id="pr">
                    <p>
                        <input name="button" type="button" onClick="hide();window.print();" value="Print" />
                    </p>
                </div>

                <table class="tabledesign">
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
        <?php for($i=0;$i<$pi;$i++){ 
            $fg_code = find_a_field('item_info','finish_goods_code','item_id='.$item_id[$i]);
        ?>
        <tr>
            <td><?=$i+1?></td>
            <td><?=$fg_code > 0 ? $fg_code : $item_id[$i]?></td>
            <td style="text-align:left"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i])?></td>
            <td><?=$unit_name[$i]?></td>
            <td style="text-align:right"><?=number_format($rate[$i],2)?></td>
            <td style="text-align:right"><?=number_format($unit_qty[$i],2)?></td>
            <td style="text-align:right"><?=number_format($amount[$i],2)?></td>
        </tr>
        <?php } ?>
        <tr class="total-row">
            <td height="40" colspan="6"> Total Amount:</td>
            <td style="text-align:right"><?=number_format($total_amount,2)?></td>
        </tr>
    </tbody>
</table>

                <i> <p class="p-text" style="margin-top:20px;">
                    All goods are received in a good condition as per Terms.
                </p> </i>

   <div class="footer1">
  <table class="table1" style="width:100%; margin-top:30px; border: none;">
    <tr>
      <td align="center" style="border: none !important; padding: 20px 0;">
        <div style="border-top: 1px solid #000; width: 50%; margin: 0 auto;"></div>
        <p style="margin-top:5px;">Received By</p>
      </td>
      <td align="center" style="border: none !important; padding: 20px 0;">
        <div style="border-top: 1px solid #000; width: 50%; margin: 0 auto;"></div>
        <p style="margin-top:5px;">Quality Controller</p>
      </td>
      <td align="center" style="border: none !important; padding: 20px 0;">
        <div style="border-top: 1px solid #000; width: 50%; margin: 0 auto;"></div>
        <p style="margin-top:5px;">Store Incharge</p>
      </td>
    </tr>
  </table>
</div>


            </td>
        </tr>
    </tbody>
</table>

</div>

<?php
$page_name="Other Receive Report Print View";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>
