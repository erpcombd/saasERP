<?php

//====================== EOF ===================



//var_dump($_SESSION);



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

 $pr_no = url_decode(str_replace(' ', '+', $_REQUEST['v_no']));

$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);

//$do_no= find_a_field('sale_return_details','do_no','chalan_no='.$chalan_no);

$master = find_all_field('purchase_return_details','','pr_no='.$pr_no);




  		  $barcode_content = $chalan_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


foreach($challan as $key=>$value){
$$key=$value;
}

  $ssql = 'select a.*,b.* from vendor a, purchase_return_details b where a.vendor_id=b.vendor_id and b.pr_no='.$pr_no;

 $dealer = find_all_field_sql($ssql);

$entry_time=$dealer->do_date;



$dept = 'select warehouse_name from warehouse where warehouse_id='.$dept;

$deptt = find_all_field_sql($dept);

$to_ctn = find_a_field('purchase_return_details','sum(pkt_unit)','pr_no='.$pr_no);

$to_pcs = find_a_field('purchase_return_details','sum(dist_unit)','pr_no='.$pr_no); 



$ordered_total_ctn = find_a_field('purchase_return_details','sum(pkt_unit)','dist_unit = 0 and pr_no='.$pr_no);

$ordered_total_pcs = find_a_field('purchase_return_details','sum(dist_unit)','pr_no='.$pr_no);

$tr_type="Show";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>debit_note</title>
	
<style>
  table1 {
            border: none; /* Ensures no gaps between table cells */
        }
        table1, th1, td1 {
            border: none; /* No borders for the table, header, or data cells */
        }
		
 
 
     .no-spacing {
        line-height:0px; !important;
		margin: 0; !important;
        padding: 0; !important;
		text-align:center; !important;
		
    }
    .no-spacing h1 {
        margin: 0;
        padding: 0;
    }
	
	
    /* Ensures no gaps between table cells */
    table {
        border-collapse: collapse;
        width: 100%;
    }
    td {
        padding: 5px;
    }
    
    /* Print-specific CSS */
    @media print {
        body {
            margin: 0;
            padding: 0;
            font-size: 10px;
			
        }
        table {
            width: 100%;
        }
        td {
            padding: 2px;
        }
        /* Prevents page breaks within table rows */
        table, tr, td {
            page-break-inside: avoid;
        }
        /* Controls the page margins for printing */
        @page {
            size: A4;
            margin: 1cm; /* Adjust margins as needed */
        }
    }
    
    /* For on-screen view */
    .no-spacing {
        line-height: 1;
    }
    .no-spacing h1 {
        margin: 0;
        padding: 0;
    }
	
	@page {
		@bottom-center {
		  content: "Page " counter(page) " of " counter(pages);
		}
  }

	
</style>


	<script type="text/javascript">



function hide()



{



    document.getElementById("pr").style.display="none";



}



</script>
	
</head>
<body>
<table width="0%" border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse;">
  <tr>
    <td ><table width="0%" border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse;">
      <tr>
         <td style="width: 196px !important;"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style=" width: 100%" /></div></td>
        <td><div align="center">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার<br>
          জাতীয় রাজস্ব বোর্ড <br>
          ডেবিট নোট <br>
          [বিধি ৪০ এর উপ-বিধি (১) এর দফা (ছ) দ্রষ্টব্যঃ ]</div></td>
        <td><div align="center">মূসক-৬.৮</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="center">
      <table width="0%" border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse;">
        <tr>
          <td><div align="center">ডেবিট নোট নম্বর : <?php echo $dealer->pr_no?><br>
            ইস্যুর তারিখ : <?=date("j-M-Y",strtotime($dealer->entry_time));?><br>
            ইস্যুর সময় : <?=date("h:i:s",strtotime($dealer->entry_time));?></div></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td><table width="0%" border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse;">
      <tr>
        <td><p>নিবন্ধিত ব্যাক্তির নাম : <?=$group_data->group_name?><br>
          নিবন্ধিত ব্যাক্তির বিআইএন: <?=$group_data->vat_reg?><br>
          বিক্রেতার ঠিকানা : <?=$group_data->address?></p>
          <p>বিক্রেতার নাম : <?php echo $dealer->vendor_name?><br>
            বিক্রেতার বিআইএন :<br>
          বিক্রেতার ঠিকানা : <?php echo $dealer->address?></p></td>
      </tr>
    </table>      </td>
  </tr>
  <tr>
  	<td>
		<div id="pr">
        <div align="left">
          <p>
            <input name="button" type="button" onClick="hide();window.print();" value="Print" />
          </p>
            </div>
      </div>
	</td>
  
  </tr>
  <tr>
    <td><table width="0%" border="1">
      <tr>
        <td width="6%" rowspan="2"><div align="center">ক্রমিক নং :<br>
        </div></td>
        <td colspan="2" rowspan="2"><div align="center">কর চালানপত্রের নম্বর ও তারিখ </div></td>
        <td width="7%" rowspan="2"><div align="center">ডেবিট নোট ইস্যুর কারণ <br>
        </div></td>
        <td width="10%" rowspan="2"><div align="center">পণ্য বা সেবার কোড <br>
        </div></td>
        <td colspan="4"><div align="center">চালানপত্রে উল্লেখিত সরবরাহের <br>
        </div></td>
        <td colspan="4"><div align="center">বৃদ্ধিকারী সমন্বয়ের সহিত সংশ্লিষ্ট </div></td>
        </tr>
      <tr>
        <td><div align="center">মূল্য<br>
        </div></td>
        <td><div align="center">পরিমাণ <br>
        </div></td>
        <td><div align="center">মূল্য সংযোজন করের পরিমান <br>
        </div></td>
        <td><div align="center">সম্পূরক শুল্কের পরিমাণ </div></td>
        <td><div align="center">মূল্য<br>
        </div></td>
        <td><div align="center">পরিমাণ <br>
        </div></td>
        <td><div align="center">মূল্য সংযোজন করের পরিমান <br>
        </div></td>
        <td><div align="center">সম্পূরক শুল্কের পরিমাণ </div></td>
      </tr>
        <? 
   
   $res='select m.item_id, m.pr_no, m.ch_no,m.with_vat_amt grn_vat_amt,m.amount grn_amt,m.rec_date,m.qty grn_qty,a.remarks,a.pr_no,a.invoice_no,b.total_unit,b.total_amt,b.total_amt_with_vat vat_amt, i.item_name, i.unit_name,i.finish_goods_code, i.item_id
   
   from purchase_receive m 
   
   left join item_info i 
   
   on i.item_id=m.item_id 
   
   left join purchase_return_master a 
   
   on a.invoice_no=m.pr_no 
   
   left join purchase_return_details b 
   
   on a.pr_no=b.pr_no and m.item_id=b.item_id 
   
   where m.item_id=b.item_id  and a.pr_no='.$pr_no.' order by m.id,a.pr_no;';
   
   
   $i=1;

$query = mysql_query($res);

while($data=mysql_fetch_object($query)){

?>
        <tr>

<td><?=$i++?></td>

<td><?=$data->ch_no;?></td>
<td><?=$data->rec_date;?></td>
<td><?=$data->remarks;?></td>
<td><?=$data->item_name."-".$data->finish_goods_code;?></td>
<td><?=$data->grn_amt; $tot_total_amt +=$data->grn_amt;?></td>
<td><?=$data->grn_qty."".$data->unit_name; $tot_qty +=$data->grn_qty;?></td>
<td><?=$data->grn_vat_amt;$tot_vat_amt +=$data->grn_vat_amt;?></td>
<td><?=$avat=0.00;$tot_vat+=$avat;?></td>
<td><?=$data->total_amt;  $tt_total_amt +=$data->total_amt;?></td>
<td><?=$data->total_unit."".$data->unit_name;$tt_qty +=$data->total_unit;?></td>
<td><?=$data->vat_amt; $tt_vat_amt +=$data->vat_amt;?></td>

<td><?=$rvat=0.00;$tt_vat+=$rvat;?></td>
</tr>
        
        <?  } ?>
       
      <tr>
        <td colspan="5"> <div align="right">মোট </div></td>
       <td><strong><?=number_format($tot_total_amt,2);?></strong></td>
       <td><strong><?=number_format($tot_qty,2);?></strong></td>
         <td><strong><?=number_format($tot_vat_amt,2);?></strong></td>
        <td><strong><?=number_format($tot_vat,2);?></strong></td>
        <td><strong><?=number_format($tt_total_amt,2);?></strong></td>
       <td><strong><?=number_format($tt_qty,2);?></strong></td>
         <td><strong><?=number_format($tt_vat_amt,2);?></strong></td>
        <td><strong><?=number_format($tt_vat,2);?></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>

    <td><table width="0%" border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse;">
      <tr>
        <td style="padding-top:60px">প্রতিষ্ঠান কতৃপক্ষের দায়িত্ব প্রাপ্ত ব্যাক্তির নাম :<br>
পদবী :<br>
সাক্ষর :<br>
সীল :<br>

১।  প্রতি একক পণ্য /শেয়ার মূসক ০ সম্পূরক মূল্য। <br>
২।  ফেরত প্রদানের জন্য কোনো ধরণের কর্তন থাকিলে উহার পরিমান। <br>
৩।  মূসক ও সম্পূরক শুল্কের যোগফল। </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

<?
$page_name="musok for debit note";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>