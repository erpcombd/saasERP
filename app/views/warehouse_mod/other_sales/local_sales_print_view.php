<?php
session_start();
require_once "../../../controllers/routing/print_view.top.php";

$oi_no = url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));

$barcode_content = $oi_no;
$barcodeText = $barcode_content;
$barcodeType='code128';
$barcodeDisplay='horizontal';
$barcodeSize=40;
$printText='';

$datas = find_all_field('warehouse_other_issue','s','oi_no='.$oi_no);
$group_data = find_all_field('user_group','','id='.$datas->group_for);

$sql111="select * from warehouse_other_issue where oi_no = '".$oi_no."'";
$data111=db_query($sql111);
$data=mysqli_fetch_object($data111);

$rec_frm=$data->vendor_name;
$oi_date=$data->oi_date;

$sql1="select * from warehouse_other_issue_detail where oi_no = '".$oi_no."'";
$data1=db_query($sql1);

$pi=0;
$total=0;
while($info=mysqli_fetch_object($data1)){ 
    $pi++;
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
  <title>Local Sales (Other Issue)</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
  <style>
    .left .left-text, .right .right-text {
        font-weight: bold;
        margin: 0px;
        padding: 2px;
        border: none !important;
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
    #pr input[type="button"] {
        width: 70px;
        height: 25px;
        background-color: #6cff36;
        color: #333;
        font-weight: bolder;
        border-radius: 5px;
        border: 1px solid #333;
        cursor: pointer;
    }
  </style>
  <script type="text/javascript">
    function hide(){ document.getElementById("pr").style.display="none"; }
  </script>
</head>
<body>
<div class="body" id="printContent">
  <table border="0" cellpadding="2" cellspacing="0" style="width:100%">
    <thead>
      <tr><td>
        <div class="header">
          <table class="table1">
            <tr>
              <td class="logo">
                <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" class="logo-img"/>
              </td>
              <td class="titel">
                <h2 class="text-titel"> <?=$group_data->group_name?> </h2>
                <p class="text"><?=$group_data->address?></p>
                <p class="text">Cell: <?=$group_data->mobile?>. Email: <?=$group_data->email?> <br> <?=$group_data->vat_reg?></p>
              </td>
			  
              <?php /*?><td class="Qrl_code">
                <?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
                <p class="qrl-text"><?php echo $oi_no;?></p>
              </td><?php */?>
			  
			  <td class="qr-code">
        <?php 
		$company_id=url_encode($cid);
        $req_no_qr_data = url_encode($oi_no);
        $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/other_sales/local_sales_print_view.php?c=".rawurlencode($company_id)."&v=" . rawurlencode($req_no_qr_data);
        $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=" . urlencode($print_url);
        ?>
        <img src="<?=$qr_code?>" alt="QR Code" style=" width: 110px; height: 110px; ">
    </td>
			  
            </tr>
          </table>
        </div>
      </td></tr>
    </thead>
    <tbody>
      <tr><td>
        <div class="header-one">
          <hr class="hr"/>
          <h5 class="report-titel">LOCAL SALES (Other Issue)</h5>
          <br>
          <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 left">
              <p class="left-text">Customer Name: <span><?=$rec_frm?></span></p>
              <p class="left-text">Note: <span><?=$data->oi_subject?></span></p>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 right" style="padding-left: 332px !important";>
              <p class="right-text">LS No: <span><?=$oi_no?></span></p>
              <p class="right-text">LS Date: <span><?=date("d M, Y",strtotime($oi_date))?></span></p>
            </div>
          </div>
        </div>
      </td></tr>
      <tr><td>
        <div id="pr">
          <p><input type="button" onClick="hide();window.print();" value="Print" /></p>
        </div>
      </td></tr>
      <tr><td>
        <table class="table1">
          <thead>
            <tr>
              <th>SL</th>
              <th>Item Code</th>
              <th>Item Name</th>
              <th>UOM</th>
              <th>Rate</th>
              <th>Quantity</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $t_amount=0;
            for($i=0;$i<$pi;$i++){ 
              $t_amount += $amount[$i];
            ?>
            <tr>
              <td style="text-align:center;"><?=$i+1?></td>
              <td style="text-align:center;"><?=find_a_field('item_info','finish_goods_code','item_id='.$item_id[$i]);?></td>
              <td><?=find_a_field('item_info','item_name','item_id='.$item_id[$i]);?></td>
              <td style="text-align:center;"><?=$unit_name[$i]?></td>
              <td style="text-align:right;"><?=number_format($rate[$i],2)?></td>
              <td style="text-align:right;"><?=number_format($unit_qty[$i],2)?></td>
              <td style="text-align:right;"><?=number_format($amount[$i],2)?></td>
            </tr>
            <?php } ?>
            <tr>
              <td colspan="6" style="text-align:right;"><strong>Total Amount (BDT):</strong></td>
              <td style="text-align:right;"><strong><?=number_format($t_amount,2)?></strong></td>
            </tr>
          </tbody>
        </table>
      </td></tr>
      <tr><td>
       <p class="p-text" style="font-style: italic;">All goods are received in a good condition as per Terms</p>
      </td></tr>
    </tbody>
    <tfoot>
      <tr><td>
        <div class="footer1" id="footer1">
          <table class="footer-table" style="width:100%;">
            <tr>
              <td class="text-left w-25">
                <p style="margin:0; align-items: center; font-size:19px;">
             <?=find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?>
             </p>

                --------------------
              </td>
              <td class="text-left w-25">--------------------</td>
              <td class="text-left w-25">--------------------</td>
              <td class="text-left w-25">--------------------</td>
            </tr>
            <tr>
              <td class="text-left"><strong>Prepared By</strong></td>
              <td class="text-left"><strong>Reviewed By</strong></td>
              <td class="text-left"><strong>Approved By</strong></td>
              <td></td>
            </tr>
          </table>
          <?php include("../../../assets/template/report_print_buttom_content.php");?>
        </div>
      </td></tr>
    </tfoot>
  </table>
</div>
</body>
</html>
<?php
$page_name="Local Sales Print View";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>
