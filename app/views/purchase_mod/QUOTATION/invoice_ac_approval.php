<?php 
//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";

require_once "../../../controllers/routing/print_view.top.php";

$invoice_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

//$invoice_no = $_REQUEST['invoice_no'];

$count_sum = find_a_field('purchase_quotation_details','sum(count_type)','invoice_no='.$invoice_no);

if(isset($_POST['cash_discount'])){
    $po_no = $_POST['po_no'];
    $cash_discount = $_POST['cash_discount'];
    $ssql='update purchase_sp_master set cash_discount="'.$_POST['cash_discount'].'" where po_no="'.$po_no.'"';
    db_query($ssql);
}

if(isset($_POST['note_add'])){
    $update_quotation='UPDATE purchase_quotation_master SET status = "UNCHECKED", add_note = "'.$_POST['additional_note'].'" WHERE invoice_no='.$invoice_no;
    db_query($update_quotation);
}

if(isset($_POST['return'])){
    $return_quotation='UPDATE purchase_quotation_master SET status = "MANUAL" WHERE invoice_no='.$invoice_no;
    db_query($return_quotation);
}

$sql_ms="select * from purchase_quotation_master where invoice_no='$invoice_no'";
$ms_data=mysqli_fetch_object(db_query($sql_ms));

$company=find_all_field('user_group','','id='.$ms_data->group_for);
$whouse=find_all_field('warehouse','','warehouse_id='.$ms_data->warehouse_id);
$vendor=find_all_field('vendor','','vendor_id='.$ms_data->vendor_id);

// Barcode Variables
$req_bar_no = $ms_data->view_invoice_no;
$barcode_content = $req_bar_no;
$barcodeText = $barcode_content;
$barcodeType='code128';
$barcodeDisplay='horizontal';
$barcodeSize=40;
$printText='';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Purchase Quotation View</title>
<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php"); ?>
<style>
.left .left-text, .right .right-text {
    font-weight: bold;
    margin: 0px;
    padding: 2px;
    border: none !important;
}
.left .new-div, .right .new-div {
    border: 1px solid black;
    min-height: 115px;
    margin-top: 25px;
    padding: 5px;
}
.right .new-div {
    min-height: 138px;
}
.footer1 {
    page-break-inside: avoid; 
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
@media print {
    #pr { display: none; }
}

/* Table General Style */
.tabledesign1 {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Arial', sans-serif;
    font-size: 14px;
    margin: 20px 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}


.qrl-text
 {

    letter-spacing: 3px !important;
}


/* Table Header */
.tabledesign1 th {
    background-color: #4CAF50;
    color: white;
    padding: 10px 8px;
    text-align: left;
    border-bottom: 2px solid #ddd;
    border: 1px solid #000 !important;
}

/* Table Rows */
.tabledesign1 td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
    border: 1px solid #000 !important;
}

/* Alternate Row Colors */
.tabledesign1 tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Hover Effect */
.tabledesign1 tr:hover {
    background-color: #f1f1f1;
}

/* Total Row Style */
.tabledesign1 tr:last-child td {
    font-weight: bold;
    background-color: #e0e0e0;
}

/* Right Align Numeric Data */
.tabledesign1 td:nth-child(8),
.tabledesign1 td:nth-child(9),
.tabledesign1 td:nth-child(10),
.tabledesign1 td:nth-child(12),
.tabledesign1 td:nth-child(13) {
    text-align: right;
}

@media print {
    body { -webkit-print-color-adjust: exact; }
    .tabledesign1 th, .tabledesign1 td { border: 1px solid #000 !important; }
    .tabledesign1 { box-shadow: none; }
}.no-wrap {
        white-space: nowrap;
    }
    



</style>
</head>
<body>

<div class="body" id="printContent">
    <!-- Header -->
    <div class="header">
        <table class="table1" width="100%">
            <tr>
                <td class="logo">
                    <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
                </td>
                <td class="titel">
                    <h2 class="text-titel"><?=$company->group_name?></h2>          
                    <p class="text"><?=$company->address?></p>
                    <p class="text">Cell: <?=$company->mobile?>. Email: <?=$company->email?><br><?=$company->vat_reg?></p>
                </td>
                <?php /*?><td class="Qrl_code">
                    <img class="barcode Qrl_code_barcode" alt="<?=$barcodeText?>" src="barcode.php?text=<?=$barcodeText?>&codetype=<?=$barcodeType?>&orientation=<?=$barcodeDisplay?>&size=<?=$barcodeSize?>&print=<?=$printText?>"/>
                    <p class="qrl-text"><?=$ms_data->view_invoice_no?></p>
                </td><?php */?>
				
				<td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($invoice_no); 
			  $tr_from = url_encode($tr_from); 
              $print_url = "https://saaserp.ezzy-erp.com/app/views/purchase_mod/QUOTATION/invoice_ac_approval.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data). "&tr_from=" . rawurlencode($tr_from);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px;">
            </td>
            </tr>
        </table>
    </div>

    <!-- Quotation Info -->
    <div class="header-one">
        <hr class="hr"/>
        <h5 class="report-titel">RATE COLLECTION / PURCHASE QUOTATION</h5>
        <br>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 left">
                <p class="left-text">Vendor Name: <span><?=$vendor->vendor_name?></span></p>
                <p class="left-text">Address: <span> <?php if (!empty($vendor->address)) {echo $vendor->address;} else {echo "N/A";}?></span></p>

                <p class="left-text">Currency: <span><?=$ms_data->currency_type?></span></p>
                <p class="left-text">Requisition Remarks: <span><?=find_a_field('requisition_master','req_note','req_no='.$ms_data->view_req_no);?></span></p>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 right">
                <p class="right-text">Quote No: <span><?=$ms_data->view_invoice_no?></span></p>
                <p class="right-text">Quote Date: <span><?=date("d-m-Y",strtotime($ms_data->invoice_date));?></span></p>
				
                <?php /*?><p class="right-text">REQ No: <span><a href="../../warehouse_mod/mr/mr_print_view.php?req_no=<?=$ms_data->view_req_no;?>" target="_blank"><?=$ms_data->view_req_no?></a></span></p><?php */?>
				
				
				<p class="right-text">REQ No: <span><a href="../../warehouse_mod/mr/mr_print_view.php?c=<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($ms_data->view_req_no));?>" target="_blank"><?=$ms_data->view_req_no?></a></span></p>
				
                <p class="right-text">Reference No: <span><?=$ms_data->ref?></span></p>
                <p class="right-text">Attachment: <span><a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$ms_data->file_upload?>&folder=maintain_quotation&proj_id=<?=$_SESSION['proj_id']?>" target="_blank">View Attachment</a></span></p>
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <div id="pr">
        <input name="button" type="button" onClick="hide();window.print();" value="Print" />
    </div>

    <!-- Item Table -->
   <table class="tabledesign1">
    <tr>
        <th width="3%">SL</th>
        <th width="9%">Category</th>
        <th width="8%">Item Name</th>
        <th width="8%">Specification</th>
        <th width="15%">Product Specification</th>
        <th width="6%">Remarks</th>
        <th width="4%">Unit</th>
        <th width="6%">REQ Qty</th>
        <th width="10%">Each Price (<?=$ms_data->currency_type?>)</th>
        <th width="5%">Value</th>
        <th width="12%">Last Purchase Date</th>
        <th width="4%">Rate</th>
        <th width="3%">Qty</th>
        <th width="7%">Vendor</th>
    </tr>
    <?php
    $pi=0;
    $totQty=0;
    $totalAmount=0;
    $sql3="select a.*, s.sub_group_name, i.sub_group_id, i.item_name, i.finish_goods_code from purchase_quotation_details a, item_info i, item_sub_group s where a.item_id=i.item_id and i.sub_group_id=s.sub_group_id and a.invoice_no='".$invoice_no."' order by i.sub_group_id, i.item_name";
    $data3=db_query($sql3);

    $sql = "select id, po_no, po_date, rate, qty, vendor_id,item_id from purchase_invoice where 1 group by item_id order by id desc";
    $query = db_query($sql);
    while($info=mysqli_fetch_object($query)){
        $invoice_datess[$info->item_id]=$info->po_date;
        $unit_price[$info->item_id]=$info->rate;
        $total_unit[$info->item_id]=$info->qty;
        $vendor_id[$info->item_id]=$info->vendor_id;
    }
    $sql = "select vendor_id, vendor_name from vendor where 1 group by vendor_id";
    $query = db_query($sql);
    while($info=mysqli_fetch_object($query)){
        $vendor_name[$info->vendor_id]=$info->vendor_name;
    }

    while($info2=mysqli_fetch_object($data3)){
        $pi++;
        $sl=$pi;
    ?>
    <tr>
        <td><?=$sl?></td>
        <td style="text-align:center"><?=$info2->sub_group_name;?></td>
        <td><?=$info2->item_name;?></td>
        <td><?=find_a_field('requisition_order','specification','item_id="'.$info2->item_id.'" and req_no="'.$info2->req_no.'"');?></td>
        <td style="text-align:center"><?=$info2->vendor_specification;?></td>
        <td><?=$info2->remarks;?></td>
        <td style="text-align:center"><?=$info2->unit_name;?></td>
        <td style="text-align:right"><?=number_format($info2->req_qty,2); $totQty+=$info2->req_qty;?></td>
        <td style="text-align:right"><?=number_format($info2->unit_price,2);?></td>
        <td style="text-align:right"><?=number_format($info2->req_qty * $info2->unit_price, 2); $totalAmount += $info2->req_qty * $info2->unit_price;?></td>
        <td style="text-align:center"><?=($invoice_datess[$info2->item_id]!='')?date("d-M-y",strtotime($invoice_datess[$info2->item_id])):'';?></td>
        <td style="text-align:right"><?= number_format($unit_price[$info2->item_id], 2);?></td>
        <td style="text-align:right"> <?= number_format($unit_price[$info2->item_id], 2); ?></td>
        <td style="text-align:center"><?= $vendor_name[$vendor_id[$info2->item_id]]?></td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="7" style="text-align:right;"><strong>Total :</strong></td>
        <td style="text-align:right"><strong>
          <?=number_format($totQty,2)?>
        </strong></td>
        <td></td>
        <td style="text-align:right"><strong><?=number_format($totalAmount,2)?></strong></td>
        <td colspan="4"></td>
    </tr>
</table>

    <!-- Terms and Conditions -->
    <h4>Terms and Condition</h4>
    <?=$ms_data->terms_condition;?>

    <!-- Additional Note Form -->
    <form action="" method="post" name="codz" id="codz">
    <table style="width:100%; border-collapse:separate; border-spacing:3px 3px;">
        <tr>
            <td style="width:20%; white-space:nowrap;">
                Additional Specification / Note:
            </td>
            <td style="width:50%;">
                <input type="text" name="additional_note" required 
                       style="width:100%; height:32px;"/>
            </td>
            <td style="width:15%;">
                <button type="submit" name="note_add" 
                        style="width:100%; height:32px; background-color:#28a745; color:#fff; border:none; cursor:pointer;">
                    ADD
                </button>
            </td>
            <td style="width:15%;">
                <button type="submit" name="return" formnovalidate
                        style="width:100%; height:32px; background-color:#dc3545; color:#fff; border:none; cursor:pointer;">
                    Return
                </button>
            </td>
        </tr>
    </table>
</form>


</div>

<script>
function hide(){ document.getElementById("pr").style.display="none"; }
</script>

</body>
</html>
