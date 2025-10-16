<?php
session_start();
require_once "../../../controllers/routing/print_view.top.php";

$oi_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

$barcode_content = $oi_no;
$barcodeText = $barcode_content;
$barcodeType = 'code128';
$barcodeDisplay = 'horizontal';
$barcodeSize = 40;
$printText = '';

$datas = find_all_field('warehouse_other_issue','s','oi_no='.$oi_no);
$group = find_all_field('user_group','','id='.$datas->group_for);

$sql1="select * from warehouse_other_issue where oi_no='".$oi_no."'";
$data1=db_query($sql1);
while($info=mysqli_fetch_object($data1)){ 
    $issued_to = $info->issued_to;
    $oi_details = $info->oi_details;
    $oi_subject = $info->oi_subject;
    $entry_by = $info->entry_by;
    $entry_at = $info->entry_at;
    $issue_type = $info->issue_type;
    $oi_date = $info->oi_date;
    $requisition_from = $info->requisition_from;
}

$sql1="select * from warehouse_other_issue_detail where oi_no='".$oi_no."'";
$data1=db_query($sql1);

$pi=0;
while($info=mysqli_fetch_object($data1)){ 
    $pi++;
    $item_id[] = $info->item_id;
    $unit_qty[] = $info->qty;
    $unit_name[] = $info->unit_name;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Other Issue Report</title>
<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
<style>

.header .logo-img { 
	max-height: 60px; 
}
.header { 
	border-bottom: 2px solid #000;
 	padding-bottom: 10px;
	margin-bottom: 10px; 
}
.text-titel { 
	font-size: 20px; 
	font-weight: bold; 
	margin: 0; }
.qrl-text { 
	font-size: 12px; 
	text-align: center; 
	margin-top: 5px; 
	margin-left: 71px !important; 
	}
.report-titel { 
	text-align: center; 
	font-size: 18px; 
	font-weight: bold; 
	margin: 15px 0;
	padding: 10px !important;
    background-color: black !important;
    color: white;
 }
 
.info-table td { 
	padding: 5px; 
	font-size: 13px; 
	vertical-align: top; 
	}
	
.table-design { 
	width: 100%; 
	border-collapse: collapse; 
	margin-top: 10px; 
	}
	
.table-design th, .table-design td { 
	border: 1px solid #000; 
	padding: 5px; 
	text-align: center; 
	}
	
.table-design th { 
	background: #f0f0f0; 
}
.signature-table td { 
	padding: 40px 20px 5px; 
	text-align: center; 
	}
.footer1 { 
	margin-top: 30px; 
	text-align: left; 
	font-size: 11px; 
	}

/* Print Button Styles */
#print-btn {
    padding: 6px 15px;
    border: 1px solid #333;
    background: #f8f8f8;
    border-radius: 4px;
    cursor: pointer;
    font-size: 13px;
    transition: 0.3s;
}
#print-btn:hover {
    background: #333;
    color: #fff;
}
#print-area { 
    text-align: center; 
    margin: 15px 0; 
}
</style>
<script>
function hide(){ document.getElementById("pr").style.display="none"; }
</script>
</head>
<body>

<div class="body" id="printContent">

<!-- Header -->
<div class="header">
    <table width="100%">
        <tr>
            <td class="logo" width="20%">
                <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
            </td>
			
            <td class="titel" width="60%" style="text-align:center">
                <h2 class="text-titel"><?=$group->group_name?></h2>
                <p style="margin-top: 10px !important; line-height: 0px !important;"><?=$group->address?></p>
                <p>Cell: <?=$group->mobile?> | Email: <?=$group->email?></p>
            </td>
			
            <?php /*?><td class="Qrl_code" width="20%" style="text-align:right">
                <?='<img class="barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
                <p class="qrl-text"><?=$oi_no?></p>
            </td><?php */?>
			
			<td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($oi_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/other_issue/other_issue_report.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
        </tr>
    </table>
</div>

<!-- Title -->
<h5 class="report-titel"><?=$issue_type?> Report</h5>

<!-- Info Section -->
<table width="100%" class="info-table">
    <tr>
        <td width="50%" style="font-size: 14px !important;">
            <p><b>Issue To:</b> <?=$issued_to?></p>

            <p><b>Requisition From:</b> <?=$requisition_from?></p>
            <p><b>Note:</b> <?=$oi_subject; if (!empty($oi_subject)) {echo $oi_subject;} else { echo 'N/A';}?></p>
            <p><b>Entry By:</b> <?=find_a_field('user_activity_management','fname','user_id='.$entry_by)?> (<?=$entry_at?>)</p>
        </td>
        <td width="50%" style="padding-left: 320px !important; font-size: 14px !important;">
            <p><b>Issue No:</b> <?=$oi_no?></p>
            <p><b>Issue Date:</b> <?=date("d M, Y",strtotime($oi_date))?></p>
            <p><b>Store Serial No:</b> <?=$oi_no?></p>
        </td>
    </tr>
</table>

<!-- Print Button -->
<div id="pr" class="print-area">
    <input type="button" id="print-btn" onClick="hide();window.print();" value="Print"/>
</div>

<!-- Items Table -->
<table class="table-design">
    <thead>
        <tr>
            <th>SL</th>
            <th>Code</th>
            <th>Product Name</th>
            <th>Unit</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        <?php for($i=0;$i<$pi;$i++){ ?>
        <tr>
            <td><?=$i+1?></td>
            <td><?=$item_id[$i]?></td>
            <td style="text-align: left;"><?=find_a_field('item_info','item_name','item_id='.$item_id[$i])?></td>
            <td><?=$unit_name[$i]?></td>
            <td style="text-align: right;"><?=$unit_qty[$i]?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Footer / Signatures -->
<div class="footer1">
    <!-- Footer Note -->
    <p style="text-align: left; font-size: 13px; margin-bottom: 10px;">
        <em>All goods are received in good condition as per Terms</em>
    </p>

    <!-- Signature Table -->
    <table width="100%" class="signature-table">
       <tr>
    <td style="font-size:13px !important; text-align:center;">
        <div style="border-top:1px solid #000; margin-top:30px; padding-top:3px;">
            Received By
        </div>
    </td>
    <td style="font-size:13px !important; text-align:center;">
        <div style="border-top:1px solid #000; margin-top:30px; padding-top:3px;">
            Prepared By
        </div>
    </td>
    <td style="font-size:13px !important; text-align:center;">
        <div style="border-top:1px solid #000; margin-top:30px; padding-top:3px;">
            Store Incharge
        </div>
    </td>
</tr>

    </table>

    <?php include("../../../assets/template/report_print_buttom_content.php");?>
</div>

</div>

</body>
</html>
