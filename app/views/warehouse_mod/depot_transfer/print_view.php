<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$req_no = url_decode(str_replace(' ', '+', $_REQUEST['req_no']));
$sql = "select * from production_issue_master where pi_no='$req_no'";
$data = db_query($sql);
$all = mysqli_fetch_object($data);

$company_info = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');

// Barcode setup
$barcode_content = $req_no;
$barcodeText = $barcode_content;
$barcodeType = 'code128';
$barcodeDisplay = 'horizontal';
$barcodeSize = 40;
$printText = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>FG Challan Copy</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>

  <style>
    body { font-family: Arial, sans-serif; font-size: 13px; }
    .header { width: 100%; }
    .header .logo img { max-height: 60px; }
    .titel h2 { margin: 0; font-size: 20px; font-weight: bold; }
    .titel p { margin: 0; font-size: 12px; }
    .Qrl_code_barcode { max-height: 50px; }

    .report-titel { text-align: center; font-size: 16px; font-weight: bold; margin: 10px 0; }
    .p-text { font-size: 13px; margin: 10px 0; }

    .table1, .tabledesign {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .tabledesign th, .tabledesign td {
        border: 1px solid #000;
        padding: 4px;
    }
    .tabledesign th {
        background: #f9f9f9;
        text-align: center;
    }
    .footer1 { margin-top: 40px; }
    .footer1 table { width: 100%; text-align: center; }
    .footer1 td { padding-top: 25px; }
  </style>
</head>
<body>

<div class="body" id="printContent">
  <!-- Header -->
  <table border="0" cellpadding="2" cellspacing="0" width="100%">
    <tr>
      <td>
        <div class="header">
          <table class="table1">
            <tr>
              <td class="logo" style="width:20%;">
                <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/>
              </td>
              <td class="titel" style="width:60%; text-align:center;">
                <h2><?=$company_info->group_name?></h2>
                <p><?=$company_info->address?></p>
                <p>Cell: <?=$company_info->mobile?> | Email: <?=$company_info->email?></p>
              </td>
              <td class="Qrl_code" style="width:20%; text-align:right;">
                <?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" 
                  src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
                <p style="font-size:12px; padding-right: 26px !important;"><?=$all->pi_no?></p>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>

  <hr/>
  <h5 class="report-titel"><u>STORE TO STORE CHALLAN COPY</u></h5>

  <!-- Details -->
  <p class="p-text">
    <b>Transfer ID:</b> <?=$all->pi_no?><br>
    <b>Send Date:</b> <?=$all->pi_date?><br>
    <b>Invoice No:</b> <?php if(!empty($all->invoice_no)){echo $all->invoice_no;} else {echo "N/A";}?><br>
    <b>Carried By:</b> <?=$all->carried_by?>
  </p>

  <div id="pr">
    <input type="button" onClick="hide();window.print();" value="Print" style="margin-bottom: 10px !important";/>
  </div>

  <!-- Product Table -->
  <table class="tabledesign">
    <tr>
      <th>SL</th>
      <th>FG Code</th>
      <th>Product Name</th>
      <th>Unit</th>
      <th>Rate</th>
      <th>Qty</th>
      <th>Total Amt</th>
    </tr>
    <?php
    $pi=0; $grand_total_qty=0; $grand_total_amount=0;
    $sql2="select * from production_issue_detail where pi_no='$req_no'";
    $data2=db_query($sql2);
    while($info=mysqli_fetch_object($data2)){
        $pi++;
        $total_qty=$info->total_unit;
        $grand_total_qty+=$total_qty;
        $rate=$info->unit_price;
        $total_amount=$info->total_amt;
        $grand_total_amount+=$total_amount;
        $item=find_all_field('item_info','*','item_id='.$info->item_id);
    ?>
    <tr>
      <td align="center"><?=$pi?></td>
      <td align="center"><?=$item->finish_goods_code?></td>
      <td><?=$item->item_name?></td>
      <td align="center"><?=$item->unit_name?></td>
      <td align="right"><?=number_format($rate,2)?></td>
      <td align="right"><?=number_format($total_qty,2)?></td>
      <td align="right"><?=number_format($total_amount,2)?></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="5" align="right"><strong>Total:</strong></td>
      <td align="right"><strong><?=number_format($grand_total_qty,2)?></strong></td>
      <td align="right"><strong><?=number_format($grand_total_amount,2)?></strong></td>
    </tr>
  </table>

  <!-- Notes -->
  <p class="p-text"><b>Note:</b> <?=$all->remarks?></p>

  <!-- Footer -->
  <div class="footer1">
   <table>
  <tr>
    <td class="text-center">
      <?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?><br/>
      -------------------<br/>
      Prepared By
    </td>
    <td class="text-center">
      -------------------<br/>
      Received By
    </td>
    <td class="text-center">
      -------------------<br/>
      Store Incharge
    </td>
  </tr>
</table>

  </div>
</div>

<script>
function hide(){document.getElementById("pr").style.display="none";}
</script>

</body>
</html>
<?php
$page_name="FG Challan Print View";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>
