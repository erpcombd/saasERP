<?php
session_start();
require_once "../../../controllers/routing/print_view.top.php";

//$qc_no = url_decode(str_replace(' ', '+', $_REQUEST['qc_no']));

$qc_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));


$datas = find_all_field('qc_receive_purchase', '', 'qc_no='.$qc_no);

$sql1 = "select b.* from qc_receive_purchase b where b.qc_no = '".$qc_no."'";
$data1 = db_query($sql1);

$ssql   = 'select a.* from vendor a, purchase_master b where a.vendor_id=b.vendor_id and b.po_no='.$po_no;
$dealer = find_all_field_sql($ssql);


$group_data = find_all_field('user_group','*','id='.$datas->group_for);

$pi = 0;
$total = 0;

while($info = mysqli_fetch_object($data1)){ 
    $pi++;
    $rec_date   = $info->rec_date;
    $rec_no     = $info->rec_no;
    $po_no      = $info->po_no;
    $po_date    = find_a_field('purchase_master','po_date','po_no='.$po_no);
    $order_no[] = $info->order_no;
    $ch_no      = $info->ch_no;
    $warehouse_id = $info->warehouse_id;
    $qc_by      = $info->qc_by;
    $qc_by_name = find_a_field('user_activity_management','fname','user_id='.$qc_by);
    $mobile     = find_a_field('user_activity_management','mobile','user_id='.$qc_by);
    $entry_at   = $info->entry_at;
    $entry_by   = $info->entry_by;
    $item_id[]  = $info->item_id;
    $rate[]     = $info->rate;
    $amount[]   = $info->amount;
    $unit_qty[] = $info->qty;
    $damage_qty[] = $info->damage_qty;
    $unit_name[] = $info->unit_name;
}



$barcode_content = $qc_no;
$barcodeText     = $barcode_content;
$barcodeType     = 'code128';
$barcodeDisplay  = 'horizontal';
$barcodeSize     = 40;
$printText       = '';
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>QC Inspection Note</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
    <script type="text/javascript">
        function hide(){ document.getElementById("pr").style.display="none"; }
    </script>
</head>

<style>


.footer1{
	margin-top: 70px !important;
}
</style>


<body>
<div class="body">
    <!-- ===== HEADER START ===== -->
    <div class="header">
        <table class="table1">
            <tr>
                <td class="logo">
                    <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
                </td>
                <td class="titel">
                    <h2 class="text-titel"><?=$group_data->group_name?></h2>
                    <p class="text"><?=$group_data->address?></p>
                    <p class="text">Cell: <?=$group_data->mobile?>, Email: <?=$group_data->email?><br><?=$group_data->vat_reg?></p>
                </td>
                <?php /*?><td class="Qrl_code">
                    <?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
                    <p class="qrl-text">QC No : <?=$qc_no?></p>
                </td><?php */?>
				
				<td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($qc_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/qc_inspection/chalan_view2.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
            </tr>
        </table>
    </div>
    <!-- ===== HEADER END ===== -->

    <div class="header-one">
        <hr class="hr">
        <h5 class="report-titel">PURCHASED MATERIALS QC INSPECTION NOTE</h5>
        <br>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 left">
                <p class="left-text">QC Rec No : <span><?=$rec_no?></span></p>
                <p class="left-text">PO No : <span><?=$po_no?></span></p>
                <p class="left-text">PO Date : <span><?=$po_date?></span></p>
                <p class="left-text">Rec Date : <span><?=$rec_date?></span></p>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 right">
                <p class="right-text">Supplier : <span><?=$dealer->vendor_name?></span></p>
                <p class="right-text">Address: <span><?php if (!empty($dealer->address)) {echo $dealer->address;} else {echo 'N/A';}?></span></p>

                <p class="right-text">Mobile: <span><?php if (!empty($dealer->contact_no)) {echo $dealer->contact_no;} else {echo 'N/A';}?></span></p>

                <p class="right-text">Warehouse : <span><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);?></span></p>
            </div>
        </div>
    </div>

    <!-- ===== PRINT BUTTON ===== -->
    <div id="pr" class="mt-2 mb-2">
        <div align="left">
            <input name="button" type="button" onClick="hide();window.print();" value="Print">
        </div>
    </div>
    <!-- ===== ITEM TABLE ===== -->
    <br>
    <table class="table1">
        <thead>
            <tr>
                <th>SL</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>UOM</th>
                <th>Fresh Rec Qty</th>
                <th>Damage Rec Qty</th>
            </tr>
        </thead>
        <tbody>
            <? for($i=0;$i<$pi;$i++){ ?>
            <tr>
                <td align="center"><?=$i+1?></td>
                <td align="center"><?=$item_id[$i]?></td>
                <td align="left"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
                <td align="center"><?=$unit_name[$i]?></td>
                <td align="right"><?= number_format($unit_qty[$i], 2) ?></td>
                <td align="right"><?=number_format($damage_qty[$i],2)?></td>
            </tr>
            <? } ?>
        </tbody>
    </table>

    <!-- ===== FOOTER ===== -->
    <div class="footer1">
        <table class="footer-table">
            <tr><td colspan="4">&nbsp;</td></tr>
            <tr>
                <td class="text-center w-25">
                    <p style="font-weight:600; margin:0;"><?=$qc_by_name?></p>
                    <p style="font-size:11px; margin:0;">(Quality Controller)<br><?=$entry_at?></p>
                </td>
                <td class="text-center w-25">&nbsp;</td>
                <td class="text-center w-25">&nbsp;</td>
                <td class="text-center w-25">
                    <p style="font-weight:600; margin:0;"><?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?></p>
                    <p style="font-size:11px; margin:0;">(Entry By)<br><?=$entry_at?></p>
                </td>
            </tr>
            <tr>
                <td class="text-center">-------------------------------</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">-------------------------------</td>
            </tr>
            <tr>
                <td class="text-center"><strong>Quality Controller</strong></td>
                <td class="text-center"><strong></strong></td>
                <td class="text-center"><strong></strong></td>
                <td class="text-center"><strong>Prepared By</strong></td>
            </tr>
        </table>
        <?php include("../../../assets/template/report_print_buttom_content.php");?>
    </div>
</div>
</body>
</html>

<?php
$page_name="Purchased Materials QC Inspection Note";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>
