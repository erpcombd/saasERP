<?php
//require_once "../../../controllers/routing/default_values.php";
//require_once SERVER_CORE."routing/layout.top.php";

require_once "../../../controllers/routing/print_view.top.php";

//$req_no = $_REQUEST['req_no'];
$req_no=url_decode(str_replace(' ', '+', $_REQUEST['v']));
$c_id = url_decode(str_replace(' ', '+', $_REQUEST['c']));


$all = find_all_field('requisition_fg_master','','req_no='.$req_no);

$company_name = find_a_field('user_group','group_name','id="'.$all->group_for.'"');
$group_data   = find_all_field('user_group','*','id="'.$all->group_for.'"');

// Barcode config
$req_bar_no = $req_no;
$barcode_content = $all->req_no;
$barcodeText     = $barcode_content;
$barcodeType     = 'code128';
$barcodeDisplay  = 'horizontal';
$barcodeSize     = 40;
$printText       = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Requisition Print View</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
  <style>
    body { 
        margin: 0;
        padding: 0; 
    }

    .table1 { 
        width: 100%; 
        border-collapse: collapse; 
    }

    .header .logo img { 
        max-height: 60px; 
    }
    .text-titel { 
        margin: 0; 
        font-size: 20px; 
        font-weight: bold;
     }
    .text { 
        margin: 0;
        font-size: 12px; 
        }
    .Qrl_code img { 
        max-height: 60px;
     }
    .left .left-text, .right .right-text {
        font-weight: bold;
        margin: 0;
        padding: 2px;
        border: none !important;
    }
    .left .new-div, .right .new-div {
        border: 1px solid black;
        min-height: 115px;
        margin-top: 15px;
        padding: 4px;
    }
    .footer1 { 
        page-break-inside: avoid; 
        margin-top: 40px; 
    }

    .footer1 table {
         width: 100%; 
         text-align: center; 
         border-collapse: collapse; 
        }

    .footer1 td { 
        vertical-align: bottom; 
        padding-top: 25px; 
        width: 33%; 
    }
    th { 
        background: #f5f5f5; 
    }
  </style>
</head>
<body>
<div class="body" id="printContent">
  <table border="0" cellpadding="2" cellspacing="0" width="100%">
    <thead>
      <tr><td>
        <div class="header">
          <table class="table1">
            <tr>
              <td class="logo" width="20%" align="left">
                <img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$c_id?>.png" />
              </td>
              <td class="titel" width="60%" align="center">
                <h2 class="text-titel"><?=$group_data->group_name?></h2>
                <p class="text"><?=$group_data->address?></p>
                <p class="text">Cell: <?=$group_data->mobile?> | Email: <?=$group_data->email?></p>
              </td>

              <?php /*?><td class="Qrl_code">
					<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
			       <p class="qrl-text" style="padding-right: 18px !important;"><?=$all->req_no?></p>
		    </td><?php */?>
			<td width="17%" align="right" class="qr-code">
              <?php 
              $company_id = url_encode($cid);
              $req_no_qr_data = url_encode($req_no); // Change variable as needed
              $print_url = "https://saaserp.ezzy-erp.com/app/views/warehouse_mod/fr/fr_print_view.php?c=" . rawurlencode($company_id) . "&v=" . rawurlencode($req_no_qr_data);
              $qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($print_url);
              ?>
              <img src="<?=$qr_code?>" alt="QR Code" style="width:100px; height:100px;">
            </td>
            </tr>
          </table>
        </div>
      </td></tr>
    </thead>
    <tbody>
      <tr><td>
        <hr class="hr"/>
        <h5 class="report-titel" style="text-align:center; margin:5px 0;"><u>REQUISITION</u></h5><br>

        <table class="table1" style="margin-top:10px;">
          <tr>
            <td width="50%" valign="top" style="border: none;">
              <p class="left-text">Requisition No: <span><?=$all->req_no?></span></p>
              <p class="left-text">Requisition Date: <span><?=$all->req_date?></span></p>
              <p class="left-text">Need Before: <span><?=$all->need_by?></span></p>
              <div class="new-div">
                <p class="titel-text">From Warehouse</p>
                <p class="text1">Name: <span><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_id)?></span></p>
              </div>
            </td>
            <td width="50%" valign="top" style="border: none;">
              <div class="new-div" style="padding-left: 234px !important";>
                <p class="titel-text">To Warehouse</p>
                <p class="text1">Name: <span><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to)?></span></p>
                <p class="text1"><span class="left-text">Remarks: <span>
                  <?php if (!empty($all->req_note)) {echo $all->req_note;} else {echo "N/A";}?>
                </span></span></p>
              </div>
            </td>
          </tr>
        </table>

        <p class="p-text" style="margin-top:10px;">
          Dear Sir/Madam,<br/>
          Please find the details of the requisition as per below mentioned items:
        </p>
      </td></tr>

      <tr><td>
        <div id="pr" style="margin:10px 0;">
          <div align="left">
            <input name="button" type="button" onClick="window.print();" value="Print" />
          </div>
        </div>
      </td></tr>

      <tr><td>
        <table class="table1" border="1" cellspacing="0" cellpadding="3">
          <thead>
            <tr>
              <th>SL</th>
              <th>FG Code</th>
              <th>Description</th>
              <th>Pack Size</th>
              <th>Req Ctn</th>
              <th>Req Pcs</th>
              <th>Total Pcs</th>
              <th>Delivered Pcs</th>
              <th>Pending Pcs</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $pi=0; $gctn=$gqty=$gtpcs=$gditem=$gpqty=0;
            $sql2="select * from requisition_fg_order where req_no='$req_no'";
            $data2=db_query($sql2);
            while($info=mysqli_fetch_object($data2)){
              $pi++;
              $item=find_all_field('item_info','*','item_id='.$info->item_id);
              $qty=($info->qty%$item->pack_size);
              $ctn=(int)($info->qty/$item->pack_size);
              $done_item=find_a_field('fg_issue_detail','sum(total_unit)','req_no="'.$req_no.'" and item_id="'.$info->item_id.'"');
              $pending_qty=($info->qty-$done_item);
              ?>
              <tr>
                <td><?=$pi?></td>
                <td><?=$item->finish_goods_code?></td>
                <td><?=$item->item_name?><br><strong><?=$info->item_note?></strong></td>
                <td style="text-align:right;"><?=$item->pack_size?></td>
                <td style="text-align:right;"><?=$ctn; $gctn+=$ctn;?></td>
                <td style="text-align:right;"><?=$qty; $gqty+=$qty;?></td>
                <td style="text-align:right;"><?=$info->qty; $gtpcs+=$info->qty;?></td>
                <td style="text-align:right;"><?=$done_item; $gditem+=$done_item;?></td>
                <td style="text-align:right;"><?=$pending_qty; $gpqty+=$pending_qty;?></td>
              </tr>
            <?php } ?>
            <tr>
              <td colspan="4" align="right"><strong>Total</strong></td>
              <td style="text-align:right;"><?=$gctn?></td>
              <td style="text-align:right;"><?=$gqty?></td>
              <td style="text-align:right;"><?=$gtpcs?></td>
              <td style="text-align:right;"><?=$gditem?></td>
              <td style="text-align:right;"><?=$gpqty?></td>
            </tr>
          </tbody>
        </table>
      </td></tr>

      <tr><td>
        <p class="p-text" style="margin-top:20px;">For <?=$group_data->group_name?>.</p>
      </td></tr>

      <tr><td>
        <div class="footer1" id="footer1">
       <table>
  <tr>
    <td class="text-center">
      <p style="font-weight:600; margin:0;">
        <?=find_a_field('user_activity_management','fname','user_id="'.$all->entry_by.'"');?>
      </p>
      <p style="margin:0;">-------------------</p>
      <p style="font-size:11px; margin:0;">(Prepared By)</p>
    </td>
    <td class="text-center">
      <p style="font-weight:600; margin:0;">
        <?=find_a_field('user_activity_management','fname','user_id="'.$all->checked_by.'"');?>
      </p>
      <p style="margin:0;">-------------------</p>
      <p style="font-size:11px; margin:0;">(Checked By)</p>
    </td>
    <td class="text-center">
      <p style="font-weight:600; margin:0;">
        <?=find_a_field('user_activity_management','fname','user_id="'.$all->approved_by.'"');?>
      </p>
      <p style="margin:0;">-------------------</p>
      <p style="font-size:11px; margin:0;">(Approved By)</p>
    </td>
  </tr>
</table>

          <?php include("../../../assets/template/report_print_buttom_content.php");?>
        </div>
      </td></tr>
    </tbody>
  </table>
</div>
</body>
</html>

<?php
$page_name="Requisition Print View";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>
